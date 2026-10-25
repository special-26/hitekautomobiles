<?php

namespace App\Livewire\Payroll;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\PayrollSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;
use App\Models\CompanyHoliday;

class Index extends Component
{
    public string $month;

    public function mount(): void
    {
        Gate::authorize('payroll.view');

        $this->month = now()->subMonth()->format('Y-m');
    }

    public function calculatePayroll(): void
    {
        Gate::authorize('payroll.calculate');

        $validated = $this->validate([
            'month' => ['required', 'date_format:Y-m'],
        ]);

        $periodStart = Carbon::createFromFormat(
            '!Y-m',
            $validated['month']
        )->startOfMonth();

        $periodEnd = $periodStart->copy()->endOfMonth();

        if ($periodEnd->isAfter(today())) {
            throw ValidationException::withMessages([
                'month' => 'Payroll can only be calculated for a completed month.',
            ]);
        }

        $settings = PayrollSetting::current();

        $companyHolidays = CompanyHoliday::query()
            ->whereBetween('holiday_date', [
                $periodStart->toDateString(),
                $periodEnd->toDateString(),
            ])
            ->get()
            ->keyBy(fn($holiday) => $holiday->holiday_date->toDateString());

        $weeklyOffDays = array_map(
            'intval',
            $settings->weekly_off_days ?? [0]
        );

        $workingDates = collect();

        for (
            $date = $periodStart->copy();
            $date->lte($periodEnd);
            $date->addDay()
        ) {
            if (!in_array($date->dayOfWeek, $weeklyOffDays, true)) {
                $workingDates->push($date->copy());
            }
        }

        $salaryWorkingDates = $workingDates->values();
        $totalWorkingDays = $salaryWorkingDates->count();

        $attendanceRequiredDates = $salaryWorkingDates
            ->reject(fn($date) => $companyHolidays->has($date->toDateString()))
            ->values();

        if ($totalWorkingDays === 0) {
            throw ValidationException::withMessages([
                'month' => 'No working days were found for this month. Check payroll settings.',
            ]);
        }

        $employees = Employee::query()
            ->with([
                'salaryHistories' => fn($query) => $query
                    ->whereDate('effective_from', '<=', $periodEnd)
                    ->where(function ($query) use ($periodStart) {
                        $query->whereNull('effective_to')
                            ->orWhereDate('effective_to', '>=', $periodStart);
                    })
                    ->orderBy('effective_from'),
                'attendances' => fn($query) => $query
                    ->whereBetween('attendance_date', [
                        $periodStart->toDateString(),
                        $periodEnd->toDateString(),
                    ]),
            ])
            ->get();

        $createdOrUpdated = 0;
        $skipped = 0;
        $issues = [];

        DB::transaction(function () use (
            $employees,
            $workingDates,
            $totalWorkingDays,
            $periodStart,
            $periodEnd,
            $settings,
            &$createdOrUpdated,
            &$skipped,
            &$issues,
            $salaryWorkingDates,
            $attendanceRequiredDates,
            $companyHolidays,
        ) {
            foreach ($employees as $employee) {
                $histories = $employee->salaryHistories;

                if ($histories->isEmpty()) {
                    $skipped++;

                    $issues[] = "Employee #{$employee->id}: no salary history covers this period.";

                    continue;
                }

                $attendanceByDate = $employee->attendances
                    ->keyBy(
                        fn($attendance) =>
                        $attendance->attendance_date->toDateString()
                    );

                $basic = 0;
                $hra = 0;
                $transport = 0;
                $allowances = 0;
                $otherDeductions = 0;

                $presentDays = 0;
                $absentDays = 0;
                $halfDays = 0;
                $onLeaveDays = 0;

                $absenceDeduction = 0;
                $halfDayDeduction = 0;
                $missingSalaryDate = null;
                $unpaidHolidayDeduction = 0;

                $monthlyWorkingDays = max(1, $totalWorkingDays);

                foreach ($workingDates as $date) {
                    $salary = $histories->first(function ($history) use ($date) {
                        return $history->effective_from->lte($date)
                            && (
                                $history->effective_to === null
                                || $history->effective_to->gte($date)
                            );
                    });

                    if (!$salary) {
                        $missingSalaryDate = $date->toDateString();
                        break;
                    }

                    // Each salary component is prorated by the number
                    // of scheduled working days in the full month.
                    $dailyBasic = (float) $salary->basic_salary
                        / $monthlyWorkingDays;

                    $dailyHra = (float) $salary->hra
                        / $monthlyWorkingDays;

                    $dailyTransport = (float) $salary->transport_allowance
                        / $monthlyWorkingDays;

                    $dailyAllowances = (float) $salary->other_allowances
                        / $monthlyWorkingDays;

                    $dailyOtherDeductions = (float) $salary->other_deductions
                        / $monthlyWorkingDays;

                    $dailyGross = $dailyBasic
                        + $dailyHra
                        + $dailyTransport
                        + $dailyAllowances;

                    $basic += $dailyBasic;
                    $hra += $dailyHra;
                    $transport += $dailyTransport;
                    $allowances += $dailyAllowances;
                    $otherDeductions += $dailyOtherDeductions;

                    $holiday = $companyHolidays->get($date->toDateString());

                    $attendance = $attendanceByDate->get(
                        $date->toDateString()
                    );

                    // Company holidays are not ordinary attendance days.
                    // Paid holidays incur no deduction. Unpaid holidays deduct
                    // one daily gross salary rate.
                    if ($holiday) {
                        if (!$holiday->is_paid) {
                            $unpaidHolidayDeduction += $dailyGross;
                        }

                        continue;
                    }

                    // Missing attendance is not automatically an absence.
                    if (!$attendance) {
                        continue;
                    }


                    switch ($attendance->status) {
                        case 'present':
                            $presentDays++;
                            break;

                        case 'absent':
                            $absentDays++;

                            if ($settings->deduct_absent_days) {
                                $absenceDeduction += $dailyGross;
                            }

                            break;

                        case 'half_day':
                            $halfDays++;

                            if ($settings->deduct_half_days) {
                                $halfDayDeduction += $dailyGross
                                    * (float) $settings->half_day_deduction_fraction;
                            }

                            break;

                        case 'on_leave':
                            // Leave pay cannot be determined until
                            // paid/unpaid leave policies exist.
                            $onLeaveDays++;
                            break;
                    }
                }

                if ($missingSalaryDate !== null) {
                    $skipped++;

                    $issues[] = "Employee #{$employee->id}: no applicable salary structure on {$missingSalaryDate}.";

                    continue;
                }

                $payroll = Payroll::query()
                    ->where('employee_id', $employee->id)
                    ->where('month', $periodStart->month)
                    ->where('year', $periodStart->year)
                    ->lockForUpdate()
                    ->first();

                if ($payroll && $payroll->status !== 'draft') {
                    $skipped++;

                    $issues[] = "Employee #{$employee->id}: payroll already exists with status '{$payroll->status}'.";

                    continue;
                }

                $basic = round($basic, 2);
                $hra = round($hra, 2);
                $transport = round($transport, 2);
                $allowances = round($allowances, 2);
                $otherDeductions = round($otherDeductions, 2);

                $grossSalary = round(
                    $basic + $hra + $transport + $allowances,
                    2
                );

                $absenceDeduction = round($absenceDeduction, 2);
                $halfDayDeduction = round($halfDayDeduction, 2);
                $unpaidHolidayDeduction = round($unpaidHolidayDeduction, 2);

                $totalDeductions = round(
                    $otherDeductions
                        + $absenceDeduction
                        + $halfDayDeduction
                        + $unpaidHolidayDeduction,
                    2
                );

                $netSalary = max(
                    0,
                    round($grossSalary - $totalDeductions, 2)
                );

                $payrollData = [
                    'basic_salary' => $basic,
                    'hra' => $hra,
                    'transport_allowance' => $transport,
                    'other_allowances' => $allowances,
                    'other_deductions' => $otherDeductions,
                    'gross_salary' => $grossSalary,
                    'working_days' => $totalWorkingDays,
                    'present_days' => $presentDays,
                    'absent_days' => $absentDays,
                    'half_days' => $halfDays,
                    'paid_leave_days' => 0,
                    'unpaid_leave_days' => 0,
                    'per_day_salary' => round(
                        $grossSalary / $monthlyWorkingDays,
                        2
                    ),
                    'absence_deduction' => $absenceDeduction,
                    'unpaid_holiday_deduction' => $unpaidHolidayDeduction,
                    'half_day_deduction' => $halfDayDeduction,
                    'leave_deduction' => 0,
                    'total_deductions' => $totalDeductions,
                    'net_salary' => $netSalary,
                    'status' => 'draft',
                    'calculated_by' => auth()->id(),
                    'calculated_at' => now(),
                    'payment_status' => 'unpaid',
                    'notes' => $onLeaveDays > 0
                        ? "{$onLeaveDays} leave day(s) recorded; leave deductions not applied pending leave policy."
                        : null,
                ];

                if ($payroll) {
                    $payroll->update($payrollData);
                } else {
                    Payroll::create(array_merge($payrollData, [
                        'employee_id' => $employee->id,
                        'month' => $periodStart->month,
                        'year' => $periodStart->year,
                    ]));
                }

                $createdOrUpdated++;
            }
        });

        session()->flash(
            'success',
            "Payroll calculation finished. Created or updated: {$createdOrUpdated}. Skipped: {$skipped}."
        );

        session()->flash('payroll_issues', $issues);
    }

    public function render()
    {
        $payrolls = collect();

        if (preg_match('/^\d{4}-\d{2}$/', $this->month)) {
            [$year, $month] = explode('-', $this->month);

            if ((int) $month >= 1 && (int) $month <= 12) {
                $payrolls = Payroll::query()
                    ->with('employee')
                    ->where('month', (int) $month)
                    ->where('year', (int) $year)
                    ->orderBy('employee_id')
                    ->get();
            }
        }

        return view('livewire.payroll.index', [
            'payrolls' => $payrolls,
        ])->layout('components.layouts.management');
    }

    public function approvePayroll(int $payrollId): void
    {
        Gate::authorize('payroll.approve');

        DB::transaction(function () use ($payrollId) {
            $payroll = Payroll::query()
                ->lockForUpdate()
                ->findOrFail($payrollId);

            if ($payroll->status !== 'draft') {
                throw ValidationException::withMessages([
                    'approval' => 'Only draft payroll can be approved.',
                ]);
            }

            $payroll->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);
        });

        session()->flash('success', 'Payroll approved successfully.');
    }

    public function downloadPayslip(int $payrollId): Response
    {
        Gate::authorize('payroll.view');

        $payroll = Payroll::query()
            ->with([
                'employee.user',
                'employee.department',
                'payments' => fn($query) => $query
                    ->orderBy('payment_date')
                    ->orderBy('id'),
            ])
            ->findOrFail($payrollId);

        if ($payroll->status !== 'approved') {
            throw ValidationException::withMessages([
                'payslip' => 'Payslips can only be generated for approved payroll.',
            ]);
        }

        $payments = $payroll->payments;

        $totalPaid = round((float) $payments->sum('amount'), 2);

        $remainingBalance = max(
            0,
            round((float) $payroll->net_salary - $totalPaid, 2)
        );

        $pdf = Pdf::loadView('livewire.payroll.pdf.payslip', [
            'payroll' => $payroll,
            'payments' => $payments,
            'totalPaid' => $totalPaid,
            'remainingBalance' => $remainingBalance,
        ])->setPaper('a4', 'portrait');

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'payslip-' . $payroll->year . '-'
                . str_pad((string) $payroll->month, 2, '0', STR_PAD_LEFT)
                . '-employee-' . $payroll->employee_id . '.pdf',
            ['Content-Type' => 'application/pdf']
        );
    }
}

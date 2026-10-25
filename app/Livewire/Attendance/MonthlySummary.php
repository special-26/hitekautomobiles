<?php

namespace App\Livewire\Attendance;

use App\Exports\MonthlyAttendanceExport;
use App\Models\Employee;
use Carbon\Carbon;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class MonthlySummary extends Component
{
    public string $month = '';
    protected $queryString = ['month' => ['except' => ''],];

    public function mount(): void
    {
        $this->month = now()->format('Y-m');
    }

    public function updatedMonth(): void
    {
        $this->validate(['month' => ['required', 'date_format:Y-m'],]);
    }

    public function exportExcel()
    {
        abort_unless(
            auth()->user()->can('attendance.view'),
            403
        );

        $validated = $this->validate([
            'month' => ['required', 'date_format:Y-m'],
        ]);

        return Excel::download(
            new MonthlyAttendanceExport($validated['month']),
            'attendance-' . $validated['month'] . '.xlsx'
        );
    }

    public function render()
    {
        $this->validate(['month' => ['required', 'date_format:Y-m'],]);

        $startDate = Carbon::createFromFormat('!Y-m', $this->month)
            ->startOfMonth();

        $endDate = $startDate->copy()->endOfMonth();

        $employees = Employee::query()
            ->with([
                'user',
                'department',
                'attendances' => fn($query) => $query->whereBetween('attendance_date', [$startDate->toDateString(), $endDate->toDateString(),])->with('shiftRelation'),
            ])->orderBy('employee_code')->get();

        $rows = $employees->map(function ($employee) {
            $records = $employee->attendances;
            $workingMinutes = $records
                ->sum(fn($record) => $record->working_minutes ?? 0);

            return (object) [
                'employee' => $employee,
                'records_count' => $records->count(),
                'present_days' => $records->where('status', 'present')->count(),
                'absent_days' => $records->where('status', 'absent')->count(),
                'half_days' => $records->where('status', 'half_day')->count(),
                'leave_days' => $records->where('status', 'on_leave')->count(),
                'working_minutes' => $workingMinutes,
                'late_count' => $records->where('is_late', true)->count(),
                'early_count' => $records->where('left_early', true)->count(),
            ];
        });

        return view(
            'livewire.attendance.monthly-summary',
            [
                'rows' => $rows,
                'monthLabel' => $startDate->format('F Y'),
                'totals' => [
                    'employees' => $rows->count(),
                    'present' => $rows->sum('present_days'),
                    'absent' => $rows->sum('absent_days'),
                    'half_days' => $rows->sum('half_days'),
                    'leave' => $rows->sum('leave_days'),
                ],
            ]
        )->layout('components.layouts.management', ['title' => 'Monthly Attendance Summary',]);
    }
}

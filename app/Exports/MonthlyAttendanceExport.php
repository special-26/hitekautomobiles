<?php

namespace App\Exports;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class MonthlyAttendanceExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithTitle
{
    public function __construct(
        public string $month
    ) {}

    public function collection(): Enumerable
    {
        $startDate = Carbon::createFromFormat('!Y-m', $this->month)
            ->startOfMonth();

        $endDate = $startDate->copy()->endOfMonth();

        return Employee::query()
            ->with([
                'user',
                'department',
                'attendances' => fn($query) => $query
                    ->whereBetween('attendance_date', [
                        $startDate->toDateString(),
                        $endDate->toDateString(),
                    ]),
            ])
            ->orderBy('employee_code')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Employee Code',
            'Employee Name',
            'Department',
            'Present Days',
            'Absent Days',
            'Half Days',
            'Leave Days',
            'Working Hours',
            'Late Arrivals',
            'Early Departures',
            'Attendance Records',
        ];
    }

    public function map($employee): array
    {
        $records = $employee->attendances;

        $minutes = $records->sum(
            fn($record) => $record->working_minutes ?? 0
        );

        return [
            $employee->employee_code,
            $employee->user?->name ?? '',
            $employee->department?->name ?? '',
            $records->where('status', 'present')->count(),
            $records->where('status', 'absent')->count(),
            $records->where('status', 'half_day')->count(),
            $records->where('status', 'on_leave')->count(),
            sprintf('%d h %02d min', intdiv($minutes, 60), $minutes % 60),
            $records->where('is_late', true)->count(),
            $records->where('left_early', true)->count(),
            $records->count(),
        ];
    }

    public function title(): string
    {
        return 'Attendance ' . $this->month;
    }
}

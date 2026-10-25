<?php

namespace App\Livewire\Attendance;

use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Models\Shift;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $attendanceDate = '';
    public string $search = '';
    public string $statusFilter = '';
    public string $departmentFilter = '';

    public bool $showAttendanceModal = false;
    public ?int $editingEmployeeId = null;
    public string $attendanceShift = 'team_a';
    public string $attendanceStatus = 'present';
    public string $attendanceNotes = '';

    protected $queryString = [
        'attendanceDate' => ['except' => ''],
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'departmentFilter' => ['except' => ''],
    ];

    public function mount(): void
    {
        $this->attendanceDate = now()->toDateString();
    }

    public function updatedAttendanceDate(): void
    {
        $this->validate([
            'attendanceDate' => ['required', 'date'],
        ]);

        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatedDepartmentFilter(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->departmentFilter = '';
        $this->attendanceDate = now()->toDateString();

        $this->resetPage();
    }

    public function openAttendanceModal(int $employeeId): void
    {
        abort_unless(
            auth()->user()->can('attendance.manage'),
            403
        );

        $employee = Employee::findOrFail($employeeId);

        $this->resetValidation();

        $this->editingEmployeeId = $employee->id;
        $this->attendanceShift = (string) ($employee->shift_id ?? '');
        $this->attendanceStatus = 'present';
        $this->attendanceNotes = '';

        $attendance = $employee->attendances()
            ->whereDate('attendance_date', $this->attendanceDate)
            ->first();

        if ($attendance) {
            $this->attendanceShift = (string) (
                $attendance->shift_id
                ?? $employee->shift_id
                ?? ''
            );

            $this->attendanceStatus = $attendance->status;
            $this->attendanceNotes = $attendance->notes ?? '';
        }

        $this->showAttendanceModal = true;
    }

    public function closeAttendanceModal(): void
    {
        $this->showAttendanceModal = false;

        $this->resetValidation();

        $this->reset([
            'editingEmployeeId',
            'attendanceShift',
            'attendanceStatus',
            'attendanceNotes',
        ]);
    }

    public function saveAttendance(): void
    {
        abort_unless(
            auth()->user()->can('attendance.manage'),
            403
        );

        $validated = $this->validate([
            'editingEmployeeId' => [
                'required',
                'integer',
                'exists:employees,id',
            ],
            'attendanceDate' => [
                'required',
                'date',
            ],
            'attendanceShift' => [
                'required',
                'integer',
                'exists:shifts,id',
            ],
            'attendanceStatus' => [
                'required',
                'in:present,absent,half_day,on_leave',
            ],
            'attendanceNotes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $employee = Employee::findOrFail(
            $validated['editingEmployeeId']
        );

        EmployeeAttendance::updateOrCreate(
            [
                'employee_id' => $employee->id,
                'attendance_date' => $validated['attendanceDate'],
            ],
            [
                'shift_id' => $validated['attendanceShift'],
                'status' => $validated['attendanceStatus'],
                'notes' => $validated['attendanceNotes'] ?? null,
                'recorded_by' => Auth::id(),
            ]
        );

        $this->closeAttendanceModal();

        session()->flash(
            'success',
            'Attendance saved successfully.'
        );
    }

    public function render()
    {
        $date = $this->attendanceDate ?: now()->toDateString();

        $employees = Employee::query()
            ->with([
                'user.roles',
                'department',
                'attendances' => fn($query) =>
                $query->whereDate('attendance_date', $date)
                    ->with('shiftRelation'),
            ])
            ->when($this->search !== '', function ($query) {
                $search = trim($this->search);

                $query->where(function ($query) use ($search) {
                    $query->where('employee_code', 'ilike', "%{$search}%")
                        ->orWhere('phone', 'ilike', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'ilike', "%{$search}%")
                                ->orWhere('email', 'ilike', "%{$search}%");
                        });
                });
            })
            ->when(
                $this->departmentFilter !== '',
                fn($query) => $query->where(
                    'department_id',
                    $this->departmentFilter
                )
            )
            ->when(
                $this->statusFilter !== '',
                fn($query) => $query->whereHas(
                    'attendances',
                    fn($attendanceQuery) => $attendanceQuery
                        ->whereDate('attendance_date', $date)
                        ->where('status', $this->statusFilter)
                )
            )
            ->orderBy('employee_code')
            ->paginate(20);

        return view('livewire.attendance.index', [
            'employees' => $employees,
            'departments' => Department::orderBy('name')->get(),
            'attendanceStatuses' => [
                'present' => 'Present',
                'absent' => 'Absent',
                'half_day' => 'Half Day',
                'on_leave' => 'On Leave',
            ],
            'shifts' => Shift::where('is_active', true)
                ->orderBy('name')
                ->get(),
        ])->layout('components.layouts.management', [
            'title' => 'Attendance Management',
        ]);
    }

    public function checkIn(int $employeeId): void
    {
        abort_unless(
            auth()->user()->can('attendance.check-in'),
            403
        );

        $date = $this->validate([
            'attendanceDate' => ['required', 'date'],
        ])['attendanceDate'];

        if ($date !== now()->toDateString()) {
            $this->addError(
                'attendanceDate',
                'Check-in and check-out are only allowed for today.'
            );
            return;
        }

        $employee = Employee::findOrFail($employeeId);

        $attendance = EmployeeAttendance::firstOrCreate(
            [
                'employee_id' => $employee->id,
                'attendance_date' => $date,
            ],
            [
                'shift_id' => $employee->shift_id,
                'status' => 'present',
                'recorded_by' => Auth::id(),
            ]
        );

        if ($attendance->check_in_at !== null) {
            $this->addError('checkIn', 'Check-in has already been recorded.');
            return;
        }

        if (in_array($attendance->status, ['absent', 'on_leave'], true)) {
            $this->addError(
                'checkIn',
                'Change attendance status to Present or Half Day before checking in.'
            );
            return;
        }

        $shift = Shift::find($attendance->shift_id);

        if (!$shift) {
            $this->addError(
                'checkIn',
                'Assign a valid shift before recording check-in.'
            );
            return;
        }

        $now = now();
        $shiftStartAt = \Illuminate\Support\Carbon::parse(
            $date . ' ' . $shift->start_time,
            config('app.timezone')
        );

        $attendance->update([
            'check_in_at' => $now,
            'is_late' => $now->greaterThan($shiftStartAt),
            'recorded_by' => Auth::id(),
        ]);

        $this->resetErrorBag('checkIn');
        $this->employeeAttendanceRefresh();

        session()->flash('success', 'Check-in recorded successfully.');
    }

    public function checkOut(int $employeeId): void
    {
        abort_unless(
            auth()->user()->can('attendance.check-out'),
            403
        );

        $date = $this->validate([
            'attendanceDate' => ['required', 'date'],
        ])['attendanceDate'];

        if ($date !== now()->toDateString()) {
            $this->addError(
                'attendanceDate',
                'Check-in and check-out are only allowed for today.'
            );
            return;
        }

        $attendance = EmployeeAttendance::query()
            ->where('employee_id', $employeeId)
            ->whereDate('attendance_date', $date)
            ->firstOrFail();

        if (!$attendance->check_in_at) {
            $this->addError(
                'checkOut',
                'Record check-in before checking out.'
            );
            return;
        }

        if ($attendance->check_out_at) {
            $this->addError(
                'checkOut',
                'Check-out has already been recorded.'
            );
            return;
        }

        $shift = Shift::find($attendance->shift_id);

        if (!$shift) {
            $this->addError(
                'checkOut',
                'Assign a valid shift before recording check-out.'
            );
            return;
        }

        $now = now();

        $shiftEndAt = \Illuminate\Support\Carbon::parse(
            $date . ' ' . $shift->end_time,
            config('app.timezone')
        );

        $attendance->update([
            'check_out_at' => $now,
            'left_early' => $now->lessThan($shiftEndAt),
            'recorded_by' => Auth::id(),
        ]);

        $this->resetErrorBag('checkOut');
        $this->employeeAttendanceRefresh();

        session()->flash('success', 'Check-out recorded successfully.');
    }

    private function employeeAttendanceRefresh(): void
    {
        // Refresh the component's current employee list on the next render.
        $this->resetPage();
    }
}

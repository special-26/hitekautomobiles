
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">
                Attendance Management
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Track daily employee attendance, shifts and working hours.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <label for="attendanceDate" class="text-sm font-medium text-slate-700">
                Attendance Date
            </label>
            <input
                id="attendanceDate"
                type="date"
                wire:model.live="attendanceDate"
                class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
            >
        </div>
    </div>

    {{-- Flash Message --}}
    @if (session()->has('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <p class="text-sm text-slate-500">Employees Listed</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">
                {{ $employees->total() }}
            </p>
            <p class="mt-1 text-xs text-slate-500">
                Matching current filters
            </p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <p class="text-sm text-slate-500">Present</p>
            <p class="mt-2 text-2xl font-bold text-green-700">
                {{ $employees->getCollection()->filter(fn ($employee) => $employee->attendances->first()?->status === 'present')->count() }}
            </p>
            <p class="mt-1 text-xs text-slate-500">
                On this page
            </p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <p class="text-sm text-slate-500">Absent</p>
            <p class="mt-2 text-2xl font-bold text-red-600">
                {{ $employees->getCollection()->filter(fn ($employee) => $employee->attendances->first()?->status === 'absent')->count() }}
            </p>
            <p class="mt-1 text-xs text-slate-500">
                On this page
            </p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <p class="text-sm text-slate-500">Not Recorded</p>
            <p class="mt-2 text-2xl font-bold text-amber-600">
                {{ $employees->getCollection()->filter(fn ($employee) => $employee->attendances->isEmpty())->count() }}
            </p>
            <p class="mt-1 text-xs text-slate-500">
                On this page
            </p>
        </div>

    </div>

    {{-- Attendance List --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

        {{-- Filters --}}
        <div class="border-b border-slate-200 p-5">
            <div class="grid grid-cols-1 gap-3 md:grid-cols-3">

                <div>
                    <label class="mb-1.5 block text-xs font-medium uppercase tracking-wide text-slate-500">
                        Search Employees
                    </label>
                    <input
                        type="search"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Name, code, phone or email..."
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
                    >
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-medium uppercase tracking-wide text-slate-500">
                        Department
                    </label>
                    <select
                        wire:model.live="departmentFilter"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
                    >
                        <option value="">All departments</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-medium uppercase tracking-wide text-slate-500">
                        Attendance Status
                    </label>
                    <select
                        wire:model.live="statusFilter"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
                    >
                        <option value="">All statuses</option>
                        @foreach ($attendanceStatuses as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="mt-3 flex justify-end">
                <button
                    type="button"
                    wire:click="clearFilters"
                    class="text-sm font-medium text-slate-600 hover:text-slate-900"
                >
                    Clear filters
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Employee</th>
                        <th class="px-5 py-3">Department</th>
                        <th class="px-5 py-3">Shift</th>
                        <th class="px-5 py-3">Check In</th>
                        <th class="px-5 py-3">Check Out</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Working Hours
                        </th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($employees as $employee)
                        @php
                            $attendance = $employee->attendances->first();

                            $status = $attendance?->status;

                            $statusClasses = match ($status) {
                                'present' => 'bg-green-100 text-green-700',
                                'absent' => 'bg-red-100 text-red-700',
                                'half_day' => 'bg-amber-100 text-amber-700',
                                'on_leave' => 'bg-blue-100 text-blue-700',
                                default => 'bg-slate-100 text-slate-600',
                            };

                            $statusLabel = $attendance
                                ? ($attendanceStatuses[$status] ?? ucfirst(str_replace('_', ' ', $status)))
                                : 'Not Recorded';
                        @endphp

                        <tr wire:key="attendance-employee-{{ $employee->id }}" class="hover:bg-slate-50">

                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50 font-semibold text-red-600">
                                        {{ strtoupper(substr($employee->user?->name ?? '?', 0, 1)) }}
                                    </div>

                                    <div class="min-w-0">
                                        <p class="font-medium text-slate-900">
                                            {{ $employee->user?->name ?? 'Unknown Employee' }}
                                        </p>
                                        <p class="mt-1 text-xs text-slate-500">
                                            {{ $employee->employee_code }}
                                            @if ($employee->designation)
                                                · {{ $employee->designation }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-slate-600">
                                {{ $employee->department?->name ?? '—' }}
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-slate-600">
                                {{ $attendance?->shiftRelation?->name ?? '—' }}
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-slate-600">
                                {{ $attendance?->check_in_at?->format('h:i A') ?? '—' }}
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-slate-600">
                                {{ $attendance?->check_out_at?->format('h:i A') ?? '—' }}
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-700">
                                {{ $attendance?->working_hours_formatted ?? '—' }}
                            </td>

                            <td class="whitespace-nowrap px-5 py-4">
                                <span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $statusClasses }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            
                            <td class="whitespace-nowrap px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if ($attendance)
                                        @can('attendance.check-in')
                                            @if (!$attendance->check_in_at && !in_array($attendance->status, ['absent', 'on_leave'], true))
                                                <button
                                                    type="button"
                                                    wire:click="checkIn({{ $employee->id }})"
                                                    wire:loading.attr="disabled"
                                                    wire:target="checkIn({{ $employee->id }})"
                                                    class="rounded-lg bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700 disabled:opacity-50"
                                                >
                                                    Check In
                                                </button>
                                            @endif
                                        @endcan

                                        @can('attendance.check-out')
                                            @if ($attendance->check_in_at && !$attendance->check_out_at)
                                                <button
                                                    type="button"
                                                    wire:click="checkOut({{ $employee->id }})"
                                                    wire:loading.attr="disabled"
                                                    wire:target="checkOut({{ $employee->id }})"
                                                    class="rounded-lg bg-hitek-red px-3 py-2 text-sm font-medium text-white hover:bg-hitek-red-hover disabled:opacity-50"
                                                >
                                                    Check Out
                                                </button>
                                            @endif
                                        @endcan

                                        @if ($attendance->check_out_at)
                                            <span class="text-xs font-medium text-green-700">
                                                Completed
                                            </span>
                                        @endif
                                    @else
                                        @can('attendance.manage')
                                            <button
                                                type="button"
                                                wire:click="openAttendanceModal({{ $employee->id }})"
                                                class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
                                            >
                                                Mark Attendance
                                            </button>
                                        @else
                                            <span class="text-xs text-slate-400">Not marked</span>
                                        @endcan
                                    @endif

                                    @can('attendance.manage')
                                        @if ($attendance)
                                            <button
                                                type="button"
                                                wire:click="openAttendanceModal({{ $employee->id }})"
                                                class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
                                            >
                                                Edit
                                            </button>
                                        @endif
                                    @endcan
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center">
                                <p class="font-medium text-slate-900">No employees found</p>
                                <p class="mt-1 text-sm text-slate-500">
                                    Try changing the search or filters.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($employees->hasPages())
            <div class="border-t border-slate-200 px-5 py-4">
                {{ $employees->links() }}
            </div>
        @endif

    </div>


    {{-- ATTENDANCE MODAL --}}
    @if ($showAttendanceModal)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-slate-900/50 p-4"
            wire:click.self="closeAttendanceModal"
        >
            <div class="my-auto w-full max-w-xl overflow-hidden rounded-xl bg-white shadow-xl">

                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                    <div>
                        <h2 class="font-semibold text-slate-900">
                            {{ $employeeName = \App\Models\Employee::with('user')->find($editingEmployeeId)?->user?->name ?? 'Employee' }}
                        </h2>
                        <p class="mt-1 text-xs text-slate-500">
                            Attendance for {{ \Carbon\Carbon::parse($attendanceDate)->format('d M Y') }}
                        </p>
                    </div>

                    <button
                        type="button"
                        wire:click="closeAttendanceModal"
                        class="text-xl text-slate-400 hover:text-slate-600"
                    >
                        ×
                    </button>
                </div>

                <form wire:submit="saveAttendance">
                    <div class="space-y-5 p-6">

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Shift *
                            </label>
                            <select
                                wire:model="attendanceShift"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
                            >
                                <option value="">Select shift</option>
                                @foreach ($shifts as $shift)
                                    <option value="{{ $shift->id }}">
                                        {{ $shift->name }}
                                        ({{ \Carbon\Carbon::parse($shift->start_time)->format('g:i A') }}
                                        – {{ \Carbon\Carbon::parse($shift->end_time)->format('g:i A') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('attendanceShift')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Attendance Status *
                            </label>
                            <select
                                wire:model="attendanceStatus"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
                            >
                                <option value="present">Present</option>
                                <option value="absent">Absent</option>
                                <option value="half_day">Half Day</option>
                                <option value="on_leave">On Leave</option>
                            </select>
                            @error('attendanceStatus')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Notes
                            </label>
                            <textarea
                                wire:model="attendanceNotes"
                                rows="3"
                                placeholder="Optional attendance notes"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
                            ></textarea>
                            @error('attendanceNotes')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div class="flex justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4">
                        <button
                            type="button"
                            wire:click="closeAttendanceModal"
                            class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            wire:target="saveAttendance"
                            class="rounded-lg bg-hitek-red px-5 py-2.5 text-sm font-semibold text-white hover:bg-hitek-red-hover disabled:opacity-60"
                        >
                            <span wire:loading.remove wire:target="saveAttendance">
                                Save Attendance
                            </span>
                            <span wire:loading wire:target="saveAttendance">
                                Saving...
                            </span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    @endif


</div>


<div class="space-y-6">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Monthly Attendance Summary
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Review employee attendance for {{ $monthLabel }}.
            </p>
        </div>

        <div class="flex items-end gap-3">
            <div>
                <label for="attendance-month"
                    class="mb-1.5 block text-sm font-medium text-slate-700">
                    Attendance Month
                </label>
                <input
                    id="attendance-month"
                    type="month"
                    wire:model.live="month"
                    class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                />
                @error('month')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <button
                type="button"
                wire:click="exportExcel"
                wire:loading.attr="disabled"
                wire:target="exportExcel"
                class="rounded-lg bg-hitek-red px-4 py-2.5 text-sm font-semibold text-white hover:bg-hitek-red-hover disabled:opacity-50"
            >
                Export Excel
            </button>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 lg:grid-cols-5">
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <p class="text-sm text-slate-500">Employees</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">
                {{ $totals['employees'] }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <p class="text-sm text-slate-500">Present Records</p>
            <p class="mt-2 text-2xl font-bold text-green-700">
                {{ $totals['present'] }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <p class="text-sm text-slate-500">Absent Records</p>
            <p class="mt-2 text-2xl font-bold text-red-700">
                {{ $totals['absent'] }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <p class="text-sm text-slate-500">Half-Day Records</p>
            <p class="mt-2 text-2xl font-bold text-amber-700">
                {{ $totals['half_days'] }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <p class="text-sm text-slate-500">Leave Records</p>
            <p class="mt-2 text-2xl font-bold text-blue-700">
                {{ $totals['leave'] }}
            </p>
        </div>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-5 py-4">
            <h2 class="font-semibold text-slate-900">Employee Breakdown</h2>
            <p class="mt-1 text-sm text-slate-500">
                Attendance records for the selected month.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                            Employee
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                            Department
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase text-slate-500">
                            Present
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase text-slate-500">
                            Absent
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase text-slate-500">
                            Half Day
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase text-slate-500">
                            Leave
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                            Working Hours
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase text-slate-500">
                            Late
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase text-slate-500">
                            Left Early
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase text-slate-500">
                            Not Marked
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($rows as $row)
                        <tr class="hover:bg-slate-50">
                            <td class="whitespace-nowrap px-4 py-4">
                                <p class="text-sm font-medium text-slate-900">
                                    {{ $row->employee->user?->name ?? '—' }}
                                </p>
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $row->employee->employee_code }}
                                </p>
                            </td>

                            <td class="whitespace-nowrap px-4 py-4 text-sm text-slate-600">
                                {{ $row->employee->department?->name ?? '—' }}
                            </td>

                            <td class="px-4 py-4 text-center text-sm font-medium text-green-700">
                                {{ $row->present_days }}
                            </td>

                            <td class="px-4 py-4 text-center text-sm font-medium text-red-700">
                                {{ $row->absent_days }}
                            </td>

                            <td class="px-4 py-4 text-center text-sm text-amber-700">
                                {{ $row->half_days }}
                            </td>

                            <td class="px-4 py-4 text-center text-sm text-blue-700">
                                {{ $row->leave_days }}
                            </td>

                            <td class="whitespace-nowrap px-4 py-4 text-sm text-slate-700">
                                {{ intdiv($row->working_minutes, 60) }} h
                                {{ sprintf('%02d', $row->working_minutes % 60) }} min
                            </td>

                            <td class="px-4 py-4 text-center text-sm text-slate-700">
                                {{ $row->late_count }}
                            </td>

                            <td class="px-4 py-4 text-center text-sm text-slate-700">
                                {{ $row->early_count }}
                            </td>

                            <td class="px-4 py-4 text-center text-sm">
                                @php
                                    $notMarked = max(
                                        0,
                                        now()->parse($month . '-01')->daysInMonth
                                        - $row->records_count
                                    );
                                @endphp

                                <span class="font-medium {{ $notMarked > 0 ? 'text-amber-700' : 'text-slate-500' }}">
                                    {{ $notMarked }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-5 py-12 text-center">
                                <p class="font-medium text-slate-700">
                                    No employees found
                                </p>
                                <p class="mt-1 text-sm text-slate-500">
                                    Add employee records to see the attendance summary.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <p class="text-sm text-slate-500">
        Not Marked is a provisional count based on calendar days, including
        weekends and future dates. It is not an absence or a payroll deduction.
        We'll refine this when we define working days, weekly offs, and holidays.
    </p>
</div>

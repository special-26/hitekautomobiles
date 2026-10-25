<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Employees
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Manage employees, roles and employment status.
            </p>
        </div>

        @can('employees.create')
            <a
                href="{{ route('employees.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-hitek-red px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-hitek-red-hover"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 5v14M5 12h14"
                    />
                </svg>

                Add Employee
            </a>
        @endcan
    </div>


    {{-- Filters --}}
    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">

        <div class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-4">

            {{-- Search --}}
            <div class="">
                <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                    Search
                </label>

                <div class="relative">
                    <svg
                        class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                        />
                    </svg>

                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Name, email, employee code, phone..."
                        class="w-full rounded-lg border border-slate-300 py-2.5 pl-9 pr-3 text-sm outline-none transition focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >
                </div>
            </div>


            {{-- Department --}}
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                    Department
                </label>

                <select
                    wire:model.live="department"
                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                >
                    <option value="">All Departments</option>

                    @foreach($departments as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Role --}}
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                    Role
                </label>

                <select
                    wire:model.live="role"
                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                >
                    <option value="">All Roles</option>

                    <option value="Admin">Admin</option>
                    <option value="Advisor">Advisor</option>
                    <option value="Floor Manager">Floor Manager</option>
                    <option value="Mechanic Coordinator">Mechanic Coordinator</option>
                    <option value="Mechanic">Mechanic</option>
                    <option value="Auto Parts Store Manager">Auto Parts Store Manager</option>
                    <option value="General Store Manager">General Store Manager</option>
                    <option value="Customer Support">Customer Support</option>
                </select>
            </div>


            {{-- Status --}}
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                    Status
                </label>

                <select
                    wire:model.live="status"
                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                >
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="on_leave">On Leave</option>
                    <option value="terminated">Terminated</option>
                </select>
            </div>

        </div>


        {{-- Filter actions --}}
        @if($search !== '' || $department !== '' || $role !== '' || $status !== '')
            <div class="mt-3 flex justify-end">
                <button
                    type="button"
                    wire:click="clearFilters"
                    class="text-xs font-semibold text-slate-500 hover:text-slate-900"
                >
                    Clear filters
                </button>
            </div>
        @endif

    </div>


    {{-- Employee Table --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="border-b border-slate-200 bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Employee
                        </th>

                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Code
                        </th>

                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Department
                        </th>

                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Designation
                        </th>

                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Role
                        </th>

                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Joining Date
                        </th>

                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Status
                        </th>

                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Action
                        </th>
                    </tr>
                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse($employees as $employee)

                        <tr class="transition hover:bg-slate-50">

                            {{-- Employee --}}
                            <td class="px-5 py-4">
                                <a
                                    href="{{ route('employees.show', $employee) }}"
                                    class="font-medium text-slate-900 hover:text-hitek-red"
                                >
                                    {{ $employee->user?->name ?? '—' }}
                                </a>

                                <div class="mt-0.5 text-xs text-slate-500">
                                    {{ $employee->user?->email ?? '—' }}
                                </div>
                            </td>


                            {{-- Code --}}
                            <td class="px-5 py-4 font-medium text-slate-700">
                                {{ $employee->employee_code }}
                            </td>


                            {{-- Department --}}
                            <td class="px-5 py-4 text-slate-600">
                                {{ $employee->department?->name ?? '—' }}
                            </td>


                            {{-- Designation --}}
                            <td class="px-5 py-4 text-slate-600">
                                {{ $employee->designation ?? '—' }}
                            </td>


                            {{-- Role --}}
                            <td class="px-5 py-4">
                                @forelse($employee->user?->roles ?? [] as $role)
                                    <span class="inline-flex rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-700">
                                        {{ $role->name }}
                                    </span>
                                @empty
                                    <span class="text-xs text-slate-400">
                                        —
                                    </span>
                                @endforelse
                            </td>


                            {{-- Joining Date --}}
                            <td class="px-5 py-4 text-slate-600">
                                {{ $employee->joining_date?->format('d M Y') ?? '—' }}
                            </td>


                            {{-- Status --}}
                            <td class="px-5 py-4">

                                @php
                                    $statusClasses = match ($employee->status) {
                                        'active' => 'bg-emerald-50 text-emerald-700',
                                        'inactive' => 'bg-slate-100 text-slate-600',
                                        'on_leave' => 'bg-amber-50 text-amber-700',
                                        'terminated' => 'bg-red-50 text-red-700',
                                        default => 'bg-slate-100 text-slate-600',
                                    };
                                @endphp

                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClasses }}">
                                    {{ str_replace('_', ' ', ucfirst($employee->status)) }}
                                </span>

                            </td>


                            {{-- Action --}}
                            <td class="px-5 py-4 text-right">

                                @can('employees.update')
                                    <a
                                        href="{{ route('employees.edit', $employee) }}"
                                        class="text-xs font-semibold text-hitek-red hover:text-hitek-red-hover"
                                    >
                                        Edit
                                    </a>
                                @endcan

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center">

                                <div class="text-sm font-semibold text-slate-700">
                                    No employees found
                                </div>

                                <p class="mt-1 text-xs text-slate-500">
                                    Try changing your search or filters.
                                </p>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($employees->hasPages())
            <div class="border-t border-slate-200 px-5 py-4">
                {{ $employees->links() }}
            </div>
        @endif

    </div>

</div>
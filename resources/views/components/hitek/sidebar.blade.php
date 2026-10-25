<aside
    class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col bg-hitek-sidebar text-white"
>
    {{-- Logo --}}
    <div class="flex h-16 shrink-0 items-center border-b border-white/10 px-5">
        <a href="{{ url('/dashboard') }}" class="flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-hitek-red">
                <span class="text-sm font-bold">H</span>
            </div>

            <div>
                <div class="text-sm font-bold tracking-wide">
                    HITEK
                </div>
                <div class="text-[10px] font-medium tracking-widest text-slate-400">
                    MOTORZ
                </div>
            </div>
        </a>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto px-3 py-5">

        {{-- Main --}}
        @if(auth()->user()->can('dashboard.view'))
            <div class="mb-6">
                <p class="mb-2 px-3 text-[10px] font-semibold uppercase tracking-wider text-slate-500">
                    Main
                </p>

                <a
                    href="{{ url('/dashboard') }}"
                    class="flex items-center gap-3 rounded-lg bg-hitek-red px-3 py-2.5 text-sm font-medium text-white"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m3 12 9-9 9 9M5 10v10h14V10M9 20v-6h6v6"/>
                    </svg>

                    Dashboard
                </a>
            </div>
        @endif


        {{-- Workshop --}}
        @if(
            auth()->user()->can('job-cards.view') ||
            auth()->user()->can('customers.view') ||
            auth()->user()->can('vehicles.view') ||
            auth()->user()->can('bays.view')
        )
            <div class="mb-6">
                <p class="mb-2 px-3 text-[10px] font-semibold uppercase tracking-wider text-slate-500">
                    Workshop
                </p>

                <div class="space-y-1">

                    {{-- Job Cards --}}
                    @can('job-cards.view')
                        <a
                            href="{{ route('job-cards.index') }}"
                            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white"
                        >
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 13h2l1-4h12l1 4h2M5 13v5m14-5v5M7 18h10M7 9l2-4h6l2 4"/>
                            </svg>

                            Job Cards
                        </a>
                    @endcan


                    {{-- Customers --}}
                    @can('customers.view')
                        <a
                            href="{{ route('customers.index') }}"
                            wire:navigate
                            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white"
                        >
                            <x-icon name="users" outline />
                            Customers
                        </a>
                    @endcan


                    {{-- Vehicles --}}
                    @can('vehicles.view')
                        <a
                            href="#"
                            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white"
                        >
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 13h18M5 13l1-5h12l1 5M5 13v5h14v-5M8 18v2m8-2v2"/>
                            </svg>

                            Vehicles
                        </a>
                    @endcan


                    {{-- Bays --}}
                    @can('bays.view')
                        <a
                            href="{{ route('bays.index') }}"
                            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white"
                        >
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 20V10m5 10V4m6 16v-7m5 7V7"/>
                            </svg>

                            Bays
                        </a>
                    @endcan

                </div>
            </div>
        @endif


        {{-- Operations --}}
        @if(
            auth()->user()->can('job-cards-tasks.view') ||
            auth()->user()->can('inventory.view') ||
            auth()->user()->can('parts.view')
        )
            <div class="mb-6">
                <p class="mb-2 px-3 text-[10px] font-semibold uppercase tracking-wider text-slate-500">
                    Operations
                </p>

                <div class="space-y-1">

                    {{-- Tasks --}}
                    @can('job-cards-tasks.view')
                        <a
                            href="#"
                            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white"
                        >
                            <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                            Tasks
                        </a>
                    @endcan


                    {{-- Inventory --}}
                    @if(
                        auth()->user()->can('inventory.view') ||
                        auth()->user()->can('parts.view')
                    )
                        <a
                            href="#"
                            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white"
                        >
                            <span class="h-2 w-2 rounded-full bg-blue-400"></span>
                            Inventory
                        </a>
                    @endif

                </div>
            </div>
        @endif


        {{-- Business --}}
        @if(
            auth()->user()->can('reports.view') ||
            auth()->user()->can('customers.view')
        )
            <div class="mb-6">
                <p class="mb-2 px-3 text-[10px] font-semibold uppercase tracking-wider text-slate-500">
                    Business
                </p>

                <div class="space-y-1">

                    {{-- CRM --}}
                    @can('customers.view')
                        <a
                            href="#"
                            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white"
                        >
                            CRM
                        </a>
                    @endcan


                    {{-- Reports --}}
                    @can('reports.view')
                        <a
                            href="#"
                            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white"
                        >
                            Reports
                        </a>
                    @endcan

                </div>
            </div>
        @endif


        {{-- Administration --}}
        @if(
            auth()->user()->can('employees.view') ||
            auth()->user()->can('finance.view') ||
            auth()->user()->can('payroll.view') ||
            auth()->user()->can('settings.view') ||
            auth()->user()->can('admin-users.view')
        )
            <div>
                <p class="mb-2 px-3 text-[10px] font-semibold uppercase tracking-wider text-slate-500">
                    Administration
                </p>

                <div class="space-y-1">

                    {{-- Employees --}}
                    @can('attendance.view')
                        <a
                            href="{{route('attendance.index')}}"
                            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white"
                        >
                            <x-icon name="cursor-arrow-ripple" outline />
                            Attendace
                        </a>
                    @endcan

                    {{-- Employees --}}
                    @can('employees.view')
                        <a
                            href="{{route('employees.index')}}"
                            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white"
                        >
                            <x-icon name="user-group" outline />
                            Employees
                        </a>
                    @endcan


                    {{-- Finance --}}
                    @can('finance.view')
                        <a
                            href="#"
                            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white"
                        >
                            <x-icon name="currency-rupee" outline />
                            Finance
                        </a>
                    @endcan


                    {{-- Payroll --}}
                    @can('payroll.view')
                        <a
                            href="{{route('payroll.index')}}"
                            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white"
                        >
                            <x-icon name="credit-card" outline />
                            Payroll
                        </a>
                    @endcan


                    {{-- Settings --}}
                    @can('settings.view')
                        <a
                            href="#"
                            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white"
                        >
                            <x-icon name="cog" outline />
                            Settings
                        </a>
                    @endcan


                    {{-- Admin Users --}}
                    @can('admin-users.view')
                        <a
                            href="#"
                            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white"
                        >
                            <x-icon name="building-library" outline />
                            Admin Users
                        </a>
                    @endcan

                </div>
            </div>
        @endif

    </nav>


    {{-- Bottom --}}
    <div class="border-t border-white/10 p-4">
        <div class="rounded-lg bg-white/5 px-3 py-3">
            <p class="text-xs font-medium text-white">
                Hitek Automobiles
            </p>

            <p class="mt-1 text-[10px] text-slate-500">
                Workshop Management System
            </p>
        </div>
    </div>
</aside>
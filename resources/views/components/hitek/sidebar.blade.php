
<div class="contents">
    {{-- Mobile overlay --}}
    <div
        x-show="open"
        x-transition.opacity
        @click="open = false"
        class="fixed inset-0 z-40 bg-black/50 md:hidden"
        style="display: none;"
    ></div>

    <aside
        class="fixed inset-y-0 left-0 z-50 flex flex-col
            bg-hitek-sidebar text-white
            transition-all duration-300 ease-in-out
            -translate-x-full md:translate-x-0"
        :class="{
            'w-64': !collapsed,
            'w-[72px]': collapsed,
            'translate-x-0': open,
            '-translate-x-full': !open
        }"
    >

        {{-- Logo --}}
        <div class="flex h-16 shrink-0 items-center border-b border-white/10 px-5">
            <a href="{{ url('/dashboard') }}" class="flex items-center gap-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-hitek-red">
                    <span class="text-sm font-bold">H</span>
                </div>

                <div x-show="!collapsed" x-transition>
                    <div class="text-sm font-bold tracking-wide">HITEK</div>
                    <div class="text-[10px] font-medium tracking-widest text-slate-400">
                        WORKSHOP
                    </div>
                </div>
            </a>

            {{-- Mobile close --}}
            <button
                @click="open = false"
                class="ml-auto md:hidden text-slate-400 hover:text-white"
            >
                ✕
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="sidebar-nav flex-1 overflow-y-auto overflow-x-hidden px-3 py-5">

            {{-- Main --}}
            @can('dashboard.view')
                <div class="mb-6">
                    <p
                        x-show="!collapsed"
                        class="mb-2 px-3 text-[10px] font-semibold uppercase tracking-wider text-slate-500"
                    >
                        Main
                    </p>

                    <a href="{{ url('/dashboard') }}"
                       title="Dashboard"
                       class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('dashboard') || request()->is('dashboard')
                            ? 'bg-hitek-red text-white'
                            : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                    >
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="m3 12 9-9 9 9M5 10v10h14V10M9 20v-6h6v6"/>
                        </svg>
                        <span x-show="!collapsed" x-transition>Dashboard</span>
                    </a>
                </div>
            @endcan

            {{-- Workshop --}}
            @if(auth()->user()->can('job-cards.view') ||
                auth()->user()->can('customers.view') ||
                auth()->user()->can('vehicles.view') ||
                auth()->user()->can('bays.view'))

                <div class="mb-6">
                    <p x-show="!collapsed"
                       class="mb-2 px-3 text-[10px] font-semibold uppercase tracking-wider text-slate-500">
                        Workshop
                    </p>

                    <div class="space-y-1">

                        @can('job-cards.view')
                            <a href="{{ route('job-cards.index') }}"
                               title="Job Cards"
                               class="flex min-h-11 items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition
                                {{ request()->routeIs('job-cards.*')
                                    ? 'bg-hitek-red text-white'
                                    : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                            >
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3 13h2l1-4h12l1 4h2M5 13v5m14-5v5M7 18h10M7 9l2-4h6l2 4"/>
                                </svg>
                                <span x-show="!collapsed" x-transition>Job Cards</span>
                            </a>
                        @endcan

                        @can('customers.view')
                            <a href="{{ route('customers.index') }}"
                               wire:navigate title="Customers"
                               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition
                                {{ request()->routeIs('customers.*')
                                    ? 'bg-hitek-red text-white'
                                    : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                            >
                                <x-icon name="users" outline class="h-5 w-5 shrink-0" />
                                <span x-show="!collapsed">Customers</span>
                            </a>
                        @endcan

                        @can('vehicles.view')
                            <a href="#"
                               title="Vehicles"
                               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition
                                {{ request()->routeIs('vehicles.*')
                                    ? 'bg-hitek-red text-white'
                                    : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                            >
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3 13h18M5 13l1-5h12l1 5M5 13v5h14v-5M8 18v2m8-2v2"/>
                                </svg>
                                <span x-show="!collapsed">Vehicles</span>
                            </a>
                        @endcan

                        @can('bays.view')
                            <a href="{{ route('bays.index') }}"
                               title="Bays"
                               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M4 20V10m5 10V4m6 16v-7m5 7V7"/>
                                </svg>
                                <span x-show="!collapsed">Bays</span>
                            </a>
                        @endcan
                    </div>
                </div>
            @endif

            {{-- Operations --}}
            @if(auth()->user()->can('job-cards-tasks.view') ||
                auth()->user()->can('inventory.view') ||
                auth()->user()->can('parts.view'))

                <div class="mb-6">
                    <p x-show="!collapsed"
                       class="mb-2 px-3 text-[10px] font-semibold uppercase tracking-wider text-slate-500">
                        Operations
                    </p>

                    <div class="space-y-1">
                        <a href="{{ route('marketing-studio.index') }}" title="graphics"
                            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">
                            <x-icon name="photo" outline class="h-5 w-5 shrink-0" />
                            <span x-show="!collapsed">Graphics</span>
                        </a>

                        @if(auth()->user()->can('inventory.view') ||
                            auth()->user()->can('parts.view'))
                            <a href="#" title="Inventory"
                               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">
                                <span class="h-2 w-2 shrink-0 rounded-full bg-blue-400"></span>
                                <span x-show="!collapsed">Inventory</span>
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Business --}}
            @if(auth()->user()->can('reports.view') ||
                auth()->user()->can('customers.view'))

                <div class="mb-6">
                    <p x-show="!collapsed"
                       class="mb-2 px-3 text-[10px] font-semibold uppercase tracking-wider text-slate-500">
                        Business
                    </p>

                    <div class="space-y-1">
                        @can('customers.view')
                            <a href="#" title="CRM"
                               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">
                                <x-icon name="users" outline class="h-5 w-5 shrink-0" />
                                <span x-show="!collapsed">CRM</span>
                            </a>
                        @endcan

                        @can('reports.view')
                            <a href="#" title="Reports"
                               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">
                                <x-icon name="chart-bar" outline class="h-5 w-5 shrink-0" />
                                <span x-show="!collapsed">Reports</span>
                            </a>
                        @endcan
                    </div>
                </div>
            @endif

            {{-- Administration --}}
            @if(auth()->user()->can('employees.view') ||
                auth()->user()->can('finance.view') ||
                auth()->user()->can('payroll.view') ||
                auth()->user()->can('settings.view') ||
                auth()->user()->can('admin-users.view') ||
                auth()->user()->can('attendance.view'))

                <div class="mb-6">
                    <p x-show="!collapsed"
                       class="mb-2 px-3 text-[10px] font-semibold uppercase tracking-wider text-slate-500">
                        Administration
                    </p>

                    <div class="space-y-1">
                        @can('attendance.view')
                            <a href="{{ route('attendance.index') }}" title="Attendance"
                               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">
                                <x-icon name="cursor-arrow-ripple" outline class="h-5 w-5 shrink-0" />
                                <span x-show="!collapsed">Attendance</span>
                            </a>
                        @endcan

                        @can('employees.view')
                            <a href="{{ route('employees.index') }}" title="Employees"
                               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">
                                <x-icon name="user-group" outline class="h-5 w-5 shrink-0" />
                                <span x-show="!collapsed">Employees</span>
                            </a>
                        @endcan

                        @can('finance.view')
                            <a href="#" title="Finance"
                               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">
                                <x-icon name="currency-rupee" outline class="h-5 w-5 shrink-0" />
                                <span x-show="!collapsed">Finance</span>
                            </a>
                        @endcan

                        @can('payroll.view')
                            <a href="{{ route('payroll.index') }}" title="Payroll"
                               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">
                                <x-icon name="credit-card" outline class="h-5 w-5 shrink-0" />
                                <span x-show="!collapsed">Payroll</span>
                            </a>
                        @endcan

                        @can('settings.view')
                            <a href="#" title="Settings"
                               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">
                                <x-icon name="cog" outline class="h-5 w-5 shrink-0" />
                                <span x-show="!collapsed">Settings</span>
                            </a>
                        @endcan

                        @can('admin-users.view')
                            <a href="#" title="Admin Users"
                               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">
                                <x-icon name="building-library" outline class="h-5 w-5 shrink-0" />
                                <span x-show="!collapsed">Admin Users</span>
                            </a>
                        @endcan
                    </div>
                </div>
            @endif

        </nav>

        {{-- Bottom --}}
        <div class="border-t border-white/10 p-4">
            <div class="rounded-lg bg-white/5 px-3 py-3">
                <p x-show="!collapsed" class="text-xs font-medium text-white">
                    Hitek Automobiles
                </p>
                <p x-show="!collapsed" class="mt-1 text-[10px] text-slate-500">
                    Workshop Management System
                </p>
                <p x-show="collapsed" class="text-center text-xs font-bold">H</p>
            </div>
        </div>
    </aside>

    {{-- Mobile hamburger + tablet collapse control --}}
    <div class="fixed left-0 right-0 top-0 z-30 flex h-14 items-center
                justify-between border-b border-slate-200 bg-white px-4
                md:hidden">
        <button @click="open = true" class="text-slate-700">
            <x-icon name="bars-3" class="h-6 w-6" />
        </button>
        <span class="text-sm font-bold text-slate-800">HITEK BAYS</span>
    </div>

    <button
        @click="collapsed = !collapsed"
        class="fixed bottom-5 left-4 z-30 hidden h-9 w-9 items-center
               justify-center rounded-lg border border-slate-200
               bg-white text-slate-600 shadow md:flex"
        :style="collapsed ? 'left: 88px' : 'left: 272px'"
        title="Toggle sidebar"
    >
        <span x-text="collapsed ? '→' : '←'"></span>
    </button>
</div>

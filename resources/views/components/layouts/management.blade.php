<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')

    <tallstackui:script />
    @livewireStyles
</head>


<body class="min-h-screen bg-slate-100 text-slate-900 antialiased">

    <x-toast />
    <x-dialog />

    {{-- Shared responsive sidebar state --}}
    <div
        x-data="{
            open: false,
            collapsed: window.innerWidth >= 768 && window.innerWidth < 1024,

            init() {
                window.addEventListener('resize', () => {
                    if (window.innerWidth < 768) {
                        this.open = false;
                        this.collapsed = false;
                    } else if (window.innerWidth < 1024) {
                        this.open = false;
                        this.collapsed = true;
                    } else {
                        this.open = false;
                        this.collapsed = false;
                    }
                });
            }
        }"
        class="min-h-screen"
    >
        <x-hitek.sidebar />

        <div
            class="min-h-screen transition-all duration-300"
            :class="collapsed ? 'md:ml-[72px]' : 'md:ml-64'"
        >

            <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white px-4 sm:px-6">

                <div class="flex items-center gap-3">

                    {{-- Mobile menu --}}
                    <button
                        type="button"
                        @click="open = true"
                        class="flex h-10 w-10 items-center justify-center rounded-lg text-slate-700 hover:bg-slate-100 md:hidden"
                    >
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    {{-- Tablet toggle only --}}
                    <button
                        type="button"
                        @click="collapsed = !collapsed"
                        class="hidden h-9 w-9 items-center justify-center rounded-lg text-slate-600 hover:bg-slate-100 md:flex lg:hidden"
                        title="Toggle sidebar"
                    >
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <div>
                        <h1 class="text-sm font-semibold text-slate-900">
                            {{ $title ?? 'Dashboard' }}
                        </h1>
                        <p class="text-xs text-slate-500">
                            Hitek Workshop Management
                        </p>
                    </div>
                </div>

                {{-- Header actions --}}
                <div class="flex items-center gap-2 sm:gap-3">

                    {{-- Search --}}
                    <button
                        type="button"
                        class="hidden h-9 items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 text-xs text-slate-500 transition hover:bg-slate-100 lg:flex"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                        </svg>

                        <span>Search</span>

                        <span class="ml-4 rounded border border-slate-200 bg-white px-1.5 py-0.5 text-[10px]">
                            /
                        </span>
                    </button>

                    {{-- Notifications --}}
                    <button
                        type="button"
                        class="relative flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100 hover:text-slate-900"
                    >
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 0 0-12 0v3.2c0 .53-.21 1.04-.59 1.4L4 17h5m6 0a3 3 0 0 1-6 0"/>
                        </svg>

                        <span class="absolute right-2 top-2 h-1.5 w-1.5 rounded-full bg-hitek-red"></span>
                    </button>

                    {{-- User --}}
                    <div class="flex items-center gap-2 border-l border-slate-200 pl-3 sm:gap-3 sm:pl-4">

                        <div class="hidden text-right sm:block">
                            <p class="text-xs font-semibold text-slate-900">
                                {{ auth()->user()->name ?? 'Admin User' }}
                            </p>

                            <p class="text-[10px] text-slate-500">
                                Administrator
                            </p>
                        </div>

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-hitek-red text-sm font-semibold text-white">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>

                    </div>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="rounded-lg border border-red-600 px-2 py-1.5 text-xs text-red-800 hover:bg-red-50 sm:px-3 sm:text-sm"
                            data-test="logout-button"
                        >
                            <span class="hidden sm:inline">Log Out</span>
                            <span class="sm:hidden">Exit</span>
                        </button>
                    </form>

                </div>

            </header>

            {{-- Page Content --}}
            <main class="p-4 sm:p-6">
                {{ $slot }}
            </main>

        </div>

    </div>

    @livewireScripts

</body>


</html>
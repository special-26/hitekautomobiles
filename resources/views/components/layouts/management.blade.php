<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')

    @livewireStyles
</head>

<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">

    <div class="min-h-screen">

        {{-- Sidebar --}}
        <x-hitek.sidebar />

        {{-- Main content area --}}
        <div class="min-h-screen pl-64">

            {{-- Top Header --}}
            <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white px-6">

                {{-- Page information --}}
                <div>
                    <h1 class="text-sm font-semibold text-slate-900">
                        {{ $title ?? 'Dashboard' }}
                    </h1>

                    <p class="text-xs text-slate-500">
                        Hitek Workshop Management
                    </p>
                </div>

                {{-- Header actions --}}
                <div class="flex items-center gap-3">

                    {{-- Search --}}
                    <button
                        type="button"
                        class="hidden h-9 items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 text-xs text-slate-500 transition hover:bg-slate-100 lg:flex"
                    >
                        <svg
                            class="h-4 w-4"
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
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 0 0-12 0v3.2c0 .53-.21 1.04-.59 1.4L4 17h5m6 0a3 3 0 0 1-6 0"
                            />
                        </svg>

                        <span class="absolute right-2 top-2 h-1.5 w-1.5 rounded-full bg-hitek-red"></span>
                    </button>

                    {{-- User --}}
                    <div class="flex items-center gap-3 border-l border-slate-200 pl-4">

                        <div class="hidden text-right sm:block">
                            <p class="text-xs font-semibold text-slate-900">
                                {{ auth()->user()->name ?? 'Admin User' }}
                            </p>

                            <p class="text-[10px] text-slate-500">
                                Administrator
                            </p>
                        </div>

                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-hitek-red text-sm font-semibold text-white">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>

                    </div>

                </div>

            </header>

            {{-- Page Content --}}
            <main class="p-6">
                {{ $slot }}
            </main>

        </div>

    </div>

    @livewireScripts

</body>

</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')

    @livewireStyles
    @fluxAppearance
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

    <!-- Put this right before your closing </body> tag. No PHP or sessions allowed here! -->
    <div x-data="{ 
            show: false, 
            type: 'info', 
            heading: '', 
            text: '',
            styles: {
                success: { icon: '✓', color: 'text-emerald-500 bg-emerald-500/10 border-emerald-500/20' },
                danger:  { icon: '✕', color: 'text-rose-500 bg-rose-500/10 border-rose-500/20' },
                info:    { icon: '⚡', color: 'text-zinc-400 bg-zinc-800/50 border-zinc-700/50' }
            }
        }"
        x-on:notify.window="
            type = $event.detail.type || 'info';
            heading = $event.detail.heading || '';
            text = $event.detail.text || '';
            show = true;
            setTimeout(() => show = false, 4000);
        "
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none;"
        class="fixed bottom-5 right-5 z-50 flex max-w-sm w-full gap-3 bg-zinc-900 border border-zinc-800 rounded-xl p-4 shadow-xl shadow-black/40 backdrop-blur-md">
        
        <!-- Dynamic Icon Badge -->
        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md border text-xs font-bold font-mono"
            :class="styles[type]?.color">
            <span x-text="styles[type]?.icon"></span>
        </div>
        
        <!-- Text Content -->
        <div class="flex-1 pt-0.5">
            <h3 x-show="heading" class="text-sm font-medium text-white leading-5" x-text="heading"></h3>
            <p class="text-sm text-zinc-400 leading-5" :class="heading ? 'mt-1' : ''" x-text="text"></p>
        </div>
        
        <!-- Dismiss Button -->
        <button @click="show = false" class="h-5 w-5 shrink-0 flex items-center justify-center rounded-md text-zinc-500 hover:text-zinc-300 hover:bg-zinc-800/50 transition">
            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>


    @livewireScripts
    @fluxScripts

</body>

</html>
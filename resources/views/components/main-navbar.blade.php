@php
    $whatsappUrl = 'https://wa.me/919216111868?text=' . rawurlencode('Hello Hitek Automobiles, I would like to enquire about car service.');
@endphp
<header class="sticky top-0 z-50 border-b border-black/5 bg-white/95 backdrop-blur-xl">
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 lg:px-8" aria-label="Main navigation">
        <a href="{{ route('home') }}" class="group flex items-center gap-3" aria-label="Hitek Automobiles home">
            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#e32636] text-lg font-black italic tracking-tighter text-white">H</span>
            <span class="leading-none"><span class="block text-lg font-black tracking-[0.12em] text-[#17191b]">HITEK</span><span class="mt-1 block text-[9px] font-bold tracking-[0.28em] text-zinc-500">AUTOMOBILES</span></span>
        </a>
        <div class="hidden items-center gap-8 md:flex">
            <a href="#services" class="text-sm font-medium text-zinc-600 transition hover:text-[#e32636]">Services</a>
            <a href="#about" class="text-sm font-medium text-zinc-600 transition hover:text-[#e32636]">About us</a>
            <a href="#workshop" class="text-sm font-medium text-zinc-600 transition hover:text-[#e32636]">Our workshop</a>
            <a href="#offers" class="text-sm font-medium text-zinc-600 transition hover:text-[#e32636]">Offers</a>
            <a href="#contact" class="text-sm font-medium text-zinc-600 transition hover:text-[#e32636]">Contact</a>
        </div>
        
        <div class="hidden items-center gap-3 md:flex">
            @guest
                <a href="{{ route('login') }}"
                class="rounded-full border border-zinc-200 px-4 py-2.5 text-sm font-semibold text-zinc-800 transition hover:border-[#e32636] hover:text-[#e32636]">
                    Login
                </a>
            @else
                <details class="group relative">
                    <summary
                        class="flex cursor-pointer list-none items-center gap-2 rounded-full border border-zinc-200 px-4 py-2.5 text-sm font-semibold text-zinc-800 transition hover:border-[#e32636]">
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#e32636] text-xs font-bold text-white">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>

                        <span class="max-w-28 truncate">
                            {{ auth()->user()->name }}
                        </span>

                        <svg class="h-4 w-4 transition group-open:rotate-180"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="m6 9 6 6 6-6" stroke-linecap="round"
                                stroke-linejoin="round"/>
                        </svg>
                    </summary>

                    <div class="absolute right-0 top-full z-50 mt-3 w-56 overflow-hidden rounded-xl border border-zinc-200 bg-white py-2 shadow-xl">
                        <div class="border-b border-zinc-100 px-4 py-3">
                            <p class="truncate text-sm font-bold text-zinc-900">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="truncate text-xs text-zinc-500">
                                {{ auth()->user()->email }}
                            </p>
                        </div>

                        <a href="{{ route('dashboard') }}"
                        class="block px-4 py-2.5 text-sm text-zinc-700 hover:bg-zinc-50 hover:text-[#e32636]">
                            Dashboard
                        </a>

                        <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2.5 text-sm text-zinc-700 hover:bg-zinc-50 hover:text-[#e32636]">
                            Profile settings
                        </a>

                        <div class="my-2 border-t border-zinc-100"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full px-4 py-2.5 text-left text-sm font-semibold text-red-600 hover:bg-red-50">
                                Log out
                            </button>
                        </form>
                    </div>
                </details>
            @endguest

            {{-- <a href="{{ $whatsappUrl }}"
            target="_blank"
            rel="noopener noreferrer"
            class="rounded-full border border-zinc-200 px-4 py-2.5 text-sm font-semibold text-zinc-800 transition hover:border-[#e32636] hover:text-[#e32636]">
                WhatsApp us
            </a> --}}

            <a href="{{ url('/book-service') }}"
            class="rounded-full bg-[#e32636] px-5 py-2.5 text-sm font-bold text-white transition hover:bg-[#c91f2d] flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                </svg>
                Book a service 
            </a>
        </div>

        <button id="mobile-menu-button" class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-zinc-200 text-zinc-900 md:hidden" aria-expanded="false" aria-controls="mobile-menu" aria-label="Open navigation menu">
            <svg id="menu-open-icon" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 7h16M4 12h16M4 17h16" stroke-linecap="round"/></svg>
            <svg id="menu-close-icon" class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m6 6 12 12M18 6 6 18" stroke-linecap="round"/></svg>
        </button>
    </nav>
    <div id="mobile-menu" class="hidden border-t border-zinc-100 bg-white px-5 pb-5 pt-2 md:hidden">
        <div class="flex flex-col">
            <a class="mobile-menu-link border-b border-zinc-100 py-3 text-sm font-medium" href="#services">Services</a>
            <a class="mobile-menu-link border-b border-zinc-100 py-3 text-sm font-medium" href="#about">About us</a>
            <a class="mobile-menu-link border-b border-zinc-100 py-3 text-sm font-medium" href="#workshop">Our workshop</a>
            <a class="mobile-menu-link border-b border-zinc-100 py-3 text-sm font-medium" href="#offers">Offers</a>
            <a class="mobile-menu-link border-b border-zinc-100 py-3 text-sm font-medium" href="#contact">Contact</a>
        </div>
        
        <div class="mt-4 border-t border-zinc-100 pt-4">
            @guest
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('login') }}"
                    class="rounded-full bg-zinc-900 px-3 py-3 text-center text-sm font-semibold text-white">
                        Login
                    </a>
                </div>
            @else
                <div class="rounded-xl bg-zinc-50 p-4">
                    <p class="text-sm font-bold text-zinc-900">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="mt-1 truncate text-xs text-zinc-500">
                        {{ auth()->user()->email }}
                    </p>

                    <div class="mt-3 flex flex-col">
                        <a href="{{ route('dashboard') }}"
                        class="py-2 text-sm font-medium text-zinc-700">
                            Dashboard
                        </a>

                        <a href="{{ route('profile.edit') }}"
                        class="py-2 text-sm font-medium text-zinc-700">
                            Profile settings
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="py-2 text-sm font-semibold text-red-600">
                                Log out
                            </button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>

    </div>
</header>
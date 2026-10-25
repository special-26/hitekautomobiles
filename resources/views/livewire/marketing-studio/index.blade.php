
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <div class="flex items-center gap-2">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-hitek-red text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7.5A2.5 2.5 0 016.5 5h11A2.5 2.5 0 0120 7.5v9a2.5 2.5 0 01-2.5 2.5h-11A2.5 2.5 0 014 16.5v-9zM8 9h8M8 12h5M8 15h3"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white">
                        Marketing Studio
                    </h1>
                    <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                        Create professional marketing creatives for Hitek Automobiles.
                    </p>
                </div>
            </div>
        </div>
        <section class="flex gap-4 items-center">
            <a href="{{ route('marketing-studio.brand-profile') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-slate-300
                        bg-white px-4 py-2.5 text-sm font-semibold text-slate-700
                        transition hover:border-hitek-red hover:text-hitek-red
                        dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 ">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 4v-2m0 2a2 2 0 100 4m0-4a2 2 0 110 4m12-4v-2m0 2a2 2 0 100 4m0-4a2 2 0 110 4" />
                </svg>
                Brand Settings
            </a>
            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 dark:border-slate-700 dark:bg-slate-900">
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-red-50 text-hitek-red dark:bg-red-950">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3l2.4 5.4L20 10.8l-5.6 2.4L12 19l-2.4-5.8L4 10.8l5.6-2.4L12 3z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-900 dark:text-white">Hitek Automobiles</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Your brand profile</p>
                </div>
            </div>
        </section>
        
    </div>

    {{-- Hero --}}
    <div class="overflow-hidden rounded-2xl bg-slate-900">
        <div class="grid gap-6 p-6 sm:p-8 lg:grid-cols-2 lg:items-center">
            <div class="max-w-xl">
                <span class="inline-flex rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-medium text-white/80">
                    HITEK CREATIVE SPACE
                </span>
                <h2 class="mt-4 text-2xl font-bold leading-tight text-white sm:text-3xl">
                    Great marketing.
                    <span class="text-red-400">No designer required.</span>
                </h2>
                <p class="mt-3 max-w-lg text-sm leading-6 text-slate-300">
                    Choose a template for a festival, service or special offer. Your brand details will be added automatically.
                </p>

                <div class="mt-5 flex flex-wrap gap-3">
                    <a href="#creative-library" class="inline-flex items-center gap-2 rounded-lg bg-hitek-red px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-hitek-red-hover">
                        Explore creatives
                        <span aria-hidden="true">→</span>
                    </a>
                    <span class="inline-flex items-center rounded-lg border border-white/20 px-4 py-2.5 text-sm font-medium text-white/80">
                        Ready-made templates
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div class="rotate-[-5deg] overflow-hidden rounded-xl border border-white/20 bg-white shadow-lg">
                    <div class="flex aspect-[3/4] flex-col justify-between bg-gradient-to-br from-amber-300 via-orange-500 to-red-700 p-3 text-white">
                        <span class="text-[9px] font-bold uppercase tracking-widest">Festival</span>
                        <div>
                            <p class="text-xl font-black leading-none">HAPPY</p>
                            <p class="text-2xl font-black leading-none">DIWALI</p>
                            <div class="mt-3 h-1 w-8 rounded-full bg-white"></div>
                            <p class="mt-2 text-[9px]">Hitek Automobiles</p>
                        </div>
                    </div>
                </div>

                <div class="translate-y-3 overflow-hidden rounded-xl border border-white/20 bg-white shadow-lg">
                    <div class="flex aspect-[3/4] flex-col justify-between bg-slate-800 p-3 text-white">
                        <span class="text-[9px] font-bold uppercase tracking-widest text-red-400">Car care</span>
                        <div>
                            <p class="text-xl font-black leading-none">DRIVE</p>
                            <p class="text-xl font-black leading-none">BETTER.</p>
                            <div class="mt-2 rounded bg-hitek-red px-2 py-1 text-center text-[9px] font-bold">BOOK SERVICE</div>
                            <p class="mt-2 text-[9px] text-slate-300">Hitek Automobiles</p>
                        </div>
                    </div>
                </div>

                <div class="rotate-[5deg] overflow-hidden rounded-xl border border-white/20 bg-white shadow-lg">
                    <div class="flex aspect-[3/4] flex-col justify-between bg-gradient-to-br from-sky-500 via-blue-700 to-slate-950 p-3 text-white">
                        <span class="text-[9px] font-bold uppercase tracking-widest">Special offer</span>
                        <div>
                            <p class="text-lg font-black leading-none">CAR</p>
                            <p class="text-lg font-black leading-none">CARE</p>
                            <p class="mt-2 text-xl font-black text-amber-300">SAVE MORE</p>
                            <p class="mt-2 text-[9px]">Hitek Automobiles</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('info'))
        <div class="rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800 dark:border-blue-800 dark:bg-blue-950 dark:text-blue-200">
            {{ session('info') }}
        </div>
    @endif

    {{-- Search and formats --}}
    <div id="creative-library" class="space-y-5 scroll-mt-6">
        <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">Explore templates</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Find the right creative for your next campaign.
                </p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <div class="relative sm:w-72">
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="11" cy="11" r="7" stroke-width="1.8"/>
                        <path stroke-linecap="round" stroke-width="1.8" d="m16 16 4 4"/>
                    </svg>
                    <input
                        type="search"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search festivals, services..."
                        class="w-full rounded-lg border border-slate-300 bg-white py-2.5 pl-9 pr-3 text-sm text-slate-900 focus:border-hitek-red focus:outline-none dark:border-slate-700 dark:bg-slate-900 dark:text-white"
                    >
                </div>

                <select
                    wire:model.live="format"
                    aria-label="Filter by format"
                    class="rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-hitek-red focus:outline-none dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200"
                >
                    <option value="all">All formats</option>
                    <option value="square">Square post</option>
                    <option value="portrait">Portrait post</option>
                    <option value="story">Story / Status</option>
                </select>
            </div>
        </div>

        {{-- Categories --}}
        <div class="flex gap-2 overflow-x-auto pb-1">
            @php
                $categories = [
                    'all' => 'All creatives',
                    'festivals' => 'Festivals',
                    'services' => 'Car services',
                    'seasonal' => 'Seasonal',
                    'offers' => 'Offers',
                    'awareness' => 'Awareness',
                ];
            @endphp

            @foreach ($categories as $key => $label)
                <button
                    type="button"
                    wire:click="selectCategory('{{ $key }}')"
                    class="whitespace-nowrap rounded-full border px-4 py-2 text-sm font-medium transition
                        {{ $category === $key
                            ? 'border-slate-900 bg-slate-900 text-white dark:border-white dark:bg-white dark:text-slate-900'
                            : 'border-slate-200 bg-white text-slate-600 hover:border-slate-400 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:border-slate-500' }}"
                >
                    {{ $label }}
                </button>
            @endforeach
        </div>

        {{-- Template cards --}}
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4">
            @forelse ($templates as $template)
                @php
                    $editorUrl = route('marketing-studio.canvas', [
                        'template' => $template->slug,
                    ]);
                @endphp
                <article wire:key="marketing-template-{{ $template['id'] }}" class="group overflow-hidden rounded-xl border border-slate-200 bg-white transition hover:-translate-y-1 hover:shadow-lg dark:border-slate-800 dark:bg-slate-900">
                    <div class="relative overflow-hidden bg-slate-100 dark:bg-slate-800">
                        @if ($template['id'] === 'diwali-greeting')
                            <div class="flex aspect-[4/3] flex-col justify-between bg-gradient-to-br from-amber-300 via-orange-500 to-red-800 p-6 text-white">
                                <div class="flex items-center justify-between">
                                    <span class="rounded-full bg-white/20 px-2 py-1 text-[10px] font-bold uppercase tracking-widest">Festival</span>
                                    <span class="text-lg">✦</span>
                                </div>
                                <div>
                                    <p class="text-3xl font-black tracking-tight">HAPPY</p>
                                    <p class="text-4xl font-black tracking-tight">DIWALI</p>
                                    <p class="mt-2 text-xs text-white/90">Light up every journey.</p>
                                </div>
                                <div class="border-t border-white/30 pt-3 text-xs font-semibold">HITEK AUTOMOBILES</div>
                            </div>
                        @elseif ($template['id'] === 'car-service-promo')
                            <div class="flex aspect-[4/3] flex-col justify-between bg-slate-900 p-6 text-white">
                                <span class="w-fit rounded bg-red-600 px-2 py-1 text-[10px] font-bold uppercase tracking-widest">Car care</span>
                                <div>
                                    <p class="text-3xl font-black">LOVE YOUR</p>
                                    <p class="text-4xl font-black text-red-400">CAR.</p>
                                    <p class="mt-2 text-sm text-slate-300">Professional service. Reliable care.</p>
                                </div>
                                <div class="text-xs font-semibold">HITEK AUTOMOBILES</div>
                            </div>
                        @elseif ($template['id'] === 'monsoon-car-care')
                            <div class="flex aspect-[4/3] flex-col justify-between bg-gradient-to-br from-sky-500 via-blue-700 to-slate-950 p-6 text-white">
                                <span class="w-fit rounded-full bg-white/15 px-2 py-1 text-[10px] font-bold uppercase tracking-widest">Seasonal care</span>
                                <div>
                                    <p class="text-3xl font-black">MONSOON</p>
                                    <p class="text-3xl font-black text-sky-200">READY?</p>
                                    <p class="mt-2 text-sm">Check tyres, brakes and wipers.</p>
                                </div>
                                <div class="text-xs font-semibold">HITEK AUTOMOBILES</div>
                            </div>
                        @elseif ($template['id'] === 'special-offer')
                            <div class="flex aspect-[4/3] flex-col justify-between bg-gradient-to-br from-red-600 via-red-700 to-slate-950 p-6 text-white">
                                <span class="w-fit rounded-full border border-white/40 px-2 py-1 text-[10px] font-bold uppercase tracking-widest">Special offer</span>
                                <div>
                                    <p class="text-3xl font-black">GREAT DEALS.</p>
                                    <p class="text-2xl font-black text-amber-300">GREAT DRIVES.</p>
                                    <p class="mt-2 text-sm">Ask us about current offers.</p>
                                </div>
                                <div class="text-xs font-semibold">HITEK AUTOMOBILES</div>
                            </div>
                        @elseif ($template['id'] === 'independence-day')
                            <div class="flex aspect-[4/3] flex-col justify-between bg-gradient-to-br from-orange-400 via-white to-green-600 p-6 text-slate-900">
                                <span class="w-fit rounded-full bg-slate-900/10 px-2 py-1 text-[10px] font-bold uppercase tracking-widest">National occasion</span>
                                <div>
                                    <p class="text-3xl font-black">HAPPY</p>
                                    <p class="text-3xl font-black">INDEPENDENCE DAY</p>
                                    <p class="mt-2 text-sm">Celebrating freedom and every journey.</p>
                                </div>
                                <div class="text-xs font-bold">HITEK AUTOMOBILES</div>
                            </div>
                        @else
                            <div class="flex aspect-[4/3] flex-col justify-between bg-gradient-to-br from-slate-700 via-slate-800 to-black p-6 text-white">
                                <span class="w-fit rounded-full bg-white/10 px-2 py-1 text-[10px] font-bold uppercase tracking-widest">Car awareness</span>
                                <div>
                                    <p class="text-3xl font-black">DRIVE</p>
                                    <p class="text-4xl font-black text-red-400">SAFELY.</p>
                                    <p class="mt-2 text-sm text-slate-300">A little care goes a long way.</p>
                                </div>
                                <div class="text-xs font-semibold">HITEK AUTOMOBILES</div>
                            </div>
                        @endif

                        <div class="absolute inset-0 flex items-center justify-center bg-slate-950/65 opacity-0 transition group-hover:opacity-100">
                            <a href="{{ $editorUrl }}"
                                class="inline-flex items-center justify-center rounded-lg bg-hitek-red px-5 py-3 text-sm font-semibold text-white transition hover:bg-hitek-red-hover">
                                Customize this design
                                <span class="ml-2" aria-hidden="true">→</span>
                            </a>
                        </div>
                    </div>

                    <div class="space-y-3 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="font-semibold text-slate-900 dark:text-white">
                                    {{ $template['name'] }}
                                </h3>
                                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                    {{ $template['description'] }}
                                </p>
                            </div>
                            <span class="shrink-0 rounded-md bg-slate-100 px-2 py-1 text-[10px] font-medium uppercase text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                {{ $template['format'] }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between border-t border-slate-100 pt-3 dark:border-slate-800">
                            <span class="text-xs text-slate-500 dark:text-slate-400">{{ $template['occasion'] }}</span>
                            <a href="{{ $editorUrl }}"
                                class="inline-flex items-center gap-1.5 text-sm font-semibold text-hitek-red hover:underline">
                                Customize
                                <span aria-hidden="true">→</span>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-xl border border-dashed border-slate-300 py-16 text-center dark:border-slate-700">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <circle cx="11" cy="11" r="7" stroke-width="1.8"/>
                            <path stroke-linecap="round" stroke-width="1.8" d="m16 16 4 4"/>
                        </svg>
                    </div>
                    <p class="mt-3 font-semibold text-slate-800 dark:text-white">No templates found</p>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Try a different search or category.</p>
                    <button
                        type="button"
                        wire:click="$set('search', '')"
                        class="mt-4 text-sm font-semibold text-hitek-red hover:underline"
                    >
                        Clear search
                    </button>
                </div>
            @endforelse
        </div>

        <p class="text-xs text-slate-500 dark:text-slate-400">
            These are starter layout previews. Real branded creatives, editable offers and image downloads will be connected in the next stages.
        </p>
    </div>
</div>

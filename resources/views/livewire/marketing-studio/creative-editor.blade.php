
<div class="space-y-5">
    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <a href="{{ route('marketing-studio.index') }}"
               class="text-sm font-medium text-slate-500 transition hover:text-hitek-red">
                ← Back to Marketing Studio
            </a>

            <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">
                Creative Editor
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Customize your design and create a branded social media post.
            </p>
        </div>

        <a href="{{ route('marketing-studio.brand-profile') }}"
           class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 transition hover:border-hitek-red hover:text-hitek-red dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M19.4 15a1.7 1.7 0 00.3 1.9l.1.1-1.7 2.9-.2-.1a1.7 1.7 0 00-1.9.3l-.1.1h-3.4l-.1-.2a1.7 1.7 0 00-1.5-1l-.2.1-2.9-1.7.1-.2a1.7 1.7 0 00-.3-1.9l-.1-.1v-3.4l.2-.1a1.7 1.7 0 001-1.5l-.1-.2 1.7-2.9.2.1a1.7 1.7 0 001.9-.3l.1-.1h3.4l.1.2a1.7 1.7 0 001.5 1l.2-.1 2.9 1.7-.1.2a1.7 1.7 0 00.3 1.9l.1.1V15z"/>
            </svg>
            Brand settings
        </a>
    </div>

    {{-- Notifications --}}
    @if (session()->has('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-900 dark:bg-green-950 dark:text-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-900 dark:bg-red-950 dark:text-red-200">
            {{ session('error') }}
            <a href="{{ route('marketing-studio.brand-profile') }}"
               class="ml-2 font-semibold underline">
                Open Brand Settings
            </a>
        </div>
    @endif

    {{-- Main editor --}}
    <div class="grid items-start gap-5 xl:grid-cols-[320px_minmax(0,1fr)]">

        {{-- Compact editing toolbar --}}
        <aside class="space-y-4 xl:sticky xl:top-5">
            <form wire:submit="generate"
                  class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-200 px-4 py-4 dark:border-slate-800">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                        Design settings
                    </p>
                    <h2 class="mt-1 text-base font-bold text-slate-900 dark:text-white">
                        Edit your creative
                    </h2>
                </div>

                <div class="space-y-4 p-4">
                    {{-- Template --}}
                    <div>
                        <label for="template"
                               class="mb-1.5 block text-xs font-semibold text-slate-600 dark:text-slate-300">
                            Template
                        </label>

                        <select id="template"
                                wire:model.live="template"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                            @foreach ($templates as $key => $item)
                                <option value="{{ $key }}">{{ $item['label'] }}</option>
                            @endforeach
                        </select>

                        @error('template')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border-t border-slate-100 dark:border-slate-800"></div>

                    {{-- Text controls --}}
                    <div>
                        <label for="title"
                               class="mb-1.5 block text-xs font-semibold text-slate-600 dark:text-slate-300">
                            Main heading
                        </label>
                        <input id="title"
                               type="text"
                               wire:model.live.debounce.300ms="title"
                               maxlength="50"
                               placeholder="CAR SERVICE"
                               class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                        @error('title')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="subtitle"
                               class="mb-1.5 block text-xs font-semibold text-slate-600 dark:text-slate-300">
                            Supporting text
                        </label>
                        <textarea id="subtitle"
                                  wire:model.live.debounce.300ms="subtitle"
                                  rows="2"
                                  maxlength="100"
                                  placeholder="Care that keeps you moving"
                                  class="w-full resize-y rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red dark:border-slate-700 dark:bg-slate-800 dark:text-white"></textarea>
                        @error('subtitle')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price"
                               class="mb-1.5 block text-xs font-semibold text-slate-600 dark:text-slate-300">
                            Offer price / discount
                        </label>
                        <input id="price"
                               type="text"
                               wire:model.live.debounce.300ms="price"
                               maxlength="40"
                               placeholder="₹1,499 or 20% OFF"
                               class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                        @error('price')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="cta"
                               class="mb-1.5 block text-xs font-semibold text-slate-600 dark:text-slate-300">
                            Call-to-action
                        </label>
                        <input id="cta"
                               type="text"
                               wire:model.live.debounce.300ms="cta"
                               maxlength="100"
                               placeholder="Book your service today"
                               class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                        @error('cta')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border-t border-slate-100 dark:border-slate-800"></div>

                    {{-- Photo upload --}}
                    <div>
                        <label for="carPhoto"
                               class="mb-1.5 block text-xs font-semibold text-slate-600 dark:text-slate-300">
                            Car / workshop photo
                            <span class="font-normal text-slate-400">(optional)</span>
                        </label>

                        <label for="carPhoto"
                               class="flex cursor-pointer items-center gap-3 rounded-lg border border-dashed border-slate-300 p-3 transition hover:border-hitek-red dark:border-slate-700">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-300">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="1.8">
                                    <rect x="3" y="4" width="18" height="16" rx="2"/>
                                    <circle cx="8.5" cy="9" r="1.5"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="m21 15-5-5L5 20"/>
                                </svg>
                            </span>
                            <span class="min-w-0">
                                <span class="block truncate text-sm font-semibold text-slate-700 dark:text-slate-200">
                                    {{ $carPhoto ? 'Photo selected' : 'Choose an image' }}
                                </span>
                                <span class="mt-0.5 block text-xs text-slate-400">
                                    JPG, PNG or WebP · Max 5 MB
                                </span>
                            </span>
                        </label>

                        <input id="carPhoto"
                               type="file"
                               wire:model="carPhoto"
                               accept="image/jpeg,image/png,image/webp"
                               class="sr-only">

                        @error('carPhoto')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror

                        <div wire:loading wire:target="carPhoto"
                             class="mt-2 text-xs text-slate-500">
                            Uploading photo…
                        </div>

                        @if ($carPhoto)
                            <div class="mt-3">
                                <img src="{{ $carPhoto->temporaryUrl() }}"
                                     alt="Selected car photo"
                                     class="max-h-32 w-full rounded-lg object-cover">
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Main actions --}}
                <div class="space-y-3 border-t border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950">
                    <button type="submit"
                            wire:loading.attr="disabled"
                            wire:target="generate,carPhoto"
                            class="flex w-full items-center justify-center gap-2 rounded-lg bg-hitek-red px-4 py-3 text-sm font-bold text-white transition hover:bg-hitek-red-hover disabled:cursor-not-allowed disabled:opacity-60">
                        <svg wire:loading.remove wire:target="generate"
                             class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="m12 3 2.5 6.5L21 12l-6.5 2.5L12 21l-2.5-6.5L3 12l6.5-2.5L12 3z"/>
                        </svg>
                        <span wire:loading.remove wire:target="generate">
                            Generate final creative
                        </span>
                        <span wire:loading wire:target="generate">
                            Generating PNG…
                        </span>
                    </button>

                    @if ($generatedPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($generatedPath))
                        <button type="button"
                                wire:click="download"
                                wire:loading.attr="disabled"
                                class="flex w-full items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-hitek-red hover:text-hitek-red disabled:opacity-60 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 3v12m0 0 5-5m-5 5-5-5M5 17v3h14v-3"/>
                            </svg>
                            Download PNG
                        </button>
                    @endif
                </div>
            </form>
        </aside>

        {{-- Design canvas --}}
        <section class="min-w-0 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-4 py-4 dark:border-slate-800 sm:px-6">
                <div>
                    <h2 class="font-bold text-slate-900 dark:text-white">
                        Design preview
                    </h2>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        {{ $templates[$template]['label'] ?? 'Marketing creative' }}
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <span class="rounded-md bg-slate-100 px-2.5 py-1.5 text-xs font-medium text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                        <svg class="mr-1 inline h-3.5 w-3.5" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8">
                            <rect x="4" y="4" width="16" height="16" rx="1"/>
                        </svg>
                        Square · 1080 × 1080
                    </span>

                    @if ($generatedPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($generatedPath))
                        <span class="rounded-md bg-green-100 px-2.5 py-1.5 text-xs font-semibold text-green-700 dark:bg-green-950 dark:text-green-300">
                            Generated
                        </span>
                    @else
                        <span class="rounded-md bg-amber-100 px-2.5 py-1.5 text-xs font-semibold text-amber-700 dark:bg-amber-950 dark:text-amber-300">
                            Preview
                        </span>
                    @endif
                </div>
            </div>

            <div class="flex min-h-[420px] items-center justify-center bg-slate-100 p-4 dark:bg-slate-950 sm:p-8 lg:min-h-[650px]">
                @if ($generatedPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($generatedPath))
                    <div class="w-full max-w-[650px]">
                        <img src="{{ asset('storage/' . $generatedPath) }}"
                             alt="Generated Hitek marketing creative"
                             class="h-auto w-full rounded-sm bg-white shadow-xl">
                        <p class="mt-3 text-center text-xs text-slate-500 dark:text-slate-400">
                            Showing your generated image. Generate again after making edits to apply your latest changes.
                        </p>
                    </div>
                @else
                    {{-- Live text preview until the final PNG is generated --}}
                    <div class="w-full max-w-[650px] overflow-hidden bg-slate-900 shadow-2xl">
                        <div class="h-2 bg-hitek-red"></div>

                        <div class="relative flex aspect-square flex-col justify-between overflow-hidden bg-gradient-to-br from-slate-800 via-slate-900 to-black p-6 text-white sm:p-10 lg:p-12">
                            <div class="absolute -right-16 top-16 h-48 w-48 rounded-full border-[24px] border-white/5 sm:h-72 sm:w-72"></div>
                            <div class="absolute -bottom-16 -left-10 h-48 w-48 rounded-full bg-hitek-red/20 blur-2xl sm:h-64 sm:w-64"></div>

                            <div class="relative flex items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-red-400 sm:text-xs">
                                        HITEK AUTOMOBILES
                                    </p>
                                    <p class="mt-1 text-[9px] text-slate-400 sm:text-xs">
                                        Professional automotive care
                                    </p>
                                </div>

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-white/20 bg-white/10 text-xs font-black sm:h-14 sm:w-14 sm:text-sm">
                                    H
                                </div>
                            </div>

                            <div class="relative my-5">
                                @if ($carPhoto)
                                    <img src="{{ $carPhoto->temporaryUrl() }}"
                                         alt="Selected vehicle"
                                         class="mb-5 max-h-40 w-full rounded-lg object-cover sm:max-h-64">
                                @endif

                                <p class="text-xs font-bold uppercase tracking-[0.18em] text-red-400 sm:text-sm">
                                    {{ str_replace('-', ' ', $template) }}
                                </p>

                                <h3 class="mt-3 break-words text-3xl font-black uppercase leading-[1.05] tracking-tight sm:text-5xl lg:text-6xl">
                                    {{ $title ?: 'CAR SERVICE' }}
                                </h3>

                                <div class="mt-4 h-1 w-16 rounded-full bg-hitek-red sm:w-24"></div>

                                <p class="mt-4 max-w-lg break-words text-sm leading-relaxed text-slate-300 sm:text-lg">
                                    {{ $subtitle ?: 'CARE THAT KEEPS YOU MOVING' }}
                                </p>

                                @if ($price)
                                    <div class="mt-6 inline-block max-w-full rounded-lg bg-hitek-red px-4 py-3 sm:px-6 sm:py-4">
                                        <p class="break-words text-xl font-black sm:text-3xl">
                                            {{ $price }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <div class="relative border-t border-white/20 pt-4 sm:pt-6">
                                <p class="break-words text-sm font-bold sm:text-lg">
                                    {{ $cta ?: 'Book your service today' }}
                                </p>

                                <div class="mt-3 flex flex-wrap items-end justify-between gap-3">
                                    <p class="max-w-[75%] break-words text-[9px] leading-relaxed text-slate-400 sm:text-xs">
                                        Plot No. 131, Industrial Area Phase I<br>
                                        Chandigarh · 160002
                                    </p>
                                    <span class="text-[9px] font-semibold text-slate-400 sm:text-xs">
                                        DRIVE WITH CONFIDENCE
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-200 px-4 py-3 dark:border-slate-800 sm:px-6">
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Changes appear in the preview. Generate to create your downloadable PNG.
                </p>

                @if ($generatedPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($generatedPath))
                    <span class="text-xs font-medium text-green-700 dark:text-green-400">
                        Ready to download
                    </span>
                @else
                    <span class="text-xs text-slate-400">
                        Not generated yet
                    </span>
                @endif
            </div>
        </section>
    </div>
</div>

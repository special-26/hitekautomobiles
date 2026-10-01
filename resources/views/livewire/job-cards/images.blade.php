<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div class="flex items-start gap-3">
            <a
                href="{{ route('job-cards.show', $jobCard['id']) }}"
                class="mt-1 inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50 hover:text-slate-900"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 19l-7-7 7-7"/>
                </svg>
            </a>

            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                    Job Card Images
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    #{{ $jobCard['id'] }}
                    <span class="mx-1">•</span>
                    {{ $jobCard['vehicle_no'] }}
                    <span class="mx-1">•</span>
                    {{ $jobCard['vehicle'] }}
                </p>
            </div>
        </div>

        <button
            type="button"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-hitek-red px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-hitek-red-hover"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 5v14M5 12h14"/>
            </svg>

            Upload Images
        </button>
    </div>


    {{-- Job Card Navigation --}}
    <x-hitek.job-card-navigation
        :job-card-id="$jobCard['id']"
        active="images"
    />


    {{-- Summary --}}
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">
                    Total Images
                </p>

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 text-slate-600"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <rect x="3" y="4" width="18" height="16" rx="2"/>
                        <circle cx="8.5" cy="9.5" r="1.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 15l-5-5L5 20"/>
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                {{ count($images) }}
            </p>
        </div>


        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">
                    Before Service
                </p>

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 text-blue-600"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <rect x="3" y="4" width="18" height="16" rx="2"/>
                        <circle cx="8.5" cy="9.5" r="1.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 15l-5-5L5 20"/>
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                {{ collect($images)->where('category', 'Before Service')->count() }}
            </p>
        </div>


        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">
                    Inspection
                </p>

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 text-amber-600"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 9v4m0 4h.01"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M10.3 3.7L2.6 17a2 2 0 001.7 3h15.4a2 2 0 001.7 3h-7.7a2 2 0 001.7-3L13.7 3.7a2 2 0 00-3.4 0z"/>
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                {{ collect($images)->whereIn('category', ['Inspection', 'Damage / Inspection'])->count() }}
            </p>
        </div>


        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">
                    After Service
                </p>

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 text-emerald-600"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <rect x="3" y="4" width="18" height="16" rx="2"/>
                        <circle cx="8.5" cy="9.5" r="1.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 15l-5-5L5 20"/>
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                {{ collect($images)->where('category', 'After Service')->count() }}
            </p>
        </div>

    </div>


    {{-- Filters --}}
    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">

        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">

            <div class="relative w-full lg:max-w-sm">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">
                    <circle cx="11" cy="11" r="7"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M20 20l-4-4"/>
                </svg>

                <input
                    type="text"
                    placeholder="Search images..."
                    class="w-full rounded-lg border border-slate-200 bg-white py-2.5 pl-9 pr-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-hitek-red focus:ring-2 focus:ring-red-100"
                >
            </div>

            <div class="flex flex-wrap gap-2">

                <button
                    type="button"
                    class="rounded-lg bg-slate-900 px-3 py-2 text-sm font-medium text-white"
                >
                    All Images
                </button>

                <button
                    type="button"
                    class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50"
                >
                    Before Service
                </button>

                <button
                    type="button"
                    class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50"
                >
                    Inspection
                </button>

                <button
                    type="button"
                    class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50"
                >
                    After Service
                </button>

                <button
                    type="button"
                    class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50"
                >
                    Documents
                </button>

            </div>

        </div>
    </div>


    {{-- Image Gallery --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">

        @foreach ($images as $image)

            <div class="group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">

                {{-- Image --}}
                <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">

                    <img
                        src="{{ $image['url'] }}"
                        alt="{{ $image['name'] }}"
                        class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                    >

                    {{-- Category --}}
                    <div class="absolute left-3 top-3">
                        <span class="rounded-full bg-white/95 px-2.5 py-1 text-xs font-semibold text-slate-700 shadow-sm backdrop-blur">
                            {{ $image['category'] }}
                        </span>
                    </div>

                    {{-- Hover Actions --}}
                    <div class="absolute inset-0 flex items-center justify-center gap-2 bg-slate-900/40 opacity-0 transition group-hover:opacity-100">

                        <button
                            type="button"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-white text-slate-700 shadow-sm transition hover:bg-slate-50"
                            title="View Image"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6z"/>
                                <circle cx="12" cy="12" r="2.5"/>
                            </svg>
                        </button>

                        <button
                            type="button"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-white text-slate-700 shadow-sm transition hover:bg-slate-50"
                            title="Download"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 3v12m0 0l4-4m-4 4l-4-4"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M5 21h14"/>
                            </svg>
                        </button>

                        <button
                            type="button"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-red-50 text-hitek-red shadow-sm transition hover:bg-red-100"
                            title="Delete"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M4 7h16"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M10 11v6M14 11v6"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M6 7l1 14h10l1-14M9 7V4h6v3"/>
                            </svg>
                        </button>

                    </div>

                </div>


                {{-- Image Details --}}
                <div class="p-4">

                    <div class="flex items-start justify-between gap-3">

                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-slate-900">
                                {{ $image['name'] }}
                            </p>

                            <p class="mt-1 text-xs text-slate-400">
                                Uploaded {{ $image['uploaded_at'] }}
                            </p>
                        </div>

                        <button
                            type="button"
                            class="shrink-0 text-slate-400 hover:text-slate-700"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <circle cx="12" cy="5" r="1"/>
                                <circle cx="12" cy="12" r="1"/>
                                <circle cx="12" cy="19" r="1"/>
                            </svg>
                        </button>

                    </div>


                    <div class="mt-3 flex items-center gap-2">

                        <div class="flex h-7 w-7 items-center justify-center rounded-full bg-slate-300 text-xs font-semibold text-slate-600">
                            {{ strtoupper(substr($image['uploaded_by'], 0, 1)) }}
                        </div>

                        <span class="text-xs font-medium text-slate-600">
                            {{ $image['uploaded_by'] }}
                        </span>

                    </div>

                </div>

            </div>

        @endforeach

    </div>


    {{-- Upload Area --}}
    <div class="rounded-xl border border-dashed border-slate-200 bg-white p-8">

        <div class="mx-auto flex max-w-lg flex-col items-center text-center">

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-6 w-6 text-hitek-red"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 16V4m0 0l-4 4m4-4l4 4"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 15v3a2 2 0 002 2h12a2 2 0 002-2v-3"/>
                </svg>
            </div>

            <h3 class="mt-4 text-sm font-semibold text-slate-900">
                Add more job card images
            </h3>

            <p class="mt-1 max-w-md text-sm text-slate-500">
                Upload vehicle photos, inspection images, damage photos or service documents.
            </p>

            <button
                type="button"
                class="mt-4 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
            >
                Choose Images
            </button>

            <p class="mt-2 text-xs text-slate-400">
                JPG, PNG or WEBP • Multiple images supported
            </p>

        </div>

    </div>

</div>
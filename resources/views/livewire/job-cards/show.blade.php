<div class="space-y-6">

    {{-- Back --}}
    <div>
        <a
            href="{{ route('job-cards.index') }}"
            class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-slate-900"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19 12H5m6 6-6-6 6-6"/>
            </svg>

            Back to Job Cards
        </a>
    </div>


    {{-- Job Card Header --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

        <div class="border-b border-slate-200 p-6">

            <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">

                {{-- Vehicle / Customer --}}
                <div class="flex items-start gap-4">

                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-red-50 text-hitek-red">

                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 13h18M5 13l1-5h12l1 5M5 13v5h14v-5M8 18v2m8-2v2"/>
                        </svg>

                    </div>

                    <div>

                        <div class="flex flex-wrap items-center gap-3">

                            <h2 class="text-xl font-bold text-slate-900">
                                Job Card #{{ $jobCard['id'] }}
                            </h2>

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                {{ $jobCard['status'] }}
                            </span>

                        </div>

                        <p class="mt-1 text-sm font-medium text-slate-700">
                            {{ $jobCard['vehicle'] }}
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            {{ $jobCard['vehicle_no'] }}
                        </p>

                    </div>

                </div>


                {{-- Actions --}}
                <div class="flex flex-wrap gap-2">

                    <button
                        type="button"
                        class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50"
                    >
                        Edit
                    </button>

                    <button
                        type="button"
                        class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50"
                    >
                        Print
                    </button>

                    <button
                        type="button"
                        class="rounded-lg bg-hitek-red px-3 py-2 text-xs font-semibold text-white hover:bg-hitek-red-hover"
                    >
                        Create Invoice
                    </button>

                </div>

            </div>

        </div>


        {{-- Quick Information --}}
        <div class="grid grid-cols-2 divide-x divide-slate-200 sm:grid-cols-4">

            <div class="p-4">
                <p class="text-xs text-slate-500">Customer</p>
                <p class="mt-1 text-sm font-semibold text-slate-900">
                    {{ $jobCard['customer'] }}
                </p>
            </div>

            <div class="p-4">
                <p class="text-xs text-slate-500">Advisor</p>
                <p class="mt-1 text-sm font-semibold text-slate-900">
                    {{ $jobCard['advisor'] }}
                </p>
            </div>

            <div class="p-4">
                <p class="text-xs text-slate-500">Arrival</p>
                <p class="mt-1 text-sm font-semibold text-slate-900">
                    {{ $jobCard['arrival_date'] }}
                </p>
            </div>

            <div class="p-4">
                <p class="text-xs text-slate-500">KM Driven</p>
                <p class="mt-1 text-sm font-semibold text-slate-900">
                    {{ $jobCard['km'] }}
                </p>
            </div>

        </div>

    </div>


    {{-- Navigation --}}
    <x-hitek.job-card-navigation
        :job-card-id="$jobCard['id']"
        active="overview"
    />


    {{-- Main Grid --}}
    <div class="grid gap-6 xl:grid-cols-3">


        {{-- Customer --}}
        <div class="rounded-xl border border-slate-200 bg-white">

            <div class="border-b border-slate-200 px-5 py-4">

                <div class="flex items-center justify-between">

                    <h3 class="text-sm font-semibold text-slate-900">
                        Customer
                    </h3>

                    <button class="text-xs font-medium text-hitek-red hover:underline">
                        Edit
                    </button>

                </div>

            </div>

            <div class="space-y-4 p-5">

                <div>
                    <p class="text-xs text-slate-500">
                        Customer Name
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-900">
                        {{ $jobCard['customer'] }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">
                        Mobile
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        {{ $jobCard['phone'] }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">
                        Customer Source
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        {{ $jobCard['customer_source'] }}
                    </p>
                </div>

            </div>

        </div>


        {{-- Vehicle --}}
        <div class="rounded-xl border border-slate-200 bg-white">

            <div class="border-b border-slate-200 px-5 py-4">

                <div class="flex items-center justify-between">

                    <h3 class="text-sm font-semibold text-slate-900">
                        Vehicle
                    </h3>

                    <button class="text-xs font-medium text-hitek-red hover:underline">
                        Edit
                    </button>

                </div>

            </div>

            <div class="space-y-4 p-5">

                <div>
                    <p class="text-xs text-slate-500">
                        Vehicle
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-900">
                        {{ $jobCard['vehicle'] }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">
                        Registration Number
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        {{ $jobCard['vehicle_no'] }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">
                        Kilometer Driven
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        {{ $jobCard['km'] }} KM
                    </p>
                </div>

            </div>

        </div>


        {{-- Insurance --}}
        <div class="rounded-xl border border-slate-200 bg-white">

            <div class="border-b border-slate-200 px-5 py-4">

                <div class="flex items-center justify-between">

                    <h3 class="text-sm font-semibold text-slate-900">
                        Insurance
                    </h3>

                    <button class="text-xs font-medium text-hitek-red hover:underline">
                        Edit
                    </button>

                </div>

            </div>

            <div class="space-y-4 p-5">

                <div>
                    <p class="text-xs text-slate-500">
                        Provider
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-900">
                        {{ $jobCard['insurance'] }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">
                        Claim Status
                    </p>

                    <span class="mt-1 inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">
                        In Process
                    </span>
                </div>

                <div>
                    <p class="text-xs text-slate-500">
                        Policy Number
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        Not Available
                    </p>
                </div>

            </div>

        </div>

    </div>


    {{-- Financial Summary --}}
    <div class="rounded-xl border border-slate-200 bg-white">

        <div class="border-b border-slate-200 px-5 py-4">

            <h3 class="text-sm font-semibold text-slate-900">
                Financial Summary
            </h3>

        </div>

        <div class="grid divide-y divide-slate-200 sm:grid-cols-3 sm:divide-x sm:divide-y-0">

            <div class="p-5">

                <p class="text-xs text-slate-500">
                    Estimate / Invoice
                </p>

                <p class="mt-2 text-xl font-bold text-slate-900">
                    {{ $jobCard['estimate'] }}
                </p>

            </div>

            <div class="p-5">

                <p class="text-xs text-slate-500">
                    Total Paid
                </p>

                <p class="mt-2 text-xl font-bold text-emerald-600">
                    {{ $jobCard['paid'] }}
                </p>

            </div>

            <div class="p-5">

                <p class="text-xs text-slate-500">
                    Outstanding
                </p>

                <p class="mt-2 text-xl font-bold text-hitek-red">
                    {{ $jobCard['due'] }}
                </p>

            </div>

        </div>

    </div>


    {{-- Service Timeline --}}
    <div class="rounded-xl border border-slate-200 bg-white">

        <div class="border-b border-slate-200 px-5 py-4">

            <h3 class="text-sm font-semibold text-slate-900">
                Service Timeline
            </h3>

        </div>

        <div class="p-5">

            <div class="space-y-6">

                <div class="flex gap-4">

                    <div class="relative flex w-5 justify-center">

                        <span class="h-3 w-3 rounded-full bg-hitek-red"></span>

                    </div>

                    <div>
                        <p class="text-sm font-semibold text-slate-900">
                            Job Card Created
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            23 Sep 2026 · 09:30 AM
                        </p>
                    </div>

                </div>


                <div class="flex gap-4">

                    <div class="relative flex w-5 justify-center">

                        <span class="h-3 w-3 rounded-full bg-amber-400"></span>

                    </div>

                    <div>
                        <p class="text-sm font-semibold text-slate-900">
                            Vehicle Under Service
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Mechanic assigned and work started
                        </p>
                    </div>

                </div>


                <div class="flex gap-4">

                    <div class="relative flex w-5 justify-center">

                        <span class="h-3 w-3 rounded-full bg-slate-300"></span>

                    </div>

                    <div>
                        <p class="text-sm font-semibold text-slate-400">
                            Ready for Delivery
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            Pending
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
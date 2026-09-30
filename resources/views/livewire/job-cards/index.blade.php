<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Job Cards
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Manage workshop jobs, vehicles, customers and service status.
            </p>
        </div>

        <button
            type="button"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-hitek-red px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-hitek-red-hover"
        >
            <svg
                class="h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 5v14M5 12h14"
                />
            </svg>

            New Job Card
        </button>

    </div>


    {{-- Summary Cards --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">

        {{-- Total --}}
        <div class="rounded-xl border border-slate-300 bg-white p-4">

            <div class="flex items-center justify-between">

                <p class="text-sm font-medium text-slate-500">
                    Total
                </p>

                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 3h12v18H6zM9 7h6M9 11h6M9 15h4"/>
                    </svg>
                </div>

            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                1,245
            </p>

            <p class="mt-1 text-xs text-slate-500">
                All job cards
            </p>

        </div>


        {{-- Under Service --}}
        <div class="rounded-xl border border-slate-300 bg-white p-4">

            <div class="flex items-center justify-between">

                <p class="text-sm font-medium text-slate-500">
                    Under Service
                </p>

                <div class="h-2.5 w-2.5 rounded-full bg-amber-400"></div>

            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                32
            </p>

            <p class="mt-1 text-xs text-slate-500">
                Currently in workshop
            </p>

        </div>


        {{-- Ready --}}
        <div class="rounded-xl border border-slate-300 bg-white p-4">

            <div class="flex items-center justify-between">

                <p class="text-sm font-medium text-slate-500">
                    Ready
                </p>

                <div class="h-2.5 w-2.5 rounded-full bg-emerald-500"></div>

            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                7
            </p>

            <p class="mt-1 text-xs text-slate-500">
                Ready for delivery
            </p>

        </div>


        {{-- Payment --}}
        <div class="rounded-xl border border-slate-300 bg-white p-4">

            <div class="flex items-center justify-between">

                <p class="text-sm font-medium text-slate-500">
                    Payment Pending
                </p>

                <div class="h-2.5 w-2.5 rounded-full bg-blue-500"></div>

            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                4
            </p>

            <p class="mt-1 text-xs text-slate-500">
                Awaiting payment
            </p>

        </div>


        {{-- Completed --}}
        <div class="rounded-xl border border-slate-300 bg-white p-4">

            <div class="flex items-center justify-between">

                <p class="text-sm font-medium text-slate-500">
                    Completed
                </p>

                <div class="h-2.5 w-2.5 rounded-full bg-slate-400"></div>

            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                1,202
            </p>

            <p class="mt-1 text-xs text-slate-500">
                Completed services
            </p>

        </div>

    </div>


    {{-- Job Card Table --}}
    <div class="overflow-hidden rounded-xl border border-slate-300 bg-white">

        {{-- Toolbar --}}
        <div class="border-b border-slate-300 p-4">

            <div class="flex flex-col gap-3 xl:flex-row xl:items-center xl:justify-between">

                {{-- Search --}}
                <div class="relative w-full xl:max-w-md">

                    <svg
                        class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
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

                    <input
                        type="text"
                        placeholder="Search job card, vehicle or customer..."
                        class="w-full rounded-lg border border-slate-300 bg-slate-50 py-2.5 pl-10 pr-4 text-sm outline-none transition placeholder:text-slate-400 focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >

                </div>


                {{-- Filters --}}
                <div class="flex flex-wrap gap-2">

                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-xs font-medium text-slate-600 hover:bg-slate-50"
                    >
                        Status

                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>


                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-xs font-medium text-slate-600 hover:bg-slate-50"
                    >
                        Advisor

                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>


                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-xs font-medium text-slate-600 hover:bg-slate-50"
                    >
                        Date

                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>

                </div>

            </div>

        </div>


        {{-- Table --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[1000px] text-left">

                <thead class="border-b border-slate-300 bg-slate-50">

                    <tr class="text-xs uppercase tracking-wider text-slate-500">

                        <th class="px-5 py-3 font-semibold">
                            Job Card
                        </th>

                        <th class="px-5 py-3 font-semibold">
                            Vehicle
                        </th>

                        <th class="px-5 py-3 font-semibold">
                            Customer
                        </th>

                        <th class="px-5 py-3 font-semibold">
                            Advisor
                        </th>

                        <th class="px-5 py-3 font-semibold">
                            Status
                        </th>

                        <th class="px-5 py-3 text-right font-semibold">
                            Amount
                        </th>

                        <th class="px-5 py-3 text-right font-semibold">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">


                    {{-- Row 1 --}}
                    <tr class="transition hover:bg-slate-50">

                        <td class="px-5 py-4">

                            <p class="text-sm font-semibold text-slate-900">
                                #13887
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                23 Sep 2026
                            </p>

                        </td>


                        <td class="px-5 py-4">

                            <p class="text-sm font-medium text-slate-900">
                                Hyundai Creta
                            </p>

                            <p class="mt-1 text-xs font-medium text-slate-500">
                                CH01BT9020
                            </p>

                        </td>


                        <td class="px-5 py-4">

                            <p class="text-sm font-medium text-slate-900">
                                Mrs. Indu Narula
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                9256681776
                            </p>

                        </td>


                        <td class="px-5 py-4 text-sm text-slate-600">
                            Basant Joshi
                        </td>


                        <td class="px-5 py-4">

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700">

                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>

                                Under Service

                            </span>

                        </td>


                        <td class="px-5 py-4 text-right">

                            <p class="text-sm font-semibold text-slate-900">
                                ₹47,234
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                Due ₹12,000
                            </p>

                        </td>


                        <td class="px-5 py-4 text-right">

                            <a
                                href="{{ route('job-cards.show', 13887) }}"
                                class="inline-flex items-center rounded-lg border border-slate-300 px-3 py-2 text-xs font-medium text-slate-600 hover:bg-slate-50"
                            >
                                View
                            </a>

                        </td>

                    </tr>


                    {{-- Row 2 --}}
                    <tr class="transition hover:bg-slate-50">

                        <td class="px-5 py-4">

                            <p class="text-sm font-semibold text-slate-900">
                                #13886
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                23 Sep 2026
                            </p>

                        </td>


                        <td class="px-5 py-4">

                            <p class="text-sm font-medium text-slate-900">
                                Nissan Magnite
                            </p>

                            <p class="mt-1 text-xs font-medium text-slate-500">
                                PB39M2956
                            </p>

                        </td>


                        <td class="px-5 py-4">

                            <p class="text-sm font-medium text-slate-900">
                                Mrs. Baby Devi
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                9653873594
                            </p>

                        </td>


                        <td class="px-5 py-4 text-sm text-slate-600">
                            Basant Joshi
                        </td>


                        <td class="px-5 py-4">

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">

                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                Ready

                            </span>

                        </td>


                        <td class="px-5 py-4 text-right">

                            <p class="text-sm font-semibold text-slate-900">
                                ₹12,500
                            </p>

                            <p class="mt-1 text-xs text-emerald-600">
                                Paid
                            </p>

                        </td>


                        <td class="px-5 py-4 text-right">

                            <button
                                type="button"
                                class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-medium text-slate-600 hover:bg-slate-50"
                            >
                                View
                            </button>

                        </td>

                    </tr>


                    {{-- Row 3 --}}
                    <tr class="transition hover:bg-slate-50">

                        <td class="px-5 py-4">

                            <p class="text-sm font-semibold text-slate-900">
                                #13884
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                23 Sep 2026
                            </p>

                        </td>


                        <td class="px-5 py-4">

                            <p class="text-sm font-medium text-slate-900">
                                Hyundai Venue
                            </p>

                            <p class="mt-1 text-xs font-medium text-slate-500">
                                PB07K7396
                            </p>

                        </td>


                        <td class="px-5 py-4">

                            <p class="text-sm font-medium text-slate-900">
                                Zurich Kotak Mahindra
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                9216721868
                            </p>

                        </td>


                        <td class="px-5 py-4 text-sm text-slate-600">
                            Basant Joshi
                        </td>


                        <td class="px-5 py-4">

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">

                                <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>

                                Payment Pending

                            </span>

                        </td>


                        <td class="px-5 py-4 text-right">

                            <p class="text-sm font-semibold text-slate-900">
                                ₹47,234
                            </p>

                            <p class="mt-1 text-xs text-red-600">
                                Due ₹47,234
                            </p>

                        </td>


                        <td class="px-5 py-4 text-right">

                            <button
                                type="button"
                                class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-medium text-slate-600 hover:bg-slate-50"
                            >
                                View
                            </button>

                        </td>

                    </tr>


                    {{-- Row 4 --}}
                    <tr class="transition hover:bg-slate-50">

                        <td class="px-5 py-4">

                            <p class="text-sm font-semibold text-slate-900">
                                #13883
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                22 Sep 2026
                            </p>

                        </td>


                        <td class="px-5 py-4">

                            <p class="text-sm font-medium text-slate-900">
                                Mahindra Bolero
                            </p>

                            <p class="mt-1 text-xs font-medium text-slate-500">
                                HR03V3099
                            </p>

                        </td>


                        <td class="px-5 py-4">

                            <p class="text-sm font-medium text-slate-900">
                                Mr. Balwinder Kumar
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                9896457692
                            </p>

                        </td>


                        <td class="px-5 py-4 text-sm text-slate-600">
                            Basant Joshi
                        </td>


                        <td class="px-5 py-4">

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">

                                <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>

                                Completed

                            </span>

                        </td>


                        <td class="px-5 py-4 text-right">

                            <p class="text-sm font-semibold text-slate-900">
                                ₹4,998
                            </p>

                            <p class="mt-1 text-xs text-emerald-600">
                                Paid
                            </p>

                        </td>


                        <td class="px-5 py-4 text-right">

                            <button
                                type="button"
                                class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-medium text-slate-600 hover:bg-slate-50"
                            >
                                View
                            </button>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        <div class="flex flex-col gap-3 border-t border-slate-300 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

            <p class="text-xs text-slate-500">
                Showing <span class="font-medium text-slate-700">1</span>
                to <span class="font-medium text-slate-700">20</span>
                of <span class="font-medium text-slate-700">1,245</span>
                job cards
            </p>

            <div class="flex items-center gap-1">

                <button
                    type="button"
                    class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-400"
                    disabled
                >
                    Previous
                </button>

                <button
                    type="button"
                    class="rounded-lg bg-hitek-red px-3 py-1.5 text-xs font-semibold text-white"
                >
                    1
                </button>

                <button
                    type="button"
                    class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-600 hover:bg-slate-50"
                >
                    2
                </button>

                <button
                    type="button"
                    class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-600 hover:bg-slate-50"
                >
                    3
                </button>

                <button
                    type="button"
                    class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-600 hover:bg-slate-50"
                >
                    Next
                </button>

            </div>

        </div>

    </div>

</div>
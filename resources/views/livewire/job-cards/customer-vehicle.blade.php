<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex items-start justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <a
                    href="{{ route('job-cards.show', $jobCard['id']) }}"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50 hover:text-slate-900"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>

                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                        Customer & Vehicle
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Job Card #{{ $jobCard['id'] }}
                        <span class="mx-1">•</span>
                        {{ $jobCard['vehicle_no'] }}
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button
                type="button"
                class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit
            </button>

            <button
                type="button"
                class="inline-flex items-center gap-2 rounded-lg bg-hitek-red px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-hitek-red-hover"
            >
                Save Changes
            </button>
        </div>
    </div>


    {{-- Job Card Navigation --}}
    <x-hitek.job-card-navigation
        :job-card-id="$jobCard['id']"
        active="customer-vehicle"
    />


    {{-- Customer + Vehicle --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

        {{-- Customer --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5 text-slate-600"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M22 21v-2a4 4 0 00-3-3.87"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M16 3.13a4 4 0 010 7.75"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-slate-900">
                            Customer Details
                        </h2>

                        <p class="text-xs text-slate-500">
                            Customer information
                        </p>
                    </div>
                </div>

                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                    Customer
                </span>
            </div>

            <div class="grid grid-cols-1 gap-x-6 gap-y-5 p-6 sm:grid-cols-2">

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Customer Name
                    </p>
                    <p class="mt-1.5 text-sm font-semibold text-slate-900">
                        {{ $jobCard['customer_name'] }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Mobile Number
                    </p>
                    <p class="mt-1.5 text-sm font-semibold text-slate-900">
                        {{ $jobCard['mobile'] }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Email
                    </p>
                    <p class="mt-1.5 text-sm text-slate-700">
                        {{ $jobCard['email'] }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Customer Source
                    </p>
                    <p class="mt-1.5 text-sm font-medium text-slate-700">
                        {{ $jobCard['customer_source'] }}
                    </p>
                </div>

                <div class="sm:col-span-2">
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Address
                    </p>
                    <p class="mt-1.5 text-sm text-slate-700">
                        {{ $jobCard['address'] }}
                    </p>
                </div>

            </div>
        </div>


        {{-- Vehicle --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-50">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5 text-hitek-red"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 13l2-5a2 2 0 011.9-1.2h10.2A2 2 0 0119 8l2 5"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M5 13h14a2 2 0 012 2v3H3v-3a2 2 0 012-2z"/>
                            <circle cx="7" cy="17" r="1.5"/>
                            <circle cx="17" cy="17" r="1.5"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-slate-900">
                            Vehicle Details
                        </h2>

                        <p class="text-xs text-slate-500">
                            Vehicle information
                        </p>
                    </div>
                </div>

                <span class="rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-hitek-red">
                    {{ $jobCard['vehicle_no'] }}
                </span>
            </div>

            <div class="grid grid-cols-1 gap-x-6 gap-y-5 p-6 sm:grid-cols-2">

                <div class="sm:col-span-2">
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Vehicle
                    </p>
                    <p class="mt-1.5 text-base font-semibold text-slate-900">
                        {{ $jobCard['vehicle'] }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Registration Number
                    </p>
                    <p class="mt-1.5 text-sm font-semibold text-slate-900">
                        {{ $jobCard['vehicle_no'] }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        KM Driven
                    </p>
                    <p class="mt-1.5 text-sm font-semibold text-slate-900">
                        {{ $jobCard['km'] }} km
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Fuel
                    </p>
                    <p class="mt-1.5 text-sm text-slate-700">
                        {{ $jobCard['fuel'] }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Year
                    </p>
                    <p class="mt-1.5 text-sm text-slate-700">
                        {{ $jobCard['year'] }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Colour
                    </p>
                    <p class="mt-1.5 text-sm text-slate-700">
                        {{ $jobCard['colour'] }}
                    </p>
                </div>

            </div>
        </div>

    </div>


    {{-- RC Details --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 text-slate-600"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M14 3v5h5"/>
                    </svg>
                </div>

                <div>
                    <h2 class="text-base font-semibold text-slate-900">
                        Registration Certificate
                    </h2>

                    <p class="text-xs text-slate-500">
                        RC and registration information
                    </p>
                </div>
            </div>

            <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                RC Details
            </span>
        </div>

        <div class="grid grid-cols-1 gap-x-8 gap-y-5 p-6 sm:grid-cols-2 lg:grid-cols-3">

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Owner Name
                </p>
                <p class="mt-1.5 text-sm font-semibold text-slate-900">
                    {{ $jobCard['owner_name'] }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Registration Date
                </p>
                <p class="mt-1.5 text-sm text-slate-700">
                    {{ $jobCard['registration_date'] }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    RTO
                </p>
                <p class="mt-1.5 text-sm text-slate-700">
                    {{ $jobCard['rto'] }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Chassis / VIN
                </p>
                <p class="mt-1.5 break-all font-mono text-sm text-slate-700">
                    {{ $jobCard['chassis_no'] }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Engine Number
                </p>
                <p class="mt-1.5 break-all font-mono text-sm text-slate-700">
                    {{ $jobCard['engine_no'] }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Fuel Type
                </p>
                <p class="mt-1.5 text-sm text-slate-700">
                    {{ $jobCard['fuel_type'] }}
                </p>
            </div>

        </div>
    </div>


    {{-- Vehicle History Preview --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <div>
                <h2 class="text-base font-semibold text-slate-900">
                    Vehicle History
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Previous workshop visits for this vehicle
                </p>
            </div>

            <button
                type="button"
                class="text-sm font-semibold text-hitek-red hover:text-hitek-red-hover"
            >
                View Full History →
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] text-left">
                <thead class="bg-slate-50">
                    <tr class="border-b border-slate-200">
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Job Card
                        </th>
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Date
                        </th>
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Service
                        </th>
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Amount
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Status
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 text-sm font-semibold text-slate-900">
                            #13742
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-600">
                            14 Jun 2026
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-600">
                            General Service
                        </td>

                        <td class="px-6 py-4 text-sm font-medium text-slate-900">
                            ₹8,450
                        </td>

                        <td class="px-6 py-4 text-right">
                            <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                Completed
                            </span>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 text-sm font-semibold text-slate-900">
                            #13118
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-600">
                            08 Jan 2026
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-600">
                            Periodic Maintenance
                        </td>

                        <td class="px-6 py-4 text-sm font-medium text-slate-900">
                            ₹12,850
                        </td>

                        <td class="px-6 py-4 text-right">
                            <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                Completed
                            </span>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

</div>
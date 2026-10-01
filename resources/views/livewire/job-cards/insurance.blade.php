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
                    Insurance & Claim
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

        <div class="flex flex-wrap items-center gap-2">
            <button
                type="button"
                class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 4v16m8-8H4"/>
                </svg>
                Add Document
            </button>

            <button
                type="button"
                class="inline-flex items-center gap-2 rounded-lg bg-hitek-red px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-hitek-red-hover"
            >
                Edit Insurance
            </button>
        </div>
    </div>


    {{-- Job Card Navigation --}}
    <x-hitek.job-card-navigation
        :job-card-id="$jobCard['id']"
        active="insurance"
    />


    {{-- Status Summary --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">
                Insurance Company
            </p>

            <p class="mt-2 text-base font-bold text-slate-900">
                {{ $insurance['company'] }}
            </p>

            <p class="mt-1 text-xs text-slate-400">
                {{ $insurance['policy_type'] }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">
                Policy Validity
            </p>

            <p class="mt-2 text-base font-bold text-slate-900">
                {{ $insurance['policy_expiry'] }}
            </p>

            <p class="mt-1 text-xs text-emerald-600 font-medium">
                Active Policy
            </p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">
                Claim Status
            </p>

            <div class="mt-2">
                <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                    {{ $claim['status'] }}
                </span>
            </div>

            <p class="mt-2 text-xs text-slate-400">
                {{ $claim['claim_number'] }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">
                Approved Amount
            </p>

            <p class="mt-2 text-xl font-bold text-slate-900">
                ₹{{ number_format($claim['approved_amount']) }}
            </p>

            <p class="mt-1 text-xs text-slate-400">
                Claim approved
            </p>
        </div>

    </div>


    {{-- Insurance Policy --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="flex flex-col gap-3 border-b border-slate-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-base font-semibold text-slate-900">
                    Insurance Policy
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Policy information for this vehicle
                </p>
            </div>

            @if ($insurance['cashless'])
                <span class="inline-flex w-fit rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                    Cashless Available
                </span>
            @endif

        </div>

        <div class="grid grid-cols-1 gap-x-8 gap-y-6 p-6 sm:grid-cols-2 lg:grid-cols-3">

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Insurance Company
                </p>

                <p class="mt-1.5 text-sm font-semibold text-slate-900">
                    {{ $insurance['company'] }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Policy Number
                </p>

                <p class="mt-1.5 font-mono text-sm font-medium text-slate-700">
                    {{ $insurance['policy_number'] }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Policy Type
                </p>

                <p class="mt-1.5 text-sm text-slate-700">
                    {{ $insurance['policy_type'] }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Policy Start
                </p>

                <p class="mt-1.5 text-sm text-slate-700">
                    {{ $insurance['policy_start'] }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Policy Expiry
                </p>

                <p class="mt-1.5 text-sm font-semibold text-slate-900">
                    {{ $insurance['policy_expiry'] }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Insured Declared Value
                </p>

                <p class="mt-1.5 text-sm font-semibold text-slate-900">
                    ₹{{ number_format($insurance['insured_declared_value']) }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Customer Contribution
                </p>

                <p class="mt-1.5 text-sm font-semibold text-slate-900">
                    ₹{{ number_format($insurance['customer_contribution']) }}
                </p>
            </div>

        </div>

    </div>


    {{-- Claim Details --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="flex flex-col gap-3 border-b border-slate-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-base font-semibold text-slate-900">
                    Insurance Claim
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Claim and survey information
                </p>
            </div>

            <span class="inline-flex w-fit rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                {{ $claim['status'] }}
            </span>

        </div>

        <div class="grid grid-cols-1 gap-x-8 gap-y-6 p-6 sm:grid-cols-2 lg:grid-cols-3">

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Claim Number
                </p>

                <p class="mt-1.5 font-mono text-sm font-semibold text-slate-900">
                    {{ $claim['claim_number'] }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Surveyor
                </p>

                <p class="mt-1.5 text-sm font-semibold text-slate-900">
                    {{ $claim['surveyor_name'] }}
                </p>

                <p class="mt-1 text-xs text-slate-400">
                    {{ $claim['surveyor_phone'] }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Approved Amount
                </p>

                <p class="mt-1.5 text-lg font-bold text-slate-900">
                    ₹{{ number_format($claim['approved_amount']) }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Claim Intimated
                </p>

                <p class="mt-1.5 text-sm text-slate-700">
                    {{ $claim['intimation_date'] }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Survey Completed
                </p>

                <p class="mt-1.5 text-sm text-slate-700">
                    {{ $claim['survey_date'] }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Approval Date
                </p>

                <p class="mt-1.5 text-sm text-slate-700">
                    {{ $claim['approval_date'] }}
                </p>
            </div>

            <div class="sm:col-span-2 lg:col-span-3">

                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Claim Remarks
                </p>

                <div class="mt-2 rounded-lg bg-slate-50 p-4 text-sm leading-6 text-slate-600">
                    {{ $claim['remarks'] }}
                </div>

            </div>

        </div>

    </div>


    {{-- Claim Timeline --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-base font-semibold text-slate-900">
                Claim Timeline
            </h2>

            <p class="mt-1 text-xs text-slate-500">
                Important events during the insurance claim
            </p>
        </div>

        <div class="p-6">

            <div class="relative ml-3 border-l border-slate-200 pl-8">

                {{-- Event --}}
                <div class="relative pb-8">

                    <div class="absolute -left-[41px] flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 ring-4 ring-white">
                        <div class="h-2 w-2 rounded-full bg-blue-600"></div>
                    </div>

                    <p class="text-sm font-semibold text-slate-900">
                        Claim Intimated
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        23 Sep 2026
                    </p>

                    <p class="mt-2 text-sm text-slate-500">
                        Insurance claim was registered with the insurance company.
                    </p>

                </div>


                {{-- Event --}}
                <div class="relative pb-8">

                    <div class="absolute -left-[41px] flex h-6 w-6 items-center justify-center rounded-full bg-amber-100 ring-4 ring-white">
                        <div class="h-2 w-2 rounded-full bg-amber-600"></div>
                    </div>

                    <p class="text-sm font-semibold text-slate-900">
                        Vehicle Surveyed
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        24 Sep 2026
                    </p>

                    <p class="mt-2 text-sm text-slate-500">
                        Surveyor inspected the vehicle and assessed the repair requirement.
                    </p>

                </div>


                {{-- Event --}}
                <div class="relative">

                    <div class="absolute -left-[41px] flex h-6 w-6 items-center justify-center rounded-full bg-emerald-100 ring-4 ring-white">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-3.5 w-3.5 text-emerald-600"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>

                    <p class="text-sm font-semibold text-slate-900">
                        Claim Approved
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        25 Sep 2026
                    </p>

                    <p class="mt-2 text-sm text-slate-500">
                        Claim approved for ₹{{ number_format($claim['approved_amount']) }}.
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- Documents --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="flex flex-col gap-3 border-b border-slate-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-base font-semibold text-slate-900">
                    Claim Documents
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Insurance and claim related documents
                </p>
            </div>

            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                {{ count($documents) }} Documents
            </span>

        </div>

        <div class="divide-y divide-slate-100">

            @foreach ($documents as $document)

                <div class="flex flex-col gap-4 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 text-hitek-red"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M14 2v6h6"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M8 13h8M8 17h5"/>
                            </svg>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-slate-900">
                                {{ $document['name'] }}
                            </p>

                            <p class="mt-1 text-xs text-slate-400">
                                {{ $document['type'] }}
                                <span class="mx-1">•</span>
                                Uploaded by {{ $document['uploaded_by'] }}
                                <span class="mx-1">•</span>
                                {{ $document['uploaded_at'] }}
                            </p>
                        </div>

                    </div>


                    <div class="flex items-center gap-3">

                        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                            {{ $document['status'] }}
                        </span>

                        <button
                            type="button"
                            class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50"
                        >
                            View
                        </button>

                        <button
                            type="button"
                            class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50"
                        >
                            Download
                        </button>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>
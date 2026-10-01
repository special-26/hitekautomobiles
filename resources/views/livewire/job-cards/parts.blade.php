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
                    Job Card Parts
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

            Request Part
        </button>
    </div>


    {{-- Job Card Navigation --}}
    <x-hitek.job-card-navigation
        :job-card-id="$jobCard['id']"
        active="parts"
    />


    {{-- Summary --}}
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-5">

        {{-- Total --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">
                    Total Parts
                </p>

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 text-slate-600"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4-8-4V7m8 4v10"/>
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                {{ count($parts) }}
            </p>
        </div>


        {{-- Requested --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">
                    Requested
                </p>

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 text-blue-600"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 5h6M9 9h6M9 13h4"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                {{ collect($parts)->where('status', 'Requested')->count() }}
            </p>
        </div>


        {{-- Pending --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">
                    Pending
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
                              d="M10.3 3.7L2.6 17a2 2 0 001.7 3h15.4a2 2 0 001.7 3h15.4a2 2 0 001.7-3L13.7 3.7a2 2 0 00-3.4 0z"/>
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                {{ collect($parts)->where('status', 'Pending')->count() }}
            </p>
        </div>


        {{-- Issued --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">
                    Issued
                </p>

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 text-emerald-600"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                {{ collect($parts)->where('status', 'Issued')->count() }}
            </p>
        </div>


        {{-- Value --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">
                    Parts Value
                </p>

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 text-hitek-red"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 1v22M17 5.5C16.2 4.6 14.7 4 12.5 4 9.5 4 8 5.4 8 7.5c0 2.2 2 3 4.5 3.7 2.5.7 4.5 1.5 4.5 3.8 0 2.2-1.8 4-4.8 4-2.3 0-4.1-.7-5.2-2"/>
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                ₹{{ number_format(collect($parts)->sum('total')) }}
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
                    placeholder="Search part, number or task..."
                    class="w-full rounded-lg border border-slate-200 bg-white py-2.5 pl-9 pr-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-hitek-red focus:ring-2 focus:ring-red-100"
                >
            </div>

            <div class="flex flex-wrap gap-2">

                <button
                    type="button"
                    class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50"
                >
                    All Parts
                </button>

                <button
                    type="button"
                    class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50"
                >
                    Status
                </button>

                <button
                    type="button"
                    class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50"
                >
                    Category
                </button>

                <button
                    type="button"
                    class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50"
                >
                    Task
                </button>

            </div>

        </div>
    </div>


    {{-- Parts List --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-4">
            <div class="flex items-center justify-between gap-4">

                <div>
                    <h2 class="text-base font-semibold text-slate-900">
                        Requested Parts
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Parts requested against this job card
                    </p>
                </div>

                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                    {{ count($parts) }} Parts
                </span>

            </div>
        </div>


        <div class="overflow-x-auto">

            <table class="w-full min-w-[1100px] text-left">

                <thead class="bg-slate-50">
                    <tr class="border-b border-slate-200">

                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Part
                        </th>

                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Task
                        </th>

                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Qty
                        </th>

                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Price
                        </th>

                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Requested By
                        </th>

                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Status
                        </th>

                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Action
                        </th>

                    </tr>
                </thead>


                <tbody class="divide-y divide-slate-300">

                    @foreach ($parts as $part)

                        <tr class="transition hover:bg-slate-50">

                            {{-- Part --}}
                            <td class="px-6 py-4">

                                <div>
                                    <p class="text-sm font-semibold text-slate-900">
                                        {{ $part['part_name'] }}
                                    </p>

                                    <div class="mt-1 flex flex-wrap items-center gap-2">

                                        <span class="font-mono text-xs text-slate-400">
                                            {{ $part['part_number'] }}
                                        </span>

                                        <span class="text-slate-300">
                                            •
                                        </span>

                                        <span class="text-xs text-slate-500">
                                            {{ $part['category'] }}
                                        </span>

                                    </div>
                                </div>

                            </td>


                            {{-- Task --}}
                            <td class="px-6 py-4">

                                <span class="rounded-md bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                                    {{ $part['task'] }}
                                </span>

                            </td>


                            {{-- Quantity --}}
                            <td class="px-6 py-4">

                                <p class="text-sm font-semibold text-slate-900">
                                    {{ $part['quantity'] }}
                                </p>

                                <p class="mt-0.5 text-xs text-slate-400">
                                    {{ $part['unit'] }}
                                </p>

                            </td>


                            {{-- Price --}}
                            <td class="px-6 py-4">

                                <p class="text-sm font-semibold text-slate-900">
                                    ₹{{ number_format($part['total']) }}
                                </p>

                                <p class="mt-0.5 text-xs text-slate-400">
                                    ₹{{ number_format($part['unit_price']) }} / unit
                                </p>

                            </td>


                            {{-- Requested By --}}
                            <td class="px-6 py-4">

                                <p class="text-sm font-medium text-slate-700">
                                    {{ $part['requested_by'] }}
                                </p>

                                <p class="mt-0.5 text-xs text-slate-400">
                                    {{ $part['requested_at'] }}
                                </p>

                            </td>


                            {{-- Status --}}
                            <td class="px-6 py-4">

                                @if ($part['status'] === 'Issued')

                                    <div class="flex flex-col items-start gap-1">
                                        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                            Issued
                                        </span>

                                        @if ($part['issued_by'])
                                            <span class="text-xs text-slate-400">
                                                By {{ $part['issued_by'] }}
                                            </span>
                                        @endif
                                    </div>

                                @elseif ($part['status'] === 'Pending')

                                    <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                        Pending
                                    </span>

                                @elseif ($part['status'] === 'Requested')

                                    <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700">
                                        Requested
                                    </span>

                                @elseif ($part['status'] === 'Returned')

                                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                        Returned
                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center justify-end gap-2">

                                    <button
                                        type="button"
                                        class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 transition hover:bg-slate-50"
                                    >
                                        View
                                    </button>

                                    @if (in_array($part['status'], ['Requested', 'Pending']))

                                        <button
                                            type="button"
                                            class="rounded-lg bg-hitek-red px-3 py-2 text-xs font-semibold text-white transition hover:bg-hitek-red-hover"
                                        >
                                            Issue
                                        </button>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>


    {{-- Parts Workflow --}}
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <div class="mb-6">
            <h2 class="text-base font-semibold text-slate-900">
                Parts Workflow
            </h2>

            <p class="mt-1 text-xs text-slate-500">
                Current lifecycle of parts requested for this job card
            </p>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-4">

            {{-- Requested --}}
            <div class="rounded-xl border border-blue-100 bg-blue-50/50 p-4">
                <div class="flex items-center gap-3">

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-100">
                        <span class="text-sm font-bold text-blue-700">1</span>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-slate-900">
                            Requested
                        </p>

                        <p class="text-xs text-slate-500">
                            Mechanic requests part
                        </p>
                    </div>

                </div>
            </div>


            {{-- Pending --}}
            <div class="rounded-xl border border-amber-100 bg-amber-50/50 p-4">
                <div class="flex items-center gap-3">

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-100">
                        <span class="text-sm font-bold text-amber-700">2</span>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-slate-900">
                            Pending
                        </p>

                        <p class="text-xs text-slate-500">
                            Waiting for issue
                        </p>
                    </div>

                </div>
            </div>


            {{-- Issued --}}
            <div class="rounded-xl border border-emerald-100 bg-emerald-50/50 p-4">
                <div class="flex items-center gap-3">

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-100">
                        <span class="text-sm font-bold text-emerald-700">3</span>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-slate-900">
                            Issued
                        </p>

                        <p class="text-xs text-slate-500">
                            Store issues part
                        </p>
                    </div>

                </div>
            </div>


            {{-- Returned --}}
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                <div class="flex items-center gap-3">

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-200">
                        <span class="text-sm font-bold text-slate-600">4</span>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-slate-900">
                            Returned
                        </p>

                        <p class="text-xs text-slate-500">
                            Unused part returned
                        </p>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>
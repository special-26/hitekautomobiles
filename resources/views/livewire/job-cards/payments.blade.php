<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div>
            <div class="flex items-center gap-3">

                <a
                    href="{{ route('job-cards.show', $jobCard['id']) }}"
                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-200 hover:text-slate-900"
                >
                    ←
                </a>

                <div>
                    <h1 class="text-xl font-bold text-slate-900">
                        Payments
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Job Card #{{ $jobCard['id'] }}
                        · {{ $jobCard['vehicle_no'] }}
                        · {{ $jobCard['customer'] }}
                    </p>
                </div>

            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2">

            <button
                type="button"
                class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-200"
            >
                Print Statement
            </button>

            <button
                type="button"
                class="rounded-lg bg-hitek-red px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-hitek-red-hover"
            >
                Record Payment
            </button>

        </div>

    </div>


    {{-- Job Card Navigation --}}
    <x-hitek.job-card-navigation
        :job-card-id="$jobCard['id']"
        active="payments"
    />


    {{-- Payment Summary --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Invoice --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5">

            <p class="text-sm font-medium text-slate-500">
                Invoice Amount
            </p>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                ₹{{ number_format($summary['invoice_total']) }}
            </p>

            <p class="mt-1 text-xs text-slate-500">
                {{ $summary['invoice_number'] }}
            </p>

        </div>


        {{-- Paid --}}
        <div class="rounded-xl border border-green-100 bg-green-50 p-5">

            <p class="text-sm font-medium text-green-700">
                Total Paid
            </p>

            <p class="mt-3 text-2xl font-bold text-green-700">
                ₹{{ number_format($summary['total_paid']) }}
            </p>

            <p class="mt-1 text-xs text-green-600">
                Payments received
            </p>

        </div>


        {{-- Due --}}
        <div class="rounded-xl border border-red-100 bg-red-50 p-5">

            <p class="text-sm font-medium text-red-600">
                Balance Due
            </p>

            <p class="mt-3 text-2xl font-bold text-red-700">
                ₹{{ number_format($summary['balance_due']) }}
            </p>

            <p class="mt-1 text-xs text-red-500">
                Pending from customer
            </p>

        </div>


        {{-- Status --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5">

            <p class="text-sm font-medium text-slate-500">
                Payment Status
            </p>

            <div class="mt-3">

                <span class="inline-flex rounded-full bg-amber-50 px-3 py-1.5 text-sm font-semibold text-amber-700">
                    {{ $summary['payment_status'] }}
                </span>

            </div>

            <p class="mt-2 text-xs text-slate-500">
                Invoice {{ $summary['invoice_number'] }}
            </p>

        </div>

    </div>


    {{-- Payment Progress --}}
    <div class="rounded-xl border border-slate-200 bg-white p-5">

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="font-semibold text-slate-900">
                    Payment Progress
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Amount collected against the final invoice
                </p>
            </div>

            <p class="text-sm font-semibold text-slate-700">
                ₹{{ number_format($summary['total_paid']) }}
                /
                ₹{{ number_format($summary['invoice_total']) }}
            </p>

        </div>


        @php
            $paymentPercentage = $summary['invoice_total'] > 0
                ? min(100, ($summary['total_paid'] / $summary['invoice_total']) * 100)
                : 0;
        @endphp

        <div class="mt-4 h-3 overflow-hidden rounded-full bg-slate-100">
            <div
                class="h-full rounded-full bg-green-500"
                style="width: {{ $paymentPercentage }}%"
            ></div>
        </div>

        <div class="mt-2 flex justify-between text-xs text-slate-500">
            <span>
                {{ number_format($paymentPercentage, 0) }}% collected
            </span>

            <span>
                ₹{{ number_format($summary['balance_due']) }} remaining
            </span>
        </div>

    </div>


    {{-- Payment History --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

        <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="font-semibold text-slate-900">
                    Payment History
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    All payments received against this job card
                </p>
            </div>

            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                {{ count($payments) }} Payments
            </span>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-slate-200 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">

                    <tr>
                        <th class="px-5 py-3">Receipt</th>
                        <th class="px-3 py-3">Date</th>
                        <th class="px-3 py-3">Method</th>
                        <th class="px-3 py-3">Reference</th>
                        <th class="px-3 py-3">Received By</th>
                        <th class="px-3 py-3 text-right">Amount</th>
                        <th class="px-5 py-3 text-center">Action</th>
                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @foreach ($payments as $payment)

                        <tr class="transition hover:bg-slate-200">

                            {{-- Receipt --}}
                            <td class="px-5 py-4">

                                <p class="font-semibold text-slate-800">
                                    {{ $payment['receipt_number'] }}
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    {{ $payment['notes'] }}
                                </p>

                            </td>


                            {{-- Date --}}
                            <td class="px-3 py-4 whitespace-nowrap">

                                <p class="font-medium text-slate-700">
                                    {{ $payment['date'] }}
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    {{ $payment['time'] }}
                                </p>

                            </td>


                            {{-- Method --}}
                            <td class="px-3 py-4">

                                @php
                                    $methodClasses = match ($payment['method']) {
                                        'UPI' => 'bg-purple-50 text-purple-700',
                                        'Cash' => 'bg-green-50 text-green-700',
                                        'Card' => 'bg-blue-50 text-blue-700',
                                        default => 'bg-slate-100 text-slate-600',
                                    };
                                @endphp

                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $methodClasses }}">
                                    {{ $payment['method'] }}
                                </span>

                            </td>


                            {{-- Reference --}}
                            <td class="px-3 py-4">

                                @if ($payment['reference'])

                                    <span class="font-mono text-xs text-slate-600">
                                        {{ $payment['reference'] }}
                                    </span>

                                @else

                                    <span class="text-xs text-slate-400">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- Received By --}}
                            <td class="px-3 py-4">

                                <p class="font-medium text-slate-700">
                                    {{ $payment['received_by'] }}
                                </p>

                                <span class="mt-1 inline-flex rounded-full bg-green-50 px-2 py-0.5 text-xs font-medium text-green-700">
                                    {{ $payment['status'] }}
                                </span>

                            </td>


                            {{-- Amount --}}
                            <td class="px-3 py-4 text-right">

                                <p class="font-bold text-slate-900">
                                    ₹{{ number_format($payment['amount']) }}
                                </p>

                            </td>


                            {{-- Action --}}
                            <td class="px-5 py-4 text-center">

                                <button
                                    type="button"
                                    class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:bg-slate-200 hover:text-slate-900"
                                >
                                    Receipt
                                </button>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- Table Footer --}}
        <div class="border-t border-slate-200 bg-slate-200 px-5 py-4">

            <div class="ml-auto flex max-w-sm items-center justify-between">

                <span class="text-sm font-medium text-slate-500">
                    Total Payments
                </span>

                <span class="text-lg font-bold text-slate-900">
                    ₹{{ number_format($summary['total_paid']) }}
                </span>

            </div>

        </div>

    </div>


    {{-- Outstanding Balance --}}
    <div class="rounded-xl border border-red-200 bg-red-50 p-5">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <div class="flex items-center gap-2">

                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-100 text-red-600">
                        !
                    </span>

                    <h2 class="font-semibold text-red-900">
                        Outstanding Balance
                    </h2>

                </div>

                <p class="mt-2 text-sm text-red-700">
                    ₹{{ number_format($summary['balance_due']) }}
                    is still pending against invoice
                    {{ $summary['invoice_number'] }}.
                </p>

            </div>

            <button
                type="button"
                class="rounded-lg bg-hitek-red px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-hitek-red-hover"
            >
                Collect Payment
            </button>

        </div>

    </div>

</div>
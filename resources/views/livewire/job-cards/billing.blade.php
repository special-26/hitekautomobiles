<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div>
            <div class="flex items-center gap-3">
                <a
                    href="{{ route('job-cards.show', $jobCard['id']) }}"
                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50 hover:text-slate-900"
                >
                    ←
                </a>

                <div>
                    <h1 class="text-xl font-bold text-slate-900">
                        Billing
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
                class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
            >
                Print
            </button>

            <button
                type="button"
                class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
            >
                WhatsApp
            </button>

            <button
                type="button"
                class="rounded-lg bg-hitek-red px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-hitek-red-hover"
            >
                Create Invoice
            </button>

        </div>
    </div>


    {{-- Job Card Navigation --}}
    <x-hitek.job-card-navigation
        :job-card-id="$jobCard['id']"
        active="billing"
    />


    {{-- Billing Summary --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Estimate --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">
                    Estimate
                </p>

                <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                    {{ $estimate['status'] }}
                </span>
            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                ₹{{ number_format($estimate['total']) }}
            </p>

            <p class="mt-1 text-xs text-slate-500">
                {{ $estimate['number'] }} · {{ $estimate['date'] }}
            </p>
        </div>


        {{-- Invoice --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">
                    Final Invoice
                </p>

                <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">
                    {{ $invoice['status'] }}
                </span>
            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                ₹{{ number_format($invoice['total']) }}
            </p>

            <p class="mt-1 text-xs text-slate-500">
                {{ $invoice['number'] }} · {{ $invoice['date'] }}
            </p>
        </div>


        {{-- Paid --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <p class="text-sm font-medium text-slate-500">
                Total Paid
            </p>

            <p class="mt-3 text-2xl font-bold text-green-600">
                ₹{{ number_format($invoice['paid']) }}
            </p>

            <p class="mt-1 text-xs text-slate-500">
                Payments received against invoice
            </p>
        </div>


        {{-- Due --}}
        <div class="rounded-xl border border-red-100 bg-red-50 p-5">
            <p class="text-sm font-medium text-red-600">
                Balance Due
            </p>

            <p class="mt-3 text-2xl font-bold text-red-700">
                ₹{{ number_format($invoice['due']) }}
            </p>

            <p class="mt-1 text-xs text-red-500">
                Amount pending from customer
            </p>
        </div>

    </div>


    {{-- Estimate + Invoice --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

        {{-- Estimate --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">

                <div>
                    <h2 class="font-semibold text-slate-900">
                        Estimate
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        {{ $estimate['number'] }}
                    </p>
                </div>

                <button
                    type="button"
                    class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-50"
                >
                    Edit
                </button>

            </div>


            {{-- Items --}}
            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Description</th>
                            <th class="px-3 py-3 text-center">Qty</th>
                            <th class="px-3 py-3 text-right">Rate</th>
                            <th class="px-5 py-3 text-right">Amount</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @foreach ($estimateItems as $item)

                            <tr>

                                <td class="px-5 py-3">

                                    <p class="font-medium text-slate-800">
                                        {{ $item['description'] }}
                                    </p>

                                    <span class="text-xs text-slate-400">
                                        {{ $item['type'] }}
                                    </span>

                                </td>

                                <td class="px-3 py-3 text-center text-slate-600">
                                    {{ $item['quantity'] }}
                                </td>

                                <td class="px-3 py-3 text-right text-slate-600">
                                    ₹{{ number_format($item['rate']) }}
                                </td>

                                <td class="px-5 py-3 text-right font-medium text-slate-800">
                                    ₹{{ number_format($item['amount']) }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- Estimate Summary --}}
            <div class="border-t border-slate-200 bg-slate-50 px-5 py-4">

                <div class="ml-auto max-w-xs space-y-2 text-sm">

                    <div class="flex justify-between text-slate-500">
                        <span>Subtotal</span>
                        <span>₹{{ number_format($estimate['subtotal']) }}</span>
                    </div>

                    <div class="flex justify-between text-slate-500">
                        <span>Discount</span>
                        <span>- ₹{{ number_format($estimate['discount']) }}</span>
                    </div>

                    <div class="flex justify-between text-slate-500">
                        <span>GST / Tax</span>
                        <span>₹{{ number_format($estimate['tax']) }}</span>
                    </div>

                    <div class="flex justify-between border-t border-slate-200 pt-2 text-base font-bold text-slate-900">
                        <span>Estimate Total</span>
                        <span>₹{{ number_format($estimate['total']) }}</span>
                    </div>

                </div>

            </div>

        </div>


        {{-- Final Invoice --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">

                <div>
                    <h2 class="font-semibold text-slate-900">
                        Final Invoice
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        {{ $invoice['number'] }}
                    </p>
                </div>

                <button
                    type="button"
                    class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-50"
                >
                    Edit
                </button>

            </div>


            {{-- Items --}}
            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Description</th>
                            <th class="px-3 py-3 text-center">Qty</th>
                            <th class="px-3 py-3 text-right">Rate</th>
                            <th class="px-5 py-3 text-right">Amount</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @foreach ($invoiceItems as $item)

                            <tr>

                                <td class="px-5 py-3">

                                    <p class="font-medium text-slate-800">
                                        {{ $item['description'] }}
                                    </p>

                                    <span class="text-xs text-slate-400">
                                        {{ $item['type'] }}
                                    </span>

                                </td>

                                <td class="px-3 py-3 text-center text-slate-600">
                                    {{ $item['quantity'] }}
                                </td>

                                <td class="px-3 py-3 text-right text-slate-600">
                                    ₹{{ number_format($item['rate']) }}
                                </td>

                                <td class="px-5 py-3 text-right font-medium text-slate-800">
                                    ₹{{ number_format($item['amount']) }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- Invoice Summary --}}
            <div class="border-t border-slate-200 bg-slate-50 px-5 py-4">

                <div class="ml-auto max-w-xs space-y-2 text-sm">

                    <div class="flex justify-between text-slate-500">
                        <span>Subtotal</span>
                        <span>₹{{ number_format($invoice['subtotal']) }}</span>
                    </div>

                    <div class="flex justify-between text-slate-500">
                        <span>Discount</span>
                        <span>- ₹{{ number_format($invoice['discount']) }}</span>
                    </div>

                    <div class="flex justify-between text-slate-500">
                        <span>GST / Tax</span>
                        <span>₹{{ number_format($invoice['tax']) }}</span>
                    </div>

                    <div class="flex justify-between border-t border-slate-200 pt-2 text-base font-bold text-slate-900">
                        <span>Invoice Total</span>
                        <span>₹{{ number_format($invoice['total']) }}</span>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Payment Summary --}}
    <div class="rounded-xl border border-slate-200 bg-white">

        <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="font-semibold text-slate-900">
                    Payment Summary
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Payment status for {{ $invoice['number'] }}
                </p>
            </div>

            <button
                type="button"
                class="rounded-lg bg-hitek-red px-4 py-2 text-sm font-semibold text-white hover:bg-hitek-red-hover"
            >
                Record Payment
            </button>

        </div>


        <div class="grid grid-cols-1 divide-y divide-slate-100 sm:grid-cols-3 sm:divide-x sm:divide-y-0">

            <div class="p-5">
                <p class="text-sm text-slate-500">
                    Invoice Amount
                </p>

                <p class="mt-2 text-xl font-bold text-slate-900">
                    ₹{{ number_format($invoice['total']) }}
                </p>
            </div>

            <div class="p-5">
                <p class="text-sm text-slate-500">
                    Amount Paid
                </p>

                <p class="mt-2 text-xl font-bold text-green-600">
                    ₹{{ number_format($invoice['paid']) }}
                </p>
            </div>

            <div class="p-5">
                <p class="text-sm text-slate-500">
                    Balance Due
                </p>

                <p class="mt-2 text-xl font-bold text-red-600">
                    ₹{{ number_format($invoice['due']) }}
                </p>
            </div>

        </div>

    </div>

</div>
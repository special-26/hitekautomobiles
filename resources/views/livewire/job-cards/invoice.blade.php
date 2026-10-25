<div class="min-h-screen bg-slate-100 px-4 py-6 sm:px-6 lg:px-8">

    {{-- Top Actions --}}
    <div class="mx-auto mb-6 flex max-w-6xl items-center justify-between">
        <div>
            <a
                href="{{ route('job-cards.billing', $jobCard['id']) }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-900"
            >
                ← Back to Billing
            </a>

            <h1 class="mt-2 text-2xl font-bold text-slate-900">
                Invoice Preview
            </h1>
        </div>

        <div class="flex items-center gap-2">
            <button
                type="button"
                wire:click="openWhatsApp"
                class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700"
            >
                <span>💬</span>
                WhatsApp
            </button>
            <button
                type="button"
                onclick="window.print()"
                class="inline-flex items-center gap-2 rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-900"
            >
                🖨 Print
            </button>
        </div>
    </div>


    {{-- Invoice --}}
    <div
        id="invoice-preview"
        class="mx-auto max-w-6xl overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm"
    >

        {{-- Invoice Header --}}
        <div class="border-b-4 border-red-600 px-8 py-6">

            <div class="flex items-start justify-between gap-8">

                {{-- Company --}}
                <div class="flex items-start gap-4">

                    <div>
                        <div class="shrink-0">
                            <img
                                src="{{ asset('images/logo.jpg') }}"
                                alt="Hitek Automobiles"
                                class="h-auto w-64 object-contain"
                            >
                        </div>

                        <div class="mt-3 space-y-0.5 text-xs leading-5 text-slate-600">
                            <p>
                                Plot No. 131, Industrial Area Phase I,
                                Chandigarh - 160002
                            </p>

                            <p>
                                <span class="font-semibold text-slate-700">Phone:</span>
                                9216111868
                            </p>

                            <p>
                                <span class="font-semibold text-slate-700">GSTIN:</span>
                                04AAPFH8690G1ZY
                            </p>
                        </div>
                    </div>

                </div>


                {{-- Invoice Information --}}
                <div class="min-w-[230px] shrink-0 text-right">

                    <div class="inline-flex rounded-md bg-red-600 px-4 py-2">
                        <span class="text-sm font-black uppercase tracking-widest text-white">
                            Tax Invoice
                        </span>
                    </div>

                    <div class="mt-4 space-y-2 text-sm">

                        <div class="flex items-center justify-between gap-6">
                            <span class="shrink-0 text-slate-500">
                                Invoice No.
                            </span>

                            <span class="whitespace-nowrap font-bold text-slate-900">
                                {{ $invoice['number'] }}
                            </span>
                        </div>

                        <div class="flex justify-between gap-8">
                            <span class="text-slate-500">
                                Invoice Date
                            </span>

                            <span class="font-semibold text-slate-800">
                                {{ $invoice['date'] }}
                            </span>
                        </div>

                        <div class="flex justify-between gap-8">
                            <span class="text-slate-500">
                                Job Card
                            </span>

                            <span class="font-semibold text-slate-800">
                                {{ $jobCard['job_card_number'] }}
                            </span>
                        </div>

                        <div class="flex justify-between gap-8">
                            <span class="text-slate-500">
                                Status
                            </span>

                            <span class="font-semibold text-slate-800">
                                {{ ucfirst($invoice['status']) }}
                            </span>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Customer + Vehicle --}}
        <div class="grid grid-cols-1 border-b border-slate-200 sm:grid-cols-2">

            {{-- Bill To --}}
            <div class="border-b border-slate-200 px-8 py-6 sm:border-b-0 sm:border-r">

                <p class="text-[11px] font-bold uppercase tracking-[0.15em] text-slate-500">
                    Bill To
                </p>

                <div class="mt-3">
                    <h3 class="text-lg font-bold text-slate-900">
                        {{ $jobCard['customer'] }}
                    </h3>

                    <div class="mt-2 space-y-1 text-sm text-slate-600">
                        @if($jobCard['phone'])
                            <p>
                                <span class="text-slate-400">Phone:</span>
                                {{ $jobCard['phone'] }}
                            </p>
                        @endif

                        @if($jobCard['email'])
                            <p>
                                <span class="text-slate-400">Email:</span>
                                {{ $jobCard['email'] }}
                            </p>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Vehicle --}}
            <div class="px-8 py-6">

                <p class="text-[11px] font-bold uppercase tracking-[0.15em] text-slate-500">
                    Vehicle Details
                </p>

                <div class="mt-3 grid grid-cols-[120px_1fr] gap-y-2 text-sm">

                    <span class="text-slate-400">
                        Registration
                    </span>

                    <span class="font-bold text-slate-900">
                        {{ $jobCard['vehicle_no'] }}
                    </span>

                    <span class="text-slate-400">
                        Vehicle
                    </span>

                    <span class="font-semibold text-slate-800">
                        {{ $jobCard['vehicle'] }}
                    </span>

                    <span class="text-slate-400">
                        Job Card
                    </span>

                    <span class="font-semibold text-slate-800">
                        {{ $jobCard['job_card_number'] }}
                    </span>

                </div>

            </div>

        </div>


        {{-- Items --}}
        <div class="px-8 py-7">

            <div class="mb-4">
                <h3 class="text-base font-bold text-slate-900">
                    Invoice Details
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Services and parts supplied for this vehicle
                </p>
            </div>

            <div class="invoice-table-wrapper overflow-x-auto rounded-lg border border-slate-200">
                <table class="invoice-table w-full text-xs">

                    <thead class="bg-slate-50">
                        <tr class="border-b border-slate-200 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Description</th>
                            <th class="px-4 py-3">HSN/SAC</th>
                            <th class="px-4 py-3 text-right">Qty</th>
                            <th class="px-4 py-3 text-right">Rate</th>
                            <th class="px-4 py-3 text-right">Discount</th>
                            <th class="px-4 py-3 text-right">Taxable</th>
                            <th class="px-4 py-3 text-right">CGST</th>
                            <th class="px-4 py-3 text-right">SGST/UGST</th>
                            <th class="px-4 py-3 text-right">IGST</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @foreach($items as $index => $item)

                            <tr class="text-slate-700">

                                <td class="px-4 py-4 font-medium text-slate-400">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-4 py-4">
                                    <p class="font-semibold text-slate-900">
                                        {{ $item['description'] }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-slate-400">
                                        {{ $item['type'] }}
                                    </p>
                                </td>

                                <td class="px-4 py-4 text-slate-600">
                                    {{ $item['hsn_sac'] ?: '—' }}
                                </td>

                                <td class="px-4 py-4 text-right">
                                    {{ number_format($item['quantity'], 2) }}
                                </td>

                                <td class="px-4 py-4 text-right">
                                    ₹{{ number_format($item['rate'], 2) }}
                                </td>

                                <td class="px-4 py-4 text-right">
                                    ₹{{ number_format($item['discount'], 2) }}
                                </td>

                                <td class="px-4 py-4 text-right font-semibold text-slate-900">
                                    ₹{{ number_format($item['taxable_amount'], 2) }}
                                </td>

                                <td class="px-4 py-4 text-right">
                                    @if($item['cgst_amount'] > 0)
                                        <div class="font-medium">
                                            ₹{{ number_format($item['cgst_amount'], 2) }}
                                        </div>
                                        <div class="text-xs text-slate-400">
                                            {{ number_format($item['cgst_rate'], 2) }}%
                                        </div>
                                    @else
                                        —
                                    @endif
                                </td>

                                <td class="px-4 py-4 text-right">
                                    @if($item['sgst_amount'] > 0)
                                        <div class="font-medium">
                                            ₹{{ number_format($item['sgst_amount'], 2) }}
                                        </div>
                                        <div class="text-xs text-slate-400">
                                            {{ number_format($item['sgst_rate'], 2) }}%
                                        </div>
                                    @else
                                        —
                                    @endif
                                </td>

                                <td class="px-4 py-4 text-right">
                                    @if($item['igst_amount'] > 0)
                                        <div class="font-medium">
                                            ₹{{ number_format($item['igst_amount'], 2) }}
                                        </div>
                                        <div class="text-xs text-slate-400">
                                            {{ number_format($item['igst_rate'], 2) }}%
                                        </div>
                                    @else
                                        —
                                    @endif
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>
            </div>
        </div>


        {{-- Bottom Section --}}
        <div class="grid grid-cols-1 border-t border-slate-200 lg:grid-cols-2">

            {{-- Tax Information --}}
            <div class="tax-summary border-b border-slate-200 px-8 py-7 lg:border-b-0 lg:border-r">

                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500">
                    Tax Information
                </h3>

                <div class="mt-4 rounded-lg bg-slate-50 p-5">

                    <div class="flex justify-between py-1.5 text-sm">
                        <span class="text-slate-500">GST Type</span>
                        <span class="font-semibold text-slate-900">
                            {{ $invoice['tax_type'] }}
                        </span>
                    </div>

                    <div class="flex justify-between py-1.5 text-sm">
                        <span class="text-slate-500">GST Rate</span>
                        <span class="font-semibold text-slate-900">
                            {{ number_format($invoice['tax_rate'], 2) }}%
                        </span>
                    </div>

                    <div class="mt-3 border-t border-slate-200 pt-3">

                        @if($invoice['tax_type'] === 'SGST/UGST')

                            <div class="flex justify-between py-1.5 text-sm">
                                <span class="text-slate-500">CGST</span>
                                <span class="font-semibold text-slate-900">
                                    ₹{{ number_format($invoice['tax'] / 2, 2) }}
                                </span>
                            </div>

                            <div class="flex justify-between py-1.5 text-sm">
                                <span class="text-slate-500">SGST/UGST</span>
                                <span class="font-semibold text-slate-900">
                                    ₹{{ number_format($invoice['tax'] / 2, 2) }}
                                </span>
                            </div>

                        @else

                            <div class="flex justify-between py-1.5 text-sm">
                                <span class="text-slate-500">IGST</span>
                                <span class="font-semibold text-slate-900">
                                    ₹{{ number_format($invoice['tax'], 2) }}
                                </span>
                            </div>

                        @endif

                        <div class="mt-2 flex justify-between border-t border-slate-200 pt-3">
                            <span class="font-semibold text-slate-700">
                                Total Tax
                            </span>

                            <span class="font-bold text-slate-900">
                                ₹{{ number_format($invoice['tax'], 2) }}
                            </span>
                        </div>

                    </div>

                </div>

                <div class="mt-6">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">
                        Amount in Words
                    </p>

                    <p class="mt-2 text-sm font-medium text-slate-700">
                        {{ $invoice['amount_in_words'] }}
                    </p>
                </div>

            </div>


            {{-- Invoice Totals --}}
            <div class="px-8 py-7">

                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500">
                    Invoice Summary
                </h3>

                <div class="mt-5 space-y-3">

                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">
                            Subtotal
                        </span>

                        <span class="font-semibold text-slate-800">
                            ₹{{ number_format($invoice['subtotal'], 2) }}
                        </span>
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">
                            Discount
                        </span>

                        <span class="font-semibold text-slate-800">
                            ₹{{ number_format($invoice['discount'], 2) }}
                        </span>
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">
                            Tax
                        </span>

                        <span class="font-semibold text-slate-800">
                            ₹{{ number_format($invoice['tax'], 2) }}
                        </span>
                    </div>

                    <div class="my-4 border-t border-slate-200"></div>

                    <div class="flex items-end justify-between">
                        <span class="text-base font-bold text-slate-900">
                            Grand Total
                        </span>

                        <span class="text-2xl font-black text-red-600">
                            ₹{{ number_format($invoice['total'], 2) }}
                        </span>
                    </div>

                </div>


                {{-- Payment Status --}}
                <div class="payment-summary mt-7 rounded-lg border border-slate-200 p-4">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-500">
                                Payment Status
                            </p>

                            <p class="mt-1 text-sm font-semibold text-slate-900">
                                {{ $invoice['payment_status'] }}
                            </p>
                        </div>

                        @if($invoice['payment_status'] === 'PAID')
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">
                                PAID
                            </span>
                        @elseif($invoice['payment_status'] === 'PARTIALLY PAID')
                            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700">
                                PARTIALLY PAID
                            </span>
                        @else
                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-700">
                                UNPAID
                            </span>
                        @endif

                    </div>

                    <div class="mt-4 space-y-2 border-t border-slate-200 pt-4">

                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">
                                Invoice Total
                            </span>

                            <span class="font-semibold text-slate-800">
                                ₹{{ number_format($invoice['total'], 2) }}
                            </span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">
                                Amount Paid
                            </span>

                            <span class="font-semibold text-emerald-600">
                                ₹{{ number_format($invoice['paid'], 2) }}
                            </span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="font-medium text-slate-700">
                                Amount Due
                            </span>

                            <span class="font-bold text-red-600">
                                ₹{{ number_format($invoice['due'], 2) }}
                            </span>
                        </div>

                        @if($invoice['due'] > 0)
                            <div class="mt-4 border-t border-slate-200 pt-4">
                                <button
                                    type="button"
                                    wire:click="payNow"
                                    wire:loading.attr="disabled"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-hitek-red px-4 py-2.5 text-sm font-bold text-white transition hover:bg-hitek-red-hover disabled:cursor-not-allowed disabled:opacity-60"
                                >
                                    <span wire:loading.remove wire:target="payNow">
                                        Pay Now
                                    </span>

                                    <span wire:loading wire:target="payNow">
                                        Creating Payment Link...
                                    </span>
                                </button>
                            </div>
                        @endif

                    </div>

                </div>

            </div>

        </div>

        {{-- Payment Transactions --}}
        @if(count($payments) > 0)

            <div class="border-t border-slate-200 px-8 py-7">

                <div class="mb-4">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500">
                        Payment Transactions
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Payments received against this invoice
                    </p>
                </div>

                <div class="payment-table-wrapper overflow-x-auto rounded-lg border border-slate-200">
                    <table class="payment-table w-full text-xs">

                        <thead class="bg-slate-50">
                            <tr class="border-b border-slate-200 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Receipt No.</th>
                                <th class="px-4 py-3">Payment Method</th>
                                <th class="px-4 py-3">Reference</th>
                                <th class="px-4 py-3 text-right">Amount</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @foreach($payments as $payment)

                                <tr class="text-slate-700">

                                    <td class="px-4 py-3">
                                        {{ $payment['payment_date'] }}
                                    </td>

                                    <td class="px-4 py-3 font-semibold text-slate-900">
                                        {{ $payment['receipt_number'] }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">
                                            {{ strtoupper($payment['payment_method']) }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-slate-500">
                                        {{ $payment['reference'] ?: '—' }}
                                    </td>

                                    <td class="px-4 py-3 text-right font-bold text-slate-900">
                                        ₹{{ number_format($payment['amount'], 2) }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                        <tfoot class="bg-slate-50">
                            <tr>
                                <td
                                    colspan="4"
                                    class="px-4 py-3 text-right font-semibold text-slate-700"
                                >
                                    Total Paid
                                </td>

                                <td class="px-4 py-3 text-right font-black text-emerald-600">
                                    ₹{{ number_format($invoice['paid'], 2) }}
                                </td>
                            </tr>
                        </tfoot>

                    </table>
                </div>

            </div>

        @endif

        {{-- Footer --}}
        <div class="border-t border-slate-200 bg-slate-50 px-8 py-6">

            <div class="flex flex-col justify-between gap-4 text-sm sm:flex-row">

                <div>
                    <p class="font-semibold text-slate-800">
                        Thank you for choosing Hitek Automobiles.
                    </p>

                    <p class="mt-1 text-slate-500">
                        Please retain this invoice for your records.
                    </p>
                </div>

                <div class="text-left sm:text-right text-slate-500">
                    <p>Authorised Signature</p>
                    <img src="{{ asset('images/sign.png') }}" alt="Signature" class=" h-12 w-30 object-contain">
                    <div class=" border-b border-slate-300 sm:w-30"></div>
                </div>

            </div>

        </div>

    </div>
</div>


{{-- Print Styling --}}
<style>
    /* Screen */
    #invoice-preview {
        font-family: Arial, Helvetica, sans-serif;
    }

    /* Print */
    @media print {

        html,
        body {
            background: #ffffff !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        body * {
            visibility: hidden;
        }

        #invoice-preview,
        #invoice-preview * {
            visibility: visible;
        }

        #invoice-preview {
            position: absolute;
            left: 0;
            top: 0;

            width: 100%;
            max-width: none;

            margin: 0 !important;
            padding: 0 !important;

            border: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;

            background: #ffffff !important;
        }

        /* Hide screen-only elements */
        a[href*="billing"],
        button {
            display: none !important;
        }

        /* A4 page */
        @page {
            size: A4;
            margin: 0mm;
        }

        /* Avoid awkward page breaks */
        table {
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }

        h1,
        h2,
        h3 {
            page-break-after: avoid;
        }

        /* Keep important sections together */
        .payment-summary,
        .tax-summary,
        .invoice-footer {
            page-break-inside: avoid;
        }

        .invoice-table-wrapper,
        .payment-table-wrapper {
            overflow: visible !important;
            width: 100% !important;
        }

        .invoice-table,
        .payment-table {
            width: 100% !important;
            min-width: 0 !important;
            table-layout: fixed;
            font-size: 8px !important;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 5px 4px !important;
            white-space: normal !important;
            word-break: break-word;
        }

        .payment-table th,
        .payment-table td {
            padding: 5px 4px !important;
            white-space: normal !important;
            word-break: break-word;
        }
        .invoice-table th:nth-child(1),
        .invoice-table td:nth-child(1) {
            width: 3%;
        }

        .invoice-table th:nth-child(2),
        .invoice-table td:nth-child(2) {
            width: 24%;
        }

        .invoice-table th:nth-child(3),
        .invoice-table td:nth-child(3) {
            width: 7%;
        }

        .invoice-table th:nth-child(4),
        .invoice-table td:nth-child(4) {
            width: 5%;
        }

        .invoice-table th:nth-child(5),
        .invoice-table td:nth-child(5) {
            width: 8%;
        }

        .invoice-table th:nth-child(6),
        .invoice-table td:nth-child(6) {
            width: 8%;
        }

        .invoice-table th:nth-child(7),
        .invoice-table td:nth-child(7) {
            width: 11%;
        }

        .invoice-table th:nth-child(8),
        .invoice-table td:nth-child(8) {
            width: 10%;
        }

        .invoice-table th:nth-child(9),
        .invoice-table td:nth-child(9) {
            width: 12%;
        }

        .invoice-table th:nth-child(10),
        .invoice-table td:nth-child(10) {
            width: 12%;
        }

        .payment-table th:nth-child(1),
        .payment-table td:nth-child(1) {
            width: 22%;
        }

        .payment-table th:nth-child(2),
        .payment-table td:nth-child(2) {
            width: 22%;
        }

        .payment-table th:nth-child(3),
        .payment-table td:nth-child(3) {
            width: 18%;
        }

        .payment-table th:nth-child(4),
        .payment-table td:nth-child(4) {
            width: 20%;
        }

        .payment-table th:nth-child(5),
        .payment-table td:nth-child(5) {
            width: 18%;
        }
        .invoice-table th {
            white-space: nowrap !important;
            font-size: 7px !important;
            line-height: 1.1 !important;
        }
        @media screen {
            .invoice-table th {
                white-space: nowrap;
            }
        }
    }
</style>
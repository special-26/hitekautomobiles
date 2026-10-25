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
                        Job Card #{{ $jobCard['job_card_number'] }}
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
                wire:click="openInvoiceModal"
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

                @if ($estimate)
                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                        {{ $estimate['status'] }}
                    </span>
                @else
                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">
                        Not Created
                    </span>
                @endif
            </div>

            @if ($estimate)
                <p class="mt-3 text-2xl font-bold text-slate-900">
                    ₹{{ number_format($estimate['total']) }}
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    {{ $estimate['number'] }} · {{ $estimate['date'] }}
                </p>
            @else
                <p class="mt-3 text-2xl font-bold text-slate-400">
                    —
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    No estimate available
                </p>
            @endif
        </div>

        {{-- Final Invoice --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">
                    Final Invoice
                </p>

                @if ($invoice)
                    <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">
                        {{ $invoice['status'] }}
                    </span>
                @else
                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">
                        Not Created
                    </span>
                @endif
            </div>

            @if ($invoice)
                <p class="mt-3 text-2xl font-bold text-slate-900">
                    ₹{{ number_format($invoice['total']) }}
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    {{ $invoice['number'] }} · {{ $invoice['date'] }}
                </p>
            @else
                <p class="mt-3 text-2xl font-bold text-slate-400">
                    —
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    No invoice available
                </p>
            @endif
        </div>

        {{-- Paid --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <p class="text-sm font-medium text-slate-500">
                Total Paid
            </p>

            <p class="mt-3 text-2xl font-bold text-green-600">
                {{ $invoice && $invoice['paid'] !== null
                    ? '₹' . number_format($invoice['paid'])
                    : 'Not Available' }}
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
                {{ $invoice && $invoice['due'] !== null
                    ? '₹' . number_format($invoice['due'])
                    : 'Not Available' }}
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

                    @if ($estimate)
                        <p class="mt-1 text-xs text-slate-500">
                            {{ $estimate['number'] }}
                        </p>
                    @endif
                </div>

                @if ($estimate)
                    <button
                        type="button"
                        wire:click="editEstimate"
                        class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-50"
                    >
                        Edit
                    </button>
                @endif
            </div>

            @if ($estimate)

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

            @else

                {{-- No Estimate --}}
                <div class="flex min-h-64 flex-col items-center justify-center px-5 py-10 text-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M9 14h6m-6-4h6m2 9H7a2 2 0 01-2-2V5a2 2 0 012-2h6l4 4v10a2 2 0 01-2 2z"/>
                        </svg>
                    </div>

                    <h3 class="mt-4 text-sm font-semibold text-slate-900">
                        No Estimate Created
                    </h3>

                    <p class="mt-1 max-w-xs text-xs text-slate-500">
                        An estimate has not been created for this job card yet.
                    </p>

                    <button
                        type="button"
                        wire:click="openEstimateModal"
                        class="mt-4 rounded-lg bg-hitek-red px-4 py-2 text-xs font-semibold text-white hover:bg-hitek-red-hover"
                    >
                        Create Estimate
                    </button>
                </div>

            @endif

        </div>

        {{-- Final Invoice --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

            {{-- Header --}}
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                <div>
                    <h2 class="font-semibold text-slate-900">
                        Final Invoice
                    </h2>

                    @if ($invoice)
                        <p class="mt-1 text-xs text-slate-500">
                            {{ $invoice['number'] }}
                        </p>
                    @endif
                </div>

                @if ($invoice)
                    <div class="flex flex-wrap items-center gap-2">
                        <a
                            href="{{ route('job-cards.invoice', [
                                'jobCard' => $jobCard['id'],
                                'invoice' => $invoice['id'],
                            ]) }}"
                            class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50"
                        >
                            View Invoice
                        </a>
                        <button
                            type="button"
                            class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-700"
                        >
                            Print
                        </button>
                        <button
                            type="button"
                            class="rounded-lg bg-hitek-red px-3 py-2 text-xs font-semibold text-white hover:bg-hitek-red-hover"
                        >
                            WhatsApp
                        </button>
                        <button
                            type="button"
                            class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-50"
                        >
                            Edit
                        </button>
                    </div>
                @endif
            </div>

            @if ($invoice)

                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="min-w-full text-sm">

                        <thead class="bg-slate-50">
                            <tr class="border-b border-slate-200">

                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                    Description
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                    HSN/SAC
                                </th>

                                <th class="px-4 py-3 text-center text-xs font-semibold uppercase text-slate-500">
                                    Qty
                                </th>

                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-slate-500">
                                    Rate
                                </th>

                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-slate-500">
                                    Discount
                                </th>

                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-slate-500">
                                    Taxable
                                </th>

                                @if ($invoice['tax_type'] === 'SGST/UGST')

                                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-slate-500">
                                        CGST
                                    </th>

                                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-slate-500">
                                        SGST/UGST
                                    </th>

                                @else

                                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-slate-500">
                                        IGST
                                    </th>

                                @endif

                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-slate-500">
                                    Total
                                </th>

                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @forelse ($invoiceItems as $item)

                                <tr>

                                    <td class="px-4 py-3 font-medium text-slate-800">
                                        {{ $item['description'] }}

                                        <div class="mt-0.5 text-xs text-slate-400">
                                            {{ $item['type'] }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-3 text-slate-600">
                                        {{ $item['hsn_sac'] ?: '—' }}
                                    </td>

                                    <td class="px-4 py-3 text-center text-slate-600">
                                        {{ $item['quantity'] }}
                                    </td>

                                    <td class="px-4 py-3 text-right text-slate-600">
                                        ₹{{ number_format($item['rate'], 2) }}
                                    </td>

                                    <td class="px-4 py-3 text-right text-slate-600">
                                        ₹{{ number_format($item['discount'], 2) }}
                                    </td>

                                    <td class="px-4 py-3 text-right font-medium text-slate-800">
                                        ₹{{ number_format($item['taxable_amount'], 2) }}
                                    </td>

                                    @if ($invoice['tax_type'] === 'SGST/UGST')

                                        <td class="px-4 py-3 text-right text-slate-600">
                                            <div>
                                                ₹{{ number_format($item['cgst_amount'], 2) }}
                                            </div>

                                            <div class="text-xs text-slate-400">
                                                {{ number_format($item['cgst_rate'], 2) }}%
                                            </div>
                                        </td>

                                        <td class="px-4 py-3 text-right text-slate-600">
                                            <div>
                                                ₹{{ number_format($item['sgst_amount'], 2) }}
                                            </div>

                                            <div class="text-xs text-slate-400">
                                                {{ number_format($item['sgst_rate'], 2) }}%
                                            </div>
                                        </td>

                                    @else

                                        <td class="px-4 py-3 text-right text-slate-600">
                                            <div>
                                                ₹{{ number_format($item['igst_amount'], 2) }}
                                            </div>

                                            <div class="text-xs text-slate-400">
                                                {{ number_format($item['igst_rate'], 2) }}%
                                            </div>
                                        </td>

                                    @endif

                                    <td class="px-4 py-3 text-right font-bold text-slate-900">
                                        ₹{{ number_format(
                                            $item['taxable_amount']
                                            + $item['cgst_amount']
                                            + $item['sgst_amount']
                                            + $item['igst_amount'],
                                            2
                                        ) }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td
                                        colspan="10"
                                        class="px-4 py-8 text-center text-sm text-slate-500"
                                    >
                                        No invoice items found.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>

            @endif

            {{-- Invoice Summary --}}
            @if ($invoice)

                <div class="ml-auto mt-5 max-w-sm space-y-2">

                    <div class="flex justify-between text-sm text-slate-600">
                        <span>Taxable Amount</span>

                        <span>
                            ₹{{ number_format($invoice['subtotal'], 2) }}
                        </span>
                    </div>

                    @if ($invoice['tax_type'] === 'SGST/UGST')

                        <div class="flex justify-between text-sm text-slate-600">
                            <span>
                                CGST @ {{ number_format($invoice['tax_rate'] / 2, 2) }}%
                            </span>

                            <span>
                                ₹{{ number_format($invoice['tax'] / 2, 2) }}
                            </span>
                        </div>

                        <div class="flex justify-between text-sm text-slate-600">
                            <span>
                                SGST/UGST @ {{ number_format($invoice['tax_rate'] / 2, 2) }}%
                            </span>

                            <span>
                                ₹{{ number_format($invoice['tax'] / 2, 2) }}
                            </span>
                        </div>

                    @else

                        <div class="flex justify-between text-sm text-slate-600">
                            <span>
                                IGST @ {{ number_format($invoice['tax_rate'], 2) }}%
                            </span>

                            <span>
                                ₹{{ number_format($invoice['tax'], 2) }}
                            </span>
                        </div>

                    @endif

                    <div class="flex justify-between border-t border-slate-200 pt-3 text-base font-bold text-slate-900">

                        <span>
                            Grand Total
                        </span>

                        <span class="text-hitek-red">
                            ₹{{ number_format($invoice['total'], 2) }}
                        </span>

                    </div>

                </div>

            @endif

        </div>

    </div>


    {{-- Payment Summary --}}
    <div class="rounded-xl border border-slate-200 bg-white">

        <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="font-semibold text-slate-900">
                    Payment Summary
                </h2>

                @if ($invoice)
                    <p class="mt-1 text-xs text-slate-500">
                        Payment status for {{ $invoice['number'] }}
                    </p>
                @else
                    <p class="mt-1 text-xs text-slate-500">
                        No invoice created yet
                    </p>
                @endif
            </div>

            @if ($invoice)
                <button
                    type="button"
                    class="rounded-lg bg-hitek-red px-4 py-2 text-sm font-semibold text-white hover:bg-hitek-red-hover"
                >
                    Record Payment
                </button>
            @endif

        </div>


        @if ($invoice)

            <div class="grid grid-cols-1 divide-y divide-slate-100 sm:grid-cols-3 sm:divide-x sm:divide-y-0">

                {{-- Invoice Amount --}}
                <div class="p-5">
                    <p class="text-sm text-slate-500">
                        Invoice Amount
                    </p>

                    <p class="mt-2 text-xl font-bold text-slate-900">
                        ₹{{ number_format($invoice['total']) }}
                    </p>
                </div>


                {{-- Amount Paid --}}
                <div class="p-5">
                    <p class="text-sm text-slate-500">
                        Amount Paid
                    </p>

                    <p class="mt-2 text-xl font-bold text-green-600">
                        {{ $invoice['paid'] !== null
                            ? '₹' . number_format($invoice['paid'])
                            : 'Not Available' }}
                    </p>
                </div>


                {{-- Balance Due --}}
                <div class="p-5">
                    <p class="text-sm text-slate-500">
                        Balance Due
                    </p>

                    <p class="mt-2 text-xl font-bold text-red-600">
                        {{ $invoice['due'] !== null
                            ? '₹' . number_format($invoice['due'])
                            : 'Not Available' }}
                    </p>
                </div>

            </div>

        @else

            {{-- No Invoice --}}
            <div class="flex min-h-40 flex-col items-center justify-center px-5 py-8 text-center">

                <p class="text-sm font-medium text-slate-700">
                    No Payment Information
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Payment details will appear here after an invoice is created.
                </p>

            </div>

        @endif

    </div>

    {{-- Estimate Creation Modal --}}
    @if ($showEstimateModal)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4"
        >
            <div
                class="w-full max-w-4xl overflow-hidden rounded-2xl bg-white shadow-2xl"
            >
                {{-- Modal Header --}}
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">
                            {{ $editingEstimateId ? 'Edit Estimate' : 'Create Estimate' }}
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            {{ $editingEstimateId
                                ? 'Update estimate items and pricing.'
                                : 'Add services, parts and other charges.'
                            }}
                        </p>
                    </div>

                    <button
                        type="button"
                        wire:click="closeEstimateModal"
                        class="flex h-9 w-9 items-center justify-center rounded-lg text-xl text-slate-400 hover:bg-slate-100 hover:text-slate-700"
                    >
                        ×
                    </button>
                </div>

                {{-- Add Item --}}
                <div class="border-b border-slate-200 bg-slate-50 px-6 py-5">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-12">

                        {{-- Type --}}
                        <div class="md:col-span-2">
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                                Type
                            </label>

                            <select
                                wire:model="newEstimateItem.type"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                            >
                                <option value="Service">Service</option>
                                <option value="Part">Part</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        {{-- Description --}}
                        <div class="md:col-span-4">
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                                Description
                            </label>

                            <input
                                type="text"
                                wire:model="newEstimateItem.description"
                                placeholder="e.g. Full Car Service"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                            >

                            @error('newEstimateItem.description')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Quantity --}}
                        <div class="md:col-span-1">
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                                Qty
                            </label>

                            <input
                                type="number"
                                min="1"
                                step="1"
                                wire:model="newEstimateItem.quantity"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                            >
                        </div>

                        {{-- Rate --}}
                        <div class="md:col-span-2">
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                                Rate
                            </label>

                            <input
                                type="number"
                                min="0"
                                step="0.01"
                                wire:model="newEstimateItem.rate"
                                placeholder="0.00"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                            >
                        </div>

                        {{-- Discount --}}
                        <div class="md:col-span-2">
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                                Discount
                            </label>

                            <input
                                type="number"
                                min="0"
                                step="0.01"
                                wire:model="newEstimateItem.discount"
                                placeholder="0.00"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                            >
                        </div>

                        {{-- Add --}}
                        <div class="flex items-end md:col-span-1">
                            <button
                                type="button"
                                wire:click="addEstimateItem"
                                class="w-full rounded-lg bg-hitek-red px-3 py-2.5 text-sm font-semibold text-white hover:bg-hitek-red-hover"
                            >
                                Add
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Items --}}
                <div class="max-h-[380px] overflow-y-auto px-6 py-5">

                    @if (!empty($estimateDraftItems))
                        <div class="overflow-hidden rounded-xl border border-slate-200">
                            <table class="min-w-full text-sm">
                                <thead class="bg-slate-50">
                                    <tr class="border-b border-slate-200">
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                            Type
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                            Description
                                        </th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase text-slate-500">
                                            Qty
                                        </th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-slate-500">
                                            Rate
                                        </th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-slate-500">
                                            Discount
                                        </th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-slate-500">
                                            Amount
                                        </th>
                                        <th class="px-4 py-3"></th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-slate-100">
                                    @foreach (($estimateDraftItems ?? []) as $index => $item)
                                        <tr>
                                            <td class="px-4 py-3">
                                                <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600">
                                                    {{ $item['type'] }}
                                                </span>
                                            </td>

                                            <td class="px-4 py-3 font-medium text-slate-800">
                                                {{ $item['description'] }}
                                            </td>

                                            <td class="px-4 py-3 text-center text-slate-600">
                                                {{ $item['quantity'] }}
                                            </td>

                                            <td class="px-4 py-3 text-right text-slate-600">
                                                ₹{{ number_format((float) $item['rate'], 2) }}
                                            </td>

                                            <td class="px-4 py-3 text-right text-slate-600">
                                                ₹{{ number_format((float) $item['discount'], 2) }}
                                            </td>

                                            <td class="px-4 py-3 text-right font-semibold text-slate-900">
                                                ₹{{ number_format((float) $item['amount'], 2) }}
                                            </td>

                                            <td class="px-4 py-3 text-right">
                                                <button
                                                    type="button"
                                                    wire:click="removeEstimateItem({{ $index }})"
                                                    class="text-xs font-semibold text-red-600 hover:text-red-800"
                                                >
                                                    Remove
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center">
                            <div class="text-3xl text-slate-300">₹</div>

                            <p class="mt-3 font-semibold text-slate-700">
                                No estimate items added
                            </p>

                            <p class="mt-1 text-sm text-slate-500">
                                Add your first service or part above.
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Totals --}}
                <div class="border-t border-slate-200 bg-slate-50 px-6 py-5">
                    <div class="ml-auto max-w-sm space-y-2 text-sm">

                        <div class="flex justify-between text-slate-600">
                            <span>Subtotal</span>
                            <span class="font-medium">
                                ₹{{ number_format($this->estimateSubtotal, 2) }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-4 text-slate-600">
                            <span>GST Type</span>

                            <select
                                wire:model.live="estimateTaxType"
                                class="w-40 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                            >
                                <option value="SGST/UGST">SGST/UGST</option>
                                <option value="IGST">IGST</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-between gap-4 text-slate-600">
                            <span>GST Rate</span>

                            <div class="flex items-center gap-2">
                                <input
                                    type="number"
                                    min="0"
                                    max="100"
                                    step="0.01"
                                    wire:model.live="estimateTaxRate"
                                    class="w-24 rounded-lg border border-slate-300 bg-white px-3 py-2 text-right text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                                >

                                <span>%</span>
                            </div>
                        </div>

                        <div class="flex justify-between text-slate-600">
                            <span>
                                {{ $estimateTaxType }} @ {{ number_format((float) $estimateTaxRate, 2) }}%
                            </span>

                            <span class="font-medium">
                                ₹{{ number_format($this->estimateTaxAmount, 2) }}
                            </span>
                        </div>

                        <div class="flex justify-between border-t border-slate-200 pt-3 text-base font-bold text-slate-900">
                            <span>Grand Total</span>
                            <span class="text-hitek-red">
                                ₹{{ number_format($this->estimateGrandTotal, 2) }}
                            </span>
                        </div>

                    </div>
                </div>

                @error('estimate')
                    <div class="px-6 pb-3 text-sm font-medium text-red-600">
                        {{ $message }}
                    </div>
                @enderror

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-3 border-t border-slate-200 px-6 py-4">
                    <button
                        type="button"
                        wire:click="closeEstimateModal"
                        class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                    >
                        Cancel
                    </button>

                    <button
                        type="button"
                        wire:click="saveEstimate"
                        wire:loading.attr="disabled"
                        class="rounded-lg bg-hitek-red px-5 py-2.5 text-sm font-semibold text-white hover:bg-hitek-red-hover disabled:opacity-50"
                    >
                        <span wire:loading.remove wire:target="saveEstimate">
                            {{ $editingEstimateId ? 'Update Estimate' : 'Save Estimate' }}
                        </span>

                        <span wire:loading wire:target="saveEstimate">
                            {{ $editingEstimateId ? 'Updating...' : 'Saving...' }}
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Final Invoice Modal --}}
    @if ($showInvoiceModal)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4"
        >
            <div class="w-full max-w-6xl overflow-hidden rounded-2xl bg-white shadow-2xl">

                {{-- Header --}}
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">
                            Create Final Invoice
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Review estimate items and prepare the final invoice.
                        </p>
                    </div>

                    <button
                        type="button"
                        wire:click="$set('showInvoiceModal', false)"
                        class="flex h-9 w-9 items-center justify-center rounded-lg text-xl text-slate-400 hover:bg-slate-100 hover:text-slate-700"
                    >
                        ×
                    </button>
                </div>

                {{-- Add Invoice Item --}}
                <div class="mb-5 rounded-xl border border-slate-200 bg-slate-50 p-4">

                    <div class="mb-3">
                        <h3 class="text-sm font-bold text-slate-800">
                            Add Invoice Item
                        </h3>

                        <p class="mt-1 text-xs text-slate-500">
                            Add the actual services, parts or other charges.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-3 md:grid-cols-12">

                        {{-- Type --}}
                        <div class="md:col-span-2">
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                                Type
                            </label>

                            <select
                                wire:model="newInvoiceItem.type"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                            >
                                <option value="Service">Service</option>
                                <option value="Part">Part</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        {{-- Description --}}
                        <div class="md:col-span-3">
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                                Description
                            </label>

                            <input
                                type="text"
                                wire:model="newInvoiceItem.description"
                                placeholder="e.g. Brake Pad Replacement"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                            >

                            @error('newInvoiceItem.description')
                                <p class="mt-1 text-xs text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- HSN/SAC --}}
                        <div class="md:col-span-2">
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                                HSN / SAC
                            </label>

                            <input
                                type="text"
                                wire:model="newInvoiceItem.hsn_sac"
                                placeholder="HSN/SAC"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                            >
                        </div>

                        {{-- Qty --}}
                        <div class="md:col-span-1">
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                                Qty
                            </label>

                            <input
                                type="number"
                                min="1"
                                step="1"
                                wire:model="newInvoiceItem.quantity"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                            >
                        </div>

                        {{-- Rate --}}
                        <div class="md:col-span-2">
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                                Rate
                            </label>

                            <input
                                type="number"
                                min="0"
                                step="0.01"
                                wire:model="newInvoiceItem.rate"
                                placeholder="0.00"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                            >
                        </div>

                        {{-- Discount --}}
                        <div class="md:col-span-1">
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                                Discount
                            </label>

                            <input
                                type="number"
                                min="0"
                                step="0.01"
                                wire:model="newInvoiceItem.discount"
                                placeholder="0"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                            >
                        </div>

                        {{-- Add --}}
                        <div class="flex items-end md:col-span-1">
                            <button
                                type="button"
                                wire:click="addInvoiceItem"
                                class="w-full rounded-lg bg-hitek-red px-3 py-2.5 text-sm font-semibold text-white hover:bg-hitek-red-hover"
                            >
                                Add
                            </button>
                        </div>

                    </div>
                </div>

                {{-- Invoice Items --}}
                <div class="max-h-[420px] overflow-y-auto px-6 py-5">

                    @if (!empty($invoiceDraftItems))

                        <div class="overflow-hidden rounded-xl border border-slate-200">
                            <table class="min-w-full text-sm">

                                <thead class="bg-slate-50">
                                    <tr class="border-b border-slate-200">

                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                            Type
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                            Description
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                            HSN / SAC
                                        </th>

                                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase text-slate-500">
                                            Qty
                                        </th>

                                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-slate-500">
                                            Rate
                                        </th>

                                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-slate-500">
                                            Discount
                                        </th>

                                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-slate-500">
                                            Taxable
                                        </th>

                                        <th class="px-4 py-3"></th>

                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-slate-100">

                                    @foreach ($invoiceDraftItems as $index => $item)

                                        <tr>

                                            <td class="px-4 py-3">
                                                <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600">
                                                    {{ $item['type'] }}
                                                </span>
                                            </td>

                                            <td class="px-4 py-3 font-medium text-slate-800">
                                                {{ $item['description'] }}
                                            </td>

                                            <td class="px-4 py-3">

                                                <input
                                                    type="text"
                                                    wire:model.live="invoiceDraftItems.{{ $index }}.hsn_sac"
                                                    placeholder="HSN/SAC"
                                                    class="w-28 rounded-lg border border-slate-300 px-2.5 py-2 text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                                                >

                                            </td>

                                            <td class="px-4 py-3 text-center text-slate-600">
                                                <input
                                                    type="number"
                                                    min="1"
                                                    step="1"
                                                    wire:model.live="invoiceDraftItems.{{ $index }}.quantity"
                                                    wire:change="updateInvoiceItem({{ $index }})"
                                                    class="w-20 rounded-lg border border-slate-300 px-2 py-2 text-center text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                                                >
                                            </td>

                                            <td class="px-4 py-3 text-right text-slate-600">
                                                <input
                                                    type="number"
                                                    min="0"
                                                    step="0.01"
                                                    wire:model.live="invoiceDraftItems.{{ $index }}.rate"
                                                    wire:change="updateInvoiceItem({{ $index }})"
                                                    class="w-28 rounded-lg border border-slate-300 px-2 py-2 text-right text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                                                >
                                            </td>

                                            <td class="px-4 py-3 text-right text-slate-600">
                                                <input
                                                    type="number"
                                                    min="0"
                                                    step="0.01"
                                                    wire:model.live="invoiceDraftItems.{{ $index }}.discount"
                                                    wire:change="updateInvoiceItem({{ $index }})"
                                                    class="w-28 rounded-lg border border-slate-300 px-2 py-2 text-right text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                                                >
                                            </td>

                                            <td class="px-4 py-3 text-right font-semibold text-slate-900">
                                                ₹{{ number_format((float) $item['taxable_amount'], 2) }}
                                            </td>

                                            <td class="px-4 py-3 text-right">
                                                <button
                                                    type="button"
                                                    wire:click="removeInvoiceItem({{ $index }})"
                                                    class="text-xs font-semibold text-red-600 hover:text-red-800"
                                                >
                                                    Remove
                                                </button>
                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>
                        </div>

                    @else

                        <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center">

                            <p class="font-semibold text-slate-700">
                                No invoice items
                            </p>

                            <p class="mt-1 text-sm text-slate-500">
                                The invoice will be created from the estimate.
                            </p>

                        </div>

                    @endif

                </div>

                {{-- GST & Totals --}}
                <div class="border-t border-slate-200 bg-slate-50 px-6 py-5">

                    <div class="ml-auto max-w-md space-y-3">

                        {{-- GST Type --}}
                        <div class="flex items-center justify-between gap-4">

                            <span class="text-sm text-slate-600">
                                GST Type
                            </span>

                            <select
                                wire:model.live="invoiceTaxType"
                                wire:change="recalculateInvoiceItems"
                                class="w-40 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                            >
                                <option value="SGST/UGST">
                                    SGST/UGST
                                </option>

                                <option value="IGST">
                                    IGST
                                </option>
                            </select>

                        </div>

                        {{-- GST Rate --}}
                        <div class="flex items-center justify-between gap-4">

                            <span class="text-sm text-slate-600">
                                GST Rate
                            </span>

                            <div class="flex items-center gap-2">

                                <input
                                    type="number"
                                    min="0"
                                    max="100"
                                    step="0.01"
                                    wire:model.live="invoiceTaxRate"
                                    wire:change="recalculateInvoiceItems"
                                    class="w-24 rounded-lg border border-slate-300 bg-white px-3 py-2 text-right text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                                >

                                <span class="text-sm text-slate-500">
                                    %
                                </span>

                            </div>

                        </div>

                        {{-- Subtotal --}}
                        <div class="flex justify-between text-sm text-slate-600">
                            <span>
                                Taxable Amount
                            </span>

                            <span class="font-medium text-slate-800">
                                ₹{{ number_format($this->invoiceSubtotal, 2) }}
                            </span>
                        </div>

                        @if ($invoiceTaxType === 'SGST/UGST')

                            {{-- CGST --}}
                            <div class="flex justify-between text-sm text-slate-600">
                                <span>
                                    CGST @ {{ number_format($this->invoiceCgstRate, 2) }}%
                                </span>

                                <span class="font-medium text-slate-800">
                                    ₹{{ number_format($this->invoiceCgstAmount, 2) }}
                                </span>
                            </div>

                            {{-- SGST / UGST --}}
                            <div class="flex justify-between text-sm text-slate-600">
                                <span>
                                    SGST/UGST @ {{ number_format($this->invoiceSgstRate, 2) }}%
                                </span>

                                <span class="font-medium text-slate-800">
                                    ₹{{ number_format($this->invoiceSgstAmount, 2) }}
                                </span>
                            </div>

                        @else

                            {{-- IGST --}}
                            <div class="flex justify-between text-sm text-slate-600">
                                <span>
                                    IGST @ {{ number_format((float) $invoiceTaxRate, 2) }}%
                                </span>

                                <span class="font-medium text-slate-800">
                                    ₹{{ number_format($this->invoiceTaxAmount, 2) }}
                                </span>
                            </div>

                        @endif

                        {{-- Total Tax --}}
                        <div class="flex justify-between text-sm font-medium text-slate-700">
                            <span>
                                Total Tax
                            </span>

                            <span>
                                ₹{{ number_format($this->invoiceTaxAmount, 2) }}
                            </span>
                        </div>

                        {{-- Grand Total --}}
                        <div class="flex justify-between border-t border-slate-200 pt-3 text-base font-bold text-slate-900">
                            <span>
                                Grand Total
                            </span>

                            <span class="text-hitek-red">
                                ₹{{ number_format($this->invoiceGrandTotal, 2) }}
                            </span>
                        </div>

                    </div>

                </div>

                @error('invoice')
                    <div class="px-6 pb-3 text-sm font-medium text-red-600">
                        {{ $message }}
                    </div>
                @enderror

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-3 border-t border-slate-200 px-6 py-4">

                    <button
                        type="button"
                        wire:click="$set('showInvoiceModal', false)"
                        class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                    >
                        Cancel
                    </button>

                    <button
                        type="button"
                        wire:click="createInvoice"
                        wire:loading.attr="disabled"
                        class="rounded-lg bg-hitek-red px-5 py-2.5 text-sm font-semibold text-white hover:bg-hitek-red-hover disabled:opacity-50"
                    >
                        <span wire:loading.remove wire:target="createInvoice">
                            Create Invoice
                        </span>

                        <span wire:loading wire:target="createInvoice">
                            Creating...
                        </span>
                    </button>

                </div>

            </div>
        </div>
    @endif

</div>
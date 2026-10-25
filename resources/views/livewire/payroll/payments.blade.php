
<div class="space-y-6">
    <div>
        <a href="{{ route('payroll.index') }}"
           class="text-sm font-medium text-hitek-red hover:text-hitek-red-hover">
            ← Back to Payroll
        </a>

        <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">
            Payroll Payments
        </h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Record advances, instalments, and final salary settlements.
        </p>
    </div>

    @if (session()->has('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-900 dark:bg-green-950 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-700 dark:bg-slate-900">
            <p class="text-sm text-slate-500 dark:text-slate-400">Employee</p>
            <p class="mt-1 font-semibold text-slate-900 dark:text-white">
                {{ $payroll->employee?->user?->name ?? 'Employee #'.$payroll->employee_id }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-700 dark:bg-slate-900">
            <p class="text-sm text-slate-500 dark:text-slate-400">Approved Net Salary</p>
            <p class="mt-1 text-xl font-bold text-slate-900 dark:text-white">
                ₹{{ number_format((float) $payroll->net_salary, 2) }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-700 dark:bg-slate-900">
            <p class="text-sm text-slate-500 dark:text-slate-400">Total Paid</p>
            <p class="mt-1 text-xl font-bold text-green-600">
                ₹{{ number_format($totalPaid, 2) }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-700 dark:bg-slate-900">
            <p class="text-sm text-slate-500 dark:text-slate-400">Remaining Balance</p>
            <p class="mt-1 text-xl font-bold text-hitek-red">
                ₹{{ number_format($remainingBalance, 2) }}
            </p>
        </div>
    </div>

    @if ($payroll->status !== 'approved')
        <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800 dark:border-amber-900 dark:bg-amber-950 dark:text-amber-300">
            This payroll is not approved. Payments cannot be recorded until approval.
        </div>
    @elseif ($remainingBalance > 0)
        <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                Record Payment
            </h2>

            <form wire:submit="recordPayment" class="mt-4 space-y-4">
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Amount (₹)
                        </label>
                        <input
                            type="number"
                            min="0.01"
                            max="{{ $remainingBalance }}"
                            step="0.01"
                            wire:model="amount"
                            class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-hitek-red focus:ring-hitek-red dark:border-slate-600 dark:bg-slate-800 dark:text-white"
                            placeholder="Enter payment amount"
                        >
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Payment Date
                        </label>
                        <input
                            type="date"
                            wire:model="payment_date"
                            max="{{ today()->toDateString() }}"
                            class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-hitek-red focus:ring-hitek-red dark:border-slate-600 dark:bg-slate-800 dark:text-white"
                        >
                        @error('payment_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Payment Type
                        </label>
                        <select
                            wire:model="payment_type"
                            class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-hitek-red focus:ring-hitek-red dark:border-slate-600 dark:bg-slate-800 dark:text-white"
                        >
                            <option value="advance">Advance</option>
                            <option value="installment">Instalment</option>
                            <option value="final_settlement">Final settlement</option>
                        </select>
                        @error('payment_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Payment Method
                        </label>
                        <select
                            wire:model="payment_method"
                            class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-hitek-red focus:ring-hitek-red dark:border-slate-600 dark:bg-slate-800 dark:text-white"
                        >
                            <option value="bank_transfer">Bank transfer</option>
                            <option value="upi">UPI</option>
                            <option value="cash">Cash</option>
                            <option value="cheque">Cheque</option>
                            <option value="other">Other</option>
                        </select>
                        @error('payment_method')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Transaction Reference
                        </label>
                        <input
                            type="text"
                            wire:model="payment_reference"
                            maxlength="255"
                            class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-hitek-red focus:ring-hitek-red dark:border-slate-600 dark:bg-slate-800 dark:text-white"
                            placeholder="UPI ID, transaction ID, etc."
                        >
                        @error('payment_reference')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Notes
                        </label>
                        <input
                            type="text"
                            wire:model="notes"
                            maxlength="2000"
                            class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-hitek-red focus:ring-hitek-red dark:border-slate-600 dark:bg-slate-800 dark:text-white"
                            placeholder="Optional notes"
                        >
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center rounded-lg bg-hitek-red px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-hitek-red-hover disabled:opacity-50"
                    >
                        <span wire:loading.remove wire:target="recordPayment">
                            Record Payment
                        </span>
                        <span wire:loading wire:target="recordPayment">
                            Recording...
                        </span>
                    </button>
                </div>
            </form>
        </section>
    @else
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-900 dark:bg-green-950 dark:text-green-300">
            This payroll has been fully paid.
        </div>
    @endif

    <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
        <div class="border-b border-slate-200 px-5 py-4 dark:border-slate-700">
            <h2 class="font-semibold text-slate-900 dark:text-white">
                Payment History
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Method</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Reference</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Recorded By</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-slate-500">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse ($payroll->payments->sortByDesc('payment_date') as $payment)
                        <tr>
                            <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-700 dark:text-slate-300">
                                {{ $payment->payment_date->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700 dark:text-slate-300">
                                {{ ucwords(str_replace('_', ' ', $payment->payment_type)) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700 dark:text-slate-300">
                                {{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700 dark:text-slate-300">
                                {{ $payment->payment_reference ?: '—' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700 dark:text-slate-300">
                                {{ $payment->recordedBy?->name ?? '—' }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-right text-sm font-semibold text-slate-900 dark:text-white">
                                ₹{{ number_format((float) $payment->amount, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-sm text-slate-500 dark:text-slate-400">
                                No payments recorded for this payroll yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>

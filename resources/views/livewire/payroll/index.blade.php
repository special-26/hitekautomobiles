
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">
            Monthly Payroll
        </h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Calculate and review employee salaries before approval.
        </p>
    </div>

    @if (session()->has('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-900 dark:bg-green-950 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('payroll_issues') && count(session('payroll_issues')))
        <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 dark:border-amber-900 dark:bg-amber-950">
            <h3 class="font-semibold text-amber-900 dark:text-amber-200">
                Employees requiring attention
            </h3>
            <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-amber-800 dark:text-amber-300">
                @foreach (session('payroll_issues') as $issue)
                    <li>{{ $issue }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
        <form wire:submit="calculatePayroll" class="flex flex-col gap-4 sm:flex-row sm:items-end">
            <div class="w-full sm:max-w-xs">
                <label for="payroll-month" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                    Payroll month
                </label>
                <input
                    id="payroll-month"
                    type="month"
                    wire:model="month"
                    class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-hitek-red focus:ring-hitek-red dark:border-slate-600 dark:bg-slate-800 dark:text-white"
                >
                @error('month')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="calculatePayroll"
                class="inline-flex items-center justify-center rounded-lg bg-hitek-red px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-hitek-red-hover disabled:opacity-50"
            >
                <span wire:loading.remove wire:target="calculatePayroll">
                    Calculate Payroll
                </span>
                <span wire:loading wire:target="calculatePayroll">
                    Calculating...
                </span>
            </button>
        </form>

        <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">
            Calculation creates or updates draft payroll records. Approved or otherwise non-draft records are skipped.
        </p>
    </section>

    <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
        <div class="flex flex-col gap-1 border-b border-slate-200 px-5 py-4 dark:border-slate-700 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-slate-900 dark:text-white">
                Payroll Records
            </h2>
            <span class="text-sm text-slate-500 dark:text-slate-400">
                {{ \Carbon\Carbon::createFromFormat('!Y-m', $month)->format('F Y') }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Employee</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Working Days</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Present</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Absent</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Half Days</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Gross Salary</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Deductions</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Net Salary</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse ($payrolls as $payroll)
                        <tr wire:key="payroll-{{ $payroll->id }}" class="hover:bg-slate-50 dark:hover:bg-slate-800/60">
                            <td class="whitespace-nowrap px-4 py-3">
                                <div class="font-medium text-slate-900 dark:text-white">
                                    {{ $payroll->employee?->user?->name ?? 'Employee #'.$payroll->employee_id }}
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                    ID: {{ $payroll->employee_id }}
                                </div>
                            </td>

                            <td class="px-4 py-3 text-right text-sm text-slate-700 dark:text-slate-300">
                                {{ $payroll->working_days }}
                            </td>
                            <td class="px-4 py-3 text-right text-sm text-slate-700 dark:text-slate-300">
                                {{ number_format((float) $payroll->present_days, 1) }}
                            </td>
                            <td class="px-4 py-3 text-right text-sm text-slate-700 dark:text-slate-300">
                                {{ number_format((float) $payroll->absent_days, 1) }}
                            </td>
                            <td class="px-4 py-3 text-right text-sm text-slate-700 dark:text-slate-300">
                                {{ number_format((float) $payroll->half_days, 1) }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-right text-sm text-slate-700 dark:text-slate-300">
                                ₹{{ number_format((float) $payroll->gross_salary, 2) }}
                            </td>
                            
                            <td class="whitespace-nowrap px-4 py-3 text-right text-sm text-red-600 dark:text-red-400">
                                <div class="font-semibold">
                                    ₹{{ number_format((float) $payroll->total_deductions, 2) }}
                                </div>

                                @if ((float) $payroll->unpaid_holiday_deduction > 0)
                                    <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                        Unpaid holidays: ₹{{ number_format((float) $payroll->unpaid_holiday_deduction, 2) }}
                                    </div>
                                @endif
                            </td>

                            <td class="whitespace-nowrap px-4 py-3 text-right text-sm font-semibold text-slate-900 dark:text-white">
                                ₹{{ number_format((float) $payroll->net_salary, 2) }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium
                                    {{ $payroll->status === 'approved'
                                        ? 'bg-green-100 text-green-800 dark:bg-green-950 dark:text-green-300'
                                        : 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300' }}">
                                    {{ ucfirst(str_replace('_', ' ', $payroll->status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if ($payroll->status === 'draft' && auth()->user()->can('payroll.approve'))
                                    <button
                                        type="button"
                                        wire:click="approvePayroll({{ $payroll->id }})"
                                        wire:confirm="Are you sure you want to approve this payroll? Approved payroll cannot be recalculated."
                                        wire:loading.attr="disabled"
                                        wire:target="approvePayroll({{ $payroll->id }})"
                                        class="inline-flex items-center rounded-lg bg-green-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-green-700 disabled:opacity-50"
                                    >
                                        <span wire:loading.remove wire:target="approvePayroll({{ $payroll->id }})">
                                            Approve
                                        </span>
                                        <span wire:loading wire:target="approvePayroll({{ $payroll->id }})">
                                            Approving...
                                        </span>
                                    </button>
                                @else
                                    <span class="text-xs text-slate-400">
                                        —
                                    </span>
                                @endif

                                {{-- if approved --}}
                                @if ($payroll->status === 'approved' && auth()->user()->can('payroll.payment.manage'))
                                    <a
                                        href="{{ route('payroll.payments', $payroll) }}"
                                        class="inline-flex items-center rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-800"
                                    >
                                        Payments
                                    </a>
                                @endif

                                @if ($payroll->status === 'approved' && auth()->user()->can('payroll.view'))
                                    <button
                                        type="button"
                                        wire:click="downloadPayslip({{ $payroll->id }})"
                                        wire:loading.attr="disabled"
                                        wire:target="downloadPayslip({{ $payroll->id }})"
                                        class="mt-1 inline-flex items-center rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 disabled:opacity-50 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-800"
                                    >
                                        Download Payslip
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-4 py-12 text-center">
                                <p class="font-medium text-slate-700 dark:text-slate-200">
                                    No payroll records for this month
                                </p>
                                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                    Select a completed month and click Calculate Payroll to create draft records.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                @if ($payrolls->isNotEmpty())
                    <tfoot class="bg-slate-50 dark:bg-slate-800">
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-right text-sm font-semibold text-slate-700 dark:text-slate-200">
                                Total
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-right text-sm font-semibold text-slate-900 dark:text-white">
                                ₹{{ number_format($payrolls->sum(fn ($row) => (float) $row->gross_salary), 2) }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-right text-sm font-semibold text-red-600 dark:text-red-400">
                                ₹{{ number_format($payrolls->sum(fn ($row) => (float) $row->total_deductions), 2) }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-right text-sm font-bold text-slate-900 dark:text-white">
                                ₹{{ number_format($payrolls->sum(fn ($row) => (float) $row->net_salary), 2) }}
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </section>
</div>

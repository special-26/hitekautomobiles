<?php

namespace App\Livewire\Payroll;

use App\Models\Payroll;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Payments extends Component
{
    public int $payrollId;

    public string $amount = '';

    public string $payment_date = '';

    public string $payment_type = 'installment';

    public string $payment_method = 'bank_transfer';

    public string $payment_reference = '';

    public string $notes = '';

    public function mount(Payroll $payroll): void
    {
        Gate::authorize('payroll.payment.manage');

        $this->payrollId = $payroll->id;
        $this->payment_date = today()->toDateString();
    }

    public function recordPayment(): void
    {
        Gate::authorize('payroll.payment.manage');

        $validated = $this->validate([
            'amount' => ['required', 'numeric', 'gt:0', 'decimal:0,2'],
            'payment_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
            'payment_type' => [
                'required',
                Rule::in([
                    'advance',
                    'installment',
                    'final_settlement',
                ]),
            ],
            'payment_method' => [
                'required',
                Rule::in([
                    'cash',
                    'bank_transfer',
                    'upi',
                    'cheque',
                    'other',
                ]),
            ],
            'payment_reference' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($validated) {
            // Lock the payroll row so concurrent payments cannot
            // both spend the same outstanding balance.
            $payroll = Payroll::query()
                ->lockForUpdate()
                ->findOrFail($this->payrollId);

            if ($payroll->status !== 'approved') {
                throw ValidationException::withMessages([
                    'amount' => 'Payments can only be recorded for approved payroll.',
                ]);
            }

            $alreadyPaid = (float) $payroll->payments()->sum('amount');
            $netSalary = (float) $payroll->net_salary;
            $remaining = round($netSalary - $alreadyPaid, 2);
            $amount = round((float) $validated['amount'], 2);

            if ($remaining <= 0) {
                throw ValidationException::withMessages([
                    'amount' => 'This payroll has already been fully paid.',
                ]);
            }

            if ($amount > $remaining) {
                throw ValidationException::withMessages([
                    'amount' => 'Payment exceeds the outstanding balance of ₹'
                        . number_format($remaining, 2) . '.',
                ]);
            }

            $payroll->payments()->create([
                'amount' => $amount,
                'payment_date' => $validated['payment_date'],
                'payment_type' => $validated['payment_type'],
                'payment_method' => $validated['payment_method'],
                'payment_reference' => $validated['payment_reference'] ?: null,
                'notes' => $validated['notes'] ?: null,
                'recorded_by' => auth()->id(),
            ]);

            $totalPaid = (float) $payroll->payments()->sum('amount');

            $paymentStatus = match (true) {
                $totalPaid >= $netSalary => 'paid',
                $totalPaid > 0 => 'partially_paid',
                default => 'unpaid',
            };

            $payroll->update([
                'payment_status' => $paymentStatus,
                'paid_at' => $paymentStatus === 'paid' ? now() : null,
            ]);
        });

        $this->reset([
            'amount',
            'payment_reference',
            'notes',
        ]);

        $this->payment_type = 'installment';
        $this->payment_method = 'bank_transfer';
        $this->payment_date = today()->toDateString();

        session()->flash('success', 'Payment recorded successfully.');
    }

    public function render()
    {
        $payroll = Payroll::query()
            ->with(['employee.user', 'payments.recordedBy'])
            ->findOrFail($this->payrollId);

        return view('livewire.payroll.payments', [
            'payroll' => $payroll,
            'totalPaid' => (float) $payroll->payments->sum('amount'),
            'remainingBalance' => max(
                0,
                round(
                    (float) $payroll->net_salary
                        - (float) $payroll->payments->sum('amount'),
                    2
                )
            ),
        ])->layout('components.layouts.management');
    }
}

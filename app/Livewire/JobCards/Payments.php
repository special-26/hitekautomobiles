<?php

namespace App\Livewire\JobCards;

use App\Models\JobCard;
use Livewire\Component;

class Payments extends Component
{
    public $jobCard;

    public $summary;

    public $payments = [];

    public function mount($jobCard)
    {
        $this->loadJobCard($jobCard);
    }

    protected function loadJobCard($jobCardId): void
    {
        $jobCard = JobCard::query()
            ->with([
                'customer',
                'vehicle',
                'invoices.items',
                'invoices.payments.receivedBy',
            ])
            ->findOrFail($jobCardId);

        $this->jobCard = [
            'id' => $jobCard->id,
            'job_card_number' => $jobCard->job_card_number,
            'vehicle_no' => $jobCard->vehicle->registration_number,
            'vehicle' => trim(
                $jobCard->vehicle->make . ' ' . $jobCard->vehicle->model
            ),
            'customer' => $jobCard->customer->name,
        ];

        $invoice = $jobCard->invoices
            ->sortByDesc('id')
            ->first();

        if (! $invoice) {
            $this->summary = null;
            $this->payments = [];

            return;
        }

        $successfulPayments = $invoice->payments
            ->where('status', 'success');

        $totalPaid = $successfulPayments->sum('amount');

        $invoiceTotal = (float) $invoice->total;

        $balanceDue = max(
            0,
            $invoiceTotal - (float) $totalPaid
        );

        $paymentStatus = match (true) {
            $totalPaid <= 0 => 'Unpaid',
            $balanceDue <= 0 => 'Paid',
            default => 'Partially Paid',
        };

        $this->summary = [
            'invoice_id' => $invoice->id,
            'invoice_number' => $invoice->invoice_number,
            'invoice_total' => $invoiceTotal,
            'total_paid' => (float) $totalPaid,
            'balance_due' => $balanceDue,
            'payment_status' => $paymentStatus,
        ];

        $this->payments = $invoice->payments
            ->sortByDesc('payment_date')
            ->map(function ($payment) {
                return [
                    'id' => $payment->id,
                    'receipt_number' => $payment->receipt_number,
                    'date' => $payment->payment_date?->format('d M Y'),
                    'time' => $payment->payment_date?->format('h:i A'),
                    'amount' => (float) $payment->amount,
                    'method' => strtoupper(str_replace('_', ' ', $payment->payment_method)),
                    'reference' => $payment->reference,
                    'received_by' => $payment->receivedBy?->name ?? 'Not Available',
                    'status' => ucfirst($payment->status),
                    'notes' => $payment->notes,
                ];
            })
            ->values()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.job-cards.payments')
            ->layout('components.layouts.management', [
                'title' => 'Job Card #' . $this->jobCard['job_card_number'] . ' - Payments',
            ]);
    }
}

<?php

namespace App\Livewire\JobCards;

use Livewire\Component;

class Payments extends Component
{
    public $jobCard;

    public $summary;

    public $payments = [];

    public function mount($jobCard)
    {
        $this->jobCard = [
            'id' => $jobCard,
            'vehicle_no' => 'CH01BT9020',
            'vehicle' => 'Hyundai Creta 1.6',
            'customer' => 'Mrs. Indu Narula',
        ];

        $this->summary = [
            'invoice_number' => 'INV-13887',
            'invoice_total' => 46846,
            'total_paid' => 35000,
            'balance_due' => 11846,
            'payment_status' => 'Partially Paid',
        ];

        $this->payments = [
            [
                'id' => 1,
                'receipt_number' => 'REC-13887-01',
                'date' => '23 Sep 2026',
                'time' => '12:45 PM',
                'amount' => 15000,
                'method' => 'UPI',
                'reference' => 'UPI9827346512',
                'received_by' => 'Basant Joshi',
                'status' => 'Success',
                'notes' => 'Advance payment',
            ],
            [
                'id' => 2,
                'receipt_number' => 'REC-13887-02',
                'date' => '25 Sep 2026',
                'time' => '03:20 PM',
                'amount' => 10000,
                'method' => 'Cash',
                'reference' => null,
                'received_by' => 'Basant Joshi',
                'status' => 'Success',
                'notes' => 'Customer payment',
            ],
            [
                'id' => 3,
                'receipt_number' => 'REC-13887-03',
                'date' => '26 Sep 2026',
                'time' => '04:35 PM',
                'amount' => 10000,
                'method' => 'Card',
                'reference' => 'CARD-782451',
                'received_by' => 'Basant Joshi',
                'status' => 'Success',
                'notes' => 'Final payment',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.job-cards.payments')
            ->layout('components.layouts.management', [
                'title' => 'Job Card #' . $this->jobCard['id'] . ' - Payments',
            ]);
    }
}

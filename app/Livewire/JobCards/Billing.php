<?php

namespace App\Livewire\JobCards;

use App\Models\JobCard;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Billing extends Component
{
    use Interactions;

    public $jobCard;
    public $estimate;
    public $invoice;

    public $estimateTaxType = 'SGST/UGST';
    public $estimateTaxRate = 18;

    public $estimateItems = [];
    public $invoiceItems = [];

    public $showEstimateModal = false;
    public $newEstimateItem = [
        'type' => 'Service',
        'description' => '',
        'quantity' => 1,
        'rate' => 0,
        'discount' => 0,
    ];
    public $estimateDraftItems = [];
    public $editingEstimateId = null;

    // Final Invoice
    public $newInvoiceItem = [
        'type' => 'Service',
        'description' => '',
        'hsn_sac' => '',
        'quantity' => 1,
        'rate' => 0,
        'discount' => 0,
    ];
    public $showInvoiceModal = false;
    public $invoiceDraftItems = [];
    public $invoiceTaxType = 'SGST/UGST';
    public $invoiceTaxRate = 18;
    public $invoiceCustomerContribution = 0;

    public function getEstimateTaxAmountProperty(): float
    {
        $subtotal = $this->estimateSubtotal;

        $rate = (float) $this->estimateTaxRate;

        if ($rate <= 0) {
            return 0;
        }

        return round($subtotal * $rate / 100, 2);
    }
    public function getEstimateGrandTotalProperty(): float
    {
        return round(
            $this->estimateSubtotal + $this->estimateTaxAmount,
            2
        );
    }

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
                'estimates.items',
                'invoices.items',
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

        $this->loadEstimate($jobCard);
        $this->loadInvoice($jobCard);
    }

    protected function loadEstimate(JobCard $jobCard): void
    {
        $estimate = $jobCard->estimates
            ->sortByDesc('id')
            ->first();

        if (! $estimate) {
            $this->estimate = null;
            $this->estimateItems = [];

            return;
        }

        $this->estimate = [
            'id' => $estimate->id,
            'number' => $estimate->estimate_number,
            'date' => $estimate->created_at?->format('d M Y'),
            'status' => $estimate->status,
            'subtotal' => $estimate->subtotal,
            'discount' => $estimate->discount,
            'tax' => $estimate->tax,
            'tax_type' => $estimate->tax_type,
            'tax_rate' => $estimate->tax_rate,
            'total' => $estimate->total,
        ];

        $this->estimateItems = $estimate->items
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'type' => $item->item_type,
                    'description' => $item->description,
                    'quantity' => $item->quantity,
                    'rate' => $item->unit_price,
                    'discount' => $item->discount,
                    'amount' => $item->total,
                ];
            })
            ->toArray();
    }

    protected function loadInvoice(JobCard $jobCard): void
    {
        $invoice = $jobCard->invoices
            ->sortByDesc('id')
            ->first();

        if (! $invoice) {
            $this->invoice = null;
            $this->invoiceItems = [];
            return;
        }

        $this->invoice = [
            'id' => $invoice->id,
            'number' => $invoice->invoice_number,
            'date' => $invoice->created_at?->format('d M Y'),
            'status' => $invoice->status,

            'subtotal' => (float) $invoice->subtotal,
            'discount' => (float) $invoice->discount,
            'tax' => (float) $invoice->tax,
            'tax_type' => $invoice->tax_type,
            'tax_rate' => (float) $invoice->tax_rate,
            'total' => (float) $invoice->total,

            'paid' => null,
            'due' => null,
        ];

        $this->invoiceItems = $invoice->items
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'type' => $item->item_type,
                    'description' => $item->description,
                    'hsn_sac' => $item->hsn_sac,

                    'quantity' => (float) $item->quantity,
                    'rate' => (float) $item->unit_price,
                    'discount' => (float) $item->discount,

                    'taxable_amount' => (float) $item->taxable_amount,

                    'cgst_rate' => (float) $item->cgst_rate,
                    'cgst_amount' => (float) $item->cgst_amount,

                    'sgst_rate' => (float) $item->sgst_rate,
                    'sgst_amount' => (float) $item->sgst_amount,

                    'igst_rate' => (float) $item->igst_rate,
                    'igst_amount' => (float) $item->igst_amount,

                    'amount' => (float) $item->total,
                ];
            })
            ->values()
            ->toArray();
    }

    // Estimate Billing Modal Functions
    public function openEstimateModal(): void
    {
        $this->editingEstimateId = null;

        $this->estimateTaxType = 'SGST/UGST';
        $this->estimateTaxRate = 18;

        $this->resetEstimateItem();
        $this->estimateDraftItems = [];
        $this->showEstimateModal = true;
    }
    public function closeEstimateModal(): void
    {
        $this->showEstimateModal = false;
    }

    public function addEstimateItem(): void
    {
        $quantity = (float) $this->newEstimateItem['quantity'];
        $rate = (float) $this->newEstimateItem['rate'];
        $discount = (float) $this->newEstimateItem['discount'];

        $gross = $quantity * $rate;
        $amount = max(0, $gross - $discount);

        if (empty(trim($this->newEstimateItem['description']))) {
            $this->addError('newEstimateItem.description', 'Description is required.');
            return;
        }

        if ($quantity <= 0) {
            $this->addError('newEstimateItem.quantity', 'Quantity must be greater than 0.');
            return;
        }

        if ($rate < 0 || $discount < 0) {
            return;
        }

        $this->estimateDraftItems[] = [
            'id' => null,
            'type' => $this->newEstimateItem['type'],
            'description' => trim($this->newEstimateItem['description']),
            'quantity' => $quantity,
            'rate' => $rate,
            'discount' => $discount,
            'amount' => $amount,
        ];

        $this->resetEstimateItem();
    }

    public function removeEstimateItem(int $index): void
    {
        unset($this->estimateDraftItems[$index]);

        $this->estimateDraftItems = array_values($this->estimateDraftItems);
    }

    protected function resetEstimateItem(): void
    {
        $this->newEstimateItem = [
            'type' => 'Service',
            'description' => '',
            'quantity' => 1,
            'rate' => 0,
            'discount' => 0,
        ];

        $this->resetValidation();
    }

    public function getEstimateSubtotalProperty(): float
    {
        return collect($this->estimateDraftItems ?? [])
            ->sum(fn($item) => (float) ($item['amount'] ?? 0));
    }

    public function saveEstimate(): void
    {
        if (empty($this->estimateDraftItems)) {
            $this->addError('estimate', 'Please add at least one estimate item.');
            return;
        }

        $subtotal = collect($this->estimateDraftItems)
            ->sum(fn($item) => (float) ($item['amount'] ?? 0));

        $discount = collect($this->estimateDraftItems)
            ->sum(fn($item) => (float) ($item['discount'] ?? 0));

        $tax = $this->estimateTaxAmount;
        $total = $this->estimateGrandTotal;

        /*
        |--------------------------------------------------------------------------
        | Update Existing Estimate
        |--------------------------------------------------------------------------
        */

        if ($this->editingEstimateId) {
            $estimate = \App\Models\JobCardEstimate::query()
                ->findOrFail($this->editingEstimateId);

            $estimate->update([
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'total' => $total,
                'tax_type' => $this->estimateTaxType,
                'tax_rate' => $this->estimateTaxRate,
            ]);

            // Replace existing items with current draft.
            $estimate->items()->delete();

            foreach ($this->estimateDraftItems as $item) {
                $estimate->items()->create([
                    'item_type' => $item['type'],
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['rate'],
                    'discount' => $item['discount'],
                    'total' => $item['amount'],
                ]);
            }

            $this->toast()
                ->position('top-center')
                ->success('Estimate Bill', 'Estimate updated successfully.')
                ->send();
        }

        /*
        |--------------------------------------------------------------------------
        | Create New Estimate
        |--------------------------------------------------------------------------
        */ else {
            $jobCard = JobCard::findOrFail($this->jobCard['id']);

            $estimate = $jobCard->estimates()->create([
                'estimate_number' => 'EST-' . now()->format('YmdHis'),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'tax_type' => $this->estimateTaxType,
                'tax_rate' => $this->estimateTaxRate,
                'total' => $total,
                'status' => 'draft',
                'created_by' => auth()->id(),
            ]);

            foreach ($this->estimateDraftItems as $item) {
                $estimate->items()->create([
                    'item_type' => $item['type'],
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['rate'],
                    'discount' => $item['discount'],
                    'total' => $item['amount'],
                ]);
            }

            $this->toast()
                ->position('top-center')
                ->success('Estimate Bill', 'Estimate created successfully.')
                ->send();
        }

        /*
        |--------------------------------------------------------------------------
        | Refresh Billing Data
        |--------------------------------------------------------------------------
        */

        $this->showEstimateModal = false;
        $this->editingEstimateId = null;

        $this->loadJobCard($this->jobCard['id']);
    }

    public function editEstimate(): void
    {
        if (! $this->estimate) {
            return;
        }

        $estimate = \App\Models\JobCardEstimate::query()
            ->with('items')
            ->findOrFail($this->estimate['id']);

        $this->editingEstimateId = $estimate->id;
        $this->estimateTaxType = $estimate->tax_type ?? 'SGST/UGST';
        $this->estimateTaxRate = (float) ($estimate->tax_rate ?? 0);

        $this->estimateDraftItems = $estimate->items
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'type' => $item->item_type,
                    'description' => $item->description,
                    'quantity' => (float) $item->quantity,
                    'rate' => (float) $item->unit_price,
                    'discount' => (float) $item->discount,
                    'amount' => (float) $item->total,
                ];
            })
            ->toArray();

        $this->resetEstimateItem();

        $this->showEstimateModal = true;
    }

    // Final Billing Modal Functions
    public function openInvoiceModal(): void
    {
        $this->invoiceDraftItems = [];

        $this->invoiceTaxType = 'SGST/UGST';
        $this->invoiceTaxRate = 18;

        $this->invoiceCustomerContribution = 0;

        $this->resetInvoiceItem();

        $this->resetValidation();

        $this->showInvoiceModal = true;
    }
    public function getInvoiceTaxableAmountProperty(): float
    {
        return round(
            collect($this->invoiceDraftItems ?? [])
                ->sum(fn($item) => (float) ($item['taxable_amount'] ?? 0)),
            2
        );
    }

    public function getInvoiceTaxAmountProperty(): float
    {
        return round(
            $this->invoiceTaxableAmount * ((float) $this->invoiceTaxRate / 100),
            2
        );
    }

    public function getInvoiceCgstRateProperty(): float
    {
        if ($this->invoiceTaxType !== 'SGST/UGST') {
            return 0;
        }

        return round((float) $this->invoiceTaxRate / 2, 2);
    }

    public function getInvoiceSgstRateProperty(): float
    {
        if ($this->invoiceTaxType !== 'SGST/UGST') {
            return 0;
        }

        return round((float) $this->invoiceTaxRate / 2, 2);
    }

    public function getInvoiceCgstAmountProperty(): float
    {
        if ($this->invoiceTaxType !== 'SGST/UGST') {
            return 0;
        }

        return round($this->invoiceTaxAmount / 2, 2);
    }

    public function getInvoiceSgstAmountProperty(): float
    {
        if ($this->invoiceTaxType !== 'SGST/UGST') {
            return 0;
        }

        return round($this->invoiceTaxAmount / 2, 2);
    }

    public function getInvoiceGrandTotalProperty(): float
    {
        return round(
            $this->invoiceTaxableAmount + $this->invoiceTaxAmount,
            2
        );
    }

    public function addInvoiceItem(): void
    {
        $quantity = (float) $this->newInvoiceItem['quantity'];
        $rate = (float) $this->newInvoiceItem['rate'];
        $discount = (float) $this->newInvoiceItem['discount'];

        if (empty(trim($this->newInvoiceItem['description']))) {
            $this->addError(
                'newInvoiceItem.description',
                'Description is required.'
            );

            return;
        }

        if ($quantity <= 0) {
            $this->addError(
                'newInvoiceItem.quantity',
                'Quantity must be greater than 0.'
            );

            return;
        }

        if ($rate < 0 || $discount < 0) {
            return;
        }

        $grossAmount = $quantity * $rate;

        $taxableAmount = max(
            0,
            $grossAmount - $discount
        );

        $taxRate = (float) $this->invoiceTaxRate;

        $cgstRate = 0;
        $cgstAmount = 0;
        $sgstRate = 0;
        $sgstAmount = 0;
        $igstRate = 0;
        $igstAmount = 0;

        if ($this->invoiceTaxType === 'SGST/UGST') {
            $cgstRate = round($taxRate / 2, 2);
            $sgstRate = round($taxRate / 2, 2);

            $cgstAmount = round(
                $taxableAmount * $cgstRate / 100,
                2
            );

            $sgstAmount = round(
                $taxableAmount * $sgstRate / 100,
                2
            );
        } else {
            $igstRate = $taxRate;

            $igstAmount = round(
                $taxableAmount * $igstRate / 100,
                2
            );
        }

        $this->invoiceDraftItems[] = [
            'id' => null,

            'type' => $this->newInvoiceItem['type'],
            'description' => trim($this->newInvoiceItem['description']),
            'hsn_sac' => trim($this->newInvoiceItem['hsn_sac']),

            'quantity' => $quantity,
            'rate' => $rate,
            'discount' => $discount,

            'taxable_amount' => $taxableAmount,

            'cgst_rate' => $cgstRate,
            'cgst_amount' => $cgstAmount,

            'sgst_rate' => $sgstRate,
            'sgst_amount' => $sgstAmount,

            'igst_rate' => $igstRate,
            'igst_amount' => $igstAmount,
        ];

        $this->resetInvoiceItem();
    }
    public function removeInvoiceItem(int $index): void
    {
        unset($this->invoiceDraftItems[$index]);

        $this->invoiceDraftItems = array_values($this->invoiceDraftItems);
    }
    protected function resetInvoiceItem(): void
    {
        $this->newInvoiceItem = [
            'type' => 'Service',
            'description' => '',
            'hsn_sac' => '',
            'quantity' => 1,
            'rate' => 0,
            'discount' => 0,
        ];

        $this->resetValidation();
    }
    public function getInvoiceSubtotalProperty(): float
    {
        return round(
            collect($this->invoiceDraftItems ?? [])
                ->sum(fn($item) => (float) ($item['taxable_amount'] ?? 0)),
            2
        );
    }

    public function createInvoice(): void
    {
        if (empty($this->invoiceDraftItems)) {
            $this->addError('invoice', 'Please add at least one invoice item.');
            return;
        }

        $jobCard = JobCard::findOrFail($this->jobCard['id']);

        $invoice = $jobCard->invoices()->create([
            'invoice_number' => 'INV-' . now()->format('YmdHis'),
            'subtotal' => $this->invoiceSubtotal,
            'discount' => 0,
            'tax' => $this->invoiceTaxAmount,
            'tax_type' => $this->invoiceTaxType,
            'tax_rate' => $this->invoiceTaxRate,
            'total' => $this->invoiceGrandTotal,
            'status' => 'draft',
            'created_by' => auth()->id(),
        ]);

        foreach ($this->invoiceDraftItems as $item) {
            $invoice->items()->create([
                'item_type' => $item['type'],
                'description' => $item['description'],
                'hsn_sac' => $item['hsn_sac'] ?: null,

                'quantity' => $item['quantity'],
                'unit_price' => $item['rate'],
                'discount' => $item['discount'],

                'total' => $item['taxable_amount'],
                'taxable_amount' => $item['taxable_amount'],

                'cgst_rate' => $item['cgst_rate'],
                'cgst_amount' => $item['cgst_amount'],

                'sgst_rate' => $item['sgst_rate'],
                'sgst_amount' => $item['sgst_amount'],

                'igst_rate' => $item['igst_rate'],
                'igst_amount' => $item['igst_amount'],
            ]);
        }

        $this->showInvoiceModal = false;

        $this->loadJobCard($this->jobCard['id']);

        $this->toast()
            ->position('top-center')
            ->success('Invoice Bill', 'Invoice created successfully.')
            ->send();
    }
    public function updateInvoiceItem(int $index): void
    {
        if (! isset($this->invoiceDraftItems[$index])) {
            return;
        }

        $quantity = (float) $this->invoiceDraftItems[$index]['quantity'];
        $rate = (float) $this->invoiceDraftItems[$index]['rate'];
        $discount = (float) $this->invoiceDraftItems[$index]['discount'];

        $grossAmount = $quantity * $rate;

        $this->invoiceDraftItems[$index]['taxable_amount'] = max(
            0,
            $grossAmount - $discount
        );
    }
    public function recalculateInvoiceItems(): void
    {
        $taxRate = (float) $this->invoiceTaxRate;

        foreach ($this->invoiceDraftItems as $index => $item) {
            $taxableAmount = (float) ($item['taxable_amount'] ?? 0);

            $cgstRate = 0;
            $cgstAmount = 0;
            $sgstRate = 0;
            $sgstAmount = 0;
            $igstRate = 0;
            $igstAmount = 0;

            if ($this->invoiceTaxType === 'SGST/UGST') {
                $cgstRate = round($taxRate / 2, 2);
                $sgstRate = round($taxRate / 2, 2);

                $cgstAmount = round(
                    $taxableAmount * $cgstRate / 100,
                    2
                );

                $sgstAmount = round(
                    $taxableAmount * $sgstRate / 100,
                    2
                );
            } else {
                $igstRate = $taxRate;

                $igstAmount = round(
                    $taxableAmount * $igstRate / 100,
                    2
                );
            }

            $this->invoiceDraftItems[$index]['cgst_rate'] = $cgstRate;
            $this->invoiceDraftItems[$index]['cgst_amount'] = $cgstAmount;

            $this->invoiceDraftItems[$index]['sgst_rate'] = $sgstRate;
            $this->invoiceDraftItems[$index]['sgst_amount'] = $sgstAmount;

            $this->invoiceDraftItems[$index]['igst_rate'] = $igstRate;
            $this->invoiceDraftItems[$index]['igst_amount'] = $igstAmount;
        }
    }

    public function render()
    {
        return view('livewire.job-cards.billing')
            ->layout('components.layouts.management', [
                'title' => 'Job Card #' . $this->jobCard['job_card_number'] . ' - Billing',
            ]);
    }
}

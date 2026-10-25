<?php

namespace App\Livewire\JobCards;

use App\Models\JobCard;
use App\Models\JobCardInvoice;
use App\Services\RazorpayPaymentService;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Invoice extends Component
{
    use Interactions;

    public $jobCard;
    public $invoice;
    public $items = [];
    public $payments = [];

    public function mount($jobCard, $invoice): void
    {
        $jobCard = JobCard::query()
            ->with([
                'customer',
                'vehicle',
            ])
            ->findOrFail($jobCard);

        $invoice = JobCardInvoice::query()
            ->with(
                'items',
                'payments'
            )
            ->where('job_card_id', $jobCard->id)
            ->findOrFail($invoice);

        $paidAmount = (float) $invoice->payments
            ->where('status', 'success')
            ->sum('amount');

        $totalAmount = (float) $invoice->total;

        $dueAmount = max($totalAmount - $paidAmount, 0);

        $paymentStatus = match (true) {
            $paidAmount <= 0 => 'UNPAID',
            $paidAmount >= $totalAmount => 'PAID',
            default => 'PARTIALLY PAID',
        };

        $this->jobCard = [
            'id' => $jobCard->id,
            'job_card_number' => $jobCard->job_card_number,

            'customer' => $jobCard->customer->name,
            'phone' => $jobCard->customer->phone,
            'email' => $jobCard->customer->email,

            'vehicle_no' => $jobCard->vehicle->registration_number,
            'vehicle' => trim(
                $jobCard->vehicle->make . ' ' .
                    $jobCard->vehicle->model
            ),
        ];

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

            'amount_in_words' => $this->amountInWords((float) $invoice->total),

            'paid' => $paidAmount,
            'due' => $dueAmount,
            'payment_status' => $paymentStatus,
        ];

        $this->payments = $invoice->payments
            ->where('status', 'success')
            ->sortByDesc('payment_date')
            ->map(function ($payment) {
                return [
                    'id' => $payment->id,
                    'receipt_number' => $payment->receipt_number,
                    'amount' => (float) $payment->amount,
                    'payment_method' => $payment->payment_method,
                    'reference' => $payment->reference,
                    'payment_date' => $payment->payment_date?->format('d M Y, h:i A'),
                ];
            })
            ->values()
            ->toArray();

        $this->items = $invoice->items
            ->map(function ($item) {
                return [
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
                ];
            })
            ->values()
            ->toArray();
    }

    private function amountInWords(float $amount): string
    {
        $amount = round($amount, 2);

        $rupees = (int) floor($amount);
        $paise = (int) round(($amount - $rupees) * 100);

        $words = $this->numberToIndianWords($rupees);

        $result = $words . ' Rupees';

        if ($paise > 0) {
            $result .= ' and ' . $this->numberToIndianWords($paise) . ' Paise';
        }

        return $result . ' Only';
    }

    private function numberToIndianWords(int $number): string
    {
        if ($number === 0) {
            return 'Zero';
        }

        $ones = [
            '',
            'One',
            'Two',
            'Three',
            'Four',
            'Five',
            'Six',
            'Seven',
            'Eight',
            'Nine',
            'Ten',
            'Eleven',
            'Twelve',
            'Thirteen',
            'Fourteen',
            'Fifteen',
            'Sixteen',
            'Seventeen',
            'Eighteen',
            'Nineteen',
        ];

        $tens = [
            '',
            '',
            'Twenty',
            'Thirty',
            'Forty',
            'Fifty',
            'Sixty',
            'Seventy',
            'Eighty',
            'Ninety',
        ];

        $convert = function (int $number) use (&$convert, $ones, $tens): string {
            if ($number < 20) {
                return $ones[$number];
            }

            if ($number < 100) {
                return $tens[intdiv($number, 10)]
                    . ($number % 10 ? ' ' . $ones[$number % 10] : '');
            }

            if ($number < 1000) {
                return $ones[intdiv($number, 100)]
                    . ' Hundred'
                    . ($number % 100 ? ' ' . $convert($number % 100) : '');
            }

            if ($number < 100000) {
                return $convert(intdiv($number, 1000))
                    . ' Thousand'
                    . ($number % 1000 ? ' ' . $convert($number % 1000) : '');
            }

            if ($number < 10000000) {
                return $convert(intdiv($number, 100000))
                    . ' Lakh'
                    . ($number % 100000 ? ' ' . $convert($number % 100000) : '');
            }

            return $convert(intdiv($number, 10000000))
                . ' Crore'
                . ($number % 10000000 ? ' ' . $convert($number % 10000000) : '');
        };

        return $convert($number);
    }

    public function openWhatsApp(): void
    {
        $url = route('job-cards.invoice', [
            'jobCard' => $this->jobCard['id'],
            'invoice' => $this->invoice['id'],
        ]);

        $message = "Hello {$this->jobCard['customer']},\n\n"
            . "Your invoice from Hitek Automobiles is ready.\n\n"
            . "Invoice No: {$this->invoice['number']}\n"
            . "Amount: ₹" . number_format($this->invoice['total'], 2) . "\n\n"
            . "View your invoice:\n"
            . $url;

        $phone = preg_replace('/\D+/', '', $this->jobCard['phone'] ?? '');

        if (!$phone) {
            $this->addError('whatsapp', 'Customer phone number is not available.');
            return;
        }

        $whatsappUrl = 'https://wa.me/' . $phone
            . '?text=' . urlencode($message);

        $this->redirect($whatsappUrl, navigate: false);
    }

    public function payNow(RazorpayPaymentService $razorpay): void
    {
        if (($this->invoice['due'] ?? 0) <= 0) {
            return;
        }

        $invoice = JobCardInvoice::query()
            ->with([
                'jobCard.customer',
                'jobCard.vehicle',
            ])
            ->where('job_card_id', $this->jobCard['id'])
            ->findOrFail($this->invoice['id']);

        $paymentUrl = $razorpay->getOrCreateInvoicePaymentLink($invoice);

        $this->redirect($paymentUrl, navigate: false);
    }

    public function render()
    {
        return view('livewire.job-cards.invoice')
            ->layout('components.layouts.management', [
                'title' => 'Invoice ' . $this->invoice['number'],
            ]);
    }
}

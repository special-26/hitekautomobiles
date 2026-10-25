<?php

namespace Database\Seeders;

use App\Models\JobCardInvoice;
use App\Models\JobCardPayment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobCardPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $invoice = JobCardInvoice::query()
            ->with('jobCard')
            ->latest('id')
            ->first();

        if (! $invoice) {
            $this->command->warn('No invoice found. Create an invoice first.');
            return;
        }

        $user = User::query()->first();

        if (! $user) {
            $this->command->warn('No user found.');
            return;
        }

        // Avoid duplicate demo payments
        JobCardPayment::where('job_card_invoice_id', $invoice->id)->delete();

        JobCardPayment::create([
            'job_card_invoice_id' => $invoice->id,
            'receipt_number' => 'REC-' . $invoice->invoice_number . '-01',
            'amount' => 15000,
            'payment_method' => 'upi',
            'reference' => 'UPI9827346512',
            'payment_date' => now()->subDays(3)->setTime(12, 45),
            'status' => 'success',
            'received_by' => $user->id,
            'notes' => 'Advance payment',
        ]);

        JobCardPayment::create([
            'job_card_invoice_id' => $invoice->id,
            'receipt_number' => 'REC-' . $invoice->invoice_number . '-02',
            'amount' => 10000,
            'payment_method' => 'cash',
            'reference' => null,
            'payment_date' => now()->subDays(1)->setTime(15, 20),
            'status' => 'success',
            'received_by' => $user->id,
            'notes' => 'Customer payment',
        ]);

        $this->command->info(
            'Demo payments created for invoice ' . $invoice->invoice_number
        );
    }
}

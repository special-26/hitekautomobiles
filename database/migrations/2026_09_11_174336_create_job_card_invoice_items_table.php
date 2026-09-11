<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_card_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_card_invoice_id')
                ->constrained('job_card_invoices')
                ->cascadeOnDelete();

            $table->string('item_type'); // labour / part

            $table->string('description');

            $table->decimal('quantity', 10, 2)->default(1);

            $table->decimal('unit_price', 12, 2)->default(0);

            $table->decimal('discount', 12, 2)->default(0);

            $table->decimal('total', 12, 2)->default(0);

            $table->timestamps();

            $table->index('job_card_invoice_id');
            $table->index('item_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_card_invoice_items');
    }
};

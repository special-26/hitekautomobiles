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
        Schema::table('job_card_invoices', function (Blueprint $table) {
            $table->string('razorpay_payment_link_id')
                ->nullable()
                ->after('status');

            $table->text('razorpay_payment_link_url')
                ->nullable()
                ->after('razorpay_payment_link_id');

            $table->string('razorpay_payment_status')
                ->nullable()
                ->after('razorpay_payment_link_url');

            $table->timestamp('razorpay_payment_link_created_at')
                ->nullable()
                ->after('razorpay_payment_status');

            $table->timestamp('razorpay_paid_at')
                ->nullable()
                ->after('razorpay_payment_link_created_at');

            $table->index('razorpay_payment_link_id');
            $table->index('razorpay_payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_card_invoices', function (Blueprint $table) {
            $table->dropIndex([
                'razorpay_payment_link_id',
            ]);

            $table->dropIndex([
                'razorpay_payment_status',
            ]);

            $table->dropColumn([
                'razorpay_payment_link_id',
                'razorpay_payment_link_url',
                'razorpay_payment_status',
                'razorpay_payment_link_created_at',
                'razorpay_paid_at',
            ]);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('service_bookings', function (Blueprint $table) {
            $table->dropUnique('uniq_service_date_slot');
        });

        DB::statement("
            CREATE UNIQUE INDEX uniq_service_date_slot
            ON service_bookings (service_date, slot_key)
            WHERE status NOT IN ('cancelled', 'rejected')
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            DROP INDEX IF EXISTS uniq_service_date_slot
        ");

        Schema::table('service_bookings', function (Blueprint $table) {
            $table->unique(
                ['service_date', 'slot_key'],
                'uniq_service_date_slot'
            );
        });
    }
};

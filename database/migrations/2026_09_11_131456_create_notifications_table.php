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
        Schema::create('notifications', function (Blueprint $table) {
            // Laravel notification ID
            $table->uuid('id')->primary();

            // The model receiving the notification
            $table->string('notifiable_type');
            $table->uuid('notifiable_id');

            // Notification class/type
            $table->string('type');

            // Notification payload
            $table->text('data');

            // When the notification was read
            $table->timestamp('read_at')->nullable();

            $table->timestamps();

            $table->index([
                'notifiable_type',
                'notifiable_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};

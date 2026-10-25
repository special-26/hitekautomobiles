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
        Schema::create('workshop_brand_profiles', function (Blueprint $table) {
            $table->id();

            // Workshop identity
            $table->string('name');
            $table->string('logo_path')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('website')->nullable();

            // Brand styling
            $table->string('primary_color', 7)->default('#dc2626');
            $table->string('secondary_color', 7)->default('#334155');

            // Social media
            $table->string('instagram_handle')->nullable();
            $table->string('facebook_handle')->nullable();

            // Default text used in creatives
            $table->string('default_call_to_action')
                ->default('Book your service today');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workshop_brand_profiles');
    }
};

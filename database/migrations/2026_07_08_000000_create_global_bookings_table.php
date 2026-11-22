<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */// database/migrations/2026_07_08_000000_create_global_bookings_table.php
    public function up(): void
    {
        Schema::create('global_bookings', function (Blueprint $table) {
            $table->id();
            $table->enum('booking_type', ['cab', 'hotel']);
            $table->string('pickup_location')->nullable();
            $table->string('drop_location')->nullable();
            $table->string('hotel_location')->nullable();
            $table->date('checkin_date');
            $table->date('checkout_date');
            $table->unsignedInteger('adults');
            $table->unsignedInteger('kids')->nullable()->default(0);
            $table->unsignedInteger('rooms')->nullable();
            $table->time('pickup_time')->nullable();
            $table->enum('status', ['pending', 'contacted', 'closed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('global_bookings');
    }
};

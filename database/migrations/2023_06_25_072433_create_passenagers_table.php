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
        Schema::create('passenagers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('set null');
            $table->string('name');
            $table->string('phone_number');
            $table->string('suitcase_number');
            $table->timestamp('flight_date_time');
            $table->string('flight_number');
            $table->string('flight_airline');
            $table->string('flight_arriving_from');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passenagers');
    }
};

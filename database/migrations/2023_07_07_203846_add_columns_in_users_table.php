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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_no')->nullable();
            $table->string('taxi_driver_no')->nullable();
            $table->string('license_no')->nullable();
            $table->timestamp('license_expiry')->nullable();
            $table->integer('working_hours')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone_no');
            $table->dropColumn('taxi_driver_no');
            $table->dropColumn('license_no');
            $table->dropColumn('license_expiry');
            $table->dropColumn('working_hours');
        });
    }
};

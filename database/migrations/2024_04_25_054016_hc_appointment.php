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
        Schema::create('hc_appointment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('hc_users');
            $table->unsignedBigInteger('healthcare_professional_id');
            $table->foreign('healthcare_professional_id')->references('id')->on('hc_professional');
            $table->timestamp('appointment_start_time');
            $table->timestamp('appointment_end_time');
            $table->tinyInteger('status')->length(1)->comment('status 1=booked, 2=completed, 3=cancelled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hc_appointment');
    }
};

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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('clinic_user_id')->nullable();
            $table->unsignedBigInteger('schedule_time_id');
            $table->longText('cause')->nullable();
            $table->unsignedBigInteger('reschedule_time_id')->nullable();
            $table->enum('status', ['pending', 'completed', 'approved', 'cancelled', 'rescheduled'])->default('pending');
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('clinic_user_id')->references('id')->on('clinic_users')->onDelete('cascade');
            $table->foreign('schedule_time_id')->references('id')->on('schedule_times')->onDelete('cascade');
            $table->foreign('reschedule_time_id')->references('id')->on('schedule_times')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};

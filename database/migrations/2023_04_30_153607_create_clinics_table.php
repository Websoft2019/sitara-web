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
        Schema::create('clinics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            $table->longText('description')->nullable();
            $table->string('registration_number')->unique();
            $table->string('contact_person');
            $table->string('contact_person_number');
            $table->string('number')->unique();
            $table->text('address');
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('email')->unique();
            $table->enum('status', ['active', 'hidden'])->default('active');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinics');
    }
};

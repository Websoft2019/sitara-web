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
        Schema::create('registrationrequests', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['company', 'clinic']);
            $table->string('name');
            $table->string('address');
            $table->string('registration_number');
            $table->string('contactperson');
            $table->string('contact_person_number');
            $table->string('company_contact_number');
            $table->string('city');
            $table->string('state');
            $table->string('postalcode');
            $table->string('openinghour')->nullable();
            $table->string('email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrationrequests');
    }
};

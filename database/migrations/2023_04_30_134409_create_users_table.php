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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->unsignedBigInteger('company_id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('image')->nullable();
            $table->string('post')->nullable();
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'others']);
            $table->string('race')->nullable();
            $table->string('ic_number');
            $table->string('phone_number');
            $table->text('address')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('per_visit_claim');
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('status', ['active', 'hidden'])->default('active');
            $table->enum('is_first_login', ['yes', 'no'])->default('yes');
            $table->timestamp('deleted_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

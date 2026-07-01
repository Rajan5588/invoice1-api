<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('company_name')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('gst')->nullable();
            $table->string('gst_treatment')->nullable();
            $table->string('place_of_supply')->nullable();
            $table->string('state')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

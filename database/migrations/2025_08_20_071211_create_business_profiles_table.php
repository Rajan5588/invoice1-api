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
        Schema::create('business_profiles', function (Blueprint $table) {
            $table->id();
            
            // Add user_id foreign key
            $table->unsignedBigInteger('user_id')->unique(); // one-to-one relation
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->string('business_id')->unique();
            $table->string('gst_no')->nullable();
            $table->string('phone_no_first');
            $table->string('phone_no_second')->nullable();
            $table->string('email');
            $table->string('business_email')->nullable();
            $table->text('business_address');
            $table->string('pincode');
            $table->text('business_desc')->nullable();
            $table->string('digital_sign')->nullable(); // store path
            $table->string('business_state');
            $table->string('business_category');
            $table->string('website')->nullable();
            $table->string('business_signature')->nullable(); // store path
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_profiles');
    }
};

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
       Schema::create('expenses', function (Blueprint $table) {
    $table->id();
    $table->string('title'); // What is this Spent for
    $table->decimal('amount', 12, 2);
    $table->string('category');
    $table->date('expense_date');
    $table->string('payment_mode');
    $table->text('notes')->nullable();
    $table->string('photos')->nullable(); // store JSON of uploaded photos
    $table->string('status')->default('pending'); // pending, approved, rejected
    $table->string('company_code'); 
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};

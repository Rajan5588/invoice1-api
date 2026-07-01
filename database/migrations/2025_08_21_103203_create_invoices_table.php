<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // reference users
            $table->foreignId('customer_id')->constrained()->onDelete('cascade'); // reference customers

            $table->string('customer_name');
            $table->string('customer_number')->nullable();
            $table->enum('payment_type', ['cash', 'card', 'online', 'credit'])->default('cash');
            
            $table->decimal('discount_percent', 8, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('round_off', 10, 2)->default(0.00);
            
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->decimal('amount_received', 15, 2)->default(0);
            
            $table->text('note')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};

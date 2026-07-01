<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('plan_name');
            $table->decimal('plan_price', 10, 2);
            $table->integer('plan_validity'); // in days or months
            $table->enum('plan_status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('subscriptions');
    }
};

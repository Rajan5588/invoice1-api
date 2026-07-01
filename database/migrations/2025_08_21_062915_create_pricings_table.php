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
        Schema::create('pricings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
    $table->string('unit')->nullable();
    $table->decimal('salesprice_amount', 10, 2)->nullable();
    $table->boolean('salesprice_tax')->default(false);
    $table->decimal('purches_price_amount', 10, 2)->nullable();
    $table->boolean('purches_price_tax')->default(false);
    $table->decimal('mrp_price', 10, 2)->nullable();
    $table->decimal('gst', 5, 2)->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricings');
    }
};

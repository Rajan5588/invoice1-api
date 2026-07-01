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
       Schema::create('stocks', function (Blueprint $table) {
    $table->id();
    $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
    $table->integer('opening_stock')->default(0);
    $table->date('as_of_date')->nullable();
    $table->string('item_name');
    $table->boolean('low_alert_status')->default(false);
    $table->integer('low_alert_quantity')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};

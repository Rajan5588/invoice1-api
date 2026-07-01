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
        Schema::create('item_details', function (Blueprint $table) {
    $table->id();
    $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
    $table->foreignId('item_category_id')->constrained('item_categories')->onDelete('cascade');
    $table->text('item_description')->nullable();
    $table->boolean('show_online_store')->default(false);
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_details');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gst_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('item_id');
            $table->decimal('price', 12, 2);
            $table->decimal('quantity', 12, 2);
            $table->decimal('gst_percent', 5, 2);
            $table->decimal('cgst', 12, 2)->default(0);
            $table->decimal('sgst', 12, 2)->default(0);
            $table->decimal('igst', 12, 2)->default(0);
            $table->decimal('without_gst', 12, 2);
            $table->decimal('gst_amount', 12, 2);
            $table->decimal('total', 12, 2);
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gst_details');
    }
};

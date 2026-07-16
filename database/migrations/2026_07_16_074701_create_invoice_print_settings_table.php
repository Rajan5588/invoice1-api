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
    Schema::create('invoice_print_settings', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('user_id');
        $table->string('company_code')->nullable();

        // Printer
        $table->enum('printer_type', ['regular', 'thermal'])->default('regular');

        // Theme
        $table->string('theme')->default('default');
        $table->string('text_size')->default('medium');
        $table->string('page_size')->default('A4');
        $table->string('orientation')->default('portrait');

        // Company Header
        $table->boolean('print_repeat_header')->default(true);
        $table->boolean('print_company_name')->default(true);
        $table->boolean('print_logo')->default(true);
        $table->boolean('print_address')->default(true);
        $table->boolean('print_email')->default(true);
        $table->boolean('print_phone')->default(true);
        $table->boolean('print_gstin')->default(true);

        // Amount
        $table->boolean('show_received_amount')->default(true);
        $table->boolean('show_balance_amount')->default(true);
        $table->boolean('show_current_balance')->default(false);
        $table->boolean('show_tax_details')->default(true);
        $table->boolean('amount_grouping')->default(true);
        $table->boolean('show_you_saved')->default(true);
        $table->string('amount_in_words')->default('Indian');

        // Footer
        $table->boolean('print_description')->default(true);
        $table->boolean('print_terms')->default(true);
        $table->text('terms_text')->nullable();

        $table->boolean('print_received_by')->default(true);
        $table->boolean('print_delivered_by')->default(true);

        $table->boolean('print_signature')->default(true);
        $table->string('signature_text')->nullable();

        $table->boolean('show_payment_mode')->default(false);
        $table->boolean('print_acknowledgement')->default(false);
        $table->boolean('print_page_number')->default(true);

        // Item Table
        $table->integer('min_item_rows')->default(0);
        $table->boolean('show_total_quantity')->default(true);
        $table->boolean('show_decimal')->default(true);

        $table->timestamps();

        $table->foreign('user_id')
              ->references('id')
              ->on('users')
              ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::dropIfExists('invoice_print_settings');
}
};

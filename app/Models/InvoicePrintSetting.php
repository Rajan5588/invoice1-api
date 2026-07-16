<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePrintSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_code',

        // Printer
        'printer_type',

        // Theme
        'theme',
        'text_size',
        'page_size',
        'orientation',

        // Company Header
        'print_repeat_header',
        'print_company_name',
        'print_logo',
        'print_address',
        'print_email',
        'print_phone',
        'print_gstin',

        // Amount
        'show_received_amount',
        'show_balance_amount',
        'show_current_balance',
        'show_tax_details',
        'amount_grouping',
        'show_you_saved',
        'amount_in_words',

        // Footer
        'print_description',
        'print_terms',
        'terms_text',
        'print_received_by',
        'print_delivered_by',
        'print_signature',
        'signature_text',
        'show_payment_mode',
        'print_acknowledgement',
        'print_page_number',

        // Item Table
        'min_item_rows',
        'show_total_quantity',
        'show_decimal',
    ];

    protected $casts = [
        'print_repeat_header' => 'boolean',
        'print_company_name' => 'boolean',
        'print_logo' => 'boolean',
        'print_address' => 'boolean',
        'print_email' => 'boolean',
        'print_phone' => 'boolean',
        'print_gstin' => 'boolean',

        'show_received_amount' => 'boolean',
        'show_balance_amount' => 'boolean',
        'show_current_balance' => 'boolean',
        'show_tax_details' => 'boolean',
        'amount_grouping' => 'boolean',
        'show_you_saved' => 'boolean',

        'print_description' => 'boolean',
        'print_terms' => 'boolean',
        'print_received_by' => 'boolean',
        'print_delivered_by' => 'boolean',
        'print_signature' => 'boolean',
        'show_payment_mode' => 'boolean',
        'print_acknowledgement' => 'boolean',
        'print_page_number' => 'boolean',

        'show_total_quantity' => 'boolean',
        'show_decimal' => 'boolean',
    ];

    /**
     * User Relation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
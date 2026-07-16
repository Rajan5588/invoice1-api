<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\InvoicePrintSetting;
use App\Models\User;

class InvoicePrintSettingController extends Controller
{
    /**
     * Get Print Settings
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $setting = InvoicePrintSetting::firstOrCreate(
            [
                'user_id' => $request->user_id
            ],
            [
                'company_code' => User::find($request->user_id)->company_code,

                'printer_type' => 'regular',
                'theme' => 'default',
                'text_size' => 'medium',
                'page_size' => 'A4',
                'orientation' => 'portrait',

                'print_repeat_header' => true,
                'print_company_name' => true,
                'print_logo' => true,
                'print_address' => true,
                'print_email' => true,
                'print_phone' => true,
                'print_gstin' => true,

                'show_received_amount' => true,
                'show_balance_amount' => true,
                'show_current_balance' => false,
                'show_tax_details' => true,
                'amount_grouping' => true,
                'show_you_saved' => true,
                'amount_in_words' => 'Indian',

                'print_description' => true,
                'print_terms' => true,
                'terms_text' => '',
                'print_received_by' => true,
                'print_delivered_by' => true,
                'print_signature' => true,
                'signature_text' => 'Authorized Signature',

                'show_payment_mode' => false,
                'print_acknowledgement' => false,
                'print_page_number' => true,

                'min_item_rows' => 0,
                'show_total_quantity' => true,
                'show_decimal' => true,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Invoice print settings fetched successfully.',
            'data' => $setting
        ]);
    }

    /**
     * Create / Update Print Settings
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::findOrFail($request->user_id);

        $setting = InvoicePrintSetting::updateOrCreate(

            [
                'user_id' => $request->user_id,
            ],

            [
                'company_code' => $user->company_code,

                'printer_type' => $request->printer_type ?? 'regular',
                'theme' => $request->theme ?? 'default',
                'text_size' => $request->text_size ?? 'medium',
                'page_size' => $request->page_size ?? 'A4',
                'orientation' => $request->orientation ?? 'portrait',

                'print_repeat_header' => $request->print_repeat_header ?? true,
                'print_company_name' => $request->print_company_name ?? true,
                'print_logo' => $request->print_logo ?? true,
                'print_address' => $request->print_address ?? true,
                'print_email' => $request->print_email ?? true,
                'print_phone' => $request->print_phone ?? true,
                'print_gstin' => $request->print_gstin ?? true,

                'show_received_amount' => $request->show_received_amount ?? true,
                'show_balance_amount' => $request->show_balance_amount ?? true,
                'show_current_balance' => $request->show_current_balance ?? false,
                'show_tax_details' => $request->show_tax_details ?? true,
                'amount_grouping' => $request->amount_grouping ?? true,
                'show_you_saved' => $request->show_you_saved ?? true,
                'amount_in_words' => $request->amount_in_words ?? 'Indian',

                'print_description' => $request->print_description ?? true,
                'print_terms' => $request->print_terms ?? true,
                'terms_text' => $request->terms_text,
                'print_received_by' => $request->print_received_by ?? true,
                'print_delivered_by' => $request->print_delivered_by ?? true,
                'print_signature' => $request->print_signature ?? true,
                'signature_text' => $request->signature_text,

                'show_payment_mode' => $request->show_payment_mode ?? false,
                'print_acknowledgement' => $request->print_acknowledgement ?? false,
                'print_page_number' => $request->print_page_number ?? true,

                'min_item_rows' => $request->min_item_rows ?? 0,
                'show_total_quantity' => $request->show_total_quantity ?? true,
                'show_decimal' => $request->show_decimal ?? true,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Invoice print settings saved successfully.',
            'data' => $setting
        ]);
    }
}
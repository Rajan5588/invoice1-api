<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\BusinessProfile;
use App\Models\InvoicePrintSetting;

class TemplatesController extends Controller
{
    public function getTemplate($invoice_id)
    {
        try {

            $invoice = Invoice::with([
                'items.item',
                'charges',
                'customer',
                'user',
                'billingDetail',
                'shippingDetail',
                'gstDetails'
            ])->findOrFail($invoice_id);

            $business = BusinessProfile::where('user_id', $invoice->user_id)->first();

            $setting = InvoicePrintSetting::where('user_id', $invoice->user_id)->first();

            return view('BillTemplates.bill1', compact(
                'invoice',
                'business',
                'setting'
            ));

        } catch (\Throwable $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);

        }
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceAdditionalCharge;
use App\Models\User;
use App\Models\History;
class InvoiceController extends Controller
{
    
   public function getByUser(Request $request)
{
    $userId = $request->query('user_id');

    if (!$userId) {
        return response()->json(['message' => 'user_id is required'], 400);
    }

    $invoices = Invoice::with('items.item', 'charges', 'customer')
                ->where('user_id', $userId)
                ->get();

    if ($invoices->isEmpty()) {
        return response()->json(['message' => 'No invoices found for this user'], 404);
    }

    return response()->json([
        'data' => $invoices,
        'message' => 'Invoices fetched successfully for user_id: ' . $userId
    ]);
}

 
    public function index()
    {
        $invoices = Invoice::with('items.item', 'charges', 'customer')->get();
        return response()->json(['data' => $invoices, 'message' => 'Invoices fetched successfully']);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'customer_id' => 'required|exists:customers,id',
            'customer_name' => 'required|string',
            'payment_type' => 'required|string',
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'charges' => 'nullable|array',
            'charges.*.charge_name' => 'required|string',
            'charges.*.price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Validation failed'], 422);
        }

        $invoice = DB::transaction(function () use ($request) {
            $invoice = Invoice::create($request->only([
                'user_id','customer_id','customer_name','customer_number',
                'payment_type','discount_percent','discount_amount',
                'round_off','total_amount','amount_received','note'
            ]));
            
            

            foreach ($request->items as $item) {
                $total = $item['quantity'] * $item['price'];
                $invoice->items()->create([
                    'item_id' => $item['item_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $total
                ]);
            }

            if ($request->has('charges')) {
                foreach ($request->charges as $charge) {
                    $invoice->charges()->create($charge);
                }
            }
            $invoice->transactions()->create([
            'user_id'       => $request->user_id,
            'customer_name' => $request->customer_name,
            'date'          => now()->toDateString(),
            'status'        => 'paid', // default
        ]);

            return $invoice->load('items.item', 'charges','transactions');
        });
        
         $user = User::find($request->user_id);
        if ($user) {
            $description = $user->name . ' created a new invoice #' . $invoice->id . ' on ' . now()->toDateTimeString();
            History::create([
                'user_id' => $user->id,
                'description' => $description
            ]);
        }

        return response()->json(['message' => 'Invoice created successfully', 'data' => $invoice], 201);
    }

    public function show($id)
    {
        $invoice = Invoice::with('items.item', 'charges', 'customer')->find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        return response()->json(['data' => $invoice, 'message' => 'Invoice fetched successfully']);
    }

 
    
    public function update(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id' => 'required|exists:invoices,id',
        'customer_name' => 'required|string',
        'payment_type' => 'required|string',
        'items' => 'required|array',
        'items.*.item_id' => 'required|exists:items,id',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.price' => 'required|numeric|min:0',
        'charges' => 'nullable|array',
        'charges.*.charge_name' => 'required|string',
        'charges.*.price' => 'required|numeric|min:0',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors(),
            'message' => 'Validation failed'
        ], 422);
    }

    $invoice = Invoice::findOrFail($request->id);

    $invoice = DB::transaction(function () use ($request, $invoice) {
        $invoice->update($request->only([
            'customer_name','customer_number','payment_type',
            'discount_percent','discount_amount','round_off',
            'total_amount','amount_received','note'
        ]));

        $invoice->items()->delete();
        foreach ($request->items as $item) {
            $total = $item['quantity'] * $item['price'];
            $invoice->items()->create([
                'item_id' => $item['item_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $total
            ]);
        }

        $invoice->charges()->delete();
        if ($request->has('charges')) {
            foreach ($request->charges as $charge) {
                $invoice->charges()->create($charge);
            }
        }
        $invoice->transactions()->delete();
          $invoice->transactions()->create([
            'user_id'       => $request->user_id,
            'customer_name' => $request->customer_name,
            'date'          => now()->toDateString(),
            'status'        => 'paid', // default
        ]);

        return $invoice->load('items.item', 'charges','transactions');
    });
    
    $user = User::find($request->user_id);
        if ($user) {
            $description = $user->name . ' updated invoice #' . $invoice->id . ' on ' . now()->toDateTimeString();
            History::create([
                'user_id' => $user->id,
                'description' => $description
            ]);
        }

    return response()->json(['message' => 'Invoice updated successfully', 'data' => $invoice]);
}

public function destroy(Request $request)
{
  $id = $request->input('id');
$action = $request->input('action'); // permanent_destroy, temporary_destroy, restore

    $invoice = Invoice::find($id);

    if (!$invoice) {
        return response()->json(['message' => 'Invoice not found'], 404);
    }

    $user = User::find($invoice->user_id);

    if ($action === 'permanent_destroy') {
        $invoice->delete();

        if ($user) {
            $description = $user->name . ' permanently deleted invoice #' . $id . ' on ' . now()->toDateTimeString();
            History::create([
                'user_id' => $user->id,
                'description' => $description
            ]);
        }

        return response()->json(['message' => 'Invoice permanently deleted']);
    }

    if ($action === 'temporary_destroy') {
        $invoice->recycle_status = 'temporary_destroy';
        $invoice->save();

        if ($user) {
            History::create([
                'user_id' => $user->id,
                'description' => $user->name . ' temporarily deleted invoice #' . $id
            ]);
        }

        return response()->json(['message' => 'Invoice temporarily deleted']);
    }

    if ($action === 'restore') {
        $invoice->recycle_status = 'none';
        $invoice->save();

        if ($user) {
            History::create([
                'user_id' => $user->id,
                'description' => $user->name . ' restored invoice #' . $id
            ]);
        }

        return response()->json(['message' => 'Invoice restored']);
    }

    return response()->json(['message' => 'Invalid action'], 400);
}




}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Item;
use App\Models\History;
use App\Models\User;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::with('pricings', 'stocks', 'otherImages', 'details.category')->get();
        return response()->json(['data' => $items, 'message' => 'Items fetched successfully']);
    }

    /**
     * Store a newly created resource in storage.
     */
//     public function store(Request $request)
//     {
//         $validator = Validator::make($request->all(), [
//             'item_name' => 'required|string',
//             'user_id' => 'required|exists:users,id',
//             'item_category_id' => 'nullable|exists:item_categories,id',
//             'pricings.*.unit' => 'nullable|string',
//             'stocks.*.opening_stock' => 'nullable',
//             'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
//         ]);

//         if ($validator->fails()) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Validation failed',
//                 'errors' => $validator->errors()
//             ], 422);
//         }

//         $item = DB::transaction(function() use ($request) {
//             $item = Item::create($request->only('item_name','user_id'));

//             if ($request->has('pricings')) {
//                 foreach ($request->pricings as $pricing) {
//                     $item->pricings()->create($pricing);
//                 }
//             }

//             if ($request->has('stocks')) {
//                 foreach ($request->stocks as $stock) {
//                     $stock['item_name'] = $item->item_name;
//                     $item->stocks()->create($stock);
//                 }
//             }

//           if ($request->hasFile('images')) {
//     foreach ($request->file('images') as $image) {
//         // Generate unique filename
//         $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

//         // Move file to public/item_other_images
//         $image->move(public_path('item_other_images'), $filename);

//         // Save only filename OR full relative path (up to you)
//         $item->otherImages()->create([
//             'image_path' => 'item_other_images/' . $filename
//         ]);
//     }
// }


//             $item->details()->create([
//                 'item_id' => $item->id,
//                 'item_category_id' => $request->item_category_id,
//                 'item_description' => $request->item_description ?? null,
//                 'show_online_store' => $request->show_online_store ?? false,
//                 'user_id' => $request->user_id
//             ]);

//             return $item->load('pricings', 'stocks', 'otherImages', 'details');
//         });
        
//          $user = User::find($item->user_id);

//     // Log history if user exists
//   if ($user) {
    
//               $description = $user->name .' '. $item->item_name .' New Item added on ' . now()->toDateTimeString();
   

//     History::create([
//         'user_id' => $user->id,
//         'description' => $description
//     ]);
// }

//         return response()->json(['message' => 'Item created successfully', 'data' => $item]);
//     }

public function store(Request $request)
{

    $validator = Validator::make($request->all(), [
        'id' => 'nullable|exists:items,id', // check if update
        'item_name' => 'required|string',
        'user_id' => 'required|exists:users,id',
        'item_category_id' => 'nullable|exists:item_categories,id',
        'pricings.*.unit' => 'nullable|string',
        'stocks.*.opening_stock' => 'nullable',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    $item = DB::transaction(function() use ($request) {

        // ✅ If ID exists → update, else create new
        if ($request->id) {
            $item = Item::findOrFail($request->id);
            $item->update($request->only('item_name','user_id'));

            // clear old relations before re-inserting
            $item->pricings()->delete();
            $item->stocks()->delete();
            $item->details()->delete();
            $item->otherImages()->delete();

        } else {
            $item = Item::create($request->only('item_name','user_id'));
        }

        // Pricings
        if ($request->has('pricings')) {
            foreach ($request->pricings as $pricing) {
                $item->pricings()->create($pricing);
            }
        }

        // Stocks
        if ($request->has('stocks')) {
            foreach ($request->stocks as $stock) {
                $stock['item_name'] = $item->item_name;
                $item->stocks()->create($stock);
            }
        }

        // Images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('item_other_images'), $filename);

                $item->otherImages()->create([
                    'image_path' => 'item_other_images/' . $filename
                ]);
            }
        }

        // Details
        $item->details()->create([
            'item_id' => $item->id,
            'item_category_id' => $request->item_category_id,
            'item_description' => $request->item_description ?? null,
            'show_online_store' => $request->show_online_store ?? false,
            'user_id' => $request->user_id
        ]);

        return $item->load('pricings', 'stocks', 'otherImages', 'details');
    });

    // Log history
    $user = User::find($item->user_id);
    if ($user) {
        $description = $user->name .' '. $item->item_name .' ' 
                      . ($request->id ? 'Item updated' : 'New Item added') 
                      . ' on ' . now()->toDateTimeString();

        History::create([
            'user_id' => $user->id,
            'description' => $description
        ]);
    }

    return response()->json([
        'message' => $request->id ? 'Item updated successfully' : 'Item created successfully',
        'data' => $item
    ]);
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $item = Item::with('pricings', 'stocks', 'otherImages', 'details.category')->find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        return response()->json(['data' => $item, 'message' => 'Item fetched successfully']);
    }

    /**
     * Update the specified resource in storage.
     */
 public function update(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id' => 'required|exists:invoices,id', // ✅ validate against invoices table
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
        // ✅ update invoice basic info
        $invoice->update($request->only([
            'customer_name','customer_number','payment_type',
            'discount_percent','discount_amount','round_off',
            'total_amount','amount_received','note'
        ]));

        // ✅ update items (delete old, add new)
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

        // ✅ update charges
        $invoice->charges()->delete();
        if ($request->has('charges')) {
            foreach ($request->charges as $charge) {
                $invoice->charges()->create($charge);
            }
        }

        return $invoice->load('items.item', 'charges', 'customer');
    });

    return response()->json([
        'message' => 'Invoice updated successfully',
        'data' => $invoice
    ]);
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        // Optional: cascade delete manually if no DB foreign key cascade
        $item->pricings()->delete();
        $item->stocks()->delete();
        $item->otherImages()->delete();
        $item->details()->delete();

        $item->delete();
        
           $user = User::find($item->user_id);

    // Log history if user exists
   if ($user) {
    
              $description = $user->name .' '. $item->item_name .' deleted on ' . now()->toDateTimeString();
   

    History::create([
        'user_id' => $user->id,
        'description' => $description
    ]);
}

        return response()->json(['message' => 'Item deleted successfully']);
    }

    /**
     * Get items by user_id.
     */
    public function getItemsByUser(Request $request)
    {
        $userId = $request->query('user_id');

        if (!$userId) {
            return response()->json(['message' => 'user_id query parameter is required'], 400);
        }

        $items = Item::with('pricings', 'stocks', 'otherImages', 'details.category')
                     ->where('user_id', $userId)
                     ->get();

        if ($items->isEmpty()) {
            return response()->json(['message' => 'No items found for this user'], 404);
        }

        return response()->json(['data' => $items, 'message' => 'Items fetched successfully']);
    }
}

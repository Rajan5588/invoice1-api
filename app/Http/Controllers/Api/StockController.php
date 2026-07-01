<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Stock;
use App\Models\Item;
use App\Models\History;
use App\Models\User;

class StockController extends Controller
{
    /**
     * Store new stock entry for an item
     */
  public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'item_id' => 'required|exists:items,id',
        'opening_stock' => 'required|integer',
        'as_of_date' => 'nullable|date',
        'low_alert_status' => 'nullable',
        'low_alert_quantity' => 'nullable|integer'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors(),
            'message' => 'Validation failed'
        ], 422);
    }

    // Get item
    $item = Item::findOrFail($request->item_id);

    // Get user who owns the item
    $user = User::find($item->user_id);

    // Create stock
    $stock = Stock::create([
        'item_id' => $item->id,
        'item_name' => $item->item_name,
        'opening_stock' => $request->opening_stock,
        'as_of_date' => $request->as_of_date ?? now(),
        'low_alert_status' => $request->low_alert_status ?? false,
        'low_alert_quantity' => $request->low_alert_quantity ?? null,
    ]);

    // Create history log
    if ($user) {
        $description = $user->name . ' added new stock for ' . $item->item_name . ' on ' . now()->toDateTimeString();

        History::create([
            'user_id' => $user->id,
            'description' => $description
        ]);
    }

    return response()->json([
        'message' => 'Stock added successfully',
        'data' => $stock
    ]);
}


    /**
     * Update a specific stock
     */
   public function update(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id' => 'required|exists:stocks,id',
        'opening_stock' => 'nullable|integer',
        'as_of_date' => 'nullable|date',
        'low_alert_status' => 'nullable',
        'low_alert_quantity' => 'nullable|integer'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors(),
            'message' => 'Validation failed'
        ], 422);
    }

    // Find stock
    $stock = Stock::findOrFail($request->id);

    // Update stock
    $stock->update($request->only([
        'opening_stock',
        'as_of_date',
        'low_alert_status',
        'low_alert_quantity'
    ]));

    // Get related item & user
    $item = Item::findOrFail($stock->item_id);
    $user = User::find($item->user_id);

    // Log history if user exists
    if ($user) {
        $description = $user->name . ' updated stock for ' . $item->item_name . ' on ' . now()->toDateTimeString();

        History::create([
            'user_id' => $user->id,
            'description' => $description
        ]);
    }

    return response()->json([
        'message' => 'Stock updated successfully',
        'data' => $stock
    ]);
}


    /**
     * Delete stock by id
     */
     
        public function show($id)
    {
        $stock = Stock::find($id);

        if (!$stock) {
            return response()->json(['message' => 'Stock not found'], 404);
        }

      return response()->json(['message' => 'Stock details get successfully', 'data' => $stock]);
    }
    public function destroy($id)
    {
        $stock = Stock::find($id);

        if (!$stock) {
            return response()->json(['message' => 'Stock not found'], 404);
        }
        
         $item = Item::findOrFail($stock->item_id);
    $user = User::find($item->user_id);

    // Log history if user exists
    if ($user) {
        $description = $user->name . ' delete stock for ' . $item->item_name . ' on ' . now()->toDateTimeString();

        History::create([
            'user_id' => $user->id,
            'description' => $description
        ]);
    }

        $stock->delete();

        return response()->json(['message' => 'Stock deleted successfully']);
    }

    /**
     * Get stocks by item_id
     */
    public function getByItem($item_id)
    {
        $stocks = Stock::where('item_id', $item_id)->get();

        if ($stocks->isEmpty()) {
            return response()->json(['message' => 'No stocks found for this item'], 404);
        }

        return response()->json(['data' => $stocks, 'message' => 'Stocks fetched successfully']);
    }

    /**
     * Get stocks by user_id
     */
    public function getByUser($user_id)
    {
        $stocks = Stock::whereHas('item', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->get();

        if ($stocks->isEmpty()) {
            return response()->json(['message' => 'No stocks found for this user'], 404);
        }

        return response()->json(['data' => $stocks, 'message' => 'Stocks fetched successfully']);
    }
}

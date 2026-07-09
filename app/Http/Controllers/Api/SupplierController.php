<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    // Get all suppliers
    public function index()
    {
        $suppliers = Supplier::latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Suppliers fetched successfully',
            'data' => $suppliers
        ]);
    }

    // Get supplier by id
    public function show($id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return response()->json([
                'status' => false,
                'message' => 'Supplier not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $supplier
        ]);
    }

    // Create supplier
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'gst_no' => 'nullable|string|max:50',
        ]);

        $supplier = Supplier::create([
            'user_id' => $request->user_id,
            'company_code' => \App\Models\User::find($request->user_id)->company_code,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'gst_no' => $request->gst_no,
            'status' => 'active',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Supplier created successfully',
            'data' => $supplier
        ]);
    }

    // Update supplier
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:suppliers,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'gst_no' => 'nullable|string|max:50',
            'status' => 'nullable|in:active,inactive',
        ]);

        $supplier = Supplier::findOrFail($request->id);

        $supplier->update($request->only([
            'name',
            'phone',
            'email',
            'address',
            'gst_no',
            'status'
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Supplier updated successfully',
            'data' => $supplier
        ]);
    }

    // Delete supplier
    public function destroy($id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return response()->json([
                'status' => false,
                'message' => 'Supplier not found'
            ], 404);
        }

        $supplier->delete();

        return response()->json([
            'status' => true,
            'message' => 'Supplier deleted successfully'
        ]);
    }
}
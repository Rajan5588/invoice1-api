<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return response()->json(['status' => true, 'data' => $customers], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'nullable|string|max:20',
            'gst' => 'nullable|string|max:20',
            'gst_treatment' => 'nullable|string|max:50',
            'place_of_supply' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'user_id' => 'required|exists:users,id'
                              
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $customer = Customer::create($validator->validated());
            return response()->json(['status' => true, 'data' => $customer], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create customer',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function showbyuser(Request $request)
    {
        try {
        $id = $request->user_id;

        $category = Customer::where('user_id', $id)->get();

        return response()->json([
            'status' => true,
            'data' => $category
        ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch customers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json(['status' => false, 'message' => 'Customer not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'customer_name' => 'sometimes|required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'sometimes|required|email|unique:customers,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'gst' => 'nullable|string|max:20',
            'gst_treatment' => 'nullable|string|max:50',
            'place_of_supply' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'user_id' => 'sometimes|required|exists:users,id'
                                  
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $customer->update($validator->validated());
            return response()->json(['status' => true, 'data' => $customer], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update customer',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json(['status' => false, 'message' => 'Customer not found'], 404);
        }

        try {
            $customer->delete();
            return response()->json(['status' => true, 'message' => 'Customer deleted'], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete customer',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

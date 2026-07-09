<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Expense;
use App\Models\User;
use App\Models\History;

class ExpenseController extends Controller
{
    /**
     * Get All Expenses
     */
    public function index()
    {
        $expenses = Expense::latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Expenses fetched successfully',
            'data' => $expenses
        ]);
    }

    /**
     * Create Expense
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'       => 'required|exists:users,id',
            'title'         => 'required|string|max:255',
            'amount'        => 'required|numeric',
            'category'      => 'required|string|max:255',
            'expense_date'  => 'required|date',
            'payment_mode'  => 'required|string|max:100',
            'notes'         => 'nullable|string',
            'photos.*'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $expense = DB::transaction(function () use ($request) {

            $photos = [];

            if ($request->hasFile('photos')) {

                foreach ($request->file('photos') as $photo) {

                    $filename = time().'_'.uniqid().'.'.$photo->getClientOriginalExtension();

                    $photo->move(public_path('expense_images'), $filename);

                    $photos[] = 'expense_images/'.$filename;
                }
            }

            $user = User::find($request->user_id);

            return Expense::create([
                'user_id'       => $request->user_id,
                'title'         => $request->title,
                'amount'        => $request->amount,
                'category'      => $request->category,
                'expense_date'  => $request->expense_date,
                'payment_mode'  => $request->payment_mode,
                'notes'         => $request->notes,
                'photos'        => $photos,
                'status'        => 'pending',
                'company_code'  => $user->company_code
            ]);
        });

        $user = User::find($expense->user_id);

        if ($user) {

            History::create([
                'user_id' => $user->id,
                'description' => $user->name .
                    ' added new expense "' .
                    $expense->title .
                    '" on ' .
                    now()->toDateTimeString()
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Expense created successfully',
            'data' => $expense
        ]);
    }

    /**
     * Get Expense By ID
     */
    public function show($id)
    {
        $expense = Expense::find($id);

        if (!$expense) {

            return response()->json([
                'status' => false,
                'message' => 'Expense not found'
            ],404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Expense fetched successfully',
            'data' => $expense
        ]);
    }

    /**
     * Get Expenses By User
     */
    public function getByUser($user_id)
    {
        $expenses = Expense::where('user_id',$user_id)
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Expenses fetched successfully',
            'data' => $expenses
        ]);
    }



    /**
     * Update Expense
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'            => 'required|exists:expenses,id',
            'title'         => 'required|string|max:255',
            'amount'        => 'required|numeric',
            'category'      => 'required|string|max:255',
            'expense_date'  => 'required|date',
            'payment_mode'  => 'required|string|max:100',
            'notes'         => 'nullable|string',
            'status'        => 'nullable|in:pending,approved,rejected',
            'photos.*'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $expense = Expense::findOrFail($request->id);

        DB::transaction(function () use ($request, $expense) {

            $photos = $expense->photos ?? [];

            if ($request->hasFile('photos')) {

                $photos = [];

                foreach ($request->file('photos') as $photo) {

                    $filename = time().'_'.uniqid().'.'.$photo->getClientOriginalExtension();

                    $photo->move(public_path('expense_images'), $filename);

                    $photos[] = 'expense_images/'.$filename;
                }
            }

            $expense->update([
                'title'         => $request->title,
                'amount'        => $request->amount,
                'category'      => $request->category,
                'expense_date'  => $request->expense_date,
                'payment_mode'  => $request->payment_mode,
                'notes'         => $request->notes,
                'photos'        => $photos,
                'status'        => $request->status ?? $expense->status
            ]);
        });

        $user = User::find($expense->user_id);

        if ($user) {

            History::create([
                'user_id' => $user->id,
                'description' => $user->name .
                    ' updated expense "' .
                    $expense->title .
                    '" on ' .
                    now()->toDateTimeString()
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Expense updated successfully',
            'data' => $expense->fresh()
        ]);
    }

    /**
     * Delete Expense
     */
    public function destroy($id)
    {
        $expense = Expense::find($id);

        if (!$expense) {
            return response()->json([
                'status' => false,
                'message' => 'Expense not found'
            ],404);
        }

        $user = User::find($expense->user_id);

        if ($user) {

            History::create([
                'user_id' => $user->id,
                'description' => $user->name .
                    ' deleted expense "' .
                    $expense->title .
                    '" on ' .
                    now()->toDateTimeString()
            ]);
        }

        $expense->delete();

        return response()->json([
            'status' => true,
            'message' => 'Expense deleted successfully'
        ]);
    }

    /**
     * Change Expense Status
     */
    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id'=>'required|exists:expenses,id',
            'status'=>'required|in:pending,approved,rejected'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
            ],422);
        }

        $expense = Expense::findOrFail($request->id);

        $expense->update([
            'status'=>$request->status
        ]);

        return response()->json([
            'status'=>true,
            'message'=>'Expense status updated successfully',
            'data'=>$expense
        ]);
    }


}







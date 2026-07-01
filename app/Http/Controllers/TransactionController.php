<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DataTables;

class TransactionController extends Controller
{
    // List all transactions
    
    
   public function index()
    {
        return view('admin.transactions.index');
    }

  public function getTransactions(Request $request)
{
    if ($request->ajax()) {
        $query = Transaction::with(['invoice', 'user'])->latest();

        // Apply filter if status is selected
        if (!empty($request->status)) {
            $query->where('status', $request->status);
        }

        return DataTables::of($query)
            ->addIndexColumn()
              ->editColumn('invoice_id', function ($row) {
                return 'Invoice#' . ($row->invoice_id);
            })
            ->editColumn('status', function ($row) {
                return match ($row->status) {
                    'paid' => '<span class="badge bg-success">Paid</span>',
                    'unpaid' => '<span class="badge bg-danger">Unpaid</span>',
                    'overdue' => '<span class="badge bg-warning text-dark">Overdue</span>',
                    default => '<span class="badge bg-secondary">Unknown</span>',
                };
            })
            ->rawColumns(['status'])
            ->make(true);
    }
}


  

    // Store new transaction
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invoice_id' => 'required|exists:invoices,id',
            'user_id' => 'required|exists:users,id',
            'customer_name' => 'required|string',
            'date' => 'required|date',
            'status' => 'nullable|in:paid,pending,failed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $transaction = Transaction::create($request->only([
            'invoice_id', 'user_id', 'customer_name', 'date', 'status'
        ]));

        return response()->json(['message' => 'Transaction created successfully', 'data' => $transaction]);
    }

    // Show single transaction
    public function show($id)
    {
        $transaction = Transaction::with(['invoice', 'user'])->findOrFail($id);
        return response()->json($transaction);
    }

    // Update transaction
    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'customer_name' => 'nullable|string',
            'date' => 'nullable|date',
            'status' => 'nullable|in:paid,pending,failed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $transaction->update($request->only(['customer_name', 'date', 'status']));

        return response()->json(['message' => 'Transaction updated successfully', 'data' => $transaction]);
    }

    // Delete transaction
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return response()->json(['message' => 'Transaction deleted successfully']);
    }

    // Change status
public function changeStatus(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id' => 'required|exists:transactions,id',
      'status' => 'required|in:paid,unpaid,overdue'

    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    $transaction = Transaction::findOrFail($request->id);
    $transaction->status = $request->status;
    $transaction->save();

    return response()->json([
        'message' => 'Transaction status updated',
        'data' => $transaction
    ]);
}


    // List transactions by user_id
    public function getByUser($user_id)
    {
        $transactions = Transaction::with(['invoice'])
            ->where('user_id', $user_id)
            ->get();

        return response()->json($transactions);
    }
    public function totalCollectionByUser(Request $request)
{
    $validator = Validator::make($request->all(), [
        'user_id' => 'required|exists:users,id'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    $user_id = $request->query('user_id');

    // All paid transactions for the user
    $transactions = Transaction::with('invoice')
        ->where('user_id', $user_id)
        ->where('status', 'paid')
        ->get();

    // Total collection from all paid transactions
    $totalCollection = $transactions->sum(function ($txn) {
        return $txn->invoice ? $txn->invoice->total_amount : 0;
    });

    // Current week
    $startOfWeek = Carbon::now()->startOfWeek();
    $endOfWeek = Carbon::now()->endOfWeek();

    $currentWeekTransactions = $transactions->filter(function ($txn) use ($startOfWeek, $endOfWeek) {
        return $txn->date >= $startOfWeek->toDateString() && $txn->date <= $endOfWeek->toDateString();
    });

    $currentWeekCollection = $currentWeekTransactions->sum(function ($txn) {
        return $txn->invoice ? $txn->invoice->total_amount : 0;
    });

    return response()->json([
        'user_id' => $user_id,
        'total_collection' => $totalCollection,
        'paid_transactions_count' => $transactions->count(),
        'current_week_collection' => $currentWeekCollection,
        'current_week_transactions_count' => $currentWeekTransactions->count()
    ]);
}
}

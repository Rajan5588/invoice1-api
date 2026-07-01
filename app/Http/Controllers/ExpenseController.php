<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use DataTables;

class ExpenseController extends Controller
{
    public function index(Request $request, $company_slug)
    {
        if ($request->ajax()) {
            $data = Expense::where('company_code', $company_slug)->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('photos', function ($row) {
                    if (!$row->photos || count($row->photos) == 0) {
                        return '<span class="text-muted">No Image</span>';
                    }

                    $html = '';
                    foreach ($row->photos as $photo) {
                        $html .= '<img src="'.asset('assets/expenses/'.$photo).'" 
                                  class="rounded border me-1 mb-1" 
                                  style="width:50px; height:50px; object-fit:cover;">';
                    }
                    return $html;
                })
                ->addColumn('action', function ($row) use ($company_slug) {
                    $editBtn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-sm btn-info editExpense"><i class="ri-edit-fill"></i></a>';
                    $deleteBtn = '<a href="javascript:void(0)" data-url="'.route("admin-expenses.destroy", $row->id).'" class="btn btn-sm btn-danger sa-warning"><i class="ri-delete-bin-fill"></i></a>';
 $status = '
                        <select class="form-select form-select-sm changeStatus" data-id="'.$row->id.'">
                            <option value="pending" '.($row->status=="pending"?"selected":"").'>Pending</option>
                            <option value="approved" '.($row->status=="approved"?"selected":"").'>Approved</option>
                            <option value="rejected" '.($row->status=="rejected"?"selected":"").'>Rejected</option>
                        </select>';

                    return $editBtn . ' ' . $deleteBtn . ' ' . $status;
                })
                ->editColumn('expense_date', fn($row) => $row->expense_date->format('d-m-Y'))
                ->rawColumns(['action','photos'])
                ->make(true);
        }

        return view('admin.Expences.index', compact('company_slug'));
    }

    public function store(Request $request, $company_slug)
    {
        $data = $request->validate([
            'title'        => 'required|string',
            'amount'       => 'required|numeric',
            'category'     => 'required|string',
            'expense_date' => 'required|date',
            'payment_mode' => 'required|string',
            'notes'        => 'nullable|string',
            'photos.*'     => 'image|max:2048'
        ]);

        $photos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                // Store in public/assets/expenses
                $filename = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('assets/expenses'), $filename);
                $photos[] = $filename;
            }
        }

        $data['photos']       = $photos;
        $data['company_code'] = $company_slug;

        Expense::create($data);

        return response()->json(['success' => 'Expense added successfully.']);
    }

    public function edit($company_slug, Expense $expense)
    {
        return response()->json($expense);
    }

    public function update(Request $request, $company_slug, Expense $expense)
    {
        $data = $request->validate([
            'title'        => 'required|string',
            'amount'       => 'required|numeric',
            'category'     => 'required|string',
            'expense_date' => 'required|date',
            'payment_mode' => 'required|string',
            'notes'        => 'nullable|string',
        ]);

        $expense->update($data);

        return response()->json(['success' => 'Expense updated successfully.']);
    }
    public function destroy($company_slug, $id)
{
    // Find the expense by ID (or throw 404 if not found)
    $expense = Expense::findOrFail($id);

    // Delete the record
    $expense->delete();

    return response()->json([
        'success' => true,
        'message' => 'Expense deleted successfully.'
    ]);
}





    public function updateStatus(Request $request, $company_slug, Expense $expense)
    {
        $expense->update(['status' => $request->status]);
        return response()->json(['success' => 'Status updated successfully.']);
    }
}

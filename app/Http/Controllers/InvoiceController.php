<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\Invoice;
use App\Models\RolesPermission;
use Yajra\DataTables\DataTables;
use App\Models\InvoiceItem;
use App\Models\InvoiceAdditionalCharge;
use App\Models\User;
use App\Models\History;
use App\Models\Customer;
use App\Models\Item;
use App\Models\BillingDetail;
use App\Models\ShippingDetail;
use App\Models\BusinessProfile;
use App\Models\GstDetail;



class InvoiceController extends Controller
{
    // Index page
//     public function index(Request $request, $company_slug)
//     {
//       $user = Auth::user();

// if ($user->is_admin == 'admin') {
//     $permissions = [
//         'view' => 'all',
//         'edit' => 1,
//         'destroy' => 1,
//     ];
// } else {
//     $rolePerm = RolesPermission::where('role_id', $user->role_id)->first();

//     $permissions = [
//         'view' => $rolePerm->invoices_view ?? 'own',
//         'edit' => $rolePerm->invoices_edit ?? 0,
//         'destroy' => $rolePerm->invoices_delete ?? 0, // note: you were using 'destroy' but column is 'invoices_delete'
//     ];
// }


//         return view('admin.invoices.index', compact('company_slug', 'permissions'));
//     }


public function index(Request $request, $company_slug)
{
    $user = Auth::user();

    if ($user->is_admin == 'admin') {
        $permissions = [
            'view'   => 'all',
            'add'    => 1,
            'edit'   => 1,
            'delete' => 1,
        ];
    } else {
        $rolePerm = RolesPermission::where('role_id', $user->role_id)->first();

        $permissions = [
            'view'   => $rolePerm->invoices_view ?? 0,   // all | company | own | 0
            'add'    => $rolePerm->invoices_add ?? 0,
            'edit'   => $rolePerm->invoices_edit ?? 0,
            'delete' => $rolePerm->invoices_delete ?? 0,
        ];
    }

    return view('admin.invoices.index', compact('company_slug', 'permissions'));
}


//  public function getInvoices($company_slug, Request $request)
// {
//     $user = Auth::user();

//     if ($user->is_admin == 'admin') {
//         $permissions = [
//             'view' => 'all',
//             'edit' => 1,
//             'destroy' => 1,
//         ];
//     } else {
//         $rolePerm = RolesPermission::where('role_id', $user->role_id)->first();

//         // fallback to safe defaults
//         $permissions = [
//             'view' => $rolePerm->invoices_view ?? 'own',
//             'edit' => $rolePerm->invoices_edit ?? 0,
//             'destroy' => $rolePerm->invoices_delete ?? 0, // ✅ correct column name
//         ];
//     }

//  if ($request->ajax()) {
//     try {
//         $query = Invoice::with('customer')->latest();

//         if ($permissions['view'] === 'own') {
//             $query->where('user_id', $user->id);
//         } elseif ($permissions['view'] === 'company') {
//             $query->where('company_code', $company_slug);
//         }

//         $data = $query->get();

//         return DataTables::of($data)
//             ->addIndexColumn()
//             ->editColumn('id', fn($row) => 'invoice#' . $row->id)
//             ->addColumn('action', function ($row) use ($permissions) {
//     $showUrllbill1 = route('invoices.bill1', $row->id);
//     $showUrllbill2 = route('invoices.bill2', $row->id);

//     $buttons = '';

//     if ($permissions['view'] || $permissions['edit']) {
//         $buttons .= '<a href="'.route('invoices.show', $row->id).'" class="btn btn-sm btn-info"><i class="ri-eye-fill"></i></a>';
//         if ($permissions['edit']) {
//             $buttons .= '<a href="'.route('invoices.edit', $row->id).'" class="btn btn-sm btn-success"><i class="ri-edit-fill"></i></a>';
//         }
//     }

//     if ($permissions['destroy']) {
//         $buttons .= '<button type="button" class="btn btn-sm btn-danger deleteInvoice" data-id="'.$row->id.'"><i class="ri-delete-bin-fill"></i></button>';
//     }

//     // ✅ Add bill1 and bill2 buttons correctly
//     $buttons .= '<a href="'.$showUrllbill1.'" class="btn btn-sm btn-info">Temp 1</a>';
//     $buttons .= '<a href="'.$showUrllbill2.'" class="btn btn-sm btn-info">Temp 2</a>';

//     return $buttons;
// })

//             ->editColumn('total_amount', fn($row) => '₹' . number_format($row->total_amount, 2))
//             ->editColumn('amount_received', fn($row) => '₹' . number_format($row->amount_received, 2))
//             ->rawColumns(['action'])
//             ->make(true);

//     } catch (\Exception $e) {
//         return response()->json([
//             'error' => $e->getMessage()
//         ], 500);
//     }
// }

// }

public function getInvoices($company_slug, Request $request)
{
    $user = Auth::user();

    if ($user->is_admin == 'admin') {
        $permissions = [
            'view'   => 'all',
            'add'    => 1,
            'edit'   => 1,
            'delete' => 1,
        ];
    } else {
        $rolePerm = RolesPermission::where('role_id', $user->role_id)->first();

        $permissions = [
            'view'   => $rolePerm->invoices_view ?? 0,
            'add'    => $rolePerm->invoices_add ?? 0,
            'edit'   => $rolePerm->invoices_edit ?? 0,
            'delete' => $rolePerm->invoices_delete ?? 0,
        ];
    }

    if ($request->ajax()) {
        try {
            $query = Invoice::with('customer')->latest();

            // Apply "view" rules
            if ($permissions['view'] === 'own') {
                $query->where('user_id', $user->id);
            } elseif ($permissions['view'] === 'company') {
                $query->where('company_code', $company_slug);
            } elseif ($permissions['view'] === 0) {
                return DataTables::of(collect([]))->make(true); // no access
            }

            $data = $query->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('id', fn($row) => 'invoice#' . $row->id)
                ->addColumn('action', function ($row) use ($permissions) {
                    $buttons = '';

                    // 👁 View
                    if ($permissions['view'] !== 0) {
                        $buttons .= '<a href="'.route('invoices.show', $row->id).'" class="btn btn-sm btn-info">
                                        <i class="ri-eye-fill"></i></a>';
                    }

                    // ✏️ Edit
                    if ($permissions['edit'] == 1) {
                        $buttons .= '<a href="'.route('invoices.edit', $row->id).'" class="btn btn-sm btn-success">
                                        <i class="ri-edit-fill"></i></a>';
                    }

                    // 🗑 Delete
                    if ($permissions['delete'] == 1) {
                        $buttons .= '<button type="button" class="btn btn-sm btn-danger deleteInvoice" 
                                        data-id="'.$row->id.'"><i class="ri-delete-bin-fill"></i></button>';
                    }

                    // 📄 Bills (only if they can at least "view")
                    if ($permissions['view'] !== 0) {
                        $buttons .= '<a href="'.route('invoices.bill1', $row->id).'" class="btn btn-sm btn-info">Temp 1</a>';
                        $buttons .= '<a href="'.route('invoices.bill2', $row->id).'" class="btn btn-sm btn-info">Temp 2</a>';
                    }

                    return $buttons;
                })
                ->editColumn('total_amount', fn($row) => '₹' . number_format($row->total_amount, 2))
                ->editColumn('amount_received', fn($row) => '₹' . number_format($row->amount_received, 2))
                ->rawColumns(['action'])
                ->make(true);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}


     public function create($company_slug)
    {
        $customers = Customer::all();   // ✅ Fetch customers
        $items     = Item::with('pricings')->get(); // ✅ Fetch items with price

        return view('admin.invoices.create', compact('customers', 'items'));
    }
    


    public function edit($company_slug,$id)
{
    // Load invoice with related data
    $invoice = Invoice::with([
        'items.item.details',
        'charges',
        'transactions',
        'billingDetail',
        'shippingDetail',
        'gstDetails'
    ])->findOrFail($id);

    $customers = Customer::all();
    $items = Item::with('pricings')->get();

    return view('admin.invoices.edit', compact('invoice', 'customers', 'items'));
}

  
public function store($company_slug,Request $request)
{
    $validator = Validator::make($request->all(), [
        'user_id' => 'required|exists:users,id',
        'customer_id' => 'nullable|exists:customers,id',
        'customer_name' => 'nullable|string',
        'customer_number' => 'nullable|string',
        'payment_type' => 'required|string',
        'items' => 'required|array',
        'items.*.item_id' => 'required|exists:items,id',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.price' => 'required|numeric|min:0',
        'charges' => 'nullable|array',
        'charges.*.charge_name' => 'required|string',
        'charges.*.price' => 'required|numeric|min:0',
        'receiver_name' => 'required|string',
        'receiver_email' => 'nullable|email',
        'receiver_phone' => 'nullable|string',
        'receiver_state_code' => 'nullable|string',
        'receiver_address' => 'nullable|string',
        'consignee_name' => 'required|string',
        'consignee_email' => 'nullable|email',
        'consignee_phone' => 'nullable|string',
        'consignee_state_code' => 'nullable|string',
        'consignee_address' => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors(), 'message' => 'Validation failed'], 422);
    }

    // 🔹 Auto-fill customer_name & customer_number if null
    if (empty($request->customer_name)) {
        $request->merge([
            'customer_name' => $request->consignee_name,
        ]);
    }

    if (empty($request->customer_number)) {
        $request->merge([
            'customer_number' => $request->consignee_phone,
            
        ]);
    }
       $request->merge(['company_code' => $company_slug]);
    $invoice = DB::transaction(function () use ($request) {
   
        // Create Invoice
        $invoice = Invoice::create($request->only([
            'user_id','customer_id','customer_name','customer_number',
            'payment_type','discount_percent','discount_amount',
            'round_off','total_amount','amount_received','note','company_code'
        ]));

        // Billing Details
        BillingDetail::create([
            'invoice_id' => $invoice->id,
            'name' => $request->receiver_name,
            'email' => $request->receiver_email,
            'phone' => $request->receiver_phone,
            'state' => $request->receiver_state_code,
            'address' => $request->receiver_address ?? null,
            'company_code'=>$company_slug ?? null
        ]);

        // Shipping Details
        ShippingDetail::create([
            'invoice_id' => $invoice->id,
            'name' => $request->consignee_name,
            'email' => $request->consignee_email,
            'phone' => $request->consignee_phone,
            'state' => $request->consignee_state_code,
            'address' => $request->consignee_address ?? null,
            'company_code'=>$company_slug ?? null 
        ]);

        // Invoice Items & GST
        foreach ($request->items as $item) {
            $total = $item['quantity'] * $item['price'];

            $invoiceItem = $invoice->items()->create([
                'item_id' => $item['item_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'price_type' => $item['price_type'] ?? 'sales',
                'total' => $total
            ]);

            $qty = $item['quantity'];
            $price = $item['price'];
            $gstPercent = $item['gst'] ?? 0;
            $isIntraState = $request->receiver_state_code == $request->consignee_state_code;
            $gstAmount = $price * $qty * $gstPercent / 100;

            GstDetail::create([
                'invoice_id' => $invoice->id,
                'item_id' => $item['item_id'],
                'price' => $price,
                'quantity' => $qty,
                'gst_percent' => $gstPercent,
                'cgst' => $isIntraState ? $gstAmount/2 : 0,
                'sgst' => $isIntraState ? $gstAmount/2 : 0,
                'igst' => $isIntraState ? 0 : $gstAmount,
                'without_gst' => $price * $qty,
                'gst_amount' => $gstAmount,
                'total' => $price * $qty + $gstAmount
            ]);
        }

        // Charges
        if ($request->has('charges')) {
            foreach ($request->charges as $charge) {
                $invoice->charges()->create($charge);
            }
        }

        // Transaction
        $invoice->transactions()->create([
            'user_id' => $request->user_id,
            'customer_name' => $request->customer_name,
                'company_code'=>$company_slug ?? null,
            'date' => now()->toDateString(),
            'status' => 'paid',
        ]);

        return $invoice->load('items.item','charges','transactions','billingDetail','shippingDetail','gstDetails');
    });

    // Log history
    $user = auth()->user();
    if ($user) {
        History::create([
            'user_id' => $user->id,
            'description' => $user->name . ' created a new invoice #' . $invoice->id . ' on ' . now()->toDateTimeString()
        ]);
    }

    return response()->json(['message' => 'Invoice created successfully', 'data' => $invoice], 201);
}


    // Datatable data
    // public function getInvoices($company_slug,Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = Invoice::with('customer')->latest();

    //         return DataTables::of($data)
    //             ->addIndexColumn()
    //              ->editColumn('id', function ($row) {
    //                 return 'invoice#' . $row->id;
    //             })
    //             ->addColumn('action', function ($row) {
    //                 $showUrl = route('invoices.show', $row->id);
    //                 $editUrl = route('invoices.edit', $row->id);
    //                 $showUrllbill1 = route('invoices.bill1', $row->id);
    //                  $showUrllbill2 = route('invoices.bill2', $row->id);
    //                 return ' <a href="'.$showUrl.'" class="btn btn-sm btn-info">
    //                     <i class="ri-eye-fill"></i>
    //                 </a>
    //                 <a href="'.$editUrl.'" class="btn btn-sm btn-success">
    //                     <i class="ri-edit-fill"></i>
    //                 </a>
    //                 <a href="'.$showUrllbill1.'" class="btn btn-sm btn-info">
    //                   temp 1
    //                 </a>
    //                  <a href="'.$showUrllbill2.'" class="btn btn-sm btn-info">
    //                   temp 2
    //                 </a>
    //                 <button type="button" class="btn btn-sm btn-danger deleteInvoice" data-id="'.$row->id.'">
    //         <i class="ri-delete-bin-fill"></i>
    //     </button>';
    //             })
    //             ->editColumn('total_amount', function ($row) {
    //                 return '₹' . number_format($row->total_amount, 2);
    //             })
    //             ->editColumn('amount_received', function ($row) {
    //                 return '₹' . number_format($row->amount_received, 2);
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }
    // }

    // Show invoice details
    public function show($company_slug,$id)
    {
        $invoice = Invoice::with(['items', 'charges', 'customer', 'transactions'])->findOrFail($id);
        return view('admin.invoices.show', compact('invoice'));
    }
    
   public function showbill1($company_slug,$id)
{
    // Fetch invoice with all related data
    $invoice = Invoice::with([
         'items.item.details','items.item.pricings',
        'charges',
        'transactions',
        'billingDetail',
        'shippingDetail',
        'gstDetails',
        'user',
        'customer'
    ])->findOrFail($id);

    // Current logged-in user
    $user = auth()->user();

    // That user's business profile
    $businessProfile = BusinessProfile::with('user')->where('user_id', $user->id)->first();

    return view('admin.invoices.bill', compact('invoice', 'businessProfile'));
}
    
public function showbill2($company_slug,$id)
{
    // Fetch invoice with all related data
    $invoice = Invoice::with([
         'items.item.details','items.item.pricings',
        'charges',
        'transactions',
        'billingDetail',
        'shippingDetail',
        'gstDetails',
        'user',
        'customer'
    ])->findOrFail($id);

    // Current logged-in user
    $user = auth()->user();

    // That user's business profile
    $businessProfile = BusinessProfile::with('user')->where('user_id', $user->id)->first();

    return view('admin.invoices.bill2', compact('invoice', 'businessProfile'));
}



    

public function update($company_slug,Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'user_id' => 'required|exists:users,id',
        'customer_id' => 'nullable|exists:customers,id',
        'customer_name' => 'nullable|string',
        'payment_type' => 'required|string',
        'items' => 'required|array',
        'items.*.item_id' => 'required|exists:items,id',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.price' => 'required|numeric|min:0',
        'charges' => 'nullable|array',
        'charges.*.charge_name' => 'required|string',
        'charges.*.price' => 'required|numeric|min:0',
        'receiver_name' => 'required|string',
        'consignee_name' => 'required|string',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }
   

    DB::transaction(function () use ($request, $id) {
        $invoice = Invoice::with(['items', 'charges', 'transactions', 'billingDetail', 'shippingDetail'])->findOrFail($id);

        // Fill customer info from consignee if empty
        if(!$request->customer_name){
            $request->merge([
                'customer_name' => $request->consignee_name,
                'customer_number' => $request->consignee_phone,
            ]);
        }

        // Update invoice
        $invoice->update($request->only([
            'user_id','customer_id','customer_name','customer_number',
            'payment_type','discount_percent','discount_amount',
            'round_off','total_amount','amount_received','note'
        ]));

        // Update Billing
        $invoice->billingDetail()->updateOrCreate(
            ['invoice_id' => $invoice->id],
            [
                'name' => $request->receiver_name,
                'email' => $request->receiver_email,
                'phone' => $request->receiver_phone,
                'state' => $request->receiver_state_code,
                'address' => $request->receiver_address,
            ]
        );

        // Update Shipping
        $invoice->shippingDetail()->updateOrCreate(
            ['invoice_id' => $invoice->id],
            [
                'name' => $request->consignee_name,
                'email' => $request->consignee_email,
                'phone' => $request->consignee_phone,
                'state' => $request->consignee_state_code,
                'address' => $request->consignee_address,
            ]
        );

        // Refresh items & GST
        $invoice->items()->delete();
        $invoice->gstDetails()->delete();

        foreach ($request->items as $item) {
            $total = $item['quantity'] * $item['price'];
            $invoiceItem = $invoice->items()->create([
                'item_id' => $item['item_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'price_type' => $item['price_type'] ?? 'sales',
                'total' => $total
            ]);

            $qty = $item['quantity'];
            $price = $item['price'];
            $gstPercent = $item['gst'] ?? 0;
            $isIntraState = $request->receiver_state_code == $request->consignee_state_code;
            $gstAmount = $price * $qty * $gstPercent / 100;

            GstDetail::create([
                'invoice_id' => $invoice->id,
                'item_id' => $item['item_id'],
                'price' => $price,
                'quantity' => $qty,
                'gst_percent' => $gstPercent,
                'cgst' => $isIntraState ? $gstAmount/2 : 0,
                'sgst' => $isIntraState ? $gstAmount/2 : 0,
                'igst' => $isIntraState ? 0 : $gstAmount,
                'without_gst' => $price * $qty,
                'gst_amount' => $gstAmount,
                'total' => $price * $qty + $gstAmount
            ]);
        }

        // Refresh Charges
        $invoice->charges()->delete();
        if ($request->has('charges')) {
            foreach ($request->charges as $charge) {
                $invoice->charges()->create($charge);
            }
        }

        // Update Transactions
        $invoice->transactions()->updateOrCreate(
            ['invoice_id' => $invoice->id],
            [
                'user_id' => $request->user_id,
                'customer_name' => $request->customer_name,
                'date' => now()->toDateString(),
                'status' => 'paid',
            ]
        );
    });

    // Log History
    $user = User::find($request->user_id);
    if ($user) {
        History::create([
            'user_id' => $user->id,
            'description' => $user->name . ' updated invoice #' . $id . ' on ' . now()->toDateTimeString()
        ]);
    }

    return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully!');
}

public function destroy(Request $request)
{
    $id     = $request->query('id');
  
    $action = $request->query('action'); // permanent_destroy, temporary_destroy, restore

    $invoice = Invoice::find($id);

    if (!$invoice) {
        return response()->json(['message' => 'Invoice not found'], 404);
    }

    $user = Auth::user();

    if ($action === 'permanent_destroy') {
        // delete relations if needed
        $invoice->items()->delete();
        $invoice->charges()->delete();
        $invoice->transactions()->delete();

        $invoice->delete();

        if ($user) {
            History::create([
                'user_id'     => $user->id,
                'description' => $user->name . ' permanently deleted invoice #' . $id . ' on ' . now()->toDateTimeString(),
            ]);
        }

        return response()->json(['message' => 'Invoice permanently deleted']);
    }

    if ($action === 'temporary_destroy') {
        $invoice->recycle_status = 'temporary_destroy';
        $invoice->save();

        if ($user) {
            History::create([
                'user_id'     => $user->id,
                'description' => $user->name . ' temporarily deleted invoice #' . $id,
            ]);
        }

        return response()->json(['message' => 'Invoice temporarily deleted']);
    }

    if ($action === 'restore') {
        $invoice->recycle_status = 'none';
        $invoice->save();

        if ($user) {
            History::create([
                'user_id'     => $user->id,
                'description' => $user->name . ' restored invoice #' . $id,
            ]);
        }

        return response()->json(['message' => 'Invoice restored']);
    }

    return response()->json(['message' => 'Invalid action'], 400);
}




}

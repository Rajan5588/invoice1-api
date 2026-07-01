<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use App\Models\History;
use App\Models\User;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\RolesPermission;

class ItemController extends Controller
{
    public function index($company_slug)
    {
        $user = Auth::user();

        if ($user->is_admin === 'admin') {
            $permissions = [
                'view'   => 'all',
                'add'    => 1,
                'edit'   => 1,
                'delete' => 1,
            ];
        } else {
            $rolePerm = RolesPermission::where('role_id', $user->role_id)->first();

            $permissions = [
                'view'   => $rolePerm->items_view ?? 0,   // all | company | own | 0
                'add'    => $rolePerm->items_add ?? 0,
                'edit'   => $rolePerm->items_edit ?? 0,
                'delete' => $rolePerm->items_delete ?? 0,
            ];
        }

        $categories = ItemCategory::all();
        return view('admin.items.index', compact('categories', 'company_slug', 'permissions'));
    }

    public function get($company_slug, Request $request)
    {
        $user = Auth::user();

        if ($user->is_admin === 'admin') {
            $permissions = [
                'view'   => 'all',
                'add'    => 1,
                'edit'   => 1,
                'delete' => 1,
            ];
        } else {
            $rolePerm = RolesPermission::where('role_id', $user->role_id)->first();

            $permissions = [
                'view'   => $rolePerm->items_view ?? 0,
                'add'    => $rolePerm->items_add ?? 0,
                'edit'   => $rolePerm->items_edit ?? 0,
                'delete' => $rolePerm->items_delete ?? 0,
            ];
        }

        if ($request->ajax()) {
            $query = Item::with('user')->select(['id', 'item_name', 'user_id', 'company_code', 'created_at']);

            // 🔹 Restrict according to permissions
            if ($permissions['view'] === 'own') {
                $query->where('user_id', $user->id);
            } elseif ($permissions['view'] === 'company') {
                $query->where('company_code', $company_slug);
            } elseif ($permissions['view'] === 0) {
                return DataTables::of(collect([]))->make(true);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('created_at', fn($row) => $row->created_at ? $row->created_at->format('d-m-y h:i A') : '')
                ->addColumn('user_name', fn($row) => $row->user ? $row->user->name : 'N/A')
                ->addColumn('action', function ($row) use ($permissions) {
                    $buttons = '';

                    // 👁 View
                    if ($permissions['view'] !== 0) {
                        $buttons .= '<a href="'.route('items.show', $row->id).'" class="btn btn-sm btn-info">
                                        <i class="ri-eye-line"></i>
                                     </a>';
                    }

                    // ✏️ Edit
                    if ($permissions['edit'] == 1) {
                        $buttons .= '<a href="'.route('items.edit', $row->id).'" class="btn btn-sm btn-success">
                                        <i class="ri-edit-line"></i>
                                     </a>';
                    }

                    // 🗑 Delete
                    if ($permissions['delete'] == 1) {
                        $buttons .= '<button type="button" class="btn btn-sm btn-danger deleteItem" data-id="'.$row->id.'">
                                        <i class="ri-delete-bin-fill"></i>
                                     </button>';
                    }

                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    // public function index($company_slug)
    // {
    //     $categories = ItemCategory::all();
    //     return view('admin.items.index',compact('categories'));
    // }
    
//   public function store($company_slug,Request $request)
// {

//     $validator = Validator::make($request->all(), [
//         'id' => 'nullable|exists:items,id', // check if update
//         'item_name' => 'required|string',
//         'user_id' => 'required|exists:users,id',
//         'item_category_id' => 'nullable|exists:item_categories,id',
//         'pricings.*.unit' => 'nullable|string',
//         'stocks.*.opening_stock' => 'nullable',
//         'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
//     ]);

//     if ($validator->fails()) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Validation failed',
//             'errors' => $validator->errors()
//         ], 422);
//     }

//     $item = DB::transaction(function() use ($request) {

//         // ✅ If ID exists → update, else create new
//         if ($request->id) {
//             $item = Item::findOrFail($request->id);
//             $item->update($request->only('item_name','user_id'));

//             // clear old relations before re-inserting
//             $item->pricings()->delete();
//             $item->stocks()->delete();
//             $item->details()->delete();
//             $item->otherImages()->delete();

//         } else {
//             $item = Item::create($request->only('item_name','user_id'));
//         }

//         // Pricings
//         if ($request->has('pricings')) {
//             foreach ($request->pricings as $pricing) {
//                 $item->pricings()->create($pricing);
//             }
//         }

//         // Stocks
//         if ($request->has('stocks')) {
//             foreach ($request->stocks as $stock) {
//                 $stock['item_name'] = $item->item_name;
//                 $item->stocks()->create($stock);
//             }
//         }

//         // Images
//         if ($request->hasFile('images')) {
//             foreach ($request->file('images') as $image) {
//                 $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
//                 $image->move(public_path('item_other_images'), $filename);

//                 $item->otherImages()->create([
//                     'image_path' => 'item_other_images/' . $filename
//                 ]);
//             }
//         }

//         // Details
//         $item->details()->create([
//             'item_id' => $item->id,
//             'item_category_id' => $request->item_category_id,
//             'item_description' => $request->item_description ?? null,
//             'show_online_store' => $request->show_online_store ?? false,
//             'user_id' => $request->user_id
//         ]);

//         return $item->load('pricings', 'stocks', 'otherImages', 'details');
//     });

//     // Log history
//     $user = User::find($item->user_id);
//     if ($user) {
//         $description = $user->name .' '. $item->item_name .' ' 
//                       . ($request->id ? 'Item updated' : 'New Item added') 
//                       . ' on ' . now()->toDateTimeString();

//         History::create([
//             'user_id' => $user->id,
//             'description' => $description
//         ]);
//     }

//     return response()->json([
//         'message' => $request->id ? 'Item updated successfully' : 'Item created successfully',
//         'data' => $item
//     ]);
// }
public function store($company_slug, Request $request)
{
    $validator = Validator::make($request->all(), [
        'id'                => 'nullable|exists:items,id', // check if update
        'item_name'         => 'required|string',
        'user_id'           => 'required|exists:users,id',
        'item_category_id'  => 'nullable|exists:item_categories,id',

        // Pricings (validate only if provided)
        'pricings'          => 'nullable|array',
        'pricings.*.unit'   => 'nullable|string',

        // Stocks (validate only if provided)
        'stocks'                   => 'nullable|array',
        'stocks.*.opening_stock'   => 'nullable|numeric',

        // Images (validate only if provided)
        'images'            => 'nullable|array',
        'images.*'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors'  => $validator->errors()
        ], 422);
    }

    // ✅ Only items table gets company_code
    $request->merge(['company_code' => $company_slug]);

    $item = DB::transaction(function() use ($request) {
        // ✅ Update existing item
        if ($request->id) {
            $item = Item::findOrFail($request->id);
            $item->update($request->only('item_name','user_id','company_code'));

            // clear old relations before re-inserting
            $item->pricings()->delete();
            $item->stocks()->delete();
            $item->details()->delete();
            $item->otherImages()->delete();
        } 
        // ✅ Create new item
        else {
            $item = Item::create($request->only('item_name','user_id','company_code'));
        }

        // Pricings (only if provided)
        if ($request->has('pricings') && !empty($request->pricings)) {
            foreach ($request->pricings as $pricing) {
                $item->pricings()->create($pricing);
            }
        }

        // Stocks (only if provided)
       // Stocks (only if provided and valid)
if ($request->has('stocks') && !empty($request->stocks)) {
    foreach ($request->stocks as $stock) {
        // ❌ Skip if opening_stock is null or empty
        if (empty($stock['opening_stock'])) {
            continue;
        }

        $stock['item_name'] = $item->item_name;
        $item->stocks()->create($stock);
    }
}


        // Images (only if provided)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('item_other_images'), $filename);

                $item->otherImages()->create([
                    'image_path' => 'item_other_images/' . $filename,
                ]);
            }
        }

        // Details (always store one details row)
        $item->details()->create([
            'item_id'          => $item->id,
            'item_category_id' => $request->item_category_id,
            'item_description' => $request->item_description ?? null,
            'show_online_store'=> $request->show_online_store ?? false,
            'user_id'          => $request->user_id,
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
            'user_id'     => $user->id,
            'description' => $description,
        ]);
    }

    return response()->json([
        'message' => $request->id ? 'Item updated successfully' : 'Item created successfully',
        'data'    => $item,
    ]);
}




//     public function get($company_slug,Request $request)
//     {
//         if ($request->ajax()) {
//             $data = Item::with('user')->select(['id', 'item_name', 'user_id', 'created_at']);

//             return DataTables::of($data)
//                 ->addIndexColumn()
//                 ->editColumn('created_at', function ($user) {
//                 return $user->created_at 
//                     ? $user->created_at->format('d-m-y h:i A') 
//                     : '';
//             })
//                 ->addColumn('user_name', function ($row) {
//                     return $row->user ? $row->user->name : 'N/A';
//                 })
//              ->addColumn('action', function ($row) {
//     return '
//         <a href="'.route('items.show', $row->id).'" class="btn btn-sm btn-info">
//             <i class="ri-eye-line"></i>
//         </a>
//         <a href="'.route('items.edit', $row->id).'" class="btn btn-sm btn-success">
//             <i class="ri-edit-line"></i>
//         </a>
//         <button type="button" class="btn btn-sm btn-danger deleteItem" data-id="'.$row->id.'">
//             <i class="ri-delete-bin-fill"></i>
//         </button>
//     ';
// })


//                 ->rawColumns(['action'])
//                 ->make(true);
//         }
//     }

    public function show($company_slug,$id)
    {
        $item = Item::with(['user', 'pricings', 'stocks', 'otherImages', 'details'])->findOrFail($id);
        return view('admin.items.show', compact('item'));
    }
    
    // Show edit form
public function edit($company_slug,$id)
{
    $item = Item::with(['details', 'pricings', 'stocks', 'otherImages'])->findOrFail($id);
    $categories = ItemCategory::all();
    return view('admin.items.edit', compact('item', 'categories'));
}

// Update item
// public function update($company_slug,Request $request, $id)
// {
//     $validator = Validator::make($request->all(), [
//         'item_name' => 'required|string',
//         'user_id' => 'required|exists:users,id',
//         'item_category_id' => 'nullable|exists:item_categories,id',
//         'pricings.*.unit' => 'nullable|string',
//         'stocks.*.opening_stock' => 'nullable|numeric',
//         'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
//     ]);

//     if ($validator->fails()) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Validation failed',
//             'errors' => $validator->errors()
//         ], 422);
//     }

//     $item = DB::transaction(function() use ($request, $id) {
//         $item = Item::findOrFail($id);
//         $item->update($request->only('item_name','user_id'));

//         // Delete old relations
//         $item->pricings()->delete();
//         $item->stocks()->delete();
//         $item->details()->delete();
//         $item->otherImages()->delete();

//         // Insert new pricings
//         if ($request->has('pricings')) {
//             foreach ($request->pricings as $pricing) {
//                 $item->pricings()->create($pricing);
//             }
//         }

//         // Insert new stocks
//         if ($request->has('stocks')) {
//             foreach ($request->stocks as $stock) {
//                 $stock['item_name'] = $item->item_name;
//                 $item->stocks()->create($stock);
//             }
//         }

//         // Upload new images
//         if ($request->hasFile('images')) {
//             foreach ($request->file('images') as $image) {
//                 $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
//                 $image->move(public_path('item_other_images'), $filename);

//                 $item->otherImages()->create([
//                     'image_path' => 'item_other_images/' . $filename
//                 ]);
//             }
//         }

//         // Update details
//         $item->details()->create([
//             'item_id' => $item->id,
//             'item_category_id' => $request->item_category_id,
//             'item_description' => $request->item_description ?? null,
//             'show_online_store' => $request->show_online_store ?? false,
//             'user_id' => $request->user_id
//         ]);

//         return $item->load('pricings','stocks','otherImages','details');
//     });

//     // Log history
//     $user = User::find($item->user_id);
//     if ($user) {
//         $description = $user->name .' updated item '. $item->item_name 
//                       .' on '. now()->toDateTimeString();
//         History::create([
//             'user_id' => $user->id,
//             'description' => $description
//         ]);
//     }

//     return response()->json([
//         'message' => 'Item updated successfully',
//         'data' => $item
//     ]);
// }

public function update($company_slug, Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'item_name'         => 'required|string',
        'user_id'           => 'required|exists:users,id',
        'item_category_id'  => 'nullable|exists:item_categories,id',
        'pricings'          => 'nullable|array',
        'pricings.*.unit'   => 'nullable|string',
        'stocks'            => 'nullable|array',
        'stocks.*.opening_stock' => 'nullable|numeric',
        'images'            => 'nullable|array',
        'images.*'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors'  => $validator->errors()
        ], 422);
    }

    $item = DB::transaction(function() use ($request, $id, $company_slug) {
        $item = Item::findOrFail($id);

        // ✅ also update company_code for consistency
        $item->update($request->only('item_name','user_id') + ['company_code' => $company_slug]);

        // Delete old relations
        $item->pricings()->delete();
        $item->stocks()->delete();
        $item->details()->delete();
        $item->otherImages()->delete();

        // ✅ Insert new pricings (only if provided)
        if ($request->has('pricings') && !empty($request->pricings)) {
            foreach ($request->pricings as $pricing) {
                $item->pricings()->create($pricing);
            }
        }

        // ✅ Insert new stocks (only if provided and opening_stock is valid)
        if ($request->has('stocks') && !empty($request->stocks)) {
            foreach ($request->stocks as $stock) {
                if (empty($stock['opening_stock'])) {
                    continue; // skip invalid stock
                }

                $stock['item_name'] = $item->item_name;
                $item->stocks()->create($stock);
            }
        }

        // ✅ Upload new images (only if provided)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('item_other_images'), $filename);

                $item->otherImages()->create([
                    'image_path' => 'item_other_images/' . $filename,
                ]);
            }
        }

        // ✅ Always create one details row
        $item->details()->create([
            'item_id'          => $item->id,
            'item_category_id' => $request->item_category_id,
            'item_description' => $request->item_description ?? null,
            'show_online_store'=> $request->show_online_store ?? false,
            'user_id'          => $request->user_id,
        ]);

        return $item->load('pricings','stocks','otherImages','details');
    });

    // Log history
    $user = User::find($item->user_id);
    if ($user) {
        $description = $user->name .' updated item '. $item->item_name 
                      .' on '. now()->toDateTimeString();
        History::create([
            'user_id'     => $user->id,
            'description' => $description
        ]);
    }

    return response()->json([
        'message' => 'Item updated successfully',
        'data'    => $item
    ]);
}



public function destroy($company_slug,$id)
{
    try {
        $item = Item::findOrFail($id);

        $authUser = Auth::user();

        if ($authUser) {
            $description = $authUser->name . ' deleted item "' . $item->item_name . '" on ' . now()->toDateTimeString();

            History::create([
                'user_id'     => $authUser->id,   // logged-in user
                'description' => $description,
            ]);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item deleted successfully.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to delete item. ' . $e->getMessage()
        ], 500);
    }
}


}

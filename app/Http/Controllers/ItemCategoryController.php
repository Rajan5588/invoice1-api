<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemCategory;
use App\Models\RolesPermission;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ItemCategoryController extends Controller
{
    // List categories
  public function index(Request $request, $company_slug)
{
    $user = Auth::user();
    if (!$user) abort(403, "Unauthorized");

    // --------------------------
    // Get permissions
    // --------------------------
    if ($user->is_admin == 'admin') {
        $permissions = [
            'view' => 'all', // admin sees all
            'add' => 1,
            'edit' => 1,
            'destroy' => 1,
        ];
    } else {
        $rolePerm = RolesPermission::where('role_id', $user->role_id)->first();

        $permissions = [
            'view' => $rolePerm->item_categories_view,   // 'own' | 'company' | 'all'
            'add' => $rolePerm->item_categories_add,
            'edit' => $rolePerm->item_categories_edit,
            'destroy' => $rolePerm->item_categories_destroy,
        ];
    }

    // --------------------------
    // Fetch item categories based on view permission
    // --------------------------
    $query = ItemCategory::query();

    if ($permissions['view'] === 'own') {
        $query->where('user_id', $user->id);
    } elseif ($permissions['view'] === 'company') {
        $query->where('company_code', $company_slug);
    }
    // 'all' → no filter

    $itemCategories = $query->get();

    // Edit category if requested
    $editCategory = null;
    if ($request->has('edit') && $permissions['edit']) {
        $editCategory = ItemCategory::findOrFail($request->edit);
    }

    return view('admin.items.item-category.index', [
        'itemCategories' => $itemCategories,
        'editCategory' => $editCategory,
        'company_slug' => $company_slug,
        'permissions' => $permissions,
    ]);
}


    // Add category
    public function store($company_slug, Request $request)
    {
        $user = Auth::user();
        if (!$user) abort(403, "Unauthorized");

        $permissions = $this->getPermissions($user);

        if (empty($permissions['add'])) {
            abort(403, "You don't have permission to add item categories.");
        }

        $request->validate([
            'category_name' => 'required|string|max:255|unique:item_categories,item_category_name',
        ]);

        $category = new ItemCategory();
        $category->item_category_name = $request->category_name;
        $category->user_id = $user->id;
        $category->company_code = $user->company_code;
        $category->save();

        return redirect()->back()->with('success', 'Category added successfully!');
    }

    // Fetch categories for DataTables
    public function get($company_slug, Request $request)
    {
        $user = Auth::user();
        if (!$user) abort(403, "Unauthorized");

        $permissions = $this->getPermissions($user);
        if (empty($permissions['view'])) {
            abort(403, "You don't have permission to view item categories.");
        }

        if ($request->ajax()) {
            $data = ItemCategory::with('user')
                ->where('company_code', $user->company_code)
                ->select(['id', 'item_category_name', 'user_id', 'created_at']);

            return DataTables::of($data)
                ->editColumn('created_at', function ($category) {
                    return $category->created_at 
                        ? $category->created_at->format('d-m-Y h:i A') 
                        : '';
                })
                ->addIndexColumn()
                ->addColumn('user_name', function ($row) {
                    return $row->user ? $row->user->name : 'N/A';
                })
                ->addColumn('action', function ($row) use ($permissions) {
                    $buttons = '';
                    if (!empty($permissions['delete'])) {
                        $buttons .= '<button class="btn btn-sm btn-danger sa-warning" data-url="'.route('item_categories.destroy', [$row->id]).'">
                                        <i class="ri-delete-bin-line"></i>
                                     </button>';
                    }
                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    // Delete category
    public function destroy($company_slug, $id)
    {
        $user = Auth::user();
        if (!$user) abort(403, "Unauthorized");

        $permissions = $this->getPermissions($user);
        if (empty($permissions['delete'])) {
            abort(403, "You don't have permission to delete item categories.");
        }

        $category = ItemCategory::findOrFail($id);

        // Optional: check ownership if role is restricted to "own"
        if (!$user->is_admin && $permissions['view'] == 'own' && $category->user_id != $user->id) {
            abort(403, "You cannot delete this category.");
        }

        $category->delete();

        return response()->json(['message' => 'Item Category deleted successfully.']);
    }

    // Helper method to get permissions for item categories
    private function getPermissions($user)
    {
        if ($user->is_admin == 1) {
            return ['view' => 1, 'add' => 1, 'edit' => 1, 'delete' => 1];
        }

        $rolePerm = RolesPermission::where('role_id', $user->role_id)->first();

        return [
            'view' => $rolePerm->item_categories_view,
            'add' => $rolePerm->item_categories_add,
            'edit' => $rolePerm->item_categories_edit,
            'delete' => $rolePerm->item_categories_destroy,
        ];
    }
}

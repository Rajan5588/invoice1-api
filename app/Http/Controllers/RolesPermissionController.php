<?php

namespace App\Http\Controllers;

use App\Models\RolesPermission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolesPermissionController extends Controller
{
    /**
     * Display a listing of permissions.
     */
    public function index()
    {
        $permissions = RolesPermission::with('role','company')->paginate(15);
        return view('admin.roles.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating new permission.
     */
   public function create()
{
    // Get role_ids already present in RolesPermission
    $assignedRoleIds = RolesPermission::pluck('role_id')->toArray();

    // Fetch roles that are NOT in assignedRoleIds
    $roles = Role::whereNotIn('id', $assignedRoleIds)->get();

    return view('admin.roles.permissions.create', compact('roles'));
}


    /**
     * Store a newly created permission in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $data = $request->except(['_token']);

        // Auto-fill owner and company
        $data['owner_id'] = Auth::id();
        $data['company_code'] = Auth::user()->company_code;

        // Handle checkboxes (if not checked, set to 0)
        foreach ($data as $key => $val) {
            if (str_ends_with($key, '_add') || str_ends_with($key, '_edit') || str_ends_with($key, '_delete')) {
                $data[$key] = $val ? 1 : 0;
            }
        }

        // Ensure view defaults to "own" if not set
        foreach ([
            'business_profiles_view','coupons_view','customers_view','invoices_view',
            'items_view','item_categories_view','subscriptions_view','transactions_view',
            'users_view','company_view','roles_permissions_view'
        ] as $viewField) {
            if (empty($data[$viewField])) {
                $data[$viewField] = 'own';
            }
        }

        RolesPermission::create($data);

        return redirect()->route('permissions.index')->with('success', 'Permissions created successfully.');
    }

    /**
     * Show a single permission set.
     */
    public function show(RolesPermission $permission)
    {
        return view('admin.roles.permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing permission.
     */
    public function edit(RolesPermission $permission)
    {
        $roles = Role::all();
        return view('admin.roles.permissions.edit', compact('permission','roles'));
    }

    /**
     * Update permission set.
     */
    public function update(Request $request, RolesPermission $permission)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $data = $request->except(['_token','_method']);

        foreach ($data as $key => $val) {
            if (str_ends_with($key, '_add') || str_ends_with($key, '_edit') || str_ends_with($key, '_delete')) {
                $data[$key] = $val ? 1 : 0;
            }
        }

        foreach ([
            'business_profiles_view','coupons_view','customers_view','invoices_view',
            'items_view','item_categories_view','subscriptions_view','transactions_view',
            'users_view','company_view','roles_permissions_view'
        ] as $viewField) {
            if (empty($data[$viewField])) {
                $data[$viewField] = 'own';
            }
        }

        $permission->update($data);

        return redirect()->route('permissions.index')->with('success', 'Permissions updated successfully.');
    }

    /**
     * Delete a permission set.
     */
    public function destroy(RolesPermission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permissions deleted successfully.');
    }
}

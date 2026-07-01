<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RolesPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
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
                'view'   => $rolePerm->roles_permissions_view ?? 0, // all | company | own | 0
                'add'    => $rolePerm->roles_permissions_add ?? 0,
                'edit'   => $rolePerm->roles_permissions_edit ?? 0,
                'delete' => $rolePerm->roles_permissions_delete ?? 0,
            ];
        }

        return view('admin.roles.index', compact('company_slug', 'permissions'));
    }

    public function store($company_slug, Request $request)
    {
        $request->validate([
            'role_name'=>'required|string|max:255',
        ]);

        $user = Auth::user();

        // check add permission
        if ($user->is_admin !== 'admin') {
            $rolePerm = RolesPermission::where('role_id', $user->role_id)->first();
            if (($rolePerm->roles_permissions_add ?? 0) != 1) {
                return response()->json(['message' => 'You do not have permission to add roles.'], 403);
            }
        }

        $role = Role::create([
            'role_name'    => $request->role_name,
            'owner_id'     => $user->id,
            'company_code' => $company_slug ?? null,
        ]);

        return response()->json(['message'=>'Role added successfully','role'=>$role]);
    }

    public function update($company_slug , Request $request, $id){
        $request->validate([
            'role_name'=>'required|string|max:255',
        ]);

        $role = Role::findOrFail($id);
        $role->update([
            'role_name'=>$request->role_name
        ]);

        return response()->json(['message'=>'Role updated successfully','role'=>$role]);
    }

  public function getRoles($company_slug , Request $request)
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
                'view'   => $rolePerm->roles_permissions_view ?? 0,
                'add'    => $rolePerm->roles_permissions_add ?? 0,
                'edit'   => $rolePerm->roles_permissions_edit ?? 0,
                'delete' => $rolePerm->roles_permissions_delete ?? 0,
            ];
        }

        if ($request->ajax()) {
            $query = Role::with('owner')->select('*');

            // 🔹 Restrict according to permissions
            if ($permissions['view'] === 'own') {
                $query->where('owner_id', $user->id);
           } elseif ($permissions['view'] === 'company') {
    if ($user->company_code === $company_slug) {
        $query->where('company_code', $company_slug);
    } else {
        // if user tries another company slug → return empty
        return datatables()->of(collect([]))->make(true);
    }
}
 elseif ($permissions['view'] === 0) {
                return datatables()->of(collect([]))->make(true);
            }

            return datatables()->of($query)
                ->addIndexColumn()
                ->addColumn('action', function($role) use ($permissions, $company_slug) {
    $editBtn = '';
    $deleteBtn = '';

    if ($permissions['edit'] == 1) {
        $editBtn = '<button class="btn btn-info btn-sm edit-btn" 
                        data-id="'.$role->id.'" 
                        data-name="'.$role->role_name.'"> 
                        <i class="ri-edit-line"></i></button>';
    }

    if ($permissions['delete'] == 1 && $role->id != 2) {
       $deleteBtn = '<button class="btn btn-danger btn-sm sa-warning" 
    data-url="'.route('roles.destroy', ['company_slug' => $company_slug, 'id' => $role->id]).'" 
    data-id="'.$role->id.'">
    <i class="ri-delete-bin-fill"></i>
</button>';

    }

    return $editBtn.' '.$deleteBtn;
})

                ->addColumn('owner_name', function($role){ 
                    return $role->owner->name ?? 'N/A'; 
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function destroy($company_slug,$id){
        
        $role=Role::findOrFail($id);
        if ($role->id == 2 ) {
        return response()->json([
            'message' => 'This role cannot be deleted.'
        ], 403);
    }
        Role::findOrFail($id)->delete();
        return response()->json(['message'=>'Role deleted successfully']);
    }
}

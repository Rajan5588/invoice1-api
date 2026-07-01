<?php

namespace App\Http\Controllers;
use App\Models\RolesPermission ;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    
   public function index(Request $request, $company_slug)
{
    $user = \Auth::user();

    // --------------------------
    // Get permissions
    // --------------------------
    if ($user->is_admin == 'admin') {
        $permissions = [
            'view' => 'all',
            'add' => 1,
            'edit' => 1,
            'destroy' => 1,
        ];
    } else {
        $rolePerm = RolesPermission::where('role_id', $user->role_id)->first();

        $permissions = [
            'view' => $rolePerm->coupons_view,      // 'own' | 'company' | 'all'
            'add' => $rolePerm->coupons_add,
            'edit' => $rolePerm->coupons_edit,
            'destroy' => $rolePerm->coupons_destroy,
        ];
    }

    // --------------------------
    // Fetch coupons based on view permission
    // --------------------------
    $query = Coupon::query();

    if ($permissions['view'] === 'own') {
        $query->where('user_id', $user->id);
    } elseif ($permissions['view'] === 'company') {
        $query->where('company_code', $company_slug); // assuming coupons have company_slug
    }
    
    // 'all' → no filter

    $coupons = $query->get();

    // Edit coupon if requested
    $editCoupon = null;
    if ($request->has('edit') && $permissions['edit']) {
        $editCoupon = Coupon::findOrFail($request->edit);
    }

    return view('admin.coupons.index', compact('coupons', 'editCoupon', 'company_slug', 'permissions'));
}


    public function store(Request $request, $company_slug)
{
    // Validate request
    $request->validate([
        'coupon_code' => 'required|unique:coupons,coupon_code',
        'discount' => 'required|numeric|min:0|max:100',
    ]);

    // Prepare data to insert
    $data = $request->only(['coupon_code', 'discount']);
    
    // Add company_code from the logged-in user
    $data['company_code'] = auth()->user()->company_code;

    // Create coupon
    Coupon::create($data);

    return redirect()->route('coupons.index', ['company_slug' => $company_slug])
                     ->with('success', 'Coupon created successfully!');
}


    public function update($company_slug ,Request $request, Coupon $coupon )
    {
        $request->validate([
            'coupon_code' => 'required|unique:coupons,coupon_code,' . $coupon->id,
            'discount' => 'required|numeric|min:0|max:100',
        ]);

        $coupon->update($request->only(['coupon_code', 'discount']));

        return redirect()->route('coupons.index')->with('success', 'Coupon updated successfully!');
    }

    public function destroy($company_slug ,Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('coupons.index')->with('success', 'Coupon deleted successfully!');
    }

    // ðŸ”¥ API method to validate coupon
    public function validateCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string'
        ]);

        $coupon = Coupon::where('coupon_code', $request->coupon_code)->first();

        if (!$coupon) {
            return response()->json(['status' => false, 'message' => 'Invalid coupon'], 404);
        }

        return response()->json([
            'status' => true,
            'coupon' => $coupon
        ]);
    }
}

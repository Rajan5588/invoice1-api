<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscribedUser;
use App\Models\User;
use App\Models\RolesPermission;   // ✅ Import here
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ Import Auth

class SubscriptionController extends Controller
{
    


public function index($company_slug, Request $request)
{
    $user = auth()->user();

    // 🔹 Determine permissions
    if ($user->is_admin === 'admin') {
        $permissions = [
            'view'   => 'all',
            'add'    => 1,
            'edit'   => 1,
            'delete' => 1,
        ];
    } else {
        $rolePerm = \App\Models\RolesPermission::where('role_id', $user->role_id)->first();

        $permissions = [
            'view'   => $rolePerm->subscriptions_view ?? 0,
            'add'    => $rolePerm->subscriptions_add ?? 0,
            'edit'   => $rolePerm->subscriptions_edit ?? 0,
            'delete' => $rolePerm->subscriptions_delete ?? 0,
        ];
    }

    // 🔹 Build query based on view permission
    $query = Subscription::latest();

    if ($permissions['view'] === 'own') {
        $query->where('owner_id', $user->id); // assuming Subscription has owner_id
    } elseif ($permissions['view'] === 'company') {
        if ($user->company_code === $company_slug) {
            $query->where('company_code', $company_slug);
        } else {
            // user tries accessing another company → block
            $subscriptions = collect([]);
            return view('subscriptions.index', compact('subscriptions', 'permissions'))
                ->with('editSubscription', null);
        }
    } elseif ($permissions['view'] === 0) {
        // no access
        $subscriptions = collect([]);
        return view('subscriptions.index', compact('subscriptions', 'permissions'))
            ->with('editSubscription', null);
    }

    $subscriptions = $query->get();

    // 🔹 If `edit` param is passed in the query, fetch that subscription
    $editSubscription = null;
    if ($request->has('edit') && $permissions['edit'] == 1) {
        $editSubscription = Subscription::findOrFail($request->edit);
    }

    return view('subscriptions.index', compact('subscriptions', 'editSubscription', 'permissions'));
}


//   public function index($company_slug, Request $request)
// {
//     $subscriptions = Subscription::latest()->get();

//     // If `edit` param is passed in the query, fetch that subscription
//     $editSubscription = null;
//     if ($request->has('edit')) {
//         $editSubscription = Subscription::findOrFail($request->edit);
//     }

//     return view('subscriptions.index', compact('subscriptions', 'editSubscription'));
// }
public function subscribedUsers($company_slug)
{
    // Get all subscribed users with their subscription and user details
    $subscribedUsers = SubscribedUser::with(['user', 'subscription'])
        ->latest()
        ->get();

    return view('subscriptions.users', compact('subscribedUsers'));
}
public function store($company_slug, Request $request)
{
    $request->validate([
        'plan_name'          => 'required|string|max:255',
        'plan_price'         => 'required|numeric|min:0',
        'plan_validity'      => 'required|integer|min:1',
        'plan_status'        => 'required|in:active,inactive',
        'plan_description'   => 'required',
        'user_add_count'     => 'required|integer|min:0',
        'business_add_count' => 'required|integer|min:0',
        'invoice_add_count'  => 'required|integer|min:0',
    ]);

    // 🔹 Merge company_slug into request data
    $data = $request->all();
    $data['company_code'] = $company_slug;

    Subscription::create($data);

    return redirect()
        ->route('subscriptions.index', $company_slug) // ✅ include company_slug in redirect
        ->with('success', 'Subscription added successfully!');
}


public function update($company_slug, Request $request, $id)
{
    $request->validate([
        'plan_name' => 'required|string|max:255',
        'plan_price' => 'required|numeric|min:0',
        'plan_validity' => 'required|integer|min:1',
        'plan_status' => 'required|in:active,inactive',
          'plan_description' => 'required',
           'user_add_count'=>'required',
         'business_add_count'=>'required',
         'invoice_add_count'=>'required',
    ]);

    $subscription = Subscription::findOrFail($id);
    $subscription->update($request->all());

    return redirect()->route('subscriptions.index')->with('success', 'Subscription updated successfully!');
}

public function destroy($company_slug,$id)
{
    $subscription = Subscription::findOrFail($id);
    $subscription->delete();

    return redirect()->route('subscriptions.index')->with('success', 'Subscription deleted successfully!');
}

}

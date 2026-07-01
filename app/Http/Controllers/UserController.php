<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Role;
use App\Models\Subscription;
use App\Models\SubscribedUser;
use Illuminate\Support\Carbon;


class UserController extends Controller
{
    // Blade view
    public function index()
    {
        return view('admin.users.index');
    }
    
      public function indexCompany()
    {
        return view('admin.users.company_index');
    }
    
    public function getCompanies(Request $request)
{
    if ($request->ajax()) {
        $users = User::where('is_admin','company')->with(['subscribedUsers.subscription' => function($q) {
                        $q->orderBy('id', 'desc'); // latest subscription
                    }])
                    ->select(['id', 'name', 'email', 'phone', 'state', 'district', 'full_address', 'avatar', 'created_at'])
                    ->where('id', '!=', 1);

        // Filters
        if ($request->has('filter')) {
            $filter = $request->filter;
            if ($filter == 'subscribed') {
                $users->whereHas('subscribedUsers', fn($q) => $q->where('status','active'));
            } elseif ($filter == 'unsubscribed') {
                $users->whereDoesntHave('subscribedUsers');
            } elseif ($filter == 'near_expiry') {
                $users->whereHas('subscribedUsers', fn($q) => 
                    $q->where('status','active')
                      ->whereDate('end_date', '<=', Carbon::now()->addDays(15))
                      ->whereDate('end_date', '>=', Carbon::now())
                );
            } elseif ($filter == 'expired') {
                $users->whereHas('subscribedUsers', fn($q) => 
                    $q->where('status','active')
                      ->whereDate('end_date', '<', Carbon::now())
                );
            } elseif ($filter == 'latest') {
                $users->orderBy('created_at', 'desc');
            }
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('subscription_plan', function($user) {
                $latest = $user->subscribedUsers->sortByDesc('id')->first();
                if ($latest && $latest->subscription) {
                    return '<button class="btn btn-success btn-sm">'.$latest->subscription->plan_name.'</button>';
                }
                return '<span class="badge bg-secondary">None</span>';
            })
            ->addColumn('subscription_expiry', function($user) {
                $latest = $user->subscribedUsers->sortByDesc('id')->first();
                if ($latest && $latest->end_date) {
                    return '<button class="btn btn-light btn-sm">'.Carbon::parse($latest->end_date)->format('d-m-Y').'</button>';
                }
                return '<span class="badge bg-secondary">None</span>';
            })
            ->editColumn('created_at', fn($user) => $user->created_at ? $user->created_at->format('d-m-y h:i A') : '')
            ->addColumn('avatar', function ($user) {
                if ($user->avatar) {
                    return '<img src="'.asset($user->avatar).'" alt="avatar" class="rounded-circle" width="40" height="40">';
                }
                return '<span class="badge bg-secondary">No Image</span>';
            })
            ->addColumn('action', function ($row) {
                return '
                    <a href="'.route('users.show', $row->id).'" class="btn btn-sm btn-info">
                        <i class="ri-eye-fill"></i>
                    </a>
                    <a href="'.route('company.edit', $row->id).'" class="btn btn-sm btn-success">
                        <i class="ri-edit-fill"></i>
                    </a>
                    <button class="btn btn-sm btn-danger sa-warning" 
                        data-id="'.$row->id.'" 
                        data-url="'.route('users.destroy', $row->id).'">
                        <i class="ri-delete-bin-fill"></i>
                    </button>
                ';
            })
            ->rawColumns(['avatar','action','subscription_plan','subscription_expiry'])
            ->make(true);
    }
}
    
    
public function createCompany()
{
    $user = auth()->user();

    if ($user->is_admin === 'admin') {
        // Super admin gets all roles and subscriptions
        $roles = Role::all();
        $subscriptions = Subscription::all();
    } else {
        // Normal user: roles under the company, but no subscriptions access
        $roles = Role::where('company_code', $user->company_code)->get();
        $subscriptions = collect(); // empty collection
    }

    return view('admin.users.company_create', compact('roles', 'subscriptions'));
}


public function editCompany($id)
{
    $user = auth()->user();

    // Find company
    $company = User::where('is_admin', 'company')->findOrFail($id);

    if ($user->is_admin === 'admin') {
        // Super admin gets all roles and subscriptions
        $roles = Role::all();
        $subscriptions = Subscription::all();
    } else {
        // Normal company owner: roles under the company, but no subscriptions access
        $roles = Role::where('company_code', $user->company_code)->get();
        $subscriptions = collect(); // empty collection
    }

    return view('admin.users.company_edit', compact('company', 'roles', 'subscriptions'));
}




    
 public function create()
{
    
    $companies=User::where('is_admin','company')->get();
    $user = auth()->user();

    if ($user->is_admin === 'super_admin') {
        // Super admin gets all roles
        $roles = Role::all();
    }  else {
        // Normal user has no access to roles
       $roles = Role::where('company_code', $user->company_code)->get();
    }

    return view('admin.users.create', compact('roles','companies'));
}

public function storeCompany(Request $request)
{
    $request->validate([
        'name'      => 'required|string|max:255',
        'email'     => 'required|email|max:255|unique:users',
        'password'  => 'required|string|min:6|confirmed',
        'phone'     => 'nullable|string|max:20|unique:users,phone',
        'state'     => 'nullable|string|max:100',
        'district'  => 'nullable|string|max:100',
        'full_address' => 'nullable|string|max:500',
        'gst_no'    => 'nullable|string|max:50',
        'subs_id'   => 'nullable|exists:subscriptions,id',
        'avatar'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // 🔹 Generate company_code
    $prefix = strtoupper(substr($request->name, 0, 3)) . "IN";
    $lastCompany = User::where('is_admin', 'company')
        ->where('company_code', 'LIKE', $prefix . '%')
        ->orderBy('id', 'desc')
        ->first();

    $nextNumber = $lastCompany 
        ? str_pad((int)substr($lastCompany->company_code, -4) + 1, 4, '0', STR_PAD_LEFT) 
        : '0001';

    $companyCode = $prefix . $nextNumber;

    // 🔹 Handle Avatar upload (directly to /public/assets)
    $avatarPath = null;
    if ($request->hasFile('avatar')) {
        $filename = time().'_'.$request->file('avatar')->getClientOriginalName();
        $request->file('avatar')->move(public_path('assets'), $filename);
        $avatarPath = 'assets/'.$filename;
    }

    // 🔹 Subscription expiry
    $subsExpiredDate = null;
    $subscription = null;
    if ($request->subs_id) {
        $subscription = Subscription::find($request->subs_id);
        if ($subscription && $subscription->plan_validity) {
            $subsExpiredDate = Carbon::now()->addDays($subscription->plan_validity);
        }
    }

    // 🔹 Create company
    $company = User::create([
        'name'          => $request->name,
        'email'         => $request->email,
        'password'      => bcrypt($request->password),
        'password_view' => $request->password,
        'phone'         => $request->phone,
        'state'         => $request->state,
        'district'      => $request->district,
        'full_address'  => $request->full_address,
        'status'        => $request->status ?? 'active',
        'is_admin'      => 'company',
        'company_code'  => $companyCode,
        'user_code'     => null,
        'verified_otp'  => '0',
        'otp_verified'  => '0',
        'avatar'        => $avatarPath,
        'fcm_token'     => $request->fcm_token ?? null,
        'subs_id'       => $request->subs_id ?? null,
        'subs_expired_date' => $subsExpiredDate,
        'gst_no'        => $request->gst_no,
        'role_id'       => $request->role_id ?? null,
    ]);

    // 🔹 Save subscription log
    if ($subscription) {
        SubscribedUser::create([
            'user_id'         => $company->id,
            'subscription_id' => $subscription->id,
            'amount'          => $subscription->plan_price,
            'payment_id'      => 'bysuperadmin',
            'start_date'      => Carbon::now(),
            'end_date'        => $subsExpiredDate,
            'status'          => 'active'
        ]);
    }

    return redirect()->route('company.index')->with('success', 'Company created successfully.');
}




public function updateCompany(Request $request, $id)
{
    $company = User::where('is_admin', 'company')->findOrFail($id);

    $request->validate([
        'name'      => 'required|string|max:255',
        'email'     => 'required|email|max:255|unique:users,email,' . $company->id,
        'password'  => 'nullable|string|min:6|confirmed',
        'phone'     => 'nullable|string|max:20|unique:users,phone,' . $company->id,
        'state'     => 'nullable|string|max:100',
        'district'  => 'nullable|string|max:100',
        'full_address' => 'nullable|string|max:500',
        'gst_no'    => 'nullable|string|max:50',
        'subs_id'   => 'nullable|exists:subscriptions,id',
        'avatar'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // ✅ Handle Avatar (delete old + upload new)
    $avatarPath = $company->avatar;
    if ($request->hasFile('avatar')) {
        if ($company->avatar && file_exists(public_path($company->avatar))) {
            unlink(public_path($company->avatar));
        }
        $filename = time().'_'.$request->file('avatar')->getClientOriginalName();
        $request->file('avatar')->move(public_path('assets'), $filename);
        $avatarPath = 'assets/'.$filename;
    }

    // ✅ Prepare update data
    $updateData = [
        'name'         => $request->name,
        'email'        => $request->email,
        'phone'        => $request->phone,
        'state'        => $request->state,
        'district'     => $request->district,
        'full_address' => $request->full_address,
        'status'       => $request->status ?? $company->status,
        'gst_no'       => $request->gst_no,
        'role_id'      => $request->role_id ?? $company->role_id,
        'avatar'       => $avatarPath,
    ];

    // ✅ Update password only if provided
    if ($request->filled('password')) {
        $updateData['password'] = bcrypt($request->password);
        $updateData['password_view'] = $request->password;
    }

    // ✅ Subscription logic
    $subsExpiredDate = $company->subs_expired_date;
    if ($request->subs_id) {
        $subscription = Subscription::find($request->subs_id);
        $updateData['subs_id'] = $subscription->id;

        if ($request->has('update_subscription_date') && $subscription && $subscription->plan_validity) {
            $subsExpiredDate = Carbon::now()->addDays($subscription->plan_validity);
            $updateData['subs_expired_date'] = $subsExpiredDate;

            SubscribedUser::create([
                'user_id'         => $company->id,
                'subscription_id' => $subscription->id,
                'amount'          => $subscription->plan_price,
                'payment_id'      => 'bysuperadmin',
                'start_date'      => Carbon::now(),
                'end_date'        => $subsExpiredDate,
                'status'          => 'active'
            ]);

            // Update all users under this company
            User::where('company_code', $company->company_code)
                ->update([
                    'subs_id' => $subscription->id,
                    'subs_expired_date' => $subsExpiredDate
                ]);
        }
    }

    $company->update($updateData);

    return redirect()->route('company.index')->with('success', 'Company updated successfully.');
}





public function store(Request $request)
{
    // 🔹 Validate inputs
    $request->validate([
        'name'          => 'required|string|max:255',
        'email'         => 'required|email|max:255|unique:users',
        'password'      => 'required|string|min:6|confirmed',
        'phone'         => 'nullable|string|max:20',
        'state'         => 'nullable|string|max:100',
        'district'      => 'nullable|string|max:100',
        'full_address'  => 'nullable|string|max:500',
        'company_code'  => 'required|exists:users,company_code',
        'role_id'       => 'required|exists:roles,id',
        'status'        => 'nullable|in:active,inactive',
        'avatar'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // 🔹 Find the selected company
    $company = User::where('company_code', $request->company_code)
                    ->where('is_admin', 'company')
                    ->firstOrFail();

    // 🔹 Generate unique user_code
    $prefix = "EMP" . strtoupper(substr($company->name, 0, 3));
    $lastEmp = User::where('company_code', $company->company_code)
                   ->where('user_code', 'LIKE', $prefix . '%')
                   ->latest('id')
                   ->first();

    $nextNumber = $lastEmp
        ? str_pad((int) substr($lastEmp->user_code, -4) + 1, 4, '0', STR_PAD_LEFT)
        : '0001';

    $userCode = $prefix . $nextNumber;

    // 🔹 Handle avatar upload
    // Handle avatar upload (store directly in /public/assets/avatars)
$avatarPath =  null;

if ($request->hasFile('avatar')) {
    $file = $request->file('avatar');
    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

    // Move file to public/assets/avatars
    $file->move(public_path('assets/avatars'), $filename);

    // Save relative path (so asset() works in blade)
    $avatarPath = 'assets/avatars/' . $filename;
}


    // 🔹 Create user under the company
    User::create([
        'name'              => $request->name,
        'email'             => $request->email,
        'password'          => bcrypt($request->password),
        'password_view'     => $request->password, // ⚠️ Security: consider removing this
        'phone'             => $request->phone,
        'state'             => $request->state,
        'district'          => $request->district,
        'full_address'      => $request->full_address,
        'status'            => $request->status ?? 'active',
        'is_admin'          => 'user',
        'company_code'      => $company->company_code,
        'user_code'         => $userCode,
        'verified_otp'      => '0',
        'otp_verified'      => '0',
        'avatar'            => $avatarPath,
        'fcm_token'         => $request->fcm_token ?? null,
        'subs_id'           => $company->subs_id,
        'subs_expired_date' => $company->subs_expired_date,
        'role_id'           => $request->role_id,
    ]);

    return redirect()->route('users.index')->with('success', 'User created successfully.');
}




   
public function getUsers(Request $request)
{
    if ($request->ajax()) {
        $users = User::where('is_admin', 'user')
            ->with('subscription') // relation with subscriptions table
            ->select([
                'id', 'name', 'email', 'phone',
                'state', 'district', 'full_address',
                'avatar', 'subs_id', 'subs_expired_date',
                'created_at'
            ])
            ->where('id', '!=', 1);

        // 🔹 Filters
        if ($request->has('filter')) {
            $filter = $request->filter;

            if ($filter == 'subscribed') {
                // Active subscription
                $users->whereNotNull('subs_id')
                      ->whereDate('subs_expired_date', '>=', Carbon::now());
            } elseif ($filter == 'unsubscribed') {
                // No subscription OR expired
                $users->where(function ($q) {
                    $q->whereNull('subs_id')
                      ->orWhereDate('subs_expired_date', '<', Carbon::now());
                });
            } elseif ($filter == 'near_expiry') {
                // Active but within next 15 days
                $users->whereNotNull('subs_id')
                      ->whereDate('subs_expired_date', '<=', Carbon::now()->addDays(15))
                      ->whereDate('subs_expired_date', '>=', Carbon::now());
            } elseif ($filter == 'expired') {
                // Expired users
                $users->whereNotNull('subs_id')
                      ->whereDate('subs_expired_date', '<', Carbon::now());
            } elseif ($filter == 'latest') {
                // Recently created
                $users->orderBy('created_at', 'desc');
            }
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('subscription_plan', function ($user) {
                if ($user->subs_id && $user->subscription) {
                    return '<button class="btn btn-success btn-sm">'
                            .$user->subscription->plan_name.'</button>';
                }
                return '<span class="badge bg-secondary">None</span>'; // 👈 for null subs_id
            })
            ->addColumn('subscription_expiry', function ($user) {
                if ($user->subs_id && $user->subs_expired_date) {
                    return '<button class="btn btn-light btn-sm">'
                            .Carbon::parse($user->subs_expired_date)->format('d-m-Y')
                            .'</button>';
                }
                return '<span class="badge bg-secondary">None</span>'; // 👈 for null subs_id
            })
            ->editColumn('created_at', fn($user) => 
                $user->created_at ? $user->created_at->format('d-m-y h:i A') : ''
            )
            ->addColumn('avatar', function ($user) {
                if ($user->avatar) {
                    return '<img src="'.asset($user->avatar).'" 
                                alt="avatar" 
                                class="rounded-circle" 
                                width="40" height="40">';
                }
                return '<span class="badge bg-secondary">No Image</span>';
            })
            ->addColumn('action', function ($row) {
                return '
                    <a href="'.route('users.show', $row->id).'" class="btn btn-sm btn-info">
                        <i class="ri-eye-fill"></i>
                    </a>
                    <a href="'.route('users.edit', $row->id).'" class="btn btn-sm btn-success">
                        <i class="ri-edit-fill"></i>
                    </a>
                    <button class="btn btn-sm btn-danger sa-warning" 
                        data-id="'.$row->id.'" 
                        data-url="'.route('users.destroy', $row->id).'">
                        <i class="ri-delete-bin-fill"></i>
                    </button>
                ';
            })
            ->rawColumns(['avatar','action','subscription_plan','subscription_expiry'])
            ->make(true);
    }
}




    
       public function show($id)
    {
        $user = User::with([
            'subscription',
            'subscribedUsers',
            'businessProfiles',
            'customers',
            'histories',
            'invoices',
            'itemCategories',
            'itemDetails',
            'items',
            'transactions'
        ])->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    public function getInvoices($id, Request $request)
    {
        if ($request->ajax()) {
            $invoices = Invoice::where('user_id', $id)->latest();

            return DataTables::of($invoices)
                ->addColumn('status', function ($row) {
                    return match ($row->status) {
                        'paid' => '<span class="badge bg-success">Paid</span>',
                        'unpaid' => '<span class="badge bg-danger">Unpaid</span>',
                        'overdue' => '<span class="badge bg-warning text-dark">Overdue</span>',
                        default => '<span class="badge bg-secondary">Unknown</span>',
                    };
                })
                ->editColumn('total', fn ($row) => '₹' . number_format($row->total, 2))
                ->editColumn('created_at', fn ($row) => $row->created_at->format('d M, Y'))
                ->rawColumns(['status'])
                ->make(true);
        }
    }

    public function getTransactions($id, Request $request)
    {
        if ($request->ajax()) {
            $transactions = Transaction::where('user_id', $id)->latest();

            return DataTables::of($transactions)
                ->addColumn('status', function ($row) {
                    return match ($row->status) {
                        'success' => '<span class="badge bg-success">Success</span>',
                        'failed' => '<span class="badge bg-danger">Failed</span>',
                        'pending' => '<span class="badge bg-warning text-dark">Pending</span>',
                        default => '<span class="badge bg-secondary">Unknown</span>',
                    };
                })
                ->editColumn('amount', fn ($row) => '₹' . number_format($row->amount, 2))
                ->editColumn('created_at', fn ($row) => $row->created_at->format('d M, Y'))
                ->rawColumns(['status'])
                ->make(true);
        }
    }

// Show edit form
public function edit($id)
{
    $user = User::findOrFail($id);

    // Fetch companies
    $companies = User::where('is_admin', 'company')->get();

    // Roles: super_admin gets all, company gets only its roles
    $authUser = auth()->user();
    if ($authUser->is_admin === 'super_admin') {
        $roles = Role::all();
    } else {
        $roles = Role::where('company_code', $authUser->company_code)->get();
    }

    return view('admin.users.edit', compact('user', 'companies', 'roles'));
}


// Update user
public function update(Request $request, $id)
{
    // ✅ Find user by ID
    $user = User::findOrFail($id);

    // ✅ Validation
    $request->validate([
        'name'          => 'required|string|max:255',
        'email'         => 'required|email|max:255|unique:users,email,' . $user->id, // ignore current user ID
        'password'      => 'nullable|string|min:6|confirmed',
        'phone'         => 'nullable|string|max:20|unique:users,phone,' . $user->id, // ignore current user ID
        'state'         => 'nullable|string|max:100',
        'district'      => 'nullable|string|max:100',
        'full_address'  => 'nullable|string|max:500',
        'company_code'  => 'required|exists:users,company_code',
        'role_id'       => 'required|exists:roles,id',
        'status'        => 'nullable|in:active,inactive',
        'avatar'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // ✅ Find selected company
    $company = User::where('company_code', $request->company_code)
                    ->where('is_admin', 'company')
                    ->firstOrFail();


   // Handle avatar upload (store directly in /public/assets/avatars)
$avatarPath = $user->avatar ?? null;

if ($request->hasFile('avatar')) {
    $file = $request->file('avatar');
    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

    // Move file to public/assets/avatars
    $file->move(public_path('assets/avatars'), $filename);

    // Save relative path (so asset() works in blade)
    $avatarPath = 'assets/avatars/' . $filename;
}


    // ✅ Update user
    $user->update([
        'name'              => $request->name,
        'email'             => $request->email,
        'password'          => $request->filled('password') ? bcrypt($request->password) : $user->password,
        'phone'             => $request->phone,
        'state'             => $request->state,
        'district'          => $request->district,
        'full_address'      => $request->full_address,
        'status'            => $request->status ?? $user->status,
        'company_code'      => $company->company_code,
        'avatar'            => $avatarPath,
        'fcm_token'         => $request->fcm_token ?? $user->fcm_token,
        'subs_id'           => $company->subs_id,
        'subs_expired_date' => $company->subs_expired_date,
        'role_id'           => $request->role_id,
    ]);

    return redirect()->route('users.index')->with('success', 'User updated successfully.');
}



    
public function destroy($id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $user->delete();

    return response()->json(['message' => 'User deleted successfully.']);
}



     
}

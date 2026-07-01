<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Item;
use App\Models\Invoice;
use App\Models\Transaction;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


 public function index(Request $request)
    {
         $authUser = Auth::user();
$companyCode = $authUser->company_code;

        // Dashboard stats
        $usersCount = User::count();
        $itemsCount = Item::count();
        $invoicesCount = Invoice::count();
        $transactionCount = Transaction::count();

        // Recent 10 transactions with invoice
        $recentTransactions = Transaction::with('invoice')->latest()->take(10)->get();

        // Recent 10 users
        $recentUsers = User::latest()->take(10)->get();

        // Today's sales (for current user's company if multi-company)
   $todaySales = Invoice::with('transaction')->whereDate('created_at', now())
    ->whereHas('user', function($query) use ($companyCode) {
        $query->where('company_code', $companyCode);
    })
    ->sum('total_amount');
    
   $pendingInvoices = Invoice::whereHas('transactions', function($query) {
    $query->where('status', 'pending');
})->whereHas('user', function($query) use ($companyCode) {
    $query->where('company_code', $companyCode);
})->count();

$paidInvoices = Invoice::whereHas('transactions', function($query) {
    $query->where('status', 'paid'); // assuming 'paid' is the status
})->whereHas('user', function($query) use ($companyCode) {
    $query->where('company_code', $companyCode);
})->count();


$overdueAmount = Invoice::whereHas('transactions', function($query) {
        $query->where('status', 'pending') // unpaid
              ->where('date', '<', Carbon::today()); // past due
    })->whereHas('user', function($query) use ($companyCode) {
        $query->where('company_code', $companyCode);
    })->sum('total_amount');

$invoices = Invoice::with('transactions', 'user', 'customer')
    ->whereHas('user', function($query) use ($companyCode) {
        $query->where('company_code', $companyCode);
    })
    ->latest()
    ->take(10) // adjust as needed
    ->get();
        $monthlyRevenue = Invoice::whereHas('user', function($query) use ($companyCode) {
        $query->where('company_code', $companyCode);
    })
    ->whereMonth('created_at', Carbon::now()->month)
    ->whereYear('created_at', Carbon::now()->year)
    ->sum('total_amount');
    
    $months = collect(range(1, 12))->map(function ($month) {
    return Carbon::create()->month($month)->format('F'); // 'January', 'February', etc.
})->toArray();

$overdueInvoices = Invoice::whereHas('transactions', function($query) {
        $query->where('status', 'pending') // unpaid
              ->where('date', '<', Carbon::today()); // past due
    })->whereHas('user', function($query) use ($companyCode) {
        $query->where('company_code', $companyCode);
    })
    ->count();
     $transactions = Transaction::with(['invoice', 'user'])
        ->whereHas('user', function($query) use ($companyCode) {
            $query->where('company_code', $companyCode);
        })
        ->latest()
        ->take(10)
        ->get();
        
         $transactions->each(function($t) {
        $t->status_badge = match ($t->status) {
            'paid' => '<span class="badge bg-success">Paid</span>',
            'unpaid' => '<span class="badge bg-warning text-dark">Unpaid</span>',
            'overdue' => '<span class="badge bg-danger">Overdue</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    });
        // Pass data to view
        if (view()->exists($request->path())) {
            return view($request->path(), compact(
                'usersCount',
                'itemsCount',
                'invoicesCount',
                'transactionCount',
                'recentTransactions',
                'recentUsers',
                'todaySales',
                'authUser','pendingInvoices','paidInvoices','overdueAmount','invoices','monthlyRevenue','months' ,'overdueInvoices','transactions'
            ));
        }

        return abort(404);
    }

    public function root()
    {
       $authUser = Auth::user();
$companyCode = $authUser->company_code;

        // Dashboard stats
        $usersCount = User::count();
        $itemsCount = Item::count();
        $invoicesCount = Invoice::count();
        $transactionCount = Transaction::count();

        // Recent 10 transactions with invoice
        $recentTransactions = Transaction::with('invoice')->latest()->take(10)->get();

        // Recent 10 users
        $recentUsers = User::latest()->take(10)->get();

        // Today's sales
       

$todaySales = Invoice::whereDate('created_at', now())
    ->whereHas('user', function($query) use ($companyCode) {
        $query->where('company_code', $companyCode);
    })
    ->sum('total_amount');
    
 $pendingInvoices = Invoice::whereHas('transactions', function($query) {
    $query->where('status', 'pending');
})->whereHas('user', function($query) use ($companyCode) {
    $query->where('company_code', $companyCode);
})->count();

$paidInvoices = Invoice::whereHas('transactions', function($query) {
    $query->where('status', 'paid'); // assuming 'paid' is the status
})->whereHas('user', function($query) use ($companyCode) {
    $query->where('company_code', $companyCode);
})->count();


$overdueAmount = Invoice::whereHas('transactions', function($query) {
        $query->where('status', 'pending') // unpaid
              ->where('date', '<', Carbon::today()); // past due
    })->whereHas('user', function($query) use ($companyCode) {
        $query->where('company_code', $companyCode);
    })->sum('total_amount');

$invoices = Invoice::with('transactions', 'user', 'customer')
    ->whereHas('user', function($query) use ($companyCode) {
        $query->where('company_code', $companyCode);
    })
    ->latest()
    ->take(10) // adjust as needed
    ->get();
    
    $monthlyRevenue = Invoice::whereHas('user', function($query) use ($companyCode) {
        $query->where('company_code', $companyCode);
    })
    ->whereMonth('created_at', Carbon::now()->month)
    ->whereYear('created_at', Carbon::now()->year)
    ->sum('total_amount');
    
     $months = collect(range(1, 12))->map(function ($month) {
    return Carbon::create()->month($month)->format('F'); // 'January', 'February', etc.
})->toArray();

$overdueInvoices = Invoice::whereHas('transactions', function($query) {
        $query->where('status', 'pending') // unpaid
              ->where('date', '<', Carbon::today()); // past due
    })->whereHas('user', function($query) use ($companyCode) {
        $query->where('company_code', $companyCode);
    })
    ->count();
    
     $transactions = Transaction::with(['invoice', 'user'])
        ->whereHas('user', function($query) use ($companyCode) {
            $query->where('company_code', $companyCode);
        })
        ->latest()
        ->take(10)
        ->get();
         $transactions->each(function($t) {
        $t->status_badge = match ($t->status) {
            'paid' => '<span class="badge bg-success">Paid</span>',
            'unpaid' => '<span class="badge bg-warning text-dark">Unpaid</span>',
            'overdue' => '<span class="badge bg-danger">Overdue</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    });
        return view('admin.index', compact(
            'usersCount',
            'itemsCount',
            'invoicesCount',
            'transactionCount',
            'recentTransactions',
            'recentUsers',
            'todaySales',
            'authUser','pendingInvoices','paidInvoices','overdueAmount' ,'invoices','monthlyRevenue','months' ,'overdueInvoices','transactions'
        ));
    }



    /*Language Translation*/
    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        $user = User::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');

        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
            $user->avatar =  $avatarName;
        }

        $user->update();
        if ($user) {
            Session::flash('message', 'User Details Updated successfully!');
            Session::flash('alert-class', 'alert-success');
            // return response()->json([
            //     'isSuccess' => true,
            //     'Message' => "User Details Updated successfully!"
            // ], 200); // Status code here
            return redirect()->back();
        } else {
            Session::flash('message', 'Something went wrong!');
            Session::flash('alert-class', 'alert-danger');
            // return response()->json([
            //     'isSuccess' => true,
            //     'Message' => "Something went wrong!"
            // ], 200); // Status code here
            return redirect()->back();

        }
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return response()->json([
                'isSuccess' => false,
                'Message' => "Your Current password does not matches with the password you provided. Please try again."
            ], 200); // Status code
        } else {
            $user = User::find($id);
            $user->password = Hash::make($request->get('password'));
            $user->update();
            if ($user) {
                Session::flash('message', 'Password updated successfully!');
                Session::flash('alert-class', 'alert-success');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Password updated successfully!"
                ], 200); // Status code here
            } else {
                Session::flash('message', 'Something went wrong!');
                Session::flash('alert-class', 'alert-danger');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Something went wrong!"
                ], 200); // Status code here
            }
        }
    }
}

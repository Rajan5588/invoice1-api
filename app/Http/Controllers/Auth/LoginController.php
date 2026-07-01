<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     * We'll override the method to include company_slug
     */
    protected function redirectTo()
    {
        $user = Auth::user();

        if ($user && $user->company_code) {
            // Redirect to company-specific root
            return '/' . $user->company_code;
        }

        // Fallback
        return '/';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function loggedOut(Request $request)
    {
        return redirect()->route('login');
    }
}

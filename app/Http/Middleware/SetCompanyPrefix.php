<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class SetCompanyPrefix
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $companySlug = Auth::user()->company_code; // or slug if you store it

            // Share companySlug in all Blade views
            view()->share('companySlug', $companySlug);

            // ✅ Tell Laravel to always use this for {company_slug}
            URL::defaults(['company_slug' => $companySlug]);

            // Also inject into current request route if missing
            if ($request->route() && !$request->route('company_slug')) {
                $request->route()->setParameter('company_slug', $companySlug);
            }
        }

        return $next($request);
    }
}

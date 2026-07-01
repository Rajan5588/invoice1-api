<?php
use Illuminate\Support\Facades\Auth;

if (! function_exists('company_route')) {
    /**
     * Generate a route with the authenticated user's company slug
     */
    function company_route($name, $parameters = [], $absolute = true) {
        if (Auth::check()) {
            // inject company_slug automatically
            $parameters = array_merge(['company_slug' => Auth::user()->company_code], $parameters);
        }
        return route($name, $parameters, $absolute);
    }
}

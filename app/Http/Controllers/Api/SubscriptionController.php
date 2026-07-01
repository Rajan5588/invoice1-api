<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Get all subscriptions (API).
     */
    public function index()
    {
        $subscriptions = Subscription::all();

        return response()->json([
            'success' => true,
            'data' => $subscriptions
        ], 200);
    }
}

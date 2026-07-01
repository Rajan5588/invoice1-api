<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubscribedUser;
use App\Models\Subscription;
use App\Models\User;   // ✅ Make sure User model is imported
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Exception;

class SubscribedUserController extends Controller
{
    /**
     * Store a new subscription purchase for a user
     */
    public function store(Request $request)
    {
        try {
            // ✅ Validate request
            $validator = Validator::make($request->all(), [
                'user_id'         => 'required|exists:users,id',
                'subscription_id' => 'required|exists:subscriptions,id',
                'amount'          => 'required|numeric|min:0',
                'payment_id'      => 'nullable|string|max:191',
                'days'            => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors'  => $validator->errors()
                ], 422);
            }

            // ✅ Get subscription
            $subscription = Subscription::find($request->subscription_id);
            if (!$subscription) {
                return response()->json([
                    'success' => false,
                    'message' => 'Subscription plan not found'
                ], 404);
            }

            // ✅ Calculate start & end date
            $startDate = Carbon::now();
            $endDate   = null;

            if (strtolower($subscription->plan_validity) !== 'unlimited') {
                $endDate = $startDate->copy()->addDays((int) $request->days);
            }

            // ✅ Save subscription in subscribed_users
            $subscribedUser = SubscribedUser::create([
                'user_id'         => $request->user_id,
                'subscription_id' => $subscription->id,
                'amount'          => $request->amount,
                'payment_id'      => $request->payment_id,
                'start_date'      => $startDate,
                'end_date'        => $endDate,
                'status'          => 'active'
            ]);

            // ✅ Update user table with subscription info
            $user = User::find($request->user_id);
            $user->subs_id = $subscription->id;
            $user->subs_expired_date = $endDate;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Subscription activated successfully',
                'data'    => [
                    'subscription' => $subscribedUser->load('subscription'),
                    'user'         => $user
                ]
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}

<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Otp;

class LoginApiController extends Controller
{
    // Send OTP
   public function sendOtp(Request $request)
{
    try {

        // Validate input
        $validator = Validator::make($request->all(), [
            'phone' => 'required|digits:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'error' => $validator->errors()
            ], 422);
        }

        // Generate OTP
        $otpCode = rand(1000, 9999);
        $expiresAt = Carbon::now()->addMinutes(5);

        // Save OTP (safe update/insert)
        Otp::updateOrCreate(
            ['phone' => $request->phone],
            [
                'otp' => $otpCode,
                'expires_at' => $expiresAt
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully',
            'otp' => $otpCode, // remove in production
            'expires_in' => 300
        ]);

    } catch (\Exception $e) {

        // 👇 THIS IS IMPORTANT (Railway debugging)
        return response()->json([
            'status' => false,
            'message' => 'Server error',
            'error' => $e->getMessage()
        ], 500);
    }
}

    // Verify OTP
    // public function verifyOtp(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'phone' => 'required|digits:10',
    //         'otp' => 'required|digits:4'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->errors()], 422);
    //     }

    //     $otpData = Otp::where('phone', $request->phone)
    //         ->where('otp', $request->otp)
    //         ->where('expires_at', '>', Carbon::now())
    //         ->first();

    //     if (!$otpData) {
    //         return response()->json(['error' => 'Invalid or expired OTP'], 401);
    //     }

    //     // Find or create the user
    //     $user = User::firstOrCreate(
    //         ['phone' => $request->phone],
    //         ['name' => 'User_' . rand(1000, 9999)] // Adjust as needed
    //     );

    //     // Delete OTP
    //     $otpData->delete();
        
    //      // Mark user as verified for next request
    // $user = User::where('phone', $request->phone)->first();
    // if ($user) {
    //     $user->otp_verified = true; // add this field in users table
    //     $user->save();
    // }


    //     // // Generate token
    //     // $token = $user->createToken('auth_token')->plainTextToken;

    //     return response()->json([
    //         'message' => 'OTP verified'
    //     ]);
    // }
//     public function verifyOtp(Request $request)
// {
//     $validator = Validator::make($request->all(), [
//         'phone' => 'required|digits:10',
//         'otp' => 'required|digits:4',
//          'fcm_token'=>'required'
//     ]);

//     if ($validator->fails()) {
//         return response()->json(['error' => $validator->errors()], 422);
//     }

//     $otpData = Otp::where('phone', $request->phone)
//         ->where('otp', $request->otp)
//         ->where('expires_at', '>', Carbon::now())
//         ->first();

//     if (!$otpData) {
//         return response()->json(['error' => 'Invalid or expired OTP'], 401);
//     }

//     // Find or create the user
//     $user = User::firstOrCreate(
//         ['phone' => $request->phone],
//         ['fcm_token' => $request->fcm_token],
//         ['name' => 'User_' . rand(1000, 9999)] // default name
//     );

//     // Delete OTP
//     $otpData->delete();
    
//     // Mark user as verified
//     $user->otp_verified = true; // make sure this column exists in users table
//     $user->save();

//     return response()->json([
//         'message' => 'OTP verified',
//         'user_info' => $user  // ðŸ‘ˆ return user details also
//     ]);
// }

public function verifyOtp(Request $request)
{
    try {

        // Validate Request
        $validator = Validator::make($request->all(), [
            'phone' => 'required|digits:10',
            'otp' => 'required|digits:4',
            'fcm_token' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check OTP
        $otpData = Otp::where('phone', $request->phone)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otpData) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired OTP'
            ], 401);
        }

        // Find or Create User
        $user = User::firstOrCreate(
            ['phone' => $request->phone],
            [
                'name' => 'User_' . rand(1000, 9999)
            ]
        );

        // Update User
        $user->fcm_token = $request->fcm_token;
        $user->otp_verified = true;
        $user->save();

        // Delete OTP
        $otpData->delete();

        // Load subscription if exists
        $user->load('subscription');

        return response()->json([
            'status' => true,
            'message' => 'OTP verified successfully',
            'user_info' => $user
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => 'Server Error',
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => basename($e->getFile())
        ], 500);
    }
}


    
    public function updateUserInfo(Request $request)
{
    $validator = Validator::make($request->all(), [
        'phone'        => 'required|digits:10',
        'name'         => 'required|string|max:255',
        'email'        => 'required|email|max:255',
        'state'        => 'required|string|max:255',
        'district'     => 'required|string|max:255',
        'full_address' => 'required|string|max:500',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    $user = User::where('phone', $request->phone)->first();
 
    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    if (!$user->otp_verified) {
        return response()->json(['error' => 'OTP verification required'], 403);
    }

    $user->update([
        'name'         => $request->name,
        'email'        => $request->email,
        'state'        => $request->state,
        'district'     => $request->district,
        'full_address' => $request->full_address,
        'otp_verified' => false // reset after update
    ]);

    return response()->json([
        'message' => 'User details updated successfully',
        'user'    => $user
    ]);
}

public function getProfile(Request $request){
    
       $user = User::where('id', $request->user_id)->first();

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }
    
       return response()->json([
        'message' => 'User details get successfully',
        'user'    => $user
    ]);
}

}

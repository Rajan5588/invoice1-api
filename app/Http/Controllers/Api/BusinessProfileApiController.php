<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\BusinessProfile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Models\History;
use App\Models\User;
class BusinessProfileApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $userId = $request->query('user_id'); // get ?user_id=1

    if (!$userId) {
        return response()->json([
            'status' => false,
            'message' => 'user_id query parameter is required'
        ], 400);
    }

    $profiles = BusinessProfile::where('user_id', $userId)->get();

    if ($profiles->isEmpty()) {
        return response()->json([
            'status' => false,
            'message' => 'No business profiles found for this user'
        ], 404);
    }

    return response()->json([
        'status' => true,
        'data' => $profiles
    ], 200);
}


    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    try {
        // Validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'business_name' => 'required|string|max:255',
            'gst_no' => 'nullable|string',
            'phone_no_first' => 'required|string',
            'phone_no_second' => 'nullable|string',
            'email' => 'required|email',
            'business_email' => 'nullable|email',
            'business_address' => 'required|string',
            'pincode' => 'required|string',
            'business_state' => 'required|string',
            'business_category' => 'required|string',
            'digital_sign' => 'nullable|image|mimes:jpg,png,jpeg',
            'business_signature' => 'nullable|image|mimes:jpg,png,jpeg',
            'company_code' => 'required|string|max:50|unique:users,company_code,' . $request->user_id,   // new error ke chance 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Generate business_id only if creating new
        $existingProfile = BusinessProfile::where('user_id', $request->user_id)->first();
        $business_id = $existingProfile ? $existingProfile->business_id : strtoupper(substr(preg_replace('/\s+/', '', $request->business_name), 0, 4)) . now()->format('dmYHis');

        // Handle file uploads
        $digital_sign_path = $existingProfile->digital_sign ?? null;
        if ($request->hasFile('digital_sign')) {
            $digitalSign = $request->file('digital_sign');
            $digitalSignName = time().'_digital.'.$digitalSign->getClientOriginalExtension();
            $digitalSign->move(public_path('assets/signature'), $digitalSignName);
            $digital_sign_path = 'assets/signature/'.$digitalSignName;
        }

        $business_signature_path = $existingProfile->business_signature ?? null;
        if ($request->hasFile('business_signature')) {
            $businessSign = $request->file('business_signature');
            $businessSignName = time().'_business.'.$businessSign->getClientOriginalExtension();
            $businessSign->move(public_path('assets/business_signature'), $businessSignName);
            $business_signature_path = 'assets/business_signature/'.$businessSignName;
        }
$user = User::findOrFail($request->user_id);
        // Create or update profile
        $profile = BusinessProfile::updateOrCreate(
            ['user_id' => $request->user_id], // condition to find existing
            [
                'business_id' => $business_id,
                'business_name'=>$request->business_name,
                'gst_no' => $request->gst_no,
                'phone_no_first' => $request->phone_no_first,
                'phone_no_second' => $request->phone_no_second,
                'email' => $request->email,
                'business_email' => $request->business_email,
                'business_address' => $request->business_address,
                'pincode' => $request->pincode,
                'business_desc' => $request->business_desc,
                'digital_sign' => $digital_sign_path,
                'business_state' => $request->business_state,
                'business_category' => $request->business_category,
                 'business_type' => $request->business_type,
                'website' => $request->website,
                'business_signature' => $business_signature_path,
                'company_code' => $user->company_code,
            ]
        );
        
            $user = User::find($profile->user_id);

    // Log history if user exists
   if ($user) {
    if ($existingProfile) {
        $description = $user->name . ' updated business profile on ' . now()->toDateTimeString();
    } else {
        $description = $user->name . ' created business profile on ' . now()->toDateTimeString();
    }

    History::create([
        'user_id' => $user->id,
        'description' => $description
    ]);
}

        return response()->json([
            'status' => true,
            'message' => $existingProfile ? 'Business profile updated successfully' : 'Business profile created successfully',
            'data' => $profile
        ], $existingProfile ? 200 : 201);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong',
            'error' => $e->getMessage()
        ], 500);
    }
}

  

    /**
     * Remove the specified resource from storage.
     */
 
public function destroy(string $id)
{
    try {
        $profile = BusinessProfile::findOrFail($id);
        $profile->delete();


        return response()->json([
            'status' => true,
            'message' => 'Business profile deleted successfully'
        ], 200);

    } catch (ModelNotFoundException $e) {
        return response()->json([
            'status' => false,
            'message' => 'Business profile not found',
            'error' => "No business profile matches the given ID: $id"
        ], 404);

    } catch (QueryException $e) {
        return response()->json([
            'status' => false,
            'message' => 'Database error: cannot delete profile',
            'error' => $e->getMessage()
        ], 400);

    } catch (Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to delete business profile',
            'error' => $e->getMessage()
        ], 500);
    }
}
}
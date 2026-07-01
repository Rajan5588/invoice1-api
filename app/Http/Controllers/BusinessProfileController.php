<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessProfile;
use Illuminate\Support\Facades\Auth;
use DataTables;

class BusinessProfileController extends Controller
{
  public function index($company_slug)
    {
        return view('admin.buisness-profiles.index',compact('company_slug'));
    }
    
    
       public function create($company_slug)
    {
        return view('admin.buisness-profiles.create',compact('company_slug'));
    }

public function store(Request $request, $company_slug)
{
    $validated = $request->validate([
        'business_id' => 'required|string|max:191',
        'business_name' => 'required|string|max:255',
        'gst_no' => 'nullable|string|max:191',
        'phone_no_first' => 'required|string|max:191',
        'phone_no_second' => 'nullable|string|max:191',
        'email' => 'required|email|max:191',
        'business_email' => 'nullable|email|max:191',
        'business_address' => 'required|string',
        'pincode' => 'required|string|max:191',
        'business_state' => 'required|string|max:191',
        'business_category' => 'required|string|max:191',
        'website' => 'nullable|string|max:191',
        'digital_sign' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'business_signature' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $validated['user_id'] = auth()->id();
      $validated['company_code'] = Auth::user()->company_code;
    // handle file uploads
    if ($request->hasFile('digital_sign')) {
        $validated['digital_sign'] = $request->file('digital_sign')->store('signs', 'public');
    }

    if ($request->hasFile('business_signature')) {
        $validated['business_signature'] = $request->file('business_signature')->store('signatures', 'public');
    }

    // update or create (to avoid duplicate user_id issue)
    \App\Models\BusinessProfile::updateOrCreate(
        ['user_id' => auth()->id()],
        $validated
    );

    return redirect()->route('business_profiles.index')
                     ->with('success', 'Business profile saved successfully!');
}


    public function getBusinessProfiles(Request $request,$company_slug)
    {
        if ($request->ajax()) {
            $profiles = BusinessProfile::select([
                'id', 'user_id', 'business_id', 'gst_no', 'phone_no_first', 'phone_no_second',
                'email', 'business_email', 'business_address', 'pincode', 'business_desc',
                'digital_sign', 'business_state', 'business_category', 'website',
                'business_signature', 'business_name', 'business_type', 'created_at'
            ]);

            return DataTables::of($profiles)
                ->addIndexColumn()
                ->editColumn('created_at', function ($profile) {
                    return $profile->created_at 
                        ? $profile->created_at->format('d-m-Y h:i A') 
                        : '';
                })
                ->addColumn('action', function ($row) {
                    return '
                        
                        <button class="btn btn-sm btn-danger sa-warning" 
                            data-id="'.$row->id.'" 
                            data-url="'.route('business_profiles.destroy', $row->id).'">
                            <i class="ri-delete-bin-fill"></i>
                        </button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function show($company_slug,$id)
    {
        $profile = BusinessProfile::findOrFail($id);
        return view('admin.buisness-profiles.show', compact('profile','company_slug'));
    }

    public function destroy($company_slug,$id)
    {
        $profile = BusinessProfile::findOrFail($id);
        $profile->delete();

        return response()->json(['message' => 'Business profile deleted successfully!']);
    }
}

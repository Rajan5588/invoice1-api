@extends('layouts.master')

@section('title', 'Create Bussiness')

@section('css')
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .form-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e9ecef;
            box-shadow: 0 3px 12px rgba(0,0,0,0.05);
            padding: 2rem;
        }
        .form-section {
            margin-top: 2rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f1f1f1;
            font-weight: 600;
            font-size: 1rem;
            color: #495057;
        }
        .required:after {
            content: " *";
            color: red;
        }
        .preview-img {
            max-width: 120px;
            max-height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #dee2e6;
        }
        .btn {
            border-radius: 6px;
            padding: 0.55rem 1.2rem;
        }
    </style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-11">
        <div class="form-card">
            <h4 class="mb-4"><i class="bi bi-person-plus me-2"></i> Create Bussiness</h4>

 <form action="{{ route('business_profiles.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Business Info -->
    <div class="form-section">Business Information</div>
    <div class="row g-4">
        <!-- User Dropdown -->

        <div class="col-md-6">
            <label class="form-label required">Business Name</label>
            <input type="text" name="business_name" class="form-control @error('business_name') is-invalid @enderror"
                   value="{{ old('business_name') }}">
            @error('business_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
 <div class="col-md-6">
            <label class="form-label required">Business ID</label>
            <input type="text" name="business_id" class="form-control @error('business_id') is-invalid @enderror"
                   value="{{ old('business_id') }}">
            @error('business_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">GST No.</label>
            <input type="text" name="gst_no" class="form-control @error('gst_no') is-invalid @enderror"
                   value="{{ old('gst_no') }}">
            @error('gst_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
         <div class="col-md-6">
            <label class="form-label">Business Website.</label>
            <input type="text" name="website" class="form-control @error('website') is-invalid @enderror"
                   value="{{ old('website') }}">
            @error('website') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <!-- Contact Details -->
    <div class="form-section">Contact Details</div>
    <div class="row g-4">
        <div class="col-md-6">
            <label class="form-label required">Primary Phone</label>
            <input type="text" name="phone_no_first" class="form-control @error('phone_no_first') is-invalid @enderror"
                   value="{{ old('phone_no_first') }}">
            @error('phone_no_first') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">Secondary Phone</label>
            <input type="text" name="phone_no_second" class="form-control @error('phone_no_second') is-invalid @enderror"
                   value="{{ old('phone_no_second') }}">
            @error('phone_no_second') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label required">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">Business Email</label>
            <input type="email" name="business_email" class="form-control @error('business_email') is-invalid @enderror"
                   value="{{ old('business_email') }}">
            @error('business_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <!-- Address -->
    <div class="form-section">Business Address</div>
    <div class="row g-4">
        <div class="col-md-12">
            <label class="form-label required">Full Address</label>
            <textarea name="business_address" rows="2"
                      class="form-control @error('business_address') is-invalid @enderror">{{ old('business_address') }}</textarea>
            @error('business_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label required">Pincode</label>
            <input type="text" name="pincode" class="form-control @error('pincode') is-invalid @enderror"
                   value="{{ old('pincode') }}">
            @error('pincode') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

       <div class="col-md-4">
    <label class="form-label required">State</label>
    <select name="business_state" class="form-control select2 @error('business_state') is-invalid @enderror">
        <option value="">-- Select State --</option>

        <!-- States -->
        <option value="Andhra Pradesh" {{ old('business_state') == 'Andhra Pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
        <option value="Arunachal Pradesh" {{ old('business_state') == 'Arunachal Pradesh' ? 'selected' : '' }}>Arunachal Pradesh</option>
        <option value="Assam" {{ old('business_state') == 'Assam' ? 'selected' : '' }}>Assam</option>
        <option value="Bihar" {{ old('business_state') == 'Bihar' ? 'selected' : '' }}>Bihar</option>
        <option value="Chhattisgarh" {{ old('business_state') == 'Chhattisgarh' ? 'selected' : '' }}>Chhattisgarh</option>
        <option value="Goa" {{ old('business_state') == 'Goa' ? 'selected' : '' }}>Goa</option>
        <option value="Gujarat" {{ old('business_state') == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
        <option value="Haryana" {{ old('business_state') == 'Haryana' ? 'selected' : '' }}>Haryana</option>
        <option value="Himachal Pradesh" {{ old('business_state') == 'Himachal Pradesh' ? 'selected' : '' }}>Himachal Pradesh</option>
        <option value="Jharkhand" {{ old('business_state') == 'Jharkhand' ? 'selected' : '' }}>Jharkhand</option>
        <option value="Karnataka" {{ old('business_state') == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
        <option value="Kerala" {{ old('business_state') == 'Kerala' ? 'selected' : '' }}>Kerala</option>
        <option value="Madhya Pradesh" {{ old('business_state') == 'Madhya Pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
        <option value="Maharashtra" {{ old('business_state') == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
        <option value="Manipur" {{ old('business_state') == 'Manipur' ? 'selected' : '' }}>Manipur</option>
        <option value="Meghalaya" {{ old('business_state') == 'Meghalaya' ? 'selected' : '' }}>Meghalaya</option>
        <option value="Mizoram" {{ old('business_state') == 'Mizoram' ? 'selected' : '' }}>Mizoram</option>
        <option value="Nagaland" {{ old('business_state') == 'Nagaland' ? 'selected' : '' }}>Nagaland</option>
        <option value="Odisha" {{ old('business_state') == 'Odisha' ? 'selected' : '' }}>Odisha</option>
        <option value="Punjab" {{ old('business_state') == 'Punjab' ? 'selected' : '' }}>Punjab</option>
        <option value="Rajasthan" {{ old('business_state') == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>
        <option value="Sikkim" {{ old('business_state') == 'Sikkim' ? 'selected' : '' }}>Sikkim</option>
        <option value="Tamil Nadu" {{ old('business_state') == 'Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu</option>
        <option value="Telangana" {{ old('business_state') == 'Telangana' ? 'selected' : '' }}>Telangana</option>
        <option value="Tripura" {{ old('business_state') == 'Tripura' ? 'selected' : '' }}>Tripura</option>
        <option value="Uttar Pradesh" {{ old('business_state') == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
        <option value="Uttarakhand" {{ old('business_state') == 'Uttarakhand' ? 'selected' : '' }}>Uttarakhand</option>
        <option value="West Bengal" {{ old('business_state') == 'West Bengal' ? 'selected' : '' }}>West Bengal</option>

        <!-- Union Territories -->
        <option value="Andaman and Nicobar Islands" {{ old('business_state') == 'Andaman and Nicobar Islands' ? 'selected' : '' }}>Andaman and Nicobar Islands</option>
        <option value="Chandigarh" {{ old('business_state') == 'Chandigarh' ? 'selected' : '' }}>Chandigarh</option>
        <option value="Dadra and Nagar Haveli and Daman and Diu" {{ old('business_state') == 'Dadra and Nagar Haveli and Daman and Diu' ? 'selected' : '' }}>Dadra and Nagar Haveli and Daman and Diu</option>
        <option value="Delhi" {{ old('business_state') == 'Delhi' ? 'selected' : '' }}>Delhi</option>
        <option value="Jammu and Kashmir" {{ old('business_state') == 'Jammu and Kashmir' ? 'selected' : '' }}>Jammu and Kashmir</option>
        <option value="Ladakh" {{ old('business_state') == 'Ladakh' ? 'selected' : '' }}>Ladakh</option>
        <option value="Lakshadweep" {{ old('business_state') == 'Lakshadweep' ? 'selected' : '' }}>Lakshadweep</option>
        <option value="Puducherry" {{ old('business_state') == 'Puducherry' ? 'selected' : '' }}>Puducherry</option>
    </select>
    @error('business_state') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="col-md-4">
    <label class="form-label required">Business Category</label>
    <select name="business_category" class="form-control select2 @error('business_category') is-invalid @enderror">
        <option value="">-- Select Category --</option>

        <option value="Retail" {{ old('business_category') == 'Retail' ? 'selected' : '' }}>Retail</option>
        <option value="Wholesale" {{ old('business_category') == 'Wholesale' ? 'selected' : '' }}>Wholesale</option>
        <option value="Manufacturing" {{ old('business_category') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
        <option value="IT & Software" {{ old('business_category') == 'IT & Software' ? 'selected' : '' }}>IT & Software</option>
        <option value="E-Commerce" {{ old('business_category') == 'E-Commerce' ? 'selected' : '' }}>E-Commerce</option>
        <option value="Finance & Banking" {{ old('business_category') == 'Finance & Banking' ? 'selected' : '' }}>Finance & Banking</option>
        <option value="Education" {{ old('business_category') == 'Education' ? 'selected' : '' }}>Education</option>
        <option value="Healthcare" {{ old('business_category') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
        <option value="Real Estate" {{ old('business_category') == 'Real Estate' ? 'selected' : '' }}>Real Estate</option>
        <option value="Hospitality & Tourism" {{ old('business_category') == 'Hospitality & Tourism' ? 'selected' : '' }}>Hospitality & Tourism</option>
        <option value="Transport & Logistics" {{ old('business_category') == 'Transport & Logistics' ? 'selected' : '' }}>Transport & Logistics</option>
        <option value="Agriculture" {{ old('business_category') == 'Agriculture' ? 'selected' : '' }}>Agriculture</option>
        <option value="Textiles & Apparel" {{ old('business_category') == 'Textiles & Apparel' ? 'selected' : '' }}>Textiles & Apparel</option>
        <option value="Food & Beverages" {{ old('business_category') == 'Food & Beverages' ? 'selected' : '' }}>Food & Beverages</option>
        <option value="Media & Entertainment" {{ old('business_category') == 'Media & Entertainment' ? 'selected' : '' }}>Media & Entertainment</option>
        <option value="Construction" {{ old('business_category') == 'Construction' ? 'selected' : '' }}>Construction</option>
        <option value="Automobile" {{ old('business_category') == 'Automobile' ? 'selected' : '' }}>Automobile</option>
        <option value="Telecommunication" {{ old('business_category') == 'Telecommunication' ? 'selected' : '' }}>Telecommunication</option>
        <option value="Other" {{ old('business_category') == 'Other' ? 'selected' : '' }}>Other</option>
    </select>
    @error('business_category') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

    </div>

    <!-- Signatures -->
    <div class="form-section">Signatures</div>
    <div class="row g-4 align-items-center">
        <div class="col-md-6">
            <label class="form-label">Digital Sign</label>
            <input type="file" name="digital_sign" class="form-control @error('digital_sign') is-invalid @enderror"
                   accept="image/*" onchange="previewImage(event, 'digitalPreview')">
            @error('digital_sign') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <div class="text-center mt-2">
                <img id="digitalPreview" src="https://via.placeholder.com/120" class="preview-img" alt="Preview">
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Business Signature</label>
            <input type="file" name="business_signature" class="form-control @error('business_signature') is-invalid @enderror"
                   accept="image/*" onchange="previewImage(event, 'signaturePreview')">
            @error('business_signature') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <div class="text-center mt-2">
                <img id="signaturePreview" src="https://via.placeholder.com/120" class="preview-img" alt="Preview">
            </div>
        </div>
    </div>

    <!-- Buttons -->
    <div class="text-end mt-4">
        <a href="{{ route('business_profiles.index') }}" class="btn btn-light border">Cancel</a>
        <button type="submit" class="btn btn-primary">Save Business</button>
    </div>
</form>

        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@if(session('success'))
    <script>
        Swal.fire({
            title: "Success!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "OK"
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            title: "Error!",
            text: "{{ session('error') }}",
            icon: "error",
            confirmButtonColor: "#d33",
            confirmButtonText: "Close"
        });
    </script>
@endif

<script>
    function previewImage(event, id) {
        const reader = new FileReader();
        reader.onload = function () {
            document.getElementById(id).src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection

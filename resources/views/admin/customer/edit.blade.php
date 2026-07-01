@extends('layouts.master')

@section('title', 'Edit Customer')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
        .btn {
            border-radius: 6px;
            padding: 0.55rem 1.2rem;
        }
    </style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="form-card">
            <h4 class="mb-4"><i class="bi bi-people me-2"></i> Edit Customer</h4>

      <form action="{{ route('admin-customers.update', [
    'company_slug' => $company_slug,
    'admin_customer' => $customer->id
]) }}" method="POST">
    @csrf
    @method('PUT')

                <!-- Basic Info -->
                <div class="form-section">Customer Information</div>
                <div class="row g-4">
                    <div class="col-md-3">
                        <label class="form-label required">Customer Name</label>
                        <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror"
                               value="{{ old('customer_name', $customer->customer_name) }}">
                        @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror"
                               value="{{ old('company_name', $customer->company_name) }}">
                        @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label required">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $customer->email) }}">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $customer->phone) }}">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- GST Info -->
                <div class="form-section">GST Information</div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <label class="form-label">GST Number</label>
                        <input type="text" name="gst" class="form-control @error('gst') is-invalid @enderror"
                               value="{{ old('gst', $customer->gst) }}">
                        @error('gst') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">GST Treatment</label>
                        <select name="gst_treatment" class="form-control select2 @error('gst_treatment') is-invalid @enderror">
                            <option value="">Select GST Treatment</option>
                            <option value="Registered Business" {{ old('gst_treatment', $customer->gst_treatment) == 'Registered Business' ? 'selected' : '' }}>
                                Registered Business
                            </option>
                            <option value="Unregistered Business" {{ old('gst_treatment', $customer->gst_treatment) == 'Unregistered Business' ? 'selected' : '' }}>
                                Unregistered Business
                            </option>
                        </select>
                        @error('gst_treatment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Address -->
                <div class="form-section">Location Information</div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Place of Supply</label>
                        <input type="text" name="place_of_supply" class="form-control @error('place_of_supply') is-invalid @enderror"
                               value="{{ old('place_of_supply', $customer->place_of_supply) }}">
                        @error('place_of_supply') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">State</label>
                        <select name="state" class="form-control select2 @error('state') is-invalid @enderror">
                            <option value="">Select State</option>
                            @foreach([
                                'Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Delhi','Goa',
                                'Gujarat','Haryana','Himachal Pradesh','Jharkhand','Karnataka','Kerala',
                                'Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha',
                                'Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh',
                                'Uttarakhand','West Bengal'
                            ] as $state)
                                <option value="{{ $state }}" {{ old('state', $customer->state) == $state ? 'selected' : '' }}>
                                    {{ $state }}
                                </option>
                            @endforeach
                        </select>
                        @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Assign User -->
                <div class="form-section">Assign User</div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label required">Select User</label>
                        <select name="user_id" class="form-control select2 @error('user_id') is-invalid @enderror">
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $customer->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Buttons -->
                <div class="text-end mt-4">
                    <a href="{{ route('admin-customers.index', $company_slug) }}" class="btn btn-light border">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Customer</button>
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

<script>
    $(function () {
        $('.select2').select2({ width: '100%' });
    });
</script>
@endsection

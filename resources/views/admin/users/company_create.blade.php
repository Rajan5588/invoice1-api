@extends('layouts.master')

@section('title', 'Create Company')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .form-card {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .form-section {
            margin-top: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #f0f0f0;
            font-weight: 600;
            font-size: 0.95rem;
            color: #495057;
        }
        .form-label {
            font-weight: 500;
        }
        .form-control, .select2-container--default .select2-selection--single {
            border-radius: 6px;
            padding: 0.55rem 0.75rem;
            font-size: 0.9rem;
        }
        .btn {
            border-radius: 6px;
            font-weight: 500;
            padding: 0.55rem 1.2rem;
        }
        .input-group .btn {
            border-radius: 0 6px 6px 0;
        }
        .required:after {
            content:" *";
            color:red;
        }
    </style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="form-card">
            <h5 class="mb-3"><i class="bi bi-building me-2"></i> Add Company</h5>
            <form action="{{ route('company.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Company Info -->
                <div class="form-section">Company Information</div>
                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label class="form-label required">Company Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Logo</label>
                        <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror">
                        @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Address Info -->
                <div class="form-section">Address & GST</div>
                <div class="row g-3 mt-1">
                    <div class="col-md-12">
                        <label class="form-label">Full Address</label>
                        <textarea name="full_address" rows="2" class="form-control @error('full_address') is-invalid @enderror">{{ old('full_address') }}</textarea>
                        @error('full_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" value="{{ old('state') }}">
                        @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">District</label>
                        <input type="text" name="district" class="form-control @error('district') is-invalid @enderror" value="{{ old('district') }}">
                        @error('district') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">GST Number</label>
                        <input type="text" name="gst_no" class="form-control @error('gst_no') is-invalid @enderror" value="{{ old('gst_no') }}">
                        @error('gst_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                     <div class="col-md-3">
                        <label class="form-label required">Role</label>
                        <select name="role_id" class="form-control select2 @error('role_id') is-invalid @enderror">
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->role_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Account Setup -->
                <div class="form-section">Account Setup</div>
                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label class="form-label required">Password</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            <button type="button" class="btn btn-outline-secondary toggle-password"><i class="bi bi-eye"></i></button>
                        </div>
                        @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                            <button type="button" class="btn btn-outline-secondary toggle-password-confirm"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Subscription</label>
                        <select name="subs_id" class="form-control select2 @error('subs_id') is-invalid @enderror">
                            <option value="">Select Subscription</option>
                            @foreach($subscriptions as $subscription)
                                <option value="{{ $subscription->id }}" {{ old('subs_id') == $subscription->id ? 'selected' : '' }}>
                                    {{ $subscription->plan_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('subs_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control select2 @error('status') is-invalid @enderror">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Buttons -->
                <div class="text-end mt-4">
                    <a href="{{ route('company.index') }}" class="btn btn-light border">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Company</button>
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

        $('.toggle-password').click(function() {
            const input = $('#password');
            input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
            $(this).find('i').toggleClass('bi-eye bi-eye-slash');
        });
        $('.toggle-password-confirm').click(function() {
            const input = $('#password_confirmation');
            input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
            $(this).find('i').toggleClass('bi-eye bi-eye-slash');
        });
    });
</script>
@endsection

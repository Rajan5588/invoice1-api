@extends('layouts.master')

@section('title', 'Create User')

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
            <h4 class="mb-4"><i class="bi bi-person-plus me-2"></i> Create User</h4>

            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Basic Info -->
                <div class="form-section">Basic Information</div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <label class="form-label required">Full Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label required">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone') }}">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Company Dropdown -->
                    <div class="col-md-4">
                        <label class="form-label required">Company</label>
                       <select name="company_code" class="form-control select2 @error('company_code') is-invalid @enderror">
    <option value="">Select Company</option>
    @foreach($companies as $company)
        <option value="{{ $company->company_code }}" {{ old('company_code') == $company->company_code ? 'selected' : '' }}>
            {{ $company->name }} ({{ $company->company_code }})
        </option>
    @endforeach
</select>
@error('company_code') <div class="invalid-feedback">{{ $message }}</div> @enderror

                       
                    </div>

                    <!-- Role Dropdown -->
                    <div class="col-md-4">
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

                <!-- Address -->
                <div class="form-section">Address</div>
                <div class="row g-4">
                    <div class="col-md-12">
                        <label class="form-label">Full Address</label>
                        <textarea name="full_address" rows="2" class="form-control @error('full_address') is-invalid @enderror">{{ old('full_address') }}</textarea>
                        @error('full_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control @error('state') is-invalid @enderror"
                               value="{{ old('state') }}">
                        @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">District</label>
                        <input type="text" name="district" class="form-control @error('district') is-invalid @enderror"
                               value="{{ old('district') }}">
                        @error('district') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Account -->
                <div class="form-section">Account Setup</div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <label class="form-label required">Password</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror">
                            <button type="button" class="btn btn-outline-secondary toggle-password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label required">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                            <button type="button" class="btn btn-outline-secondary toggle-password-confirm">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control select2 @error('status') is-invalid @enderror">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Profile Image -->
                <div class="form-section">Profile Image</div>
                <div class="row g-4 align-items-center">
                    <div class="col-md-6">
                        <label class="form-label">Upload Avatar</label>
                        <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror"
                               accept="image/*" onchange="previewImage(event)">
                        @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 text-center">
                        <img id="preview" src="https://via.placeholder.com/120" class="preview-img" alt="Preview">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="text-end mt-4">
                    <a href="{{ route('users.index') }}" class="btn btn-light border">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save User</button>
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

        // Toggle password visibility
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

    // Preview profile image
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection

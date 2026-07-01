@extends('layouts.master')

@section('title')
    Change Password
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Profile @endslot
        @slot('title') Change Password @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Update Your Password</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('change-password-update') }}" method="POST">
                        @csrf

                        <div class="row g-3">

                            <div class="col-12">
                                <div class="form-floating position-relative">
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" id="newPassword" placeholder="New Password">
                                    <label for="newPassword">New Password</label>
                                    <span class="position-absolute top-50 end-0 translate-middle-y me-3" onclick="togglePassword('newPassword', this)" style="cursor: pointer;">
                                        <i class="bi bi-eye-slash" id="toggleNewPassword"></i>
                                    </span>
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating position-relative">
                                    <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" name="new_password_confirmation" id="confirmPassword" placeholder="Confirm Password">
                                    <label for="confirmPassword">Confirm Password</label>
                                    <span class="position-absolute top-50 end-0 translate-middle-y me-3" onclick="togglePassword('confirmPassword', this)" style="cursor: pointer;">
                                        <i class="bi bi-eye-slash" id="toggleConfirmPassword"></i>
                                    </span>
                                    @error('new_password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 text-end">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@section('script')
    <!-- jQuery (optional, already included) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"></script>

    <!-- ✅ Bootstrap Icons CDN (required for eye/eye-slash icons) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script>
        function togglePassword(fieldId, el) {
            const field = document.getElementById(fieldId);
            const icon = el.querySelector('i');
            if (field.type === "password") {
                field.type = "text";
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                field.type = "password";
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        }
    </script>
@endsection

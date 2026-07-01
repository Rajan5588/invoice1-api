@extends('layouts.master')

@section('title') Create Permission @endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .form-check-label {
            font-weight: 100;
        }
        .permission-item {
            padding: 2px 5px;
            min-height: 20px;
        }
        .module-title {
            margin-top: 10px;
            margin-bottom: 5px;
            font-size: 11px;
            font-weight: 100;
            color: #2c3e50;
            border-bottom: 1px solid #ddd;
            padding-bottom: 6px;
        }
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 30px;
            height: 16px;
        }
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 20px;
        }
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 14px;
            width: 14px;
            left: 1px;
            bottom: 1px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }
        .toggle-switch input:checked + .toggle-slider {
            background-color:#364574;
        }
        .toggle-switch input:checked + .toggle-slider:before {
            transform: translateX(14px);
        }
    </style>
@endsection

@section('content')

@component('components.breadcrumb')
    @slot('li_1') Permission @endslot
    @slot('title') Add Permission @endslot
@endcomponent

<div class="card">
    <div class="card-body">
        <form action="{{ route('permissions.store')}}" method="POST">
            @csrf

            <div class="col-md-3 mb-3">
                <label for="role_id" class="form-label">Select Role</label>
                <select name="role_id" id="role_id" class="form-select select2 @error('role_id') is-invalid @enderror">
                    <option value="">-- Select Role --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->role_name }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            @php
                $modules = [
                    'business_profiles' => 'Business Profiles',
                    'coupons' => 'Coupons',
                    'customers' => 'Customers',
                    'invoices' => 'Invoices',
                    'items' => 'Items',
                    'item_categories' => 'Item Categories',
                    'subscriptions' => 'Subscriptions',
                    'transactions' => 'Transactions',
                    'users' => 'Users',
                    'company' => 'Company',
                    'roles_permissions' => 'Roles Permissions',
                ];

                $actions = [
                    'add' => 'Add',
                    'edit' => 'Edit',
                    'delete' => 'Delete',
                    'view' => 'View',
                ];
            @endphp

            <table class="table align-middle table-nowrap mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:220px;">Module</th>
                        <th colspan="9">Permissions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($modules as $moduleKey => $moduleLabel)
                        <tr>
                            <td><strong>{{ $moduleLabel }}</strong></td>
                            <td colspan="9">
                                <div class="d-flex flex-wrap gap-5">
                                    @foreach($actions as $actionKey => $actionLabel)
                                        <div class="form-check form-switch permission-item">
                                            <label class="form-check-label me-2" for="{{ $moduleKey.'_'.$actionKey }}">
                                                {{ $actionLabel }}
                                            </label>
                                            @if($actionKey === 'view')
                                                <select name="{{ $moduleKey.'_'.$actionKey }}" class="form-select form-select-sm" style="width:auto; display:inline-block;">
                                                    <option value="own" selected>Own</option>
                                                    <option value="company">Company</option>
                                                    <option value="all">All</option>
                                                </select>
                                            @else
                                                <label class="toggle-switch ms-2">
                                                    <input type="checkbox" name="{{ $moduleKey.'_'.$actionKey }}" id="{{ $moduleKey.'_'.$actionKey }}" value="1">
                                                    <span class="toggle-slider"></span>
                                                </label>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-end">
                <a href="{{ route('permissions.index')}}" class="btn btn-secondary mt-3">Back</a>
                <button type="submit" class="btn btn-primary mt-3">Save Permission</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "-- Select Role --",
                width: '100%'
            });
        });
    </script>
@endsection

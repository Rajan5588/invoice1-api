@extends('layouts.master')

@section('title') Coupons @endsection

@section('css')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" />
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Coupons @endslot
    @slot('title') Manage Coupons @endslot
@endcomponent

<div class="row">
    <!-- Coupons List -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h4 class="card-title mb-0 flex-grow-1">Coupons</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered dt-responsive nowrap table-striped align-middle" id="coupon-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.no</th>
                                <th>Coupon Code</th>
                                <th>Discount (%)</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($coupons as $key => $coupon)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $coupon->coupon_code }}</td>
                                    <td>{{ $coupon->discount }}</td>
                                    <td>{{ $coupon->created_at->format('F d, Y') }}</td>
                                    <td>
                                        @if($permissions['edit'])
                                            <a href="{{ route('coupons.index', ['edit' => $coupon->id, 'company_slug' => $company_slug]) }}" class="btn btn-sm btn-info">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                        @endif
                                        @if($permissions['destroy'])
                                            <form id="delete-form-{{ $coupon->id }}" action="{{ route('coupons.destroy', ['coupon' => $coupon->id, 'company_slug' => $company_slug]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger sa-warning" data-id="{{ $coupon->id }}"><i class="ri-delete-bin-line"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Coupon Form -->
    @if($permissions['add'])
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h4 class="card-title mb-0 flex-grow-1">{{ isset($editCoupon) ? 'Edit Coupon' : 'Add Coupon' }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ isset($editCoupon) ? route('coupons.update', ['coupon' => $editCoupon->id, 'company_slug' => $company_slug]) : route('coupons.store', ['company_slug' => $company_slug]) }}" method="POST">
                    @csrf
                    @if(isset($editCoupon)) @method('PUT') @endif

                    <div class="mb-3">
                        <label class="form-label">Coupon Code</label>
                        <input type="text" name="coupon_code" class="form-control"
                               value="{{ old('coupon_code', $editCoupon->coupon_code ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Discount (%)</label>
                        <input type="number" name="discount" class="form-control" step="0.01" min="0" max="100"
                               value="{{ old('discount', $editCoupon->discount ?? '') }}" required>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">{{ isset($editCoupon) ? 'Update' : 'Submit' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('#coupon-table').DataTable();

        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        $('.sa-warning').on('click', function () {
            const id = $(this).data('id');
            Swal.fire({
                title: "Are you sure?",
                text: "This coupon will be deleted!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $(`#delete-form-${id}`).submit();
                }
            });
        });
    });
</script>
@endsection

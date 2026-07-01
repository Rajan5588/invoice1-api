@extends('layouts.master')

@section('title') Subscriptions @endsection

@section('css')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" />
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Subscriptions @endslot
    @slot('title') Subscription Plans @endslot
@endcomponent

<div class="row" style="display: flex; justify-content: space-between; gap: 20px;">
    <!-- Subscriptions List -->
    <div class="col-xl-12" >
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h4 class="card-title mb-0 flex-grow-1">Subscriptions</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered dt-responsive nowrap table-striped align-middle" id="subscription-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.no</th>
                                <th>Plan Name</th>
                                <th>Price (₹)</th>
                                <th>Validity (days)</th>
                                <th>Status</th>
                                <th>Description</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
<tbody>
    @foreach($subscriptions as $key => $subscription)
        <tr>
            <th>{{ $key + 1 }}</th>
            <td>{{ $subscription->plan_name }}</td>
            <td>{{ $subscription->plan_price }}</td>
            <td>{{ $subscription->plan_validity }}</td>
            <td>
                <span class="badge bg-{{ $subscription->plan_status == 'active' ? 'success' : 'danger' }}">
                    {{ ucfirst($subscription->plan_status) }}
                </span>
            </td>
            <td>{{ $subscription->plan_description }}</td>
            <td>{{ $subscription->created_at->format('F d, Y') }}</td>
            <td>
                {{-- ✅ Edit permission --}}
                @if($permissions['edit'] == 1)
                    <a href="{{ route('subscriptions.index', ['edit' => $subscription->id]) }}" 
                       class="btn btn-sm btn-info">
                        <i class="ri-edit-line"></i>
                    </a>
                @endif

                {{-- ✅ Delete permission --}}
                @if($permissions['delete'] == 1)
                    <form id="delete-form-{{ $subscription->id }}" 
                          action="{{ route('subscriptions.destroy', $subscription->id) }}" 
                          method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger sa-warning" 
                                data-id="{{ $subscription->id }}">
                            <i class="ri-delete-bin-line"></i>
                        </button>
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

     <!--Create/Edit Subscription Form -->
<!--<div class="col-xl-12" >-->
<!--    <div class="card">-->
<!--        <div class="card-header d-flex align-items-center">-->
<!--            <h4 class="card-title mb-0 flex-grow-1">{{ isset($editSubscription) ? 'Edit Subscription' : 'Add Subscription' }}</h4>-->
<!--        </div>-->

<!--        <div class="card-body">-->
<!--            <form action="{{ isset($editSubscription) ? route('subscriptions.update', $editSubscription->id) : route('subscriptions.store') }}" method="POST">-->
<!--                @csrf-->
<!--                @if(isset($editSubscription)) @method('PUT') @endif-->

<!--                <div class="mb-3">-->
<!--    <div class="row g-2">-->
<!--         <div class="col-md-6">-->
<!--                    <label class="form-label">Plan Name</label>-->
<!--                    <input type="text" name="plan_name" class="form-control"-->
<!--                           value="{{ old('plan_name', $editSubscription->plan_name ?? '') }}" required>-->
<!--                </div>-->

<!--                <div class="col-md-6">-->
<!--                    <label class="form-label">Plan Price</label>-->
<!--                    <input type="number" step="0.01" name="plan_price" class="form-control" min="0"-->
<!--                           value="{{ old('plan_price', $editSubscription->plan_price ?? '') }}" required>-->
<!--                </div>-->
<!--                </div>-->
<!--                </div>-->

<!--              <div class="mb-3">-->
<!--    <div class="row g-2">-->
<!--        <div class="col-md-4">-->
<!--                    <label class="form-label">Status</label>-->
<!--                    <select name="plan_status" class="form-control">-->
<!--                        <option value="active" {{ old('plan_status', $editSubscription->plan_status ?? '') == 'active' ? 'selected' : '' }}>Active</option>-->
<!--                        <option value="inactive" {{ old('plan_status', $editSubscription->plan_status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>-->
<!--                    </select>-->
<!--                </div>-->
<!--         <div class="col-md-2">-->
<!--                    <label class="form-label">Validity (days)</label>-->
<!--                    <input type="number" name="plan_validity" class="form-control" -->
<!--                           value="{{ old('plan_validity', $editSubscription->plan_validity ?? '') }}" required>-->
<!--                </div>-->

               
           
             
<!--        <div class="col-md-2">-->
<!--            <label class="form-label">Users</label>-->
<!--            <input type="number" name="user_add_count" class="form-control" min="0"-->
<!--                   value="{{ old('user_add_count', $editSubscription->user_add_count ?? '') }}" required>-->
<!--        </div>-->

<!--        <div class="col-md-2">-->
<!--            <label class="form-label">Businesses</label> -->
<!--            <input type="number" name="business_add_count" class="form-control" min="0"-->
<!--                   value="{{ old('business_add_count', $editSubscription->business_add_count ?? '') }}" required>-->
<!--        </div>-->

<!--        <div class="col-md-2">-->
<!--            <label class="form-label">Invoices</label>-->
<!--            <input type="number" name="invoice_add_count" class="form-control" min="0"-->
<!--                   value="{{ old('invoice_add_count', $editSubscription->invoice_add_count ?? '') }}" required>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!--                <div class="mb-3">-->
<!--    <label class="form-label">Description</label>-->
<!--    <textarea name="plan_description" class="form-control" rows="3" required>{{ old('plan_description', $editSubscription->plan_description ?? '') }}</textarea>-->
<!--</div>-->


<!--                <div class="text-end">-->
<!--                    <button type="submit" class="btn btn-primary">{{ isset($editSubscription) ? 'Update' : 'Submit' }}</button>-->
<!--                </div>-->
<!--            </form>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
{{-- Only show form if user has add permission OR editing is allowed --}}
@if(($permissions['add'] == 1 && !isset($editSubscription)) || ($permissions['edit'] == 1 && isset($editSubscription)))
<div class="col-xl-12">
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h4 class="card-title mb-0 flex-grow-1">
                {{ isset($editSubscription) ? 'Edit Subscription' : 'Add Subscription' }}
            </h4>
        </div>

        <div class="card-body">
            <form action="{{ isset($editSubscription) ? route('subscriptions.update', $editSubscription->id) : route('subscriptions.store') }}" method="POST">
                @csrf
               @csrf
                @if(isset($editSubscription)) @method('PUT') @endif

                <div class="mb-3">
    <div class="row g-2">
         <div class="col-md-6">
                    <label class="form-label">Plan Name</label>
                    <input type="text" name="plan_name" class="form-control"
                           value="{{ old('plan_name', $editSubscription->plan_name ?? '') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Plan Price</label>
                    <input type="number" step="0.01" name="plan_price" class="form-control" min="0"
                           value="{{ old('plan_price', $editSubscription->plan_price ?? '') }}" required>
                </div>
                </div>
                </div>

              <div class="mb-3">
    <div class="row g-2">
        <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="plan_status" class="form-control">
                        <option value="active" {{ old('plan_status', $editSubscription->plan_status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('plan_status', $editSubscription->plan_status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
         <div class="col-md-2">
                    <label class="form-label">Validity (days)</label>
                    <input type="number" name="plan_validity" class="form-control" 
                           value="{{ old('plan_validity', $editSubscription->plan_validity ?? '') }}" required>
                </div>

               
           
             
        <div class="col-md-2">
            <label class="form-label">Users</label>
            <input type="number" name="user_add_count" class="form-control" min="0"
                   value="{{ old('user_add_count', $editSubscription->user_add_count ?? '') }}" required>
        </div>

        <div class="col-md-2">
            <label class="form-label">Businesses</label> 
            <input type="number" name="business_add_count" class="form-control" min="0"
                   value="{{ old('business_add_count', $editSubscription->business_add_count ?? '') }}" required>
        </div>

        <div class="col-md-2">
            <label class="form-label">Invoices</label>
            <input type="number" name="invoice_add_count" class="form-control" min="0"
                   value="{{ old('invoice_add_count', $editSubscription->invoice_add_count ?? '') }}" required>
        </div>
    </div>
</div>

                <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="plan_description" class="form-control" rows="3" required>{{ old('plan_description', $editSubscription->plan_description ?? '') }}</textarea>
</div>

                ...
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($editSubscription) ? 'Update' : 'Submit' }}
                    </button>
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
        $('#subscription-table').DataTable();

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
                text: "This subscription will be deleted!",
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

@extends('layouts.master')

@section('title') Companies @endsection

@section('css')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" />
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Companies @endslot
    @slot('title') Company Data @endslot
@endcomponent

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Companies Table</h5>
               <div class="d-flex align-items-center">
        <div id="company-filter" class="me-2">
            <select id="filter" class="form-select form-select-sm">
                <option value="">All Companies</option>
                <option value="subscribed">Subscribed</option>
                <option value="unsubscribed">Unsubscribed</option>
                <option value="near_expiry">Near Expiry (Under 15 days)</option>
                <option value="expired">Expired Subscriptions</option>
                <option value="latest">Latest Companies</option>
            </select>
        </div>

        <!-- Create Company Button -->
        <a href="{{ route('company.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Create Company
        </a>
    </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered dt-responsive nowrap table-striped align-middle" id="companies-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Action</th>
                                <th>Subscription Plan</th>
                                <th>Company Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Logo</th>
                                <th>State</th>
                                <th>District</th>
                                <th>Full Address</th>
                                <th>Subscription Expiry</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script>
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

$(document).ready(function () {
    const table = $('#companies-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("company.get") }}',
            data: function(d) {
                d.filter = $('#filter').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
            { data: 'subscription_plan', name: 'subscription_plan' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'avatar', name: 'avatar', orderable: false, searchable: false },
            { data: 'state', name: 'state' },
            { data: 'district', name: 'district' },
            { data: 'full_address', name: 'full_address' },
            { data: 'subscription_expiry', name: 'subscription_expiry' },
            { data: 'created_at', name: 'created_at' }
        ],
        dom: "<'d-flex justify-content-between mb-2'B<'#company-filter'>f>rtip",
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        responsive: true
    });

    $('#filter').change(function() {
        table.ajax.reload();
    });

    // SweetAlert delete
    $(document).on('click', '.sa-warning', function (e) {
        e.preventDefault();
        let deleteUrl = $(this).data('url');

        Swal.fire({
            title: "Are you sure?",
            text: "This company will be deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteUrl,
                    type: 'DELETE',
                    success: function (response) {
                        Swal.fire("Deleted!", response.message, "success");
                        table.ajax.reload();
                    },
                    error: function (xhr) {
                        Swal.fire("Error!", xhr.responseJSON.message, "error");
                    }
                });
            }
        });
    });
});
</script>
@endsection

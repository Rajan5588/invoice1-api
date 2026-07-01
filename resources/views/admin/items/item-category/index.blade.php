@extends('layouts.master')

@section('title') Item Categories @endsection

@section('css')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" />
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Item Categories @endslot
    @slot('title') Item Categories  @endslot
@endcomponent

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row">

    <!-- Left side: Item Categories Table -->
    @if(!empty($permissions['view']))
    <div class="col-xl-8 col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Item Categories </h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered dt-responsive nowrap table-striped align-middle" id="item-categories-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Action</th>
                                <th>Category Name</th>
                                <th>User Name</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Right side: Add Category Form -->
    @if(!empty($permissions['add']))
    <div class="col-xl-4 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Add Category</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('categories.store', $company_slug) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter category name" required>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Add Category</button>
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
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    @if(!empty($permissions['view']))
    const table = $('#item-categories-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("item_categories.get", $company_slug) }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
            { data: 'item_category_name', name: 'item_category_name' },
            { data: 'user_name', name: 'user.name' },
            { data: 'created_at', name: 'created_at' },
        ],
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        responsive: true
    });

    @if(!empty($permissions['delete']))
    $(document).on('click', '.sa-warning', function (e) {
        e.preventDefault();
        let deleteUrl = $(this).data('url');

        Swal.fire({
            title: "Are you sure?",
            text: "This category will be deleted!",
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
                        $('#item-categories-table').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        Swal.fire("Error!", xhr.responseJSON.message, "error");
                    }
                });
            }
        });
    });
    @endif
    @endif
});
</script>
@endsection

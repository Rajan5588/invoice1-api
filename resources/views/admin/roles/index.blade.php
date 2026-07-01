@extends('layouts.master')

@section('title') Roles @endsection

@section('css')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" />
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Roles @endslot
    @slot('title') Roles  @endslot
@endcomponent

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row">
    <!-- Roles Table -->
    <div class="col-xl-8 col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Roles </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered dt-responsive nowrap table-striped align-middle" id="roles-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Action</th>
                                <th>Role Name</th>
                                <th>Owner Name</th>
                                <th>Company Code</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Role Form -->
    <div class="col-xl-4 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0" id="form-title">Add Role</h5>
            </div>
            <div class="card-body">
                <form id="role-form" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="role_name" class="form-label">Role Name</label>
                        <input type="text" class="form-control" id="role_name" name="role_name" placeholder="Enter role name" required>
                    </div>
                    <!-- Hidden owner -->
                    <input type="hidden" name="owner_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="role_id" id="role_id">
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary" id="submit-btn">Add Role</button>
                        <button type="button" class="btn btn-secondary" id="cancel-btn" style="display:none;">Cancel</button>
                    </div>
                </form>
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
$.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });

$(document).ready(function () {
    // pass company_slug from backend
    const companySlug = "{{ $company_slug }}";

    const table = $('#roles-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('roles.get', $company_slug) }}", // ✅ include slug
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'action', name: 'action', orderable:false, searchable:false },
            { data: 'role_name', name: 'role_name' },
            { data: 'owner_name', name: 'owner.name' },
            { data: 'company_code', name: 'company_code' },
            { data: 'created_at', name: 'created_at' },
        ],
        dom: 'Bfrtip',
        buttons: ['copy','csv','excel','pdf','print'],
        responsive:true
    });

    // Add/Edit role
    $('#role-form').submit(function(e){
        e.preventDefault();
        let roleId = $('#role_id').val();

        let url = roleId 
    ? `/${companySlug}/roles/${roleId}`   // ✅ update
    : `/${companySlug}/roles`;           // ✅ store

        let method = roleId ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: $(this).serialize(),
            success: function(res){
                Swal.fire('Success!', res.message, 'success');
                $('#role-form')[0].reset();
                $('#submit-btn').text('Add Role');
                $('#form-title').text('Add Role');
                $('#cancel-btn').hide();
                $('#role_id').val('');
                table.ajax.reload();
            },
            error: function(xhr){
                Swal.fire('Error!', xhr.responseJSON.message, 'error');
            }
        });
    });

    // Edit role
    $(document).on('click', '.edit-btn', function(){
        let data = $(this).data();
        $('#role_name').val(data.name);
        $('#role_id').val(data.id);
        $('#submit-btn').text('Update Role');
        $('#form-title').text('Edit Role');
        $('#cancel-btn').show();
    });

    $('#cancel-btn').click(function(){
        $('#role-form')[0].reset();
        $('#submit-btn').text('Add Role');
        $('#form-title').text('Add Role');
        $('#cancel-btn').hide();
        $('#role_id').val('');
    });

    // Delete role
  $(document).on('click', '.sa-warning', function (e) {
    e.preventDefault();
    let deleteUrl = $(this).data('url'); // ✅ already full route

    Swal.fire({
        title: "Are you sure?",
        text: "This role will be deleted!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!"
    }).then((result) => {
        if(result.isConfirmed){
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                success: function(res){
                    Swal.fire("Deleted!", res.message, "success");
                    table.ajax.reload();
                },
                error: function(xhr){
                    Swal.fire("Error!", xhr.responseJSON.message, "error");
                }
            });
        }
    });
});



});
</script>

@endsection

@extends('layouts.master')

@section('title') Permission @endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Permission @endslot
        @slot('title') Permission List @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Role Permissions</h5>
                    <a href="{{ route('permissions.create') }}" class="btn btn-primary">Add Permission</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Action</th>
                                    <th>Role Name</th>
                                    <th>Company Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($permissions as $index => $permission)
                                    <tr>
                                        <td>{{ $permissions->firstItem() + $index }}</td>
                                        <td>
                                            <a href="{{ route('permissions.edit', $permission->id) }}" 
                                               class="btn btn-sm btn-success">
                                                <i class="ri-edit-fill"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger delete-button" 
                                                    data-url="{{ route('permissions.destroy', $permission->id) }}">
                                                <i class="ri-delete-bin-fill"></i>
                                            </button>
                                        </td>
                                        <td>{{ $permission->role->role_name ?? '-' }}</td>
                                        <td>{{ $permission->company->name ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No permissions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-end">
                            {{ $permissions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    <script>
        $(document).on('click', '.delete-button', function () {
            const button = $(this);
            const deleteUrl = button.data('url');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7066e0',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: deleteUrl,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            location.reload();
                        },
                        error: function (xhr) {
                            Swal.fire('Error!', xhr.responseJSON?.message || 'Something went wrong.', 'error');
                        }
                    });
                }
            });
        });

        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endsection

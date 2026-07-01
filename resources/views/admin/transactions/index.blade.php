@extends('layouts.master')

@section('title') Transactions @endsection

@section('css')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Transactions @endslot
        @slot('title') Transactions  @endslot
    @endcomponent

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Transactions </h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered dt-responsive nowrap table-striped align-middle" id="transactions-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    
                                    <th>Invoice ID</th>
                                    <th>User</th>
                                    <th>Customer Name</th>
                                    <th>Date</th>
                                    <th>Status</th>
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

<script>
$(document).ready(function () {
    let table = $('#transactions-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("transactions.get") }}',
            data: function (d) {
                d.status = $('#statusFilter').val(); // send status filter to backend
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
           
            { data: 'invoice_id', name: 'invoice_id' },
            { data: 'user.name', name: 'user.name' },
            { data: 'customer_name', name: 'customer_name' },
            { data: 'date', name: 'date' },
            { data: 'status', name: 'status' },
            { data: 'created_at', name: 'created_at' },
        ],
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        responsive: true,
        initComplete: function () {
            // Add dropdown filter after the buttons
            $(".dt-buttons").append(`
                <select id="statusFilter" class="form-select form-select-sm ms-2" style="width:150px; display:inline-block;">
                    <option value="">All Status</option>
                    <option value="paid">Paid</option>
                    <option value="unpaid">Unpaid</option>
                    <option value="overdue">Overdue</option>
                </select>
            `);

            // Reload table when filter changes
            $('#statusFilter').on('change', function () {
                table.ajax.reload();
            });
        }
    });
});

</script>
@endsection

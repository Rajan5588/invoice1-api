@extends('layouts.master')

@section('title') Expenses @endsection

@section('css')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" />
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
@endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Expenses @endslot
    @slot('title') Expenses @endslot
@endcomponent

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Expenses</h5>
                <button id="addExpenseBtn" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Add Expense
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered dt-responsive nowrap table-striped align-middle" id="expenses-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Action</th>
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th>Payment Mode</th>
                                <th>Status</th>
                                <th>Notes</th>
                                <th>Photos</th> {{-- 👈 Added --}}
                                <th>Created At</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================= Add/Edit Expense Modal ================= --}}
<div class="modal fade" id="expenseModal" tabindex="-1" aria-labelledby="expenseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="expenseModalLabel">Add Expense</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="expenseForm" enctype="multipart/form-data">
        <div class="modal-body">
          <input type="hidden" name="id" id="expense_id">

          <div class="row">
            {{-- Left Side --}}
            <div class="col-md-6 border-end">
                <div class="mb-3">
                    <label class="form-label">What is this Spent for</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter purpose" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Amount</label>
                    <input type="number" step="0.01" class="form-control" name="amount" id="amount" placeholder="Enter Amount" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category" id="category" class="form-select" required>
                        <option value="">Select Category</option>
                        <option value="Travel">Travel</option>
                        <option value="Food">Food</option>
                        <option value="Supplies">Supplies</option>
                        <option value="Maintenance">Maintenance</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Expense Note Date</label>
                    <input type="date" class="form-control" name="expense_date" id="expense_date" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notes (Optional)</label>
                    <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Enter notes..."></textarea>
                </div>
            </div>

            {{-- Right Side --}}
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Choose Payment Mode</label>
                    <select name="payment_mode" id="payment_mode" class="form-select" required>
                        <option value="">Select Payment Mode</option>
                        <option value="Cash">Cash</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="UPI">UPI</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Add Photo <small class="text-muted">(receipt/warranty)</small></label>
                    <div class="d-flex gap-2 flex-wrap">
                        <label class="upload-box border rounded d-flex justify-content-center align-items-center flex-column" 
                               style="width:100px; height:100px; cursor:pointer;">
                            <i class="bi bi-plus-lg fs-3"></i>
                            <input type="file" name="photos[]" id="photos" class="d-none" multiple>
                        </label>
                        <div id="previewImages" class="d-flex flex-wrap gap-2"></div>
                    </div>
                </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="saveExpenseBtn">Save</button>
        </div>
      </form>
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
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    let table = $('#expenses-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin-expenses.index", $company_slug) }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'amount', name: 'amount' },
            { data: 'category', name: 'category' },
            { data: 'expense_date', name: 'expense_date' },
            { data: 'payment_mode', name: 'payment_mode' },
            { data: 'status', name: 'status' },
            { data: 'notes', name: 'notes' },
            { data: 'photos', name: 'photos', orderable: false, searchable: false },
            { data: 'created_at', name: 'created_at' }
        ],
        dom: "<'d-flex justify-content-between mb-2'Bf>rtip",
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        responsive: true
    });

    // Open Add Modal
    $('#addExpenseBtn').click(function () {
        $('#expenseForm')[0].reset();
        $('#expense_id').val('');
        $('#previewImages').html('');
        $('#expenseModalLabel').text('Add Expense');
        $('#expenseModal').modal('show');
    });

    // Edit
    $(document).on('click', '.editExpense', function () {
        let id = $(this).data('id');
        $.get("{{ url($company_slug.'/admin-expenses') }}/" + id + "/edit", function (data) {
            $('#expense_id').val(data.id);
            $('#title').val(data.title);
            $('#amount').val(data.amount);
            $('#category').val(data.category);
            $('#expense_date').val(data.expense_date);
            $('#payment_mode').val(data.payment_mode);
            $('#notes').val(data.notes);

            // Existing photos
            $('#previewImages').html('');
            if (data.photos && data.photos.length > 0) {
                data.photos.forEach(function(photo) {
                    $('#previewImages').append(
                        '<img src="{{ asset("assets/expenses") }}/'+photo+'" class="rounded border" style="width:100px; height:100px; object-fit:cover;">'
                    );
                });
            }

            $('#expenseModalLabel').text('Edit Expense');
            $('#expenseModal').modal('show');
        });
    });

    // Save (Add + Update)
    $('#expenseForm').submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        let id = $('#expense_id').val();
        let url = id ? "{{ url($company_slug.'/admin-expenses') }}/" + id : "{{ route('admin-expenses.store', $company_slug) }}";
        if (id) formData.append('_method', 'PUT');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                $('#expenseModal').modal('hide');
                Swal.fire("Success!", res.success, "success");
                table.ajax.reload();
            },
            error: function () {
                Swal.fire("Error!", "Something went wrong.", "error");
            }
        });
    });

    // Delete
    // Delete
$(document).on('click', '.sa-warning', function (e) {
    e.preventDefault();
    let deleteUrl = $(this).data('url');

    Swal.fire({
        title: "Are you sure?",
        text: "This expense will be deleted!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                success: function (response) {
                    Swal.fire({
                        title: "Deleted!",
                        text: response.message,
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        // ✅ Reload DataTable after SweetAlert closes
                        table.ajax.reload(null, false); 
                    });
                },
                error: function () {
                    Swal.fire("Error!", "Could not delete the expense.", "error");
                }
            });
        }
    });
});


    // Change Status
    $(document).on('change', '.changeStatus', function () {
        let id = $(this).data('id');
        let statusVal = $(this).val();
        $.post("{{ url($company_slug.'/admin-expenses') }}/" + id + "/status", { status: statusVal }, function (response) {
            Swal.fire("Updated!", response.success, "success");
            table.ajax.reload();
        });
    });

    // Preview new Images
    $('#photos').on('change', function () {
        $('#previewImages').html('');
        let files = this.files;
        if (files) {
            Array.from(files).forEach(file => {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#previewImages').append('<img src="'+e.target.result+'" class="rounded border" style="width:100px; height:100px; object-fit:cover;">');
                }
                reader.readAsDataURL(file);
            });
        }
    });
});
</script>
@endsection

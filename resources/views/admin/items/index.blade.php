@extends('layouts.master')

@section('title') Items @endsection

@section('css')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" />
@endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Items @endslot
    @slot('title') Items  @endslot
@endcomponent

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="row">
    <!-- Items Table -->
    <div class="col-xl-6 col-lg-5">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Items </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered dt-responsive nowrap table-striped align-middle" id="items-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Action</th>
                                <th>Item Name</th>
                                <th>User Name</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Item Form -->
    @if($permissions['add'] == 1)
    <div class="col-xl-6 col-lg-7">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Add Item</h6>
            </div>
            <div class="card-body">
                <form id="itemForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                    <!-- Item Name -->
                    <div class="mb-3">
                        <label for="item_name" class="form-label">Item Name</label>
                        <input type="text" class="form-control" id="item_name" name="item_name" placeholder="Enter item name" required>
                    </div>

                    <!-- Tabs -->
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#pricing">Pricing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#stock">Stock</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#other">Other</a>
                        </li>
                    </ul>

                    <div class="tab-content text-muted">
                        <!-- Pricing Tab -->
                        <div class="tab-pane fade show active" id="pricing">
                            <h6 class="mb-3">Pricing</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Unit</label>
                                    <input type="text" class="form-control" name="pricings[0][unit]" placeholder="Unit">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Sales Price</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="pricings[0][salesprice_amount]" placeholder="Sales Price">
                                        <select class="form-select" name="pricings[0][salesprice_tax]" style="max-width: 100px;">
                                            <option value="">GST</option>
                                            <option value="1">With GST</option>
                                            <option value="0">Without GST</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Purchase Price</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="pricings[0][purches_price_amount]" placeholder="Purchase Price">
                                        <select class="form-select" name="pricings[0][purches_price_tax]" style="max-width: 100px;">
                                            <option value="">GST</option>
                                            <option value="1">With GST</option>
                                            <option value="0">Without GST</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">MRP Price</label>
                                    <input type="number" class="form-control" name="pricings[0][mrp_price]" placeholder="MRP Price">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">GST</label>
                                    <select class="form-control" name="pricings[0][gst]">
                                        <option value="">Select GST</option>
                                        <option value="5">5%</option>
                                        <option value="12">12%</option>
                                        <option value="18">18%</option>
                                        <option value="28">28%</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">HSN No</label>
                                    <input type="text" class="form-control" name="pricings[0][hsn_no]" placeholder="HSN No">
                                </div>
                            </div>
                        </div>

                        <!-- Stock Tab -->
                        <div class="tab-pane fade" id="stock">
                            <h6 class="mb-3">Stock</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Opening Stock</label>
                                    <input type="number" class="form-control" name="stocks[0][opening_stock]" placeholder="Opening Stock">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">As of Date</label>
                                    <input type="date" class="form-control" name="stocks[0][as_of_date]">
                                </div>
                            </div>
                            <div class="form-check form-switch mt-3">
                                <input class="form-check-input" type="checkbox" id="lowStockSwitch">
                                <label class="form-check-label" for="lowStockSwitch">Enable Low Stock Alert</label>
                            </div>
                            <div class="mt-2 d-none" id="lowStockQuantityDiv">
                                <label class="form-label">Low Stock Quantity</label>
                                <input type="number" class="form-control" name="stocks[0][low_alert_quantity]" placeholder="Enter alert quantity">
                            </div>
                        </div>

                        <!-- Other Tab -->
                        <div class="tab-pane fade" id="other">
                            <h6 class="mb-3">Other</h6>
                            <div class="mb-3">
                                <label class="form-label">Product Images</label>
                                <input type="file" class="form-control" name="images[]" accept="image/*" multiple>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select name="item_category_id" class="form-control">
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->item_category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Item Description</label>
                                <textarea name="item_description" class="form-control" rows="3" placeholder="Enter item description"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">Add Item</button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {

    // Initialize DataTable
    $('#items-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("items.get") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
            { data: 'item_name', name: 'item_name' },
            { data: 'user_name', name: 'user.name' },
            { data: 'created_at', name: 'created_at' },
        ],
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        responsive: true
    });

    // Low Stock toggle
    $("#lowStockSwitch").on("change", function() {
        $("#lowStockQuantityDiv").toggleClass("d-none", !this.checked);
    });

    // AJAX form submission
    $('#itemForm').on('submit', function(e){
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: '{{ route("items.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            beforeSend: function(){
                $('#itemForm button[type="submit"]').attr('disabled', true).text('Saving...');
            },
            success: function(res){
                alert(res.message);
                $('#itemForm')[0].reset();
                $('#items-table').DataTable().ajax.reload();
                $("#lowStockQuantityDiv").addClass("d-none");
            },
            error: function(xhr){
                let errors = xhr.responseJSON?.errors;
                if(errors){
                    let errorMsg = '';
                    $.each(errors, function(key,val){ errorMsg += val[0]+"\n"; });
                    alert(errorMsg);
                } else {
                    alert('Something went wrong.');
                }
            },
            complete: function(){
                $('#itemForm button[type="submit"]').attr('disabled', false).text('Add Item');
            }
        });
    });
    
});
// Delete item with SweetAlert
$(document).on('click', '.deleteItem', function(){
    let id = $(this).data('id');
    
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/items/" + id + "/delete",
                type: "DELETE",
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function (res) {
                    Swal.fire("Deleted!", res.message, "success");
                    $('#items-table').DataTable().ajax.reload();
                },
                error: function (xhr) {
                    Swal.fire("Error!", "Something went wrong.", "error");
                }
            });
        }
    });
});

</script>
@endsection

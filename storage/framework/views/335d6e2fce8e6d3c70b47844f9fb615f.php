

<?php $__env->startSection('title'); ?> Invoices <?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?> Invoices <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> Invoices  <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

   <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                 <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Invoices </h5>

                    <!-- Create Invoice Button -->
                   
<?php if($permissions['add'] == 1): ?>
    <a href="<?php echo e(route('invoices.create')); ?>" class="btn btn-primary btn-sm">
        <i class="ri-add-line"></i> Create Invoice
    </a>
<?php endif; ?>

                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered dt-responsive nowrap table-striped align-middle" id="invoices-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Action</th>
                                    <th>Invoice ID</th>
                                   
                                    <th>Payment Type</th>
                                    <th>Total Amount</th>
                                    <th>Amount Received</th>
                                    <th>Discount %</th>
                                    <th>Discount Amount</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
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
    const companySlug = '<?php echo e($company_slug); ?>'; // Make sure this variable is passed from Blade

    const table = $('#invoices-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/'+companySlug+'/invoices/get', // dynamically include slug
            type: 'GET',
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
            { data: 'id', name: 'id' },
            { data: 'payment_type', name: 'payment_type' },
            { data: 'total_amount', name: 'total_amount' },
            { data: 'amount_received', name: 'amount_received' },
            { data: 'discount_percent', name: 'discount_percent' },
            { data: 'discount_amount', name: 'discount_amount' },
            { data: 'created_at', name: 'created_at' },
        ],
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        responsive: true
    });
});


$(document).on('click', '.deleteInvoice', function(){
       const companySlug = '<?php echo e($company_slug); ?>';
    let id = $(this).data('id');

    Swal.fire({
        title: "Are you sure?",
        text: "This action cannot be undone!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/' + companySlug + '/invoices/destroy?id=' + id + '&action=permanent_destroy', // ✅ fix concatenation
                type: "DELETE",
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function (res) {
                    Swal.fire("Deleted!", res.message, "success");
                    $('#invoices-table').DataTable().ajax.reload();
                },
                error: function (xhr) {
                    Swal.fire("Error!", "Something went wrong.", "error");
                }
            });
        }
    });
});


</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/acttconnect/new-invoice.acttconnect.com/resources/views/admin/invoices/index.blade.php ENDPATH**/ ?>


<?php $__env->startSection('title'); ?> Coupons <?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" />
<link href="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('li_1'); ?> Coupons <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?> Manage Coupons <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

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
                            <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key + 1); ?></td>
                                    <td><?php echo e($coupon->coupon_code); ?></td>
                                    <td><?php echo e($coupon->discount); ?></td>
                                    <td><?php echo e($coupon->created_at->format('F d, Y')); ?></td>
                                    <td>
                                        <?php if($permissions['edit']): ?>
                                            <a href="<?php echo e(route('coupons.index', ['edit' => $coupon->id, 'company_slug' => $company_slug])); ?>" class="btn btn-sm btn-info">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if($permissions['destroy']): ?>
                                            <form id="delete-form-<?php echo e($coupon->id); ?>" action="<?php echo e(route('coupons.destroy', ['coupon' => $coupon->id, 'company_slug' => $company_slug])); ?>" method="POST" style="display:inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="button" class="btn btn-sm btn-danger sa-warning" data-id="<?php echo e($coupon->id); ?>"><i class="ri-delete-bin-line"></i></button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Coupon Form -->
    <?php if($permissions['add']): ?>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h4 class="card-title mb-0 flex-grow-1"><?php echo e(isset($editCoupon) ? 'Edit Coupon' : 'Add Coupon'); ?></h4>
            </div>
            <div class="card-body">
                <form action="<?php echo e(isset($editCoupon) ? route('coupons.update', ['coupon' => $editCoupon->id, 'company_slug' => $company_slug]) : route('coupons.store', ['company_slug' => $company_slug])); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php if(isset($editCoupon)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Coupon Code</label>
                        <input type="text" name="coupon_code" class="form-control"
                               value="<?php echo e(old('coupon_code', $editCoupon->coupon_code ?? '')); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Discount (%)</label>
                        <input type="number" name="discount" class="form-control" step="0.01" min="0" max="100"
                               value="<?php echo e(old('discount', $editCoupon->discount ?? '')); ?>" required>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary"><?php echo e(isset($editCoupon) ? 'Update' : 'Submit'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('#coupon-table').DataTable();

        <?php if(session('success')): ?>
            Swal.fire({
                title: 'Success!',
                text: '<?php echo e(session('success')); ?>',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        <?php endif; ?>

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/acttconnect/new-invoice.acttconnect.com/resources/views/admin/coupons/index.blade.php ENDPATH**/ ?>
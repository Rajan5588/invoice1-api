

<?php $__env->startSection('title'); ?> Subscriptions <?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" />
<link href="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('li_1'); ?> Subscriptions <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?> Subscription Plans <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

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
    <?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <th><?php echo e($key + 1); ?></th>
            <td><?php echo e($subscription->plan_name); ?></td>
            <td><?php echo e($subscription->plan_price); ?></td>
            <td><?php echo e($subscription->plan_validity); ?></td>
            <td>
                <span class="badge bg-<?php echo e($subscription->plan_status == 'active' ? 'success' : 'danger'); ?>">
                    <?php echo e(ucfirst($subscription->plan_status)); ?>

                </span>
            </td>
            <td><?php echo e($subscription->plan_description); ?></td>
            <td><?php echo e($subscription->created_at->format('F d, Y')); ?></td>
            <td>
                
                <?php if($permissions['edit'] == 1): ?>
                    <a href="<?php echo e(route('subscriptions.index', ['edit' => $subscription->id])); ?>" 
                       class="btn btn-sm btn-info">
                        <i class="ri-edit-line"></i>
                    </a>
                <?php endif; ?>

                
                <?php if($permissions['delete'] == 1): ?>
                    <form id="delete-form-<?php echo e($subscription->id); ?>" 
                          action="<?php echo e(route('subscriptions.destroy', $subscription->id)); ?>" 
                          method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="button" class="btn btn-sm btn-danger sa-warning" 
                                data-id="<?php echo e($subscription->id); ?>">
                            <i class="ri-delete-bin-line"></i>
                        </button>
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

     <!--Create/Edit Subscription Form -->
<!--<div class="col-xl-12" >-->
<!--    <div class="card">-->
<!--        <div class="card-header d-flex align-items-center">-->
<!--            <h4 class="card-title mb-0 flex-grow-1"><?php echo e(isset($editSubscription) ? 'Edit Subscription' : 'Add Subscription'); ?></h4>-->
<!--        </div>-->

<!--        <div class="card-body">-->
<!--            <form action="<?php echo e(isset($editSubscription) ? route('subscriptions.update', $editSubscription->id) : route('subscriptions.store')); ?>" method="POST">-->
<!--                <?php echo csrf_field(); ?>-->
<!--                <?php if(isset($editSubscription)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>-->

<!--                <div class="mb-3">-->
<!--    <div class="row g-2">-->
<!--         <div class="col-md-6">-->
<!--                    <label class="form-label">Plan Name</label>-->
<!--                    <input type="text" name="plan_name" class="form-control"-->
<!--                           value="<?php echo e(old('plan_name', $editSubscription->plan_name ?? '')); ?>" required>-->
<!--                </div>-->

<!--                <div class="col-md-6">-->
<!--                    <label class="form-label">Plan Price</label>-->
<!--                    <input type="number" step="0.01" name="plan_price" class="form-control" min="0"-->
<!--                           value="<?php echo e(old('plan_price', $editSubscription->plan_price ?? '')); ?>" required>-->
<!--                </div>-->
<!--                </div>-->
<!--                </div>-->

<!--              <div class="mb-3">-->
<!--    <div class="row g-2">-->
<!--        <div class="col-md-4">-->
<!--                    <label class="form-label">Status</label>-->
<!--                    <select name="plan_status" class="form-control">-->
<!--                        <option value="active" <?php echo e(old('plan_status', $editSubscription->plan_status ?? '') == 'active' ? 'selected' : ''); ?>>Active</option>-->
<!--                        <option value="inactive" <?php echo e(old('plan_status', $editSubscription->plan_status ?? '') == 'inactive' ? 'selected' : ''); ?>>Inactive</option>-->
<!--                    </select>-->
<!--                </div>-->
<!--         <div class="col-md-2">-->
<!--                    <label class="form-label">Validity (days)</label>-->
<!--                    <input type="number" name="plan_validity" class="form-control" -->
<!--                           value="<?php echo e(old('plan_validity', $editSubscription->plan_validity ?? '')); ?>" required>-->
<!--                </div>-->

               
           
             
<!--        <div class="col-md-2">-->
<!--            <label class="form-label">Users</label>-->
<!--            <input type="number" name="user_add_count" class="form-control" min="0"-->
<!--                   value="<?php echo e(old('user_add_count', $editSubscription->user_add_count ?? '')); ?>" required>-->
<!--        </div>-->

<!--        <div class="col-md-2">-->
<!--            <label class="form-label">Businesses</label> -->
<!--            <input type="number" name="business_add_count" class="form-control" min="0"-->
<!--                   value="<?php echo e(old('business_add_count', $editSubscription->business_add_count ?? '')); ?>" required>-->
<!--        </div>-->

<!--        <div class="col-md-2">-->
<!--            <label class="form-label">Invoices</label>-->
<!--            <input type="number" name="invoice_add_count" class="form-control" min="0"-->
<!--                   value="<?php echo e(old('invoice_add_count', $editSubscription->invoice_add_count ?? '')); ?>" required>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!--                <div class="mb-3">-->
<!--    <label class="form-label">Description</label>-->
<!--    <textarea name="plan_description" class="form-control" rows="3" required><?php echo e(old('plan_description', $editSubscription->plan_description ?? '')); ?></textarea>-->
<!--</div>-->


<!--                <div class="text-end">-->
<!--                    <button type="submit" class="btn btn-primary"><?php echo e(isset($editSubscription) ? 'Update' : 'Submit'); ?></button>-->
<!--                </div>-->
<!--            </form>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<?php if(($permissions['add'] == 1 && !isset($editSubscription)) || ($permissions['edit'] == 1 && isset($editSubscription))): ?>
<div class="col-xl-12">
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h4 class="card-title mb-0 flex-grow-1">
                <?php echo e(isset($editSubscription) ? 'Edit Subscription' : 'Add Subscription'); ?>

            </h4>
        </div>

        <div class="card-body">
            <form action="<?php echo e(isset($editSubscription) ? route('subscriptions.update', $editSubscription->id) : route('subscriptions.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
               <?php echo csrf_field(); ?>
                <?php if(isset($editSubscription)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

                <div class="mb-3">
    <div class="row g-2">
         <div class="col-md-6">
                    <label class="form-label">Plan Name</label>
                    <input type="text" name="plan_name" class="form-control"
                           value="<?php echo e(old('plan_name', $editSubscription->plan_name ?? '')); ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Plan Price</label>
                    <input type="number" step="0.01" name="plan_price" class="form-control" min="0"
                           value="<?php echo e(old('plan_price', $editSubscription->plan_price ?? '')); ?>" required>
                </div>
                </div>
                </div>

              <div class="mb-3">
    <div class="row g-2">
        <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="plan_status" class="form-control">
                        <option value="active" <?php echo e(old('plan_status', $editSubscription->plan_status ?? '') == 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="inactive" <?php echo e(old('plan_status', $editSubscription->plan_status ?? '') == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                    </select>
                </div>
         <div class="col-md-2">
                    <label class="form-label">Validity (days)</label>
                    <input type="number" name="plan_validity" class="form-control" 
                           value="<?php echo e(old('plan_validity', $editSubscription->plan_validity ?? '')); ?>" required>
                </div>

               
           
             
        <div class="col-md-2">
            <label class="form-label">Users</label>
            <input type="number" name="user_add_count" class="form-control" min="0"
                   value="<?php echo e(old('user_add_count', $editSubscription->user_add_count ?? '')); ?>" required>
        </div>

        <div class="col-md-2">
            <label class="form-label">Businesses</label> 
            <input type="number" name="business_add_count" class="form-control" min="0"
                   value="<?php echo e(old('business_add_count', $editSubscription->business_add_count ?? '')); ?>" required>
        </div>

        <div class="col-md-2">
            <label class="form-label">Invoices</label>
            <input type="number" name="invoice_add_count" class="form-control" min="0"
                   value="<?php echo e(old('invoice_add_count', $editSubscription->invoice_add_count ?? '')); ?>" required>
        </div>
    </div>
</div>

                <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="plan_description" class="form-control" rows="3" required><?php echo e(old('plan_description', $editSubscription->plan_description ?? '')); ?></textarea>
</div>

                ...
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <?php echo e(isset($editSubscription) ? 'Update' : 'Submit'); ?>

                    </button>
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
        $('#subscription-table').DataTable();

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\new-invoice.acttconnect.com\new-invoice.acttconnect.com\resources\views/subscriptions/index.blade.php ENDPATH**/ ?>
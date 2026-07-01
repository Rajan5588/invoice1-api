

<?php $__env->startSection('title'); ?> Permission <?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?> Permission <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> Permission List <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Role Permissions</h5>
                    <a href="<?php echo e(route('permissions.create')); ?>" class="btn btn-primary">Add Permission</a>
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
                                <?php $__empty_1 = true; $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($permissions->firstItem() + $index); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('permissions.edit', $permission->id)); ?>" 
                                               class="btn btn-sm btn-success">
                                                <i class="ri-edit-fill"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger delete-button" 
                                                    data-url="<?php echo e(route('permissions.destroy', $permission->id)); ?>">
                                                <i class="ri-delete-bin-fill"></i>
                                            </button>
                                        </td>
                                        <td><?php echo e($permission->role->role_name ?? '-'); ?></td>
                                        <td><?php echo e($permission->company->name ?? '-'); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No permissions found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-end">
                            <?php echo e($permissions->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>

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
                            _token: '<?php echo e(csrf_token()); ?>'
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

        <?php if(session('success')): ?>
            Swal.fire({
                title: 'Success!',
                text: '<?php echo e(session('success')); ?>',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        <?php endif; ?>
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/acttconnect/new-invoice.acttconnect.com/resources/views/admin/roles/permissions/index.blade.php ENDPATH**/ ?>
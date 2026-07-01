

<?php $__env->startSection('title', 'Create Customer'); ?>

<?php $__env->startSection('css'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .form-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e9ecef;
            box-shadow: 0 3px 12px rgba(0,0,0,0.05);
            padding: 2rem;
        }
        .form-section {
            margin-top: 2rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f1f1f1;
            font-weight: 600;
            font-size: 1rem;
            color: #495057;
        }
        .required:after {
            content: " *";
            color: red;
        }
        .btn {
            border-radius: 6px;
            padding: 0.55rem 1.2rem;
        }
    </style>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="form-card">
            <h4 class="mb-4"><i class="bi bi-people me-2"></i> Create Customer</h4>

            <form action="<?php echo e(route('admin-customers.store', $company_slug)); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <!-- Basic Info -->
                <div class="form-section">Customer Information</div>
                <div class="row g-4">
                    <div class="col-md-3">
                        <label class="form-label required">Customer Name</label>
                        <input type="text" name="customer_name" class="form-control <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('customer_name')); ?>">
                        <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="company_name" class="form-control <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('company_name')); ?>">
                        <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label required">Email</label>
                        <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('email')); ?>">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('phone')); ?>">
                        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- GST Info -->
                <div class="form-section">GST Information</div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <label class="form-label">GST Number</label>
                        <input type="text" name="gst" class="form-control <?php $__errorArgs = ['gst'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('gst')); ?>">
                        <?php $__errorArgs = ['gst'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-4">
    <label class="form-label">GST Treatment</label>
    <select name="gst_treatment" class="form-control select2 <?php $__errorArgs = ['gst_treatment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
        <option value="">Select GST Treatment</option>
        <option value="Registered Business" <?php echo e(old('gst_treatment') == 'Registered Business' ? 'selected' : ''); ?>>
            Registered Business
        </option>
        <option value="Unregistered Business" <?php echo e(old('gst_treatment') == 'Unregistered Business' ? 'selected' : ''); ?>>
            Unregistered Business
        </option>
    </select>
    <?php $__errorArgs = ['gst_treatment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

                </div>

                <!-- Address -->
                <div class="form-section">Location Information</div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Place of Supply</label>
                        <input type="text" name="place_of_supply" class="form-control <?php $__errorArgs = ['place_of_supply'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('place_of_supply')); ?>">
                        <?php $__errorArgs = ['place_of_supply'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6">
    <label class="form-label">State</label>
    <select name="state" class="form-control select2 <?php $__errorArgs = ['state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
        <option value="">Select State</option>
        <option value="Andhra Pradesh" <?php echo e(old('state') == 'Andhra Pradesh' ? 'selected' : ''); ?>>Andhra Pradesh</option>
        <option value="Arunachal Pradesh" <?php echo e(old('state') == 'Arunachal Pradesh' ? 'selected' : ''); ?>>Arunachal Pradesh</option>
        <option value="Assam" <?php echo e(old('state') == 'Assam' ? 'selected' : ''); ?>>Assam</option>
        <option value="Bihar" <?php echo e(old('state') == 'Bihar' ? 'selected' : ''); ?>>Bihar</option>
        <option value="Chhattisgarh" <?php echo e(old('state') == 'Chhattisgarh' ? 'selected' : ''); ?>>Chhattisgarh</option>
        <option value="Delhi" <?php echo e(old('state') == 'Delhi' ? 'selected' : ''); ?>>Delhi</option>
        <option value="Goa" <?php echo e(old('state') == 'Goa' ? 'selected' : ''); ?>>Goa</option>
        <option value="Gujarat" <?php echo e(old('state') == 'Gujarat' ? 'selected' : ''); ?>>Gujarat</option>
        <option value="Haryana" <?php echo e(old('state') == 'Haryana' ? 'selected' : ''); ?>>Haryana</option>
        <option value="Himachal Pradesh" <?php echo e(old('state') == 'Himachal Pradesh' ? 'selected' : ''); ?>>Himachal Pradesh</option>
        <option value="Jharkhand" <?php echo e(old('state') == 'Jharkhand' ? 'selected' : ''); ?>>Jharkhand</option>
        <option value="Karnataka" <?php echo e(old('state') == 'Karnataka' ? 'selected' : ''); ?>>Karnataka</option>
        <option value="Kerala" <?php echo e(old('state') == 'Kerala' ? 'selected' : ''); ?>>Kerala</option>
        <option value="Madhya Pradesh" <?php echo e(old('state') == 'Madhya Pradesh' ? 'selected' : ''); ?>>Madhya Pradesh</option>
        <option value="Maharashtra" <?php echo e(old('state') == 'Maharashtra' ? 'selected' : ''); ?>>Maharashtra</option>
        <option value="Manipur" <?php echo e(old('state') == 'Manipur' ? 'selected' : ''); ?>>Manipur</option>
        <option value="Meghalaya" <?php echo e(old('state') == 'Meghalaya' ? 'selected' : ''); ?>>Meghalaya</option>
        <option value="Mizoram" <?php echo e(old('state') == 'Mizoram' ? 'selected' : ''); ?>>Mizoram</option>
        <option value="Nagaland" <?php echo e(old('state') == 'Nagaland' ? 'selected' : ''); ?>>Nagaland</option>
        <option value="Odisha" <?php echo e(old('state') == 'Odisha' ? 'selected' : ''); ?>>Odisha</option>
        <option value="Punjab" <?php echo e(old('state') == 'Punjab' ? 'selected' : ''); ?>>Punjab</option>
        <option value="Rajasthan" <?php echo e(old('state') == 'Rajasthan' ? 'selected' : ''); ?>>Rajasthan</option>
        <option value="Sikkim" <?php echo e(old('state') == 'Sikkim' ? 'selected' : ''); ?>>Sikkim</option>
        <option value="Tamil Nadu" <?php echo e(old('state') == 'Tamil Nadu' ? 'selected' : ''); ?>>Tamil Nadu</option>
        <option value="Telangana" <?php echo e(old('state') == 'Telangana' ? 'selected' : ''); ?>>Telangana</option>
        <option value="Tripura" <?php echo e(old('state') == 'Tripura' ? 'selected' : ''); ?>>Tripura</option>
        <option value="Uttar Pradesh" <?php echo e(old('state') == 'Uttar Pradesh' ? 'selected' : ''); ?>>Uttar Pradesh</option>
        <option value="Uttarakhand" <?php echo e(old('state') == 'Uttarakhand' ? 'selected' : ''); ?>>Uttarakhand</option>
        <option value="West Bengal" <?php echo e(old('state') == 'West Bengal' ? 'selected' : ''); ?>>West Bengal</option>
    </select>
    <?php $__errorArgs = ['state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

                </div>

                <!-- Assign User -->
                <div class="form-section">Assign User</div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label required">Select User</label>
                        <select name="user_id" class="form-control select2 <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Select User</option>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>" <?php echo e(old('user_id') == $user->id ? 'selected' : ''); ?>>
                                    <?php echo e($user->name); ?> (<?php echo e($user->email); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="text-end mt-4">
                    <a href="<?php echo e(route('admin-customers.index', $company_slug)); ?>" class="btn btn-light border">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(function () {
        $('.select2').select2({ width: '100%' });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/acttconnect/new-invoice.acttconnect.com/resources/views/admin/customer/create.blade.php ENDPATH**/ ?>
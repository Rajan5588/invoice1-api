

<?php $__env->startSection('title', 'Create Bussiness'); ?>

<?php $__env->startSection('css'); ?>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
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
        .preview-img {
            max-width: 120px;
            max-height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #dee2e6;
        }
        .btn {
            border-radius: 6px;
            padding: 0.55rem 1.2rem;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-11">
        <div class="form-card">
            <h4 class="mb-4"><i class="bi bi-person-plus me-2"></i> Create Bussiness</h4>

 <form action="<?php echo e(route('business_profiles.store')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>

    <!-- Business Info -->
    <div class="form-section">Business Information</div>
    <div class="row g-4">
        <!-- User Dropdown -->

        <div class="col-md-6">
            <label class="form-label required">Business Name</label>
            <input type="text" name="business_name" class="form-control <?php $__errorArgs = ['business_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   value="<?php echo e(old('business_name')); ?>">
            <?php $__errorArgs = ['business_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
 <div class="col-md-6">
            <label class="form-label required">Business ID</label>
            <input type="text" name="business_id" class="form-control <?php $__errorArgs = ['business_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   value="<?php echo e(old('business_id')); ?>">
            <?php $__errorArgs = ['business_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="col-md-6">
            <label class="form-label">GST No.</label>
            <input type="text" name="gst_no" class="form-control <?php $__errorArgs = ['gst_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   value="<?php echo e(old('gst_no')); ?>">
            <?php $__errorArgs = ['gst_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
         <div class="col-md-6">
            <label class="form-label">Business Website.</label>
            <input type="text" name="website" class="form-control <?php $__errorArgs = ['website'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   value="<?php echo e(old('website')); ?>">
            <?php $__errorArgs = ['website'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>

    <!-- Contact Details -->
    <div class="form-section">Contact Details</div>
    <div class="row g-4">
        <div class="col-md-6">
            <label class="form-label required">Primary Phone</label>
            <input type="text" name="phone_no_first" class="form-control <?php $__errorArgs = ['phone_no_first'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   value="<?php echo e(old('phone_no_first')); ?>">
            <?php $__errorArgs = ['phone_no_first'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="col-md-6">
            <label class="form-label">Secondary Phone</label>
            <input type="text" name="phone_no_second" class="form-control <?php $__errorArgs = ['phone_no_second'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   value="<?php echo e(old('phone_no_second')); ?>">
            <?php $__errorArgs = ['phone_no_second'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="col-md-6">
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

        <div class="col-md-6">
            <label class="form-label">Business Email</label>
            <input type="email" name="business_email" class="form-control <?php $__errorArgs = ['business_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   value="<?php echo e(old('business_email')); ?>">
            <?php $__errorArgs = ['business_email'];
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
    <div class="form-section">Business Address</div>
    <div class="row g-4">
        <div class="col-md-12">
            <label class="form-label required">Full Address</label>
            <textarea name="business_address" rows="2"
                      class="form-control <?php $__errorArgs = ['business_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('business_address')); ?></textarea>
            <?php $__errorArgs = ['business_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="col-md-4">
            <label class="form-label required">Pincode</label>
            <input type="text" name="pincode" class="form-control <?php $__errorArgs = ['pincode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   value="<?php echo e(old('pincode')); ?>">
            <?php $__errorArgs = ['pincode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

       <div class="col-md-4">
    <label class="form-label required">State</label>
    <select name="business_state" class="form-control select2 <?php $__errorArgs = ['business_state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
        <option value="">-- Select State --</option>

        <!-- States -->
        <option value="Andhra Pradesh" <?php echo e(old('business_state') == 'Andhra Pradesh' ? 'selected' : ''); ?>>Andhra Pradesh</option>
        <option value="Arunachal Pradesh" <?php echo e(old('business_state') == 'Arunachal Pradesh' ? 'selected' : ''); ?>>Arunachal Pradesh</option>
        <option value="Assam" <?php echo e(old('business_state') == 'Assam' ? 'selected' : ''); ?>>Assam</option>
        <option value="Bihar" <?php echo e(old('business_state') == 'Bihar' ? 'selected' : ''); ?>>Bihar</option>
        <option value="Chhattisgarh" <?php echo e(old('business_state') == 'Chhattisgarh' ? 'selected' : ''); ?>>Chhattisgarh</option>
        <option value="Goa" <?php echo e(old('business_state') == 'Goa' ? 'selected' : ''); ?>>Goa</option>
        <option value="Gujarat" <?php echo e(old('business_state') == 'Gujarat' ? 'selected' : ''); ?>>Gujarat</option>
        <option value="Haryana" <?php echo e(old('business_state') == 'Haryana' ? 'selected' : ''); ?>>Haryana</option>
        <option value="Himachal Pradesh" <?php echo e(old('business_state') == 'Himachal Pradesh' ? 'selected' : ''); ?>>Himachal Pradesh</option>
        <option value="Jharkhand" <?php echo e(old('business_state') == 'Jharkhand' ? 'selected' : ''); ?>>Jharkhand</option>
        <option value="Karnataka" <?php echo e(old('business_state') == 'Karnataka' ? 'selected' : ''); ?>>Karnataka</option>
        <option value="Kerala" <?php echo e(old('business_state') == 'Kerala' ? 'selected' : ''); ?>>Kerala</option>
        <option value="Madhya Pradesh" <?php echo e(old('business_state') == 'Madhya Pradesh' ? 'selected' : ''); ?>>Madhya Pradesh</option>
        <option value="Maharashtra" <?php echo e(old('business_state') == 'Maharashtra' ? 'selected' : ''); ?>>Maharashtra</option>
        <option value="Manipur" <?php echo e(old('business_state') == 'Manipur' ? 'selected' : ''); ?>>Manipur</option>
        <option value="Meghalaya" <?php echo e(old('business_state') == 'Meghalaya' ? 'selected' : ''); ?>>Meghalaya</option>
        <option value="Mizoram" <?php echo e(old('business_state') == 'Mizoram' ? 'selected' : ''); ?>>Mizoram</option>
        <option value="Nagaland" <?php echo e(old('business_state') == 'Nagaland' ? 'selected' : ''); ?>>Nagaland</option>
        <option value="Odisha" <?php echo e(old('business_state') == 'Odisha' ? 'selected' : ''); ?>>Odisha</option>
        <option value="Punjab" <?php echo e(old('business_state') == 'Punjab' ? 'selected' : ''); ?>>Punjab</option>
        <option value="Rajasthan" <?php echo e(old('business_state') == 'Rajasthan' ? 'selected' : ''); ?>>Rajasthan</option>
        <option value="Sikkim" <?php echo e(old('business_state') == 'Sikkim' ? 'selected' : ''); ?>>Sikkim</option>
        <option value="Tamil Nadu" <?php echo e(old('business_state') == 'Tamil Nadu' ? 'selected' : ''); ?>>Tamil Nadu</option>
        <option value="Telangana" <?php echo e(old('business_state') == 'Telangana' ? 'selected' : ''); ?>>Telangana</option>
        <option value="Tripura" <?php echo e(old('business_state') == 'Tripura' ? 'selected' : ''); ?>>Tripura</option>
        <option value="Uttar Pradesh" <?php echo e(old('business_state') == 'Uttar Pradesh' ? 'selected' : ''); ?>>Uttar Pradesh</option>
        <option value="Uttarakhand" <?php echo e(old('business_state') == 'Uttarakhand' ? 'selected' : ''); ?>>Uttarakhand</option>
        <option value="West Bengal" <?php echo e(old('business_state') == 'West Bengal' ? 'selected' : ''); ?>>West Bengal</option>

        <!-- Union Territories -->
        <option value="Andaman and Nicobar Islands" <?php echo e(old('business_state') == 'Andaman and Nicobar Islands' ? 'selected' : ''); ?>>Andaman and Nicobar Islands</option>
        <option value="Chandigarh" <?php echo e(old('business_state') == 'Chandigarh' ? 'selected' : ''); ?>>Chandigarh</option>
        <option value="Dadra and Nagar Haveli and Daman and Diu" <?php echo e(old('business_state') == 'Dadra and Nagar Haveli and Daman and Diu' ? 'selected' : ''); ?>>Dadra and Nagar Haveli and Daman and Diu</option>
        <option value="Delhi" <?php echo e(old('business_state') == 'Delhi' ? 'selected' : ''); ?>>Delhi</option>
        <option value="Jammu and Kashmir" <?php echo e(old('business_state') == 'Jammu and Kashmir' ? 'selected' : ''); ?>>Jammu and Kashmir</option>
        <option value="Ladakh" <?php echo e(old('business_state') == 'Ladakh' ? 'selected' : ''); ?>>Ladakh</option>
        <option value="Lakshadweep" <?php echo e(old('business_state') == 'Lakshadweep' ? 'selected' : ''); ?>>Lakshadweep</option>
        <option value="Puducherry" <?php echo e(old('business_state') == 'Puducherry' ? 'selected' : ''); ?>>Puducherry</option>
    </select>
    <?php $__errorArgs = ['business_state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="col-md-4">
    <label class="form-label required">Business Category</label>
    <select name="business_category" class="form-control select2 <?php $__errorArgs = ['business_category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
        <option value="">-- Select Category --</option>

        <option value="Retail" <?php echo e(old('business_category') == 'Retail' ? 'selected' : ''); ?>>Retail</option>
        <option value="Wholesale" <?php echo e(old('business_category') == 'Wholesale' ? 'selected' : ''); ?>>Wholesale</option>
        <option value="Manufacturing" <?php echo e(old('business_category') == 'Manufacturing' ? 'selected' : ''); ?>>Manufacturing</option>
        <option value="IT & Software" <?php echo e(old('business_category') == 'IT & Software' ? 'selected' : ''); ?>>IT & Software</option>
        <option value="E-Commerce" <?php echo e(old('business_category') == 'E-Commerce' ? 'selected' : ''); ?>>E-Commerce</option>
        <option value="Finance & Banking" <?php echo e(old('business_category') == 'Finance & Banking' ? 'selected' : ''); ?>>Finance & Banking</option>
        <option value="Education" <?php echo e(old('business_category') == 'Education' ? 'selected' : ''); ?>>Education</option>
        <option value="Healthcare" <?php echo e(old('business_category') == 'Healthcare' ? 'selected' : ''); ?>>Healthcare</option>
        <option value="Real Estate" <?php echo e(old('business_category') == 'Real Estate' ? 'selected' : ''); ?>>Real Estate</option>
        <option value="Hospitality & Tourism" <?php echo e(old('business_category') == 'Hospitality & Tourism' ? 'selected' : ''); ?>>Hospitality & Tourism</option>
        <option value="Transport & Logistics" <?php echo e(old('business_category') == 'Transport & Logistics' ? 'selected' : ''); ?>>Transport & Logistics</option>
        <option value="Agriculture" <?php echo e(old('business_category') == 'Agriculture' ? 'selected' : ''); ?>>Agriculture</option>
        <option value="Textiles & Apparel" <?php echo e(old('business_category') == 'Textiles & Apparel' ? 'selected' : ''); ?>>Textiles & Apparel</option>
        <option value="Food & Beverages" <?php echo e(old('business_category') == 'Food & Beverages' ? 'selected' : ''); ?>>Food & Beverages</option>
        <option value="Media & Entertainment" <?php echo e(old('business_category') == 'Media & Entertainment' ? 'selected' : ''); ?>>Media & Entertainment</option>
        <option value="Construction" <?php echo e(old('business_category') == 'Construction' ? 'selected' : ''); ?>>Construction</option>
        <option value="Automobile" <?php echo e(old('business_category') == 'Automobile' ? 'selected' : ''); ?>>Automobile</option>
        <option value="Telecommunication" <?php echo e(old('business_category') == 'Telecommunication' ? 'selected' : ''); ?>>Telecommunication</option>
        <option value="Other" <?php echo e(old('business_category') == 'Other' ? 'selected' : ''); ?>>Other</option>
    </select>
    <?php $__errorArgs = ['business_category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

    </div>

    <!-- Signatures -->
    <div class="form-section">Signatures</div>
    <div class="row g-4 align-items-center">
        <div class="col-md-6">
            <label class="form-label">Digital Sign</label>
            <input type="file" name="digital_sign" class="form-control <?php $__errorArgs = ['digital_sign'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   accept="image/*" onchange="previewImage(event, 'digitalPreview')">
            <?php $__errorArgs = ['digital_sign'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <div class="text-center mt-2">
                <img id="digitalPreview" src="https://via.placeholder.com/120" class="preview-img" alt="Preview">
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Business Signature</label>
            <input type="file" name="business_signature" class="form-control <?php $__errorArgs = ['business_signature'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   accept="image/*" onchange="previewImage(event, 'signaturePreview')">
            <?php $__errorArgs = ['business_signature'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <div class="text-center mt-2">
                <img id="signaturePreview" src="https://via.placeholder.com/120" class="preview-img" alt="Preview">
            </div>
        </div>
    </div>

    <!-- Buttons -->
    <div class="text-end mt-4">
        <a href="<?php echo e(route('business_profiles.index')); ?>" class="btn btn-light border">Cancel</a>
        <button type="submit" class="btn btn-primary">Save Business</button>
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

<?php if(session('success')): ?>
    <script>
        Swal.fire({
            title: "Success!",
            text: "<?php echo e(session('success')); ?>",
            icon: "success",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "OK"
        });
    </script>
<?php endif; ?>

<?php if(session('error')): ?>
    <script>
        Swal.fire({
            title: "Error!",
            text: "<?php echo e(session('error')); ?>",
            icon: "error",
            confirmButtonColor: "#d33",
            confirmButtonText: "Close"
        });
    </script>
<?php endif; ?>

<script>
    function previewImage(event, id) {
        const reader = new FileReader();
        reader.onload = function () {
            document.getElementById(id).src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/acttconnect/new-invoice.acttconnect.com/resources/views/admin/buisness-profiles/create.blade.php ENDPATH**/ ?>
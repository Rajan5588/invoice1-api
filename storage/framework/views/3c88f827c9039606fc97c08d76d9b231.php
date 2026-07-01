

<?php $__env->startSection('title'); ?> Item Details <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xxl-3">
        <div class="card mt-n5 text-center">
            <div class="card-body">
                <div class="profile-user position-relative d-inline-block mx-auto mb-3">
                  
                </div>
                <h5 class="fs-16 mb-1"><?php echo e($item->item_name); ?></h5>
                <p class="text-muted mb-1">Owned by: <?php echo e($item->user?->name ?? 'N/A'); ?></p>
            </div>
        </div>
    </div>

    <div class="col-xxl-9">
        <div class="card mt-xxl-n5">
            <div class="card-header">
                <ul class="nav nav-tabs nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#detailsTab">Details</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#pricingsTab">Pricings</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#stocksTab">Stocks</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#imagesTab">Other Images</a></li>
                     <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#profileTab">User</a></li>
           
                </ul>
            </div>

            <div class="card-body p-4">
                <div class="tab-content">

                    
                    <div class="tab-pane fade show active" id="detailsTab">
                        <?php if($item->details): ?>
                            <table class="table table-bordered">
                                <tr><th>Category</th><td><?php echo e($item->details->category?->item_category_name ?? '-'); ?></td></tr>
                                <tr><th>Description</th><td><?php echo e($item->details->item_description ?? '-'); ?></td></tr>
                                <tr><th>Show Online Store</th><td><?php echo e($item->details->show_online_store ? 'Yes' : 'No'); ?></td></tr>
                                <tr><th>Created At</th><td><?php echo e($item->created_at?->format('d M Y, h:i A')); ?></td></tr>
                            </table>
                        <?php else: ?>
                            <p>No item details available</p>
                        <?php endif; ?>
                    </div>

                    
                    <div class="tab-pane fade" id="pricingsTab">
                        <?php if($item->pricings->isNotEmpty()): ?>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Unit</th>
                                    <th>Sales Price</th>
                                    <th>Sales Tax</th>
                                    <th>Purchase Price</th>
                                    <th>Purchase Tax</th>
                                    <th>MRP</th>
                                    <th>GST</th>
                                </tr>
                                <?php $__currentLoopData = $item->pricings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pricing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($pricing->unit); ?></td>
                                        <td>₹<?php echo e(number_format($pricing->salesprice_amount, 2)); ?></td>
                                        <td><?php echo e($pricing->salesprice_tax); ?>%</td>
                                        <td>₹<?php echo e(number_format($pricing->purches_price_amount, 2)); ?></td>
                                        <td><?php echo e($pricing->purches_price_tax); ?>%</td>
                                        <td>₹<?php echo e(number_format($pricing->mrp_price, 2)); ?></td>
                                        <td><?php echo e($pricing->gst); ?>%</td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </table>
                        <?php else: ?>
                            <p>No pricing records</p>
                        <?php endif; ?>
                    </div>

                    
                    <div class="tab-pane fade" id="stocksTab">
                        <?php if($item->stocks->isNotEmpty()): ?>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Opening Stock</th>
                                    <th>As of Date</th>
                                    <th>Low Alert Status</th>
                                    <th>Low Alert Quantity</th>
                                </tr>
                                <?php $__currentLoopData = $item->stocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($stock->opening_stock); ?></td>
                                        <td><?php echo e($stock->as_of_date ? \Carbon\Carbon::parse($stock->as_of_date)->format('d M, Y') : '-'); ?></td>
                                        <td><?php echo e($stock->low_alert_status ? 'Yes' : 'No'); ?></td>
                                        <td><?php echo e($stock->low_alert_quantity); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </table>
                        <?php else: ?>
                            <p>No stock records</p>
                        <?php endif; ?>
                    </div>

                    
                    <div class="tab-pane fade" id="imagesTab">
                        <?php if($item->otherImages->isNotEmpty()): ?>
                            <div class="row">
                                <?php $__currentLoopData = $item->otherImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-3 mb-3">
                                        <img src="<?php echo e(asset($image->image_path)); ?>" class="img-fluid rounded shadow" alt="item-image">
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <p>No additional images</p>
                        <?php endif; ?>
                    </div>
                    
                     <div class="tab-pane fade" id="profileTab">
                        <?php if($item->user): ?>
                            <table class="table table-bordered">
                                    <tr><th>Name</th><td><?php echo e($item->user->name ?? ''); ?></td></tr>
                                <tr><th>Full Address</th><td><?php echo e($item->user->full_address ?? ''); ?></td></tr>
                                <tr><th>State</th><td><?php echo e($item->user->state ?? ''); ?></td></tr>
                                <tr><th>District</th><td><?php echo e($item->user->district ?? ''); ?></td></tr>
                                <tr><th>Phone</th><td><?php echo e($item->user->phone ?? ''); ?></td></tr>
                                <tr><th>Email</th><td><?php echo e($item->user->email ?? ''); ?></td></tr>
                                <tr><th>Status</th><td><?php echo e(ucfirst($item->user->status)); ?></td></tr>
                                <tr><th>Subscription Expired Date</th><td><?php echo e($item->user->subs_expired_date ?? ''); ?></td></tr>
                                <tr><th>OTP Verified</th><td><?php echo e($item->user->otp_verified == '1' ? 'Yes' : 'No'); ?></td></tr>
                                <tr><th>Created At</th><td><?php echo e($item->user->created_at ? $item->user->created_at->format('d M Y, h:i A') : ''); ?></td></tr>
                            </table>
                        <?php else: ?>
                            <p>No user information available</p>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/acttconnect/new-invoice.acttconnect.com/resources/views/admin/items/show.blade.php ENDPATH**/ ?>
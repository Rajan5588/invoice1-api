

<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.dashboards'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('build/libs/apexcharts/apexcharts.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    
    <?php
        $currentTime = Carbon\Carbon::now('Asia/Kolkata');
        $hour = $currentTime->hour;

        if ($hour >= 5 && $hour < 12) {
            $greeting = 'Good Morning';
        } elseif ($hour >= 12 && $hour < 17) {
            $greeting = 'Good Afternoon';
        } elseif ($hour >= 17 && $hour < 21) {
            $greeting = 'Good Evening';
        } else {
            $greeting = 'Good Night';
        }
    ?>
    <h4 class="mb-4"><?php echo e($greeting); ?>, <?php echo e(Auth::user()->name); ?>!</h4>

    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <p class="text-muted mb-1">Today's Sales</p>
                    <h3><?php echo e($todaySales); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <p class="text-muted mb-1">Pending Invoices</p>
                    <h3><?php echo e($pendingInvoices); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <p class="text-muted mb-1">Paid Invoices</p>
                    <h3><?php echo e($paidInvoices); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <p class="text-muted mb-1">Overdue Amount</p>
                    <h3><?php echo e($overdueAmount); ?></h3>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row">
     <div class="col-lg-6">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Invoice List</h5>
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Invoice #</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($transaction->invoice->id ?? 'N/A'); ?></td>
                                <td><?php echo e($transaction->customer_name ?? $transaction->invoice->customer->name ?? 'N/A'); ?></td>
                                <td><?php echo e($transaction->date ?? $transaction->invoice->date ?? 'N/A'); ?></td>
                                <td><?php echo $transaction->status_badge; ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">No transactions found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


        
        <div class="col-lg-6">
            <!--<div class="card shadow-sm mb-3">-->
            <!--    <div class="card-body">-->
            <!--        <h5 class="mb-3">Monthly Revenue</h5>-->
            <!--        <div id="revenueChart"></div>-->
            <!--    </div>-->
            <!--</div>-->

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Invoice Status</h5>
                    <div id="statusChart"></div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row mt-4">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <a href="<?php echo e(route('invoices.create')); ?>" class="btn btn-primary me-2">Create Invoice</a>
                    <a href="<?php echo e(route('users.create')); ?>" class="btn btn-info me-2">Add Users</a>
                    <a href="<?php echo e(route('items.index')); ?>" class="btn btn-primary me-2">Create Items</a>
                    
                    <a href="" class="btn btn-secondary">Download Report</a>
                </div>
            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('build/libs/apexcharts/apexcharts.min.js')); ?>"></script>
<script>
    // Monthly Revenue Chart
    var options = {
        chart: { type: 'line', height: 250 },
        series: [{
            name: 'Revenue',
            data: <?php echo json_encode($monthlyRevenue, 15, 512) ?>
        }],
        xaxis: { categories: <?php echo json_encode($months, 15, 512) ?> }
    };
    new ApexCharts(document.querySelector("#revenueChart"), options).render();

    // Invoice Status Pie Chart
    var options2 = {
        chart: { type: 'pie', height: 250 },
        series: [<?php echo e($paidInvoices); ?>, <?php echo e($pendingInvoices); ?>, <?php echo e($overdueInvoices); ?>],
        labels: ['Paid', 'Pending', 'Overdue'],
        colors: ['#28a745', '#ffc107', '#dc3545']
    };
    new ApexCharts(document.querySelector("#statusChart"), options2).render();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/acttconnect/new-invoice.acttconnect.com/resources/views/admin/index.blade.php ENDPATH**/ ?>
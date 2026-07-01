<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" <body data-layout="horizontal"
 data-topbar="dark" data-sidebar="light"
    data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default"
    data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title><?php echo $__env->yieldContent('title'); ?> | ACT T CONNECT - Invoice & Billing Software</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ACT T CONNECT - Smart Invoice & Billing Software for businesses. Generate invoices, track payments, manage customers, and simplify accounting." />
    <meta name="keywords" content="Invoice Software, Billing Software, Accounting App, Payment Tracking, Customer Management, Online Invoices, Business Finance" />
    <meta name="author" content="ACT T CONNECT" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(URL::asset('build/images/logonewsrgi.png')); ?>" width="34px;">

    <?php echo $__env->make('layouts.head-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?php echo $__env->make('layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <?php echo $__env->make('layouts.customizer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- JAVASCRIPT -->
    <?php echo $__env->make('layouts.vendor-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html>
<?php /**PATH /home2/acttconnect/new-invoice.acttconnect.com/resources/views/layouts/master.blade.php ENDPATH**/ ?>
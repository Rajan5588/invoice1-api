<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="<?php echo e(route('root')); ?>" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="<?php echo e(URL::asset('build/images/logonewsrgi.png')); ?>" alt="" height="34">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo e(URL::asset('build/images/logonewsrgi.png')); ?>" alt="" height="72">
                        </span>
                    </a>

                    <a href="<?php echo e(route('root')); ?>" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="<?php echo e(URL::asset('build/images/logonewsrgi.png')); ?>" alt="" height="34">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo e(URL::asset('build/images/logonewsrgi.png')); ?>" alt="" height="72">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger material-shadow-none" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

              
            </div>

            <div class="d-flex align-items-center">

           
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>

                

                <div class="dropdown ms-sm-3 header-item topbar-user ">
                    <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="<?php if(Auth::user()->avatar != ''): ?><?php echo e(URL::asset('build/images/logonewsrgi.png')); ?><?php else: ?><?php echo e(URL::asset('build/images/logonewsrgi.png')); ?><?php endif; ?>" alt="Header Avatar" >
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php echo e(Auth::user()->name); ?></span>
                                  </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome <?php echo e(Auth::user()->name); ?>!</h6>
                        <a class="dropdown-item " href="" ><i class="bx bx-power-off font-size-16 align-middle me-1"></i> <span >Change Password</span></a>
                       
                       <a class="dropdown-item" href="javascript:void();"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
   <i class="bx bx-power-off font-size-16 align-middle me-1"></i>
   <span key="t-logout"><?php echo app('translator')->get('translation.logout'); ?></span>
</a>

<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
</form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


<?php /**PATH C:\new-invoice.acttconnect.com\new-invoice.acttconnect.com\resources\views/layouts/topbar.blade.php ENDPATH**/ ?>
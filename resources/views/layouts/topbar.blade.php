<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="{{route('root')}}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ URL::asset('build/images/logonewsrgi.png') }}" alt="" height="34">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ URL::asset('build/images/logonewsrgi.png') }}" alt="" height="72">
                        </span>
                    </a>

                    <a href="{{route('root')}}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ URL::asset('build/images/logonewsrgi.png') }}" alt="" height="34">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ URL::asset('build/images/logonewsrgi.png') }}" alt="" height="72">
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
                            <img class="rounded-circle header-profile-user" src="@if (Auth::user()->avatar != ''){{  URL::asset('build/images/logonewsrgi.png') }}@else{{  URL::asset('build/images/logonewsrgi.png') }}@endif" alt="Header Avatar" >
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{Auth::user()->name}}</span>
                                  </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome {{Auth::user()->name}}!</h6>
                        <a class="dropdown-item " href="" ><i class="bx bx-power-off font-size-16 align-middle me-1"></i> <span >Change Password</span></a>
                       
                       <a class="dropdown-item" href="javascript:void();"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
   <i class="bx bx-power-off font-size-16 align-middle me-1"></i>
   <span key="t-logout">@lang('translation.logout')</span>
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>



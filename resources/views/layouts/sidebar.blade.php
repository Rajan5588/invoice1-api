<?php
use App\Models\RolesPermission;
use Illuminate\Support\Facades\Auth;

$user = Auth::user();

// Admin: all permissions
if ($user->is_admin) {
    $permissions = collect([
        'business_profiles','coupons','customers','invoices','items','item_categories',
        'subscriptions','transactions','users','company','roles_permissions'
    ])->mapWithKeys(fn($p)=>[$p => ['view'=>1]])->toArray();
} else {
    $rolePerm = RolesPermission::where('role_id', $user->role_id)->first();
    $permissions = [
        'business_profiles' => ['view' => $rolePerm->business_profiles_view],
        'coupons' => ['view' => $rolePerm->coupons_view],
        'customers' => ['view' => $rolePerm->customers_view],
        'invoices' => ['view' => $rolePerm->invoices_view],
        'items' => ['view' => $rolePerm->items_view],
        'item_categories' => ['view' => $rolePerm->item_categories_view],
        'subscriptions' => ['view' => $rolePerm->subscriptions_view],
        'transactions' => ['view' => $rolePerm->transactions_view],
        'users' => ['view' => $rolePerm->users_view],
        'company' => ['view' => $rolePerm->company_view],
        'roles_permissions' => ['view' => $rolePerm->roles_permissions_view],
    ];
}
?>

<div class="app-menu navbar-menu">
    <div class="navbar-brand-box" style="background-color:#ffff;">
        <a href="{{ route('root') }}" class="logo logo-dark">
            <span class="logo-sm"><img src="{{ URL::asset('build/images/logonewsrgi.png') }}" height="34"></span>
            <span class="logo-lg"><img src="{{ URL::asset('build/images/logonewsrgi.png') }}" height="72"></span>
        </a>
        <a href="{{ route('root') }}" class="logo logo-light">
            <span class="logo-sm"><img src="{{ URL::asset('build/images/logonewsrgi.png') }}" height="34"></span>
            <span class="logo-lg"><img src="{{ URL::asset('build/images/logonewsrgi.png') }}" height="72"></span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('root') }}">
                        <i class="ri-dashboard-2-line"></i> <span>Dashboard</span>
                    </a>
                </li>

                <!-- Users -->
                @if($permissions['users']['view'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('users.index') }}">
                        <i class="ri-user-line"></i> <span>Users</span>
                    </a>
                </li>
                @endif

                <!-- Billing -->
                @if($permissions['invoices']['view'] || $permissions['transactions']['view'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#billingMenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="ri-bill-line"></i> <span>Invoices</span>
                    </a>
                    <div class="collapse menu-dropdown" id="billingMenu">
                        <ul class="nav nav-sm flex-column">
                            @if($permissions['invoices']['view'])
                            <li class="nav-item"><a class="nav-link" href="{{ route('invoices.index') }}"> invoices</a></li>
                            @endif
                            @if($permissions['transactions']['view'])
                            <li class="nav-item"><a class="nav-link" href="{{ route('transactions.index') }}">Transactions</a></li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                <!-- Items -->
                @if($permissions['items']['view'] || $permissions['item_categories']['view'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#itemsMenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="ri-box-3-line"></i> <span>Items</span>
                    </a>
                    <div class="collapse menu-dropdown" id="itemsMenu">
                        <ul class="nav nav-sm flex-column">
                            @if($permissions['item_categories']['view'])
                            <li class="nav-item"><a class="nav-link" href="{{ route('item_categories.index') }}">Items Category</a></li>
                            @endif
                            @if($permissions['items']['view'])
                            <li class="nav-item"><a class="nav-link" href="{{ route('items.index') }}">Items List</a></li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                <!-- Business -->
                @if($permissions['business_profiles']['view'] || $permissions['company']['view'] || $permissions['roles_permissions']['view'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#businessMenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="ri-building-line"></i> <span>Business</span>
                    </a>
                    <div class="collapse menu-dropdown" id="businessMenu">
                        <ul class="nav nav-sm flex-column">
                            @if($permissions['business_profiles']['view'])
                            <li class="nav-item"><a class="nav-link" href="{{ route('business_profiles.index') }}">Businesses</a></li>
                            @endif
                            @if($permissions['company']['view'])
                            <li class="nav-item"><a class="nav-link" href="{{ route('company.index') }}">Companies</a></li>
                            @endif
                            @if($permissions['roles_permissions']['view'])
                            <li class="nav-item"><a class="nav-link" href="{{ route('roles.index') }}">Roles</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('permissions.index') }}">Permissions</a></li>
                            @endif
                            
                          @if($permissions['customers']['view'])
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin-customers.index') }}">Customers</a></li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                <!-- Subscriptions -->
                @if($permissions['subscriptions']['view'] || $permissions['coupons']['view'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#subscriptionsMenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="ri-shopping-cart-2-line"></i> <span>Subscriptions</span>
                    </a>
                    <div class="collapse menu-dropdown" id="subscriptionsMenu">
                        <ul class="nav nav-sm flex-column">
                            @if($permissions['subscriptions']['view'])
                            <li class="nav-item"><a class="nav-link" href="{{ route('subscriptions.index') }}">Subscriptions</a></li>
                            @endif
                            @if($permissions['coupons']['view'])
                            <li class="nav-item"><a class="nav-link" href="{{ route('coupons.index') }}">Coupons</a></li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif
                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin-expenses.index') }}">
                        <i class="ri-user-line"></i> <span>Expenses</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>
<div class="vertical-overlay"></div>

<!--<div class="app-menu navbar-menu">-->
    <!-- LOGO -->
<!--    <div class="navbar-brand-box" style="background-color:#ffff;">-->
        <!-- Dark Logo-->
<!--        <a href="{{route('root')}}" class="logo logo-dark">-->
<!--            <span class="logo-sm">-->
<!--                <img src="{{ URL::asset('build/images/logonewsrgi.png') }}" alt="" height="34">-->
<!--            </span>-->
<!--            <span class="logo-lg">-->
<!--                <img src="{{ URL::asset('build/images/logonewsrgi.png') }}" alt="" height="72">-->
<!--            </span>-->
<!--        </a>-->
        <!-- Light Logo-->
<!--        <a href="{{route('root')}}" class="logo logo-light">-->
<!--            <span class="logo-sm">-->
<!--                <img src="{{ URL::asset('build/images/logonewsrgi.png') }}" alt="" height="34">-->
<!--            </span>-->
<!--            <span class="logo-lg">-->
<!--                <img src="{{ URL::asset('build/images/logonewsrgi.png') }}" alt="" height="72">-->
<!--            </span>-->
<!--        </a>-->
<!--        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"-->
<!--            id="vertical-hover">-->
<!--            <i class="ri-record-circle-line"></i>-->
<!--        </button>-->
<!--    </div>-->

    
<!--    <div id="scrollbar">-->
<!--        <div class="container-fluid">-->

<!--            <div id="two-column-menu">-->
<!--            </div>-->
<!--            <ul class="navbar-nav" id="navbar-nav">-->

    <!-- Dashboard -->
<!--    <li class="nav-item">-->
<!--        <a class="nav-link menu-link" href="{{ route('root') }}">-->
<!--            <i class="ri-dashboard-2-line"></i> <span>Dashboard</span>-->
<!--        </a>-->
<!--    </li>-->

<!--     <li class="nav-item">-->
<!--    <a class="nav-link menu-link" href="{{ route('users.index') }}">-->
<!--        <i class="ri-user-line"></i> <span>Users</span>-->
<!--    </a>-->
<!--</li>-->


    <!-- Billing -->
<!--    <li class="nav-item">-->
<!--        <a class="nav-link menu-link" href="#billingMenu" data-bs-toggle="collapse" role="button"-->
<!--            aria-expanded="false" aria-controls="billingMenu">-->
<!--            <i class="ri-bill-line"></i> <span>Billing</span>-->
<!--        </a>-->
<!--        <div class="collapse menu-dropdown" id="billingMenu">-->
<!--            <ul class="nav nav-sm flex-column">-->
<!--                <li class="nav-item"><a class="nav-link" href="{{route('invoices.index')}}">All  Bill</a></li>-->
<!--                <li class="nav-item"><a class="nav-link" href="{{route('transactions.index')}}">Transactions</a></li>-->
<!--            </ul>-->
<!--        </div>-->
<!--    </li>-->

    <!-- Items -->
<!--    <li class="nav-item">-->
<!--        <a class="nav-link menu-link" href="#itemsMenu" data-bs-toggle="collapse" role="button"-->
<!--            aria-expanded="false" aria-controls="itemsMenu">-->
<!--            <i class="ri-box-3-line"></i> <span>Items</span>-->
<!--        </a>-->
<!--        <div class="collapse menu-dropdown" id="itemsMenu">-->
<!--            <ul class="nav nav-sm flex-column">-->
<!--                  <li class="nav-item"><a class="nav-link" href="{{route('item_categories.index')}}">Items Category</a></li>-->
<!--                <li class="nav-item"><a class="nav-link" href="{{route('items.index')}}">Items List</a></li>-->
                
<!--            </ul>-->
<!--        </div>-->
<!--    </li>-->

    <!-- Business -->
<!--    <li class="nav-item">-->
<!--        <a class="nav-link menu-link" href="#businessMenu" data-bs-toggle="collapse" role="button"-->
<!--            aria-expanded="false" aria-controls="businessMenu">-->
<!--            <i class="ri-building-line"></i> <span>Business</span>-->
<!--        </a>-->
<!--        <div class="collapse menu-dropdown" id="businessMenu">-->
<!--            <ul class="nav nav-sm flex-column">-->
<!--                <li class="nav-item"><a class="nav-link" href="{{route('business_profiles.index')}}"> Businesses </a></li>-->
<!--                <li class="nav-item"><a class="nav-link" href="{{route('company.index')}}"> Companies</a></li>-->
<!--                <li class="nav-item"><a class="nav-link" href="{{route('roles.index')}}"> Roles</a></li>-->
<!--                <li class="nav-item"><a class="nav-link" href="{{route('permissions.index')}}"> Permissions</a></li>-->
<!--            </ul>-->
<!--        </div>-->
<!--    </li>-->

    <!-- Purchases -->
<!--    <li class="nav-item">-->
<!--        <a class="nav-link menu-link" href="#purchasesMenu" data-bs-toggle="collapse" role="button"-->
<!--            aria-expanded="false" aria-controls="purchasesMenu">-->
<!--            <i class="ri-shopping-cart-2-line"></i> <span>Purchases</span>-->
<!--        </a>-->
<!--        <div class="collapse menu-dropdown" id="purchasesMenu">-->
<!--            <ul class="nav nav-sm flex-column">-->
<!--                <li class="nav-item"><a class="nav-link" href="#">Create Purchase</a></li>-->
<!--                <li class="nav-item"><a class="nav-link" href="#">Upload Purchases</a></li>-->
<!--            </ul>-->
<!--        </div>-->
<!--    </li>-->
    
<!--        <li class="nav-item">-->
<!--        <a class="nav-link menu-link" href="#purchasesMenuu" data-bs-toggle="collapse" role="button"-->
<!--            aria-expanded="false" aria-controls="purchasesMenuu">-->
<!--            <i class="ri-shopping-cart-2-line"></i> <span>Subscriptions</span>-->
<!--        </a>-->
<!--        <div class="collapse menu-dropdown" id="purchasesMenuu">-->
<!--            <ul class="nav nav-sm flex-column">-->
<!--                <li class="nav-item"><a class="nav-link" href="{{ route('subscriptions.index') }}">Subscriptions </a></li>-->
<!--                <li class="nav-item"><a class="nav-link" href="{{ route('coupons.index') }}">Coupons</a></li>-->
<!--            </ul>-->
<!--        </div>-->
<!--    </li>-->
    


<!--</ul>-->

<!--        </div>-->
        <!-- Sidebar -->
<!--    </div>-->
<!--    <div class="sidebar-background"></div>-->
<!--</div>-->
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->


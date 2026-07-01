<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesPermission extends Model
{
    use HasFactory;

    protected $table = 'roles_permissions';

    protected $fillable = [
        'owner_id',
        'company_code',
        'role_id',

        // business_profiles
        'business_profiles_add',
        'business_profiles_edit',
        'business_profiles_delete',
        'business_profiles_view',

        // coupons
        'coupons_add',
        'coupons_edit',
        'coupons_delete',
        'coupons_view',

        // customers
        'customers_add',
        'customers_edit',
        'customers_delete',
        'customers_view',

        // invoices
        'invoices_add',
        'invoices_edit',
        'invoices_delete',
        'invoices_view',

        // items
        'items_add',
        'items_edit',
        'items_delete',
        'items_view',

        // item_categories
        'item_categories_add',
        'item_categories_edit',
        'item_categories_delete',
        'item_categories_view',

        // subscriptions
        'subscriptions_add',
        'subscriptions_edit',
        'subscriptions_delete',
        'subscriptions_view',

        // transactions
        'transactions_add',
        'transactions_edit',
        'transactions_delete',
        'transactions_view',

        // users
        'users_add',
        'users_edit',
        'users_delete',
        'users_view',

        // company
        'company_add',
        'company_edit',
        'company_delete',
        'company_view',

        // roles_permissions
        'roles_permissions_add',
        'roles_permissions_edit',
        'roles_permissions_delete',
        'roles_permissions_view',
    ];

    /**
     * Relationships
     */

    // Owner (the user who created/assigned the role permissions)
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // Role reference
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // Company reference (via company_code)
    public function company()
    {
        return $this->belongsTo(User::class, 'company_code', 'company_code');
    }
}

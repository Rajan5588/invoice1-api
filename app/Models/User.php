<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'full_address',
        'state',
        'district',
        'phone',
        'avatar',
        'fcm_token',
        'subs_id',         
        'subs_expired_date' ,
        'company_code',
        'user_code',
        'is_admin',
        'gst_no',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'subs_expired_date' => 'datetime'
    ];

    // Current active subscription
    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subs_id');
    }

    // All purchased subscriptions
    public function subscribedUsers()
    {
        return $this->hasMany(SubscribedUser::class, 'user_id');
    }

    // Business profiles
    public function businessProfiles()
    {
        return $this->hasMany(BusinessProfile::class, 'user_id');
    }

    // Customers
    public function customers()
    {
        return $this->hasMany(Customer::class, 'user_id');
    }

    // Histories
    public function histories()
    {
        return $this->hasMany(History::class, 'user_id');
    }

    // Invoices
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'user_id');
    }

    // Item categories
    public function itemCategories()
    {
        return $this->hasMany(ItemCategory::class, 'user_id');
    }

    // Item details
    public function itemDetails()
    {
        return $this->hasMany(ItemDetail::class, 'user_id');
    }

    // Items
    public function items()
    {
        return $this->hasMany(Item::class, 'user_id');
    }

    // Transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }
}

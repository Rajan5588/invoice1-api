<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscribedUser extends Model
{
    protected $fillable = [
        'user_id',
        'subscription_id',
        'amount',
        'start_date',
        'end_date',
        'status',
        'payment_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function subscription() {
        return $this->belongsTo(Subscription::class);
    }
}

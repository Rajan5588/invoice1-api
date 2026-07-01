<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'company_name',
        'email',
        'phone',
        'gst',
        'gst_treatment',
        'place_of_supply',
        'state',
        'user_id','company_code'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

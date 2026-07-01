<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_name',
        'plan_price',
        'plan_validity',
        'plan_status','plan_description',
        'user_add_count',
         'business_add_count',
         'invoice_add_count','company_code'
    ];
}

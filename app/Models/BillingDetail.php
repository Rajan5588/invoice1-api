<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id','name','email','phone','state','address'
    ];

   public function invoice()
{
    return $this->belongsTo(Invoice::class);
}

// Access company_code directly through the chain
public function getCompanyCodeAttribute()
{
    return $this->invoice->user->company_code ?? null;
}

}

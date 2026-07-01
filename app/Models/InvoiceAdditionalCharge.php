<?php

// app/Models/InvoiceAdditionalCharge.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceAdditionalCharge extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_id', 'charge_name','price'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    public function getCompanyCodeAttribute()
{
    return $this->invoice->user->company_code ?? null;
}
}

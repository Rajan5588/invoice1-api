<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BillingDetail;
use App\Models\ShippingDetail;
use App\Models\GstDetail; 
class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'customer_id', 'customer_name', 'customer_number',
        'payment_type', 'discount_percent', 'discount_amount',
        'round_off', 'total_amount', 'amount_received', 'note','company_code'
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function charges()
    {
        return $this->hasMany(InvoiceAdditionalCharge::class);
    }


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function transactions()
{
    return $this->hasMany(Transaction::class);
}

public function billingDetail()
    {
        return $this->hasOne(BillingDetail::class, 'invoice_id', 'id');
    }

    // Shipping Detail
    public function shippingDetail()
    {
        return $this->hasOne(ShippingDetail::class, 'invoice_id', 'id');
    }

    // GST Details
    public function gstDetails()
    {
        return $this->hasMany(GstDetail::class, 'invoice_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessProfile extends Model
{
    use HasFactory;
 protected $fillable = [
    'user_id', 'business_id', 'gst_no', 'phone_no_first', 'phone_no_second',
    'email', 'business_email', 'business_address', 'pincode',
    'business_desc', 'digital_sign', 'business_state', 'business_category',
    'website', 'business_signature','business_type','business_name','company_code'
];

public function user()
{
    return $this->belongsTo(User::class);
}
public function getDigitalSignAttribute($value)
    {
        return $value ? asset( $value) : null;
    }

    // ✅ Accessor for business_signature
    public function getBusinessSignatureAttribute($value)
    {
        return $value ? asset($value) : null;
    }
}

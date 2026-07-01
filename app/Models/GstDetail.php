<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GstDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id','item_id','price','quantity','gst_percent',
        'cgst','sgst','igst','without_gst','gst_amount','total'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}

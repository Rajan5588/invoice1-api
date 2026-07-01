<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id', 'unit', 'salesprice_amount', 'salesprice_tax',
        'purches_price_amount', 'purches_price_tax', 'mrp_price', 'gst'
    ];

    public function item() {
        return $this->belongsTo(Item::class);
    }
}

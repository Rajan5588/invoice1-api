<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id', 'opening_stock', 'as_of_date', 'item_name',
        'low_alert_status', 'low_alert_quantity'
    ];

    public function item() {
        return $this->belongsTo(Item::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemDetail extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'item_category_id', 'item_description', 'show_online_store', 'user_id'];

    public function item() {
        return $this->belongsTo(Item::class);
    }

    public function category() {
        return $this->belongsTo(ItemCategory::class, 'item_category_id');
    }
}


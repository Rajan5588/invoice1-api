<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['item_name', 'user_id','company_code'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function pricings() {
        return $this->hasMany(Pricing::class);
    }

    public function stocks() {
        return $this->hasMany(Stock::class);
    }

    public function otherImages() {
        return $this->hasMany(ItemOtherImage::class);
    }

    public function details() {
        return $this->hasOne(ItemDetail::class);
    }
}

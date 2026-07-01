<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_category_name',
        'user_id','company_code'
    ];

    // Optional: relation to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


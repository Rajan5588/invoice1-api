<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'amount',
        'category',
        'expense_date',
        'payment_mode',
        'notes',
        'photos',
        'status',
        'company_code'
    ];

    protected $casts = [
        'photos' => 'array',
        'expense_date' => 'date',
    ];

    /**
     * Expense belongs to a User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
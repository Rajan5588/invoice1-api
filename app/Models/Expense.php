<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
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
}

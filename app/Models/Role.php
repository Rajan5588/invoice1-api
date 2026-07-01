<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'role_name',
        'owner_id',
        'company_code',
    ];

    /**
     * Relationship: Role belongs to a User (owner)
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Optionally, you can get all users associated with this role
     * if you have a user_role or similar pivot table.
     */
    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_id');
    // }
}

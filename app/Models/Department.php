<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'head_of_department',
        'email',
        'address',
        'phone_number',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

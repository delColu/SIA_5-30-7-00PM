<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'description',
        'head_of_department',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

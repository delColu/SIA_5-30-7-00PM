<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(20)->create([
            'department_id' => Department::inRandomOrder()->first()?->id,
        ]);
    }
}

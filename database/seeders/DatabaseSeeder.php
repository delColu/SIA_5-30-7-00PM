<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {





        $this->call([
            DepartmentSeeder::class,
            UserSeeder::class,
            TaskSeeder::class,
            ActivityLogSeeder::class,
            ReportSeeder::class,
        ]);

            User::factory()->create([
                'name' => 'Admin User',
                'email' => 'testadmin@example.com',
                'password' => bcrypt('password'),
                'type' => 'admin',
                'department_id' => 1,
            ]);

            User::factory()->create([
                'name' => 'Student User',
                'email' => 'teststudent@example.com',
                'password' => bcrypt('password'),
                'type' => 'student',
                'department_id' => 1,
            ]);

            User::factory()->create([
                'name' => 'Intern User',
                'email' => 'testintern@example.com',
                'password' => bcrypt('password'),
                'type' => 'intern',
                'department_id' => 1,

            ]);

            User::factory()->create([
                'name' => 'Supervisor User',
                'email' => 'testsupervisor@example.com',
                'password' => bcrypt('password'),
                'type' => 'supervisor',
                'department_id' => 1,
            ]);

            User::factory()->create([
                'name' => 'Dean User',
                'email' => 'testdean@example.com',
                'password' => bcrypt('password'),
                'type' => 'dean',
                'department_id' => 1,
            ]);

            User::factory()->create([
                'name' => 'Staff User',
                'email' => 'teststaff@example.com',
                'password' => bcrypt('password'),
                'type' => 'staff',
                'department_id' => 1,
            ]);

            }
}

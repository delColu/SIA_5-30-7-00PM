<?php

namespace Database\Factories;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityLogFactory extends Factory
{
    protected $model = ActivityLog::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'activity_type' => $this->faker->randomElement(['login', 'logout', 'create', 'update', 'delete']),
            'method' => $this->faker->randomElement(['GET', 'POST', 'PUT', 'DELETE']),
            'description' => $this->faker->sentence(),
        ];
    }
}

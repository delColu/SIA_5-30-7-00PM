<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'report_type' => $this->faker->randomElement(['weekly', 'monthly', 'incident']),
            'status' => $this->faker->randomElement(['draft', 'submitted', 'approved', 'rejected']),
            'content' => $this->faker->paragraphs(3, true),
            'supervisor_comments' => $this->faker->paragraph(),
            'file_path' => $this->faker->word . '.pdf',
        ];
    }
}

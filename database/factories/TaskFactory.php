<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'task_name' => fake()->sentence(3),
            'description' => fake()->optional()->sentence(),
            'status' => 'Pending',
            'due_date' => '2026-10-01',
        ];
    }
}

<?php

// database/factories/TaskFactory.php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'user_id' => \App\Models\User::factory()->create()->id,
            'description' => $this->faker->paragraph,
            'status' => 'pending', // Adjust based on your task status options
            'project_id' => \App\Models\Project::factory()->create()->id,
            // Add other required fields and their fake data
        ];
    }
}

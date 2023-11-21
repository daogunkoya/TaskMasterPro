<?php

// database/factories/ProjectFactory.php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

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
            'status' => 'pending', // Adjust based on your project status options
            'deadline' => $this->faker->dateTimeBetween('now', '+30 days')->format('Y-m-d H:i:s'),
            // Add other required fields and their fake data
        ];
    }
}

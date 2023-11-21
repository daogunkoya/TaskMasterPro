<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;


class TaskControllerTest extends TestCase
{
            use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Authenticate a user using Passport actingAs()
        $user = User::factory()->create();
        Passport::actingAs($user);

        // Set default headers for API requests
        $this->withHeaders([
            'Accept' => 'application/json',
            // Add more headers if needed
        ]);
    }

    /** @test */
    public function it_can_list_all_tasks()
    {

        $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('GET', 'api/v1/tasks')
            ->assertStatus(200); // Adjust the expected status code based on your application logic for fetching tasks

    }

    /** @test */
    public function it_can_create_a_task()
    {

// Create task data
        $taskData = [
            'title' => 'New Task',
            'description' => 'Task Description',
            'status' => 'pending',
            'project_id' =>  \App\Models\Project::factory()->create()->id,
            // Add other required data for task creation
        ];

        // Make a POST request to create a task
        $response = $this->postJson('api/v1/tasks', $taskData);

        // Assert the response status
        $response->assertStatus(201); // Adjust based on your expected response status

        $this->assertDatabaseHas('tasks', ['title' => 'New Task']);


    }

    /** @test */
    public function it_can_show_a_task()
    {
        // Create a test task
        $task = Task::factory()->create();

        // Make a GET request to fetch a specific task
        $response = $this->get('api/v1/tasks/' . $task->id);

        $response->assertStatus(200)
            ->assertJson([]);
;    }

    /** @test */
    public function it_can_update_a_task()
    {
        // Create a test task
        $task = Task::factory()->create();


        // Make a PUT request to update the task
        $response = $this->put('api/v1/tasks/' . $task->id, $task->toArray());

            $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_task()
    {
        // Create a test task
        $task = Task::factory()->create();


        // Make a DELETE request to delete the task
        $response = $this->delete('api/v1/tasks/' . $task->id);

        $response->assertStatus(204);
    }

    // Add more test methods for other functionalities of the TaskController as needed...
}

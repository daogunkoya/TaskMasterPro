<?php

namespace Tests\Unit;

use App\Repositories\TaskRepository;
use Tests\TestCase;

class TaskRepositoryTest extends TestCase
{
    protected TaskRepository $taskRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->taskRepository = new TaskRepository();
    }

    /** @test */
    public function it_can_get_all_tasks()
    {
        // Mock the input parameters for the method
        $input = ['page' => 1, 'limit' => 5];

        $result = $this->taskRepository->getAllTasks($input);

        // Assert the keys and data structure of the returned array
        $this->assertArrayHasKey('task', $result);
        $this->assertArrayHasKey('count', $result);

    }


    /** @test */
    public function it_can_create_a_task()
    {
        // Prepare dummy task data for creation
        $taskData = [
            'title' => 'New Task',
            'description' => 'Task Description',
            'project_id' => 1, // Replace with a valid project ID
        ];

        // Run the method to create a task
        $taskId = $this->taskRepository->create($taskData);

        // Assert that a task ID is returned after creation
        $this->assertIsString($taskId);

    }

}

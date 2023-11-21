<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use App\Models\User;


class ProjectControllerTest extends TestCase
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
    public function it_can_list_all_projects()
    {

        $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('GET', 'api/v1/projects')
            ->assertStatus(200);

    }

    /** @test */
    public function it_can_create_a_project()
    {

// Create project data
        $projectData = [
            'title' => 'New Project',
            'description' => 'Project Description',
            'status' => 'pending',
            'deadline' => now()->addDays(10)->format('Y-m-d H:i:s'),
            // Add other required data for project creation
        ];

        // Make a POST request to create a project
        $response = $this->postJson('api/v1/projects', $projectData);

        // Assert the response status
        $response->assertStatus(201); // Adjust based on your expected response status

        $this->assertDatabaseHas('projects', ['title' => 'New Project']);


    }

    /** @test */
    public function it_can_show_a_project()
    {
        // Create a test project
        $project = Project::factory()->create();

        // Make a GET request to fetch a specific project
        $response = $this->get('api/v1/projects/' . $project->id);

        $response->assertStatus(200)
            ->assertJson([]);
;    }

    /** @test */
    public function it_can_update_a_project()
    {
        // Create a test project
        $project = Project::factory()->create();


        // Make a PUT request to update the project
        $response = $this->put('api/v1/projects/' . $project->id, $project->toArray());

            $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_project()
    {
        // Create a test project
        $project = Project::factory()->create();


        // Make a DELETE request to delete the project
        $response = $this->delete('api/v1/projects/' . $project->id);

        $response->assertStatus(204);
    }

}

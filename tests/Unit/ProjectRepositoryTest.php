<?php

namespace Tests\Unit\Repositories;

use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectRepositoryTest extends TestCase
{
    use RefreshDatabase; // This trait helps in refreshing the database after each test

    private ProjectRepository $projectRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->projectRepository = new ProjectRepository();
    }

    /** @test */
    public function it_can_get_all_projects()
    {
        // Generate dummy projects in the database (you may use factory or manually create)
        Project::factory()->count(5)->create();

        $input = ['page' => 1, 'limit' => 5];
        $projects = $this->projectRepository->getAllProjects($input);

        // Assert that the returned projects array contains 'project' and 'count' keys
        $this->assertArrayHasKey('project', $projects);
        $this->assertArrayHasKey('count', $projects);
        $this->assertCount(5, $projects['project']); // Assuming 5 projects are created for testing
    }

    /** @test */
    public function it_can_fetch_projects_statistics()
    {

        Project::factory()->count(3)->create();

        $statistics = $this->projectRepository->fetchProjectsStatistics();


        $this->assertArrayHasKey('total_projects', $statistics);
        $this->assertArrayHasKey('projects', $statistics);
        $this->assertCount(3, $statistics['projects']); // Assuming 3 projects are created for testing

    }

}

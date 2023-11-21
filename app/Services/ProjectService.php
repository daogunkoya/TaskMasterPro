<?php
namespace App\Services;

use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Support\Collection;

class ProjectService implements ProjectServiceInterface
{


    public function __construct(protected ProjectRepository $projectRepository)
    {
    }

    public function getAllProjects(array $input): array
    {
        return $this->projectRepository->getAllProjects($input);
    }

    public function getProjectTasks(string $projectId, array $input): array
    {
        return $this->projectRepository->getProjectTasks($projectId, $input);
    }


    public function create(array $data):string
    {
        return $this->projectRepository->create($data);
    }

    public function update($id, array $data):Project
    {
        $project = $this->projectRepository->findById($id);
        return $this->projectRepository->update($project, $data);
    }

    public function delete($id):bool
    {
        $project = $this->projectRepository->findById($id);
      return   $this->projectRepository->delete($project);
    }

    public function findById($id):Project
    {
        return $this->projectRepository->findById($id);
    }

    public function fetchProject(string $id):Project
    {
        return $this->projectRepository->fetchProject($id);
    }

    public function checkProjectExist(string $projectId):bool
    {
         return $this->projectRepository->checkProjectExist($projectId);
    }

    public function fetchProjectsStatistics():array
    {
        return $this->projectRepository->fetchProjectsStatistics();
    }

    // Implement other methods
}

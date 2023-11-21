<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Support\Collection;

interface ProjectServiceInterface
{
    public function create(array $data): string;

    public function update($id, array $data):Project;

    public function delete($id): bool;

    public function findById($id): Project;

    public function getAllProjects(array $input): array;

    public function getProjectTasks(string $projectId, array $input): array;

    public function fetchProject(string $id):Project;

    public function checkProjectExist(string $id): bool;

    public function fetchProjectsStatistics():array;

    // Other methods as needed
}

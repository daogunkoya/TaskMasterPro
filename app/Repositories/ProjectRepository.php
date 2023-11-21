<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Collection;
use Illuminate\Database\QueryException;

class ProjectRepository
{
    public function getAllProjects(array $input): array
    {

        $page = $input['page'] ?? 1;
        $limit = $input['limit'] ?? 6;

        $query = Project::
        select('id', 'title', 'description', 'deadline', 'created_at')
            ->orderBy('created_at', 'DESC')
            ->paginate($limit, ['*'], 'page', $page);

        return [
            'count' => $query->count(),
            'project' => $query->items()
        ];
    }

    public function fetchProjectsStatistics(): array{
        $projects = Project::withCount('tasks')->withCount('completedTasks')->get();

        $formattedProjects = $projects->map(function ($project) {
            return [
                'project_id' => $project->id,
                'total_tasks' => $project->tasks_count,
                'completed_tasks' => $project->completed_tasks_count,
            ];
        });

        return [
            'total_projects' => $projects->count(),
            'projects' => $formattedProjects,
        ];

    }

    public function getProjectTasks(string $projectId, array $input): array
    {

        $page = $input['page'] ?? 1;
        $limit = $input['limit'] ?? 6;

        $query = Task::where('project_id', $projectId)
            ->select('id as task_id', 'title', 'description', 'deadline', 'created_at')
            ->orderBy('created_at', 'DESC')
            ->paginate($limit, ['*'], 'page', $page);

        return [
            'count' => $query->count(),
            'project' => $query->items()
        ];
    }

    public function create(array $data): string
    {
        try {
            $project = Project::create($data);
            return $project->id;
        } catch (QueryException $exception) {
            // Log the exception
            return "something went wrong";
        }
    }

    public function update(Project $project, array $data): ?Project
    {
        try {
            $project->update($data);
            return $project->fresh();
        } catch (QueryException $exception) {
            // Log the exception
            return "something went wrong";
        }
    }

    public function delete(Project $project): bool
    {
        try {
            return $project->delete();
        } catch (QueryException $exception) {
            // Log the exception
            return "something went wrong";
        }
    }

    public function findById($id): Project
    {
        return Project::findOrFail($id);
    }

    public function checkProjectExist($id): bool
    {
        return Project::where('id', $id)->exists();
    }

    public function fetchProject($id): Project
    {

        return Project::where('id', $id)
            ->select('id', 'title', 'description', 'deadline', 'created_at')
            ->first();
    }


}

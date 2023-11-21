<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\ProjectStoreRequest;
use App\Http\Requests\Project\ProjectUpdateRequest;
use App\Http\Requests\Project\ProjectShowRequest;
use App\Services\ProjectServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;


class ProjectController extends Controller
{

    public function __construct(protected ProjectServiceInterface $projectService)
    {

    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $input = $request->only(['page', 'limit']);
        $projects = $this->projectService->getAllProjects($input);

        return ProjectResource::collection($projects['project'])
            ->additional(['count' => $projects['count']]);
    }

    public function getProjectTask(Request $request, $projectId): JsonResponse
    {
        $input = $request->only(['page', 'limit']);
        $projectTasks = $this->projectService->getProjectTasks($projectId, $input);
        return response()->json($projectTasks);
    }

    public function store(ProjectStoreRequest $request): JsonResponse
    {
        $data = $request->only(['title', 'description', 'status', 'deadline']);
        $data['user_id'] = Auth::id();

        $projectId = $this->projectService->create($data);

        return $projectId
            ? response()->json(['project_id' => $projectId], 201)
            : response()->json(['message' => 'Failed to create project'], 500);
    }

    public function update(ProjectUpdateRequest $request, $id):JsonResource
    {
        // Validation logic
        $data = $request->only(['title', 'description', 'status', 'deadline']);

        $project = $this->projectService->update($id, $data);

        return new ProjectResource($project);

    }

    public function show(ProjectShowRequest $request, $projectId): JsonResource
    {

        $project = $this->projectService->fetchProject($projectId);

        return new ProjectResource($project);
    }

    public function destroy(ProjectShowRequest $request, $projectId): JsonResponse
    {

        $this->projectService->delete($projectId);

        return response()->json(null, 204);
    }

    public function projectStatistics(): JsonResponse
    {
        $projectsStatistics = $this->projectService->fetchProjectsStatistics();

        return response()->json($projectsStatistics);
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\TaskStoreRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use App\Http\Requests\Task\TaskShowRequest;
use App\Services\TaskServiceInterface;
use App\Services\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Project;
use App\Models\Task;


class TaskController extends Controller
{

    public function __construct(protected TaskServiceInterface $taskService,
                                protected  UserServiceInterface $userService)
    {

    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $input = $request->only(['page', 'limit']);
        $tasks = $this->taskService->getAllTasks($input);

        return TaskResource::collection($tasks['task'])
            ->additional(['count' => $tasks['count']]);
    }

    public function getTaskTask(Request $request, $taskId): JsonResponse
    {
        $input = $request->only(['page', 'limit']);
        $taskTasks = $this->taskService->getTaskTasks($taskId, $input);
        return response()->json($taskTasks);
    }

    public function store(TaskStoreRequest $request): JsonResponse
    {
        $data = $request->only(['title', 'description', 'status', 'project_id']);

        $taskId = $this->taskService->create($data);

        return $taskId
            ? response()->json(['task_id' => $taskId], 201)
            : response()->json(['message' => 'Failed to create task'], 500);
    }

    public function update(TaskUpdateRequest $request, $id):JsonResource
    {
        // Validation logic
        $data = $request->only(['title', 'description', 'status', 'project_id']);

        $task = $this->taskService->update($id, $data);

        return new TaskResource($task);

    }

    public function show(TaskShowRequest $request, $taskId): JsonResource
    {

        $task = $this->taskService->fetchTask($taskId);

        return new TaskResource($task);
    }

    public function destroy(TaskShowRequest $request, $taskId): JsonResponse
    {

        $this->taskService->delete($taskId);

        return response()->json(null, 204);
    }

    public function assignTask(Project $project, Task $task, Request $request)
    {
        $userId = $request->input('user_id')?? Auth::id();

        // Check if the task belongs to the project
        if ($task->project_id !== $project->id) {
            return response()->json(['error' => 'Task does not belong to this project'], 404);
        }

        try {
            // Get user from UserRepository
            $user = $this->userService->getUserById($userId);

            // Check if the user exists and is associated with the project
            if (!$user ) {
                return response()->json(['error' => 'User not found or not associated with the project'], 404);
            }

            $result = $this->taskService->assignTask($task, $userId);

            return response()->json($result ?
                ['message' => 'Task assigned successfully']
                : ['error' => 'Failed to assign task'], $result ? 200 : 500);

        } catch (\Exception $e) {
            // Log the exception
            // Return appropriate error response
            return response()->json(['error' => 'Something went wrong', 'message' => $e->getMessage()], 500);
        }
    }

}

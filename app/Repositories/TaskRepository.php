<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\QueryException;

class TaskRepository
{
    public function getAllTasks(array $input): array
    {

        $page = $input['page'] ?? 1;
        $limit = $input['limit'] ?? 6;

        $query = Task::
        select('id', 'title', 'description', 'project_id', 'created_at')
            ->orderBy('created_at', 'DESC')
            ->paginate($limit, ['*'], 'page', $page);

        return [
            'count' => $query->count(),
            'task' => $query->items()
        ];
    }

    public function getTaskTasks(string $taskId, array $input): array
    {

        $page = $input['page'] ?? 1;
        $limit = $input['limit'] ?? 6;

        $query = Task::where('task_id', $taskId)
            ->select('id as task_id', 'title', 'description', 'project_id', 'created_at')
            ->orderBy('created_at', 'DESC')
            ->paginate($limit, ['*'], 'page', $page);

        return [
            'count' => $query->count(),
            'task' => $query->items()
        ];
    }

    public function create(array $data): string
    {
        try {
            $task = Task::create($data);
            return $task->id;
        } catch (QueryException $exception) {
            // Log the exception
            return "something went wrong";
        }
    }

    public function update(Task $task, array $data): ?Task
    {
        try {
            $task->update($data);
            return $task->fresh();
        } catch (QueryException $exception) {
            // Log the exception
            return "something went wrong";
        }
    }

    public function delete(Task $task): bool
    {
        try {
            return $task->delete();
        } catch (QueryException $exception) {
            // Log the exception
            return "something went wrong";
        }
    }

    public function findById($id): Task
    {
        return Task::findOrFail($id);
    }

    public function checkTaskExist($id): bool
    {
        return Task::where('id', $id)->exists();
    }

    public function fetchTask($id): Task
    {

        return Task::where('id', $id)
            ->select('id', 'title', 'description', 'project_id', 'created_at')
            ->first();
    }

    public function assignTask(Task $task, string $userId): bool
    {
        // Assign the task to the user
        $task->user_id = $userId;
        return $task->save();
    }


}

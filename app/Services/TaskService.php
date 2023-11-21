<?php
namespace App\Services;

use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Support\Collection;

class TaskService implements TaskServiceInterface
{


    public function __construct(protected TaskRepository $taskRepository)
    {
    }

    public function getAllTasks(array $input): array
    {
        return $this->taskRepository->getAllTasks($input);
    }

    public function getTaskTasks(string $taskId, array $input): array
    {
        return $this->taskRepository->getTaskTasks($taskId, $input);
    }


    public function create(array $data):string
    {
        return $this->taskRepository->create($data);
    }

    public function update($id, array $data):Task
    {
        $task = $this->taskRepository->findById($id);
        return $this->taskRepository->update($task, $data);
    }

    public function delete($id):bool
    {
        $task = $this->taskRepository->findById($id);
        return   $this->taskRepository->delete($task);
    }

    public function findById($id):Task
    {
        return $this->taskRepository->findById($id);
    }

    public function fetchTask(string $id):Task
    {
        return $this->taskRepository->fetchTask($id);
    }

    public function checkTaskExist(string $taskId):bool
    {
        return $this->taskRepository->checkTaskExist($taskId);
    }

    public function assignTask(Task $task, string $userId): bool
    {
        return $this->taskRepository->assignTask($task, $userId);
    }

    // Implement other methods
}

<?php

namespace App\Services;

use App\Models\Task;

interface TaskServiceInterface
{
    public function create(array $data): string;

    public function update($id, array $data):Task;

    public function delete($id): bool;

    public function findById($id): Task;

    public function getAllTasks(array $input): array;

    public function getTaskTasks(string $taskId, array $input): array;

    public function fetchTask(string $id):Task;

    public function checkTaskExist(string $id): bool;

    // Other methods as needed
}

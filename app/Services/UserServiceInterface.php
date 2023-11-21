<?php

namespace App\Services;

use App\Models\User;

use App\Models\Project;

interface UserServiceInterface
{

    public function getUserById($userId): User;

    public function isUserAssociatedWithProject(User $user, Project $project): bool;

}

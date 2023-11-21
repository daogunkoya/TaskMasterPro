<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\User;

class UserRepository
{
    public function getUserById($userId)
    {
        return User::findOrFail($userId);
    }

    public function isUserAssociatedWithProject($user, Project $project): bool
    {
        return $user->projects()->where('id', $project->id)->exists();
    }
}

<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;
use App\Repositories\UserRepository;

class UserService implements UserServiceInterface
{


    public function __construct(public UserRepository $userRepository)
    {
    }

    public function getUserById($userId): User
    {
        return $this->userRepository->getUserById($userId);
    }

    public function isUserAssociatedWithProject(User $user, Project $project): bool
    {
        return $this->userRepository->isUserAssociatedWithProject($user, $project);
    }
}

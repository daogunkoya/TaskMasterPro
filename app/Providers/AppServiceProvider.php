<?php

namespace App\Providers;

use App\Interfaces\Auth\LoginServiceInterface;
use App\Interfaces\Auth\RegisterServiceInterface;
use App\Services\Auth\LoginUserService;
use App\Services\Auth\RegisterUserService;
use Illuminate\Support\ServiceProvider;

use App\Services\UserService;
use App\Services\UserServiceInterface;

use App\Services\ProjectService;
use App\Services\ProjectServiceInterface;
use App\Services\TaskService;
use App\Services\TaskServiceInterface;
use App\Observers\TaskObserver;
use App\Models\Task;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        $this->app->bind(LoginServiceInterface::class, LoginUserService::class);
        $this->app->bind(RegisterServiceInterface::class, RegisterUserService::class);

        $this->app->bind(ProjectServiceInterface::class, ProjectService::class);
        $this->app->bind(TaskServiceInterface::class, TaskService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);

        Task::observe(TaskObserver::class);


    }
}

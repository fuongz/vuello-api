<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Auth\AuthRepository;
use App\Repositories\Auth\AuthRepositoryInterface;

use App\Repositories\Board\BoardRepository;
use App\Repositories\Board\BoardRepositoryInterface;

use App\Repositories\ActivityLog\ActivityLogRepository;
use App\Repositories\ActivityLog\ActivityLogRepositoryInterface;

use App\Repositories\Task\TaskRepository;
use App\Repositories\Task\TaskRepositoryInterface;

use App\Repositories\TaskGroup\TaskGroupRepository;
use App\Repositories\TaskGroup\TaskGroupRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            ActivityLogRepositoryInterface::class,
            ActivityLogRepository::class
        );

        $this->app->singleton(
            AuthRepositoryInterface::class,
            AuthRepository::class
        );

        $this->app->singleton(
            BoardRepositoryInterface::class,
            BoardRepository::class
        );

        $this->app->singleton(
            TaskGroupRepositoryInterface::class,
            TaskGroupRepository::class
        );

        $this->app->singleton(
            TaskRepositoryInterface::class,
            TaskRepository::class
        );
    }
}

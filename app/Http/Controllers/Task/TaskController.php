<?php

namespace App\Http\Controllers\Task;

// Vendors
use Illuminate\Http\Request;

// In apps
use App\Http\Controllers\AppControllerAbstract;
use App\Repositories\Task\TaskRepositoryInterface;

/**
 * Class TaskController
 * @package App\Http\Controllers\Task
 */
class TaskController extends AppControllerAbstract {

    /**
     * TaskController constructor.
     * @param Request $request
     * @param TaskRepositoryInterface $taskRepository
     */
    public function __construct(Request $request, TaskRepositoryInterface $taskRepository)
    {
        $this->setRepository($taskRepository);
        $this->setRequest($request);
        $this->authGuard();
    }
}
<?php

namespace App\Http\Controllers\TaskGroup;

// Vendors
use App\Http\Controllers\AppControllerAbstract;
use App\Repositories\TaskGroup\TaskGroupRepositoryInterface;
use Illuminate\Http\Request;


/**
 * Class TaskGroupController
 * @package App\Http\Controllers\TaskGroup
 */
class TaskGroupController extends AppControllerAbstract
{
    /**
     * TaskGroupController constructor.
     * @param Request $request
     * @param TaskGroupRepositoryInterface $taskGroupRepository
     */
    public function __construct(Request $request, TaskGroupRepositoryInterface $taskGroupRepository)
    {
        $this->authGuard();

        $this->setRequest($request);
        $this->setRepository($taskGroupRepository);
    }
}
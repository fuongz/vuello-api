<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\AppControllerAbstract;
use App\Repositories\Board\BoardRepositoryInterface;
use Illuminate\Http\Request;

/**
 * Class TaskController
 * @package App\Http\Controllers\Task
 */
class BoardController extends AppControllerAbstract {

    /**
     * BoardController constructor.
     * @param Request $request
     * @param BoardRepositoryInterface $boardRepository
     */
    public function __construct(Request $request, BoardRepositoryInterface $boardRepository)
    {
        $this->authGuard();
        $this->setRepository($boardRepository);
        $this->setRequest($request);
    }

}
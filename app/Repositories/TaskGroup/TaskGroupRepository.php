<?php

namespace App\Repositories\TaskGroup;

use App\Models\Board;
use App\Models\TaskGroup;
use App\Repositories\BaseRepository;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskGroupRepository extends BaseRepository implements TaskGroupRepositoryInterface
{

    /**
     * @return mixed|string
     */
    public function getModel()
    {
        return TaskGroup::class;
    }


    /**
     * @param $id
     * @param int $limit
     * @return array
     */
    public function getByBoardId($id, $limit = 5)
    {
        $result = $this->_prepare()->where('board_id', $id)->orderBy('position', 'asc')->take($limit)->get();
        $safe_results = [];
        foreach ($result as $item) {
            $safe_results[] = $item->release(true);
        }
        return $safe_results;
    }


    /**
     * @param bool $isUpdateRequest
     * @return array|\string[][]
     */
    public function validator($isUpdateRequest = false)
    {
        if ($isUpdateRequest === true) {
            return [];
        }

        return [
            'name' => ['required', 'max:255'],
            'board_id' => ['required', 'integer']
        ];
    }


    /**
     * @param Request $request
     * @return array
     */
    public function getUpdateAttributes($request)
    {
        $updateAttributes = [];

        if ($request->input('name')) {
            $updateAttributes['name'] = $request->input('name');
        }

        if ($request->input('description')) {
            $updateAttributes['description'] = $request->input('description');
        }

        if ($request->input('position')) {
            $updateAttributes['position'] = $request->input('position');
        }

        $this->updateAttributes = $updateAttributes;
        return $updateAttributes;
    }


    /**
     * @param Request $request
     * @return array|void
     */
    public function getCreateAttributes($request)
    {
        $createAttributes = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'board_id' => $request->input('board_id'),
            'creator_id' => Auth::id(),
            'position' => $this->getNextPosition($request->input('board_id'))
        ];

        $this->createAttributes = $createAttributes;

        return $this->createAttributes;
    }


    /**
     * Get the next position number
     *
     * @param $boardId
     * @return int
     */
    public function getNextPosition($boardId)
    {
        $currentTaskGroup = $this->model->where('board_id', $boardId)->orderBy('position', 'desc')->first();
        if ($currentTaskGroup) {
            return (int)$currentTaskGroup->position + 65535;
        }
        return 65535;
    }


    /**
     * Do something when create a new task group
     * @throws Exception
     */
    public function onBeforeCreate()
    {
        try {
            Board::query()->findOrFail($this->createAttributes['board_id']);
        } catch (ModelNotFoundException $e) {
            throw new Exception(__("Board {$this->createAttributes['board_id']} not found"));
        }
    }

    public function onAfterCreate()
    {
    }

    public function onBeforeUpdate()
    {
    }

    public function onAfterUpdate()
    {
    }
}
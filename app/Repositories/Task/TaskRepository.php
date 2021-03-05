<?php

namespace App\Repositories\Task;

use App\Models\Task;
use App\Repositories\BaseRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{

    /**
     * @return mixed|string
     */
    public function getModel()
    {
        return Task::class;
    }

    /**
     * @param $id
     * @param $limit
     * @return array
     */
    public function getByGroupId($id, $limit = 5)
    {
        $result = $this->_prepare()->where('task_group_id', $id)->orderBy('position', 'asc')->take($limit)->get();
        $safe_results = [];
        foreach ($result as $item) {
            $safe_results[] = $item->release();
        }
        return $safe_results;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getUpdateAttributes($request)
    {
        $updateAttributes = [];

        if ($request->input('taskGroupId')) {
            $updateAttributes['task_group_id'] = $request->input('taskGroupId');
        }

        if ($request->input('name')) {
            $updateAttributes['name'] = $request->input('name');
        }

        if ($request->input('position')) {
            $updateAttributes['position'] = $request->input('position');
        }

        if ($request->input('description')) {
            $updateAttributes['description'] = $request->input('description');
        }

        $this->updateAttributes = $updateAttributes;
        return $updateAttributes;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getCreateAttributes($request)
    {
        $taskGroup = \App\Models\TaskGroup::query()->findOrFail($request->input('task_group_id'));

        $attributes = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'is_done' => $request->input('is_done'),
            'task_group_id' => $taskGroup->id,
            'board_id' => $taskGroup->board_id,
            'task_data' => jsonEncode([]),
            'followers' => jsonEncode([]),
            'creator_id' => Auth::id(),
            'position' => $this->getNextPosition($request->input('task_group_id'))
        ];

        $this->createAttributes = $attributes;

        return $attributes;
    }

    /**
     * Get the next position number
     *
     * @param int $taskGroupId
     * @return int
     */
    public function getNextPosition($taskGroupId)
    {
        $currentTask = $this->model->where('task_group_id', $taskGroupId)->orderBy('position', 'desc')->first();
        if ($currentTask) {
            return (int)$currentTask->position + 65535;
        }
        return 65535;
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
            'is_done' => ['required', 'integer', Rule::in([0, 1])],
            'task_group_id' => ['required', 'integer'],
        ];
    }

    public function onBeforeCreate()
    {
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
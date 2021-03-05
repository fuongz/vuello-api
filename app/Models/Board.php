<?php

namespace App\Models;

use App\Repositories\TaskGroup\TaskGroupRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @property int id
 * @property mixed data
 * @package App
 */
class Board extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'data', 'creator_id'
    ];

    protected $table = 'boards';

    /**
     * Release a safe object
     * @param bool $needToGetTaskGroups
     * @param int $limit
     * @return $this
     */
    public function release($needToGetTaskGroups = false, $limit = 18)
    {
        $safe_data = $this;
        $safe_data->data = jsonDecode($safe_data->data);
        if ($needToGetTaskGroups === false) {
            return $safe_data;
        }
        $taskGroupRepository = new TaskGroupRepository();
        $safe_data['task_groups'] = $taskGroupRepository->getByBoardId($this->id, $limit);

        return $safe_data;
    }
}

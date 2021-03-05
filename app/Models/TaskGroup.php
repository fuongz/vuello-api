<?php

namespace App\Models;

use App\Repositories\Task\TaskRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @property int id
 * @package App
 */
class TaskGroup extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'board_id', 'position', 'creator_id'
    ];

    protected $table = 'task_groups';

    /**
     * Release a safe object
     * @param bool $needToGetTasks
     * @param int $limit
     * @return $this
     */
    public function release($needToGetTasks = false, $limit = 18)
    {
        $safe_data = $this;
        if ($needToGetTasks === false) {
            return $safe_data;
        }
        $taskRepository = new TaskRepository();
        $safe_data['tasks'] = $taskRepository->getByGroupId($this->id, $limit);

        return $safe_data;
    }
}

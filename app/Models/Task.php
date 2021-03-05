<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @property mixed task_data
 * @property mixed followers
 * @package App
 */
class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'is_done', 'task_group_id', 'board_id', 'task_data', 'followers', 'creator_id', 'position'
    ];

    protected $table = 'tasks';


    /**
     * Release a safe object
     * @return $this
     */
    public function release()
    {
        $this->task_data = json_decode($this->task_data);
        $this->followers = json_decode($this->followers);
        return $this;
    }
}

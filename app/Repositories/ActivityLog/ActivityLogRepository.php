<?php

namespace App\Repositories\ActivityLog;

use App\Models\ActivityLog;
use App\Repositories\BaseRepository;

class ActivityLogRepository extends BaseRepository implements ActivityLogRepositoryInterface {

    public function getModel()
    {
        return ActivityLog::class;
    }

    public function getUpdateAttributes($request)
    {
        // TODO: Implement getUpdateAttributes() method.
    }

    public function getCreateAttributes($request)
    {
        // TODO: Implement getCreateAttributes() method.
    }

    public function onBeforeCreate()
    {
        // TODO: Implement onBeforeCreate() method.
    }

    public function onAfterCreate()
    {
        // TODO: Implement onAfterCreate() method.
    }

    public function onBeforeUpdate()
    {
        // TODO: Implement onBeforeUpdate() method.
    }

    public function onAfterUpdate()
    {
        // TODO: Implement onAfterUpdate() method.
    }
}
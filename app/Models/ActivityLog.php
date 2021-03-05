<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @property mixed ref_cached
 * @package App
 */
class ActivityLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meta_type', 'event_name', 'ref_id', 'ref_cached', 'creator_id'
    ];

    protected $table = 'activity_logs';

    /**
     * Release a safe object
     * @return $this
     */
    public function release()
    {
        $log = $this;
        $log->ref_cached = json_decode($log->ref_cached);
        return $log;
    }
}

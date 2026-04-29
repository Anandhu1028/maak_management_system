<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskLog extends Model
{
    protected $fillable = ['stage_task_id', 'date', 'work_done_percent', 'notes'];

    protected $casts = [
        'date' => 'date',
        'work_done_percent' => 'integer'
    ];

    public function task()
    {
        return $this->belongsTo(StageTask::class, 'stage_task_id');
    }
}

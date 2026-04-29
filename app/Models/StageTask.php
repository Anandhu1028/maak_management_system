<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StageTask extends Model
{
    protected $fillable = ['project_stage_id', 'name', 'weight', 'progress', 'status'];

    protected $casts = [
        'weight' => 'decimal:2',
        'progress' => 'integer',
    ];

    public function stage()
    {
        return $this->belongsTo(ProjectStage::class, 'project_stage_id');
    }

    public function logs()
    {
        return $this->hasMany(TaskLog::class, 'stage_task_id');
    }
}

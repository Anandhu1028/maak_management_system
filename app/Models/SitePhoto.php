<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SitePhoto extends Model
{
    protected $fillable = ['project_id', 'stage_id', 'work_log_id', 'photo_path', 'caption'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function stage()
    {
        return $this->belongsTo(ProjectStage::class, 'stage_id');
    }

    public function workLog()
    {
        return $this->belongsTo(WorkLog::class);
    }
}

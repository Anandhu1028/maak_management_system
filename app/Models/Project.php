<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name', 'type', 'client_id', 'site_address', 'project_value',
        'estimated_internal_cost', 'start_date', 'end_date', 'description', 'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'project_value' => 'decimal:3',
        'estimated_internal_cost' => 'decimal:3',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function stages()
    {
        return $this->hasMany(ProjectStage::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function workLogs()
    {
        return $this->hasMany(WorkLog::class);
    }

    public function sitePhotos()
    {
        return $this->hasMany(SitePhoto::class);
    }

    public function documents()
    {
        return $this->hasMany(ProjectDocument::class);
    }

    public function supervisors()
    {
        return $this->belongsToMany(User::class, 'project_supervisor', 'project_id', 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'project_id', 'stage_id', 'type', 'amount', 'date', 'method', 'proof_path', 'description'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:3',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function stage()
    {
        return $this->belongsTo(ProjectStage::class, 'stage_id');
    }
}

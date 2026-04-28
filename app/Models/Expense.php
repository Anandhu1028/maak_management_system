<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'project_id', 'stage_id', 'user_id', 'category', 'amount',
        'date', 'description', 'invoice_path', 'status'
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

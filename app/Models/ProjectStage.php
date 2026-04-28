<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectStage extends Model
{
    protected $fillable = [
        'project_id', 'name', 'budget', 'weight_percentage', 'start_date',
        'end_date', 'client_payment_amount', 'completion_percentage', 'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:3',
        'client_payment_amount' => 'decimal:3',
        'weight_percentage' => 'decimal:2',
        'completion_percentage' => 'decimal:2',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'stage_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'stage_id');
    }
}

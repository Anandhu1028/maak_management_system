<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\StageTask;
use App\Models\TaskLog;

class TaskLogController extends Controller
{
    public function store(Request $request, StageTask $task)
    {
        $validated = $request->validate([
            'work_done_percent' => 'required|integer|min:1|max:100',
            'date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $currentTotal = $task->logs()->sum('work_done_percent');
        
        if ($currentTotal + $validated['work_done_percent'] > 100) {
            return response()->json([
                'success' => false,
                'error' => "Deployment exceeds 100% threshold. Current: {$currentTotal}%"
            ], 422);
        }

        $log = $task->logs()->create($validated);
        
        // Recalculate Task Completion
        $newProgress = $task->logs()->sum('work_done_percent');
        $task->update([
            'progress' => $newProgress,
            'status' => $newProgress >= 100 ? 'Completed' : 'In Progress'
        ]);

        // Recalculate Stage Velocity
        $stage = $task->stage;
        $totalVelocity = 0;
        foreach ($stage->tasks as $t) {
            $totalVelocity += ($t->weight * $t->progress) / 100;
        }
        $stage->update(['completion_percentage' => $totalVelocity]);

        return response()->json([
            'success' => true,
            'task_progress' => $newProgress,
            'stage_progress' => number_format($totalVelocity, 1),
            'log' => [
                'id' => $log->id,
                'date' => $log->date->format('d M Y'),
                'increment' => $log->work_done_percent,
                'notes' => $log->notes
            ]
        ]);
    }
}

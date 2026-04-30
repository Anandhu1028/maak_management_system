<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProjectStage;
use App\Models\StageTask;

class ProjectStageTaskController extends Controller
{
    public function index(ProjectStage $stage)
    {
        return response()->json([
            'success' => true,
            'tasks' => $stage->tasks()->select('id', 'name', 'weight', 'progress', 'status')->get()
        ]);
    }

    public function store(Request $request, ProjectStage $stage)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0.01|max:100',
        ]);

        $currentWeight = $stage->tasks()->sum('weight');
        if ($currentWeight + $validated['weight'] > 100) {
            $msg = "Cumulative weight exceeds 100%. Current: {$currentWeight}%";
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'error' => $msg], 422);
            }
            return back()->withErrors(['weight' => $msg]);
        }

        $task = $stage->tasks()->create($validated);
        $this->syncStageProgress($stage);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'task' => [
                    'id' => $task->id,
                    'name' => $task->name,
                    'weight' => $task->weight,
                    'progress' => $task->progress,
                    'status' => $task->status
                ]
            ]);
        }

        return back()->with('success', 'Operational task deployed.');
    }

    public function updateProgress(Request $request, StageTask $task)
    {
        $validated = $request->validate([
            'progress' => 'required|integer|min:0|max:100',
        ]);

        $task->update([
            'progress' => $validated['progress'],
            'status' => $validated['progress'] == 100 ? 'Completed' : ($validated['progress'] > 0 ? 'In Progress' : 'Pending')
        ]);

        $newProgress = $this->syncStageProgress($task->stage);

        return response()->json([
            'success' => true,
            'task_status' => $task->status,
            'stage_progress' => number_format($newProgress, 1)
        ]);
    }

    public function destroy(Request $request, StageTask $task)
    {
        $stage = $task->stage;
        $task->delete();
        $this->syncStageProgress($stage);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Task purged from workflow.');
    }

    private function syncStageProgress(ProjectStage $stage)
    {
        $tasks = $stage->tasks;
        $totalProgress = 0;

        if ($tasks->count() > 0) {
            foreach ($tasks as $task) {
                $totalProgress += ($task->weight * $task->progress) / 100;
            }
        }

        $stage->update(['completion_percentage' => $totalProgress]);
        return $totalProgress;
    }
}

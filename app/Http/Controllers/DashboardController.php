<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\CompanyExpense;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProjects = Project::count();
        $activeProjects = Project::where('status', 'Active')->count();
        
        $totalIncome = Payment::sum('amount');
        $totalProjectExpenses = Expense::where('status', 'Approved')->sum('amount');
        $totalGeneralExpenses = CompanyExpense::where('status', 'Approved')->sum('amount');
        
        $netProfit = $totalIncome - ($totalProjectExpenses + $totalGeneralExpenses);
        
        $recentProjects = Project::with('client')->latest()->take(5)->get();
        $recentPayments = Payment::with('project')->latest()->take(5)->get();
        $recentActivities = \App\Models\ActivityLog::with('user')->latest()->take(10)->get();

        // Budget Alerts logic
        $budgetAlerts = [];
        $overBudgetProjects = Project::with('stages')->get()->filter(function($project) {
            $totalExpenses = $project->expenses()->where('status', 'Approved')->sum('amount');
            return $totalExpenses > ($project->estimated_internal_cost ?? 0);
        });

        foreach($overBudgetProjects as $project) {
            $budgetAlerts[] = [
                'type' => 'danger',
                'message' => "Project '{$project->name}' has exceeded its total estimated internal cost!",
                'project_id' => $project->id
            ];
        }

        // Stage level alerts (80%)
        $criticalStages = \App\Models\ProjectStage::with('project')->get()->filter(function($stage) {
            $stageExpenses = \App\Models\Expense::where('stage_id', $stage->id)->where('status', 'Approved')->sum('amount');
            return $stage->budget > 0 && ($stageExpenses / $stage->budget) >= 0.8;
        });

        foreach($criticalStages as $stage) {
            $stageExpenses = \App\Models\Expense::where('stage_id', $stage->id)->where('status', 'Approved')->sum('amount');
            $percent = round(($stageExpenses / $stage->budget) * 100);
            $type = $percent >= 100 ? 'danger' : 'warning';
            $budgetAlerts[] = [
                'type' => $type,
                'message' => "Stage '{$stage->name}' in Project '{$stage->project->name}' is at {$percent}% budget usage.",
                'project_id' => $stage->project_id
            ];
        }

        return view('dashboard', compact(
            'totalProjects', 'activeProjects', 'totalIncome', 
            'totalProjectExpenses', 'totalGeneralExpenses', 
            'netProfit', 'recentProjects', 'recentPayments', 'recentActivities', 'budgetAlerts'
        ));
    }
}

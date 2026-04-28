<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $projectExpenses = \App\Models\Expense::with(['project', 'stage', 'user'])->latest()->get();
        $companyExpenses = \App\Models\CompanyExpense::with('user')->latest()->get();
        return view('admin.expenses.index', compact('projectExpenses', 'companyExpenses'));
    }

    public function create()
    {
        $projects = \App\Models\Project::with('stages')->get();
        $selectedProjectId = request('project_id');
        $selectedStageId = request('stage_id');
        return view('admin.expenses.create', compact('projects', 'selectedProjectId', 'selectedStageId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'stage_id' => 'required|exists:project_stages,id',
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $stage = \App\Models\ProjectStage::find($request->stage_id);
        if ($stage->status === 'Completed' && !auth()->user()->isAdmin()) {
            return back()->withErrors(['stage_id' => 'This stage is locked. Expenses cannot be added.'])->withInput();
        }

        $expense = \App\Models\Expense::create(array_merge($validated, [
            'user_id' => auth()->id(),
            'status' => auth()->user()->isAdmin() ? 'Approved' : 'Unverified'
        ]));

        \App\Models\ActivityLog::log('Logged Expense', $expense, "Logged expense of BHD {$expense->amount} for {$expense->category}");

        return redirect()->route('admin.expenses.index')->with('success', 'Expense logged successfully.');
    }

    public function approve(\App\Models\Expense $expense)
    {
        $expense->update(['status' => 'Approved']);
        \App\Models\ActivityLog::log('Approved Expense', $expense, "Admin approved expense ID: {$expense->id}");
        return back()->with('success', 'Expense approved.');
    }

    public function reject(\App\Models\Expense $expense)
    {
        $expense->update(['status' => 'Rejected']);
        \App\Models\ActivityLog::log('Rejected Expense', $expense, "Admin rejected expense ID: {$expense->id}");
        return back()->with('warning', 'Expense rejected.');
    }
}

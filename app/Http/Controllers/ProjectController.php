<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $projects = \App\Models\Project::with(['client', 'stages.expenses', 'supervisors'])->latest()->get();
        $selected_project_id = $request->query('project_id');
        return view('admin.projects.index', compact('projects', 'selected_project_id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:Interior Design,Civil Construction,Maintenance',
            'client_selection_type' => 'required|in:existing,new',
            'client_id' => 'required_if:client_selection_type,existing|nullable|exists:users,id',
            'client_name' => 'required_if:client_selection_type,new|nullable|string|max:255',
            'client_email' => 'required_if:client_selection_type,new|nullable|email|max:255',
            'client_phone' => 'nullable|string|max:255',
            'create_account' => 'nullable|boolean',
            'site_address' => 'required|string',
            'estimated_internal_cost' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'stages' => 'required|array|min:1',
            'stages.*.name' => 'required|string|max:255',
            'stages.*.budget' => 'required|numeric|min:0',
            'stages.*.client_payment_amount' => 'required|numeric|min:0',
            'stages.*.weight_percentage' => 'required|numeric|min:0|max:100',
            'stages.*.start_date' => 'required|date',
            'stages.*.end_date' => 'required|date|after_or_equal:stages.*.start_date',
            'documents.*' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:5120',
            'supervisor_ids' => 'nullable|array',
            'supervisor_ids.*' => 'exists:users,id',
        ]);

        \DB::beginTransaction();
        try {
            $clientId = $request->client_id;

            if ($request->client_selection_type === 'new') {
                // If creating account is toggled, create a user
                if ($request->create_account) {
                    $user = \App\Models\User::create([
                        'name' => $request->client_name,
                        'email' => $request->client_email,
                        'phone' => $request->client_phone,
                        'password' => \Illuminate\Support\Facades\Hash::make($request->client_email),
                        'role' => 'client',
                    ]);
                    $clientId = $user->id;
                } else {
                    // For now, if no account is created, we still need a user reference 
                    // (The system requires client_id in projects table).
                    // We could create a guest client or a system-managed client record.
                    // Let's create the user as a non-active or shadow client if account not created.
                    $user = \App\Models\User::create([
                        'name' => $request->client_name,
                        'email' => $request->client_email,
                        'phone' => $request->client_phone,
                        'password' => \Illuminate\Support\Str::random(16),
                        'role' => 'client',
                        'is_active' => false,
                    ]);
                    $clientId = $user->id;
                }
            }

            // Calculate Project Value from stages sum
            $totalProjectValue = collect($request->stages)->sum('client_payment_amount');

            $project = \App\Models\Project::create(array_merge($validated, [
                'client_id' => $clientId,
                'project_value' => $totalProjectValue
            ]));

            // Handle Stages
            foreach ($request->stages as $index => $stageData) {
                $status = ($index === 0) ? 'In Progress' : 'Not Started';
                $project->stages()->create(array_merge($stageData, ['status' => $status]));
            }

            // Handle Documents
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    $path = $file->store('project_documents', 'public');
                    $project->documents()->create([
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                    ]);
                }
            }

            // Sync Supervisors
            if ($request->has('supervisor_ids')) {
                $project->supervisors()->sync($request->supervisor_ids);
            }

            \DB::commit();
            return redirect()->route('admin.projects.index')->with('success', 'Project and Client created successfully.');
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->withErrors(['error' => 'Failed: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\Project $project)
    {
        $project->load(['client', 'stages.expenses.user', 'payments', 'workLogs.photos', 'workLogs.user']);
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function storeStage(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
            'level' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'estimated_duration' => 'nullable|integer',
            'internal_budget' => 'required|numeric|min:0',
            'planned_start' => 'required|date',
            'planned_end' => 'required|date|after_or_equal:planned_start',
            'client_payment_linked' => 'required|numeric|min:0',
        ]);

        $project = \App\Models\Project::findOrFail($request->project_id);
        
        // Calculate weight percentage? For now just set to 0 or calculate based on budget relative to project value
        $weight = 0;
        if ($project->project_value > 0) {
            $weight = ($request->client_payment_linked / $project->project_value) * 100;
        }

        $project->stages()->create([
            'name' => $request->name,
            'level' => $request->level,
            'description' => $request->description,
            'estimated_duration' => $request->estimated_duration,
            'budget' => $request->internal_budget,
            'start_date' => $request->planned_start,
            'end_date' => $request->planned_end,
            'client_payment_amount' => $request->client_payment_linked,
            'weight_percentage' => $weight,
            'status' => 'Not Started',
        ]);

        return redirect()->route('admin.projects.show', $project->id)->with('success', 'Stage added successfully.');
    }

    public function destroy(\App\Models\Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }

    public function updateStageStatus(Request $request, \App\Models\ProjectStage $stage)
    {
        $request->validate(['status' => 'required|in:Not Started,In Progress,Completed']);
        
        $oldStatus = $stage->status;
        $stage->update(['status' => $request->status]);

        $action = $request->status === 'Completed' ? 'Locked Stage' : 'Updated Stage Status';
        \App\Models\ActivityLog::log($action, $stage->project, "Admin changed stage '{$stage->name}' from {$oldStatus} to {$request->status}");

        return back()->with('success', "Stage status updated to {$request->status}.");
    }
}

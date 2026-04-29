@extends('layouts.admin')

@section('title', 'Log New Expense')

@section('content')
<div class="pl-wrap">
    <div class="pl-header" style="margin-bottom: 2.5rem;">
        <div>
            <h1 class="pl-title">Log New Expense</h1>
            <p class="pl-subtitle">Secure financial entry for project operations</p>
        </div>
        <a href="{{ route('admin.expenses.index') }}" class="btn-new-project" style="background: rgba(255,255,255,0.05) !important; border-color: rgba(255,255,255,0.1) !important;">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="pl-shell" style="max-width: 900px; margin: 0 auto; padding: 2.5rem !important;">
        <form action="{{ route('admin.expenses.store') }}" method="POST">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                <div class="form-group">
                    <label style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; display: block;">Target Project</label>
                    <select name="project_id" id="project_id" class="form-control" required 
                        style="width: 100%; padding: 1rem; background: rgba(5,5,15,0.6); border: 1px solid rgba(234, 88, 12, 0.15); border-radius: 12px; color: #fff; font-weight: 500;">
                        <option value="">-- Select Project --</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ $selectedProjectId == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; display: block;">Operational Stage</label>
                    <select name="stage_id" id="stage_id" class="form-control" required 
                        style="width: 100%; padding: 1rem; background: rgba(5,5,15,0.6); border: 1px solid rgba(234, 88, 12, 0.15); border-radius: 12px; color: #fff; font-weight: 500;">
                        <option value="">-- Select Stage --</option>
                        @if($selectedProjectId)
                            @foreach($projects->find($selectedProjectId)->stages as $stage)
                                <option value="{{ $stage->id }}" {{ $selectedStageId == $stage->id ? 'selected' : '' }}>{{ $stage->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                <div class="form-group">
                    <label style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; display: block;">Expense Category</label>
                    <select name="category" class="form-control" required 
                        style="width: 100%; padding: 1rem; background: rgba(5,5,15,0.6); border: 1px solid rgba(234, 88, 12, 0.15); border-radius: 12px; color: #fff; font-weight: 500;">
                        <option>Materials</option>
                        <option>Labour</option>
                        <option>Transportation</option>
                        <option>Equipment Rental</option>
                        <option>Miscellaneous</option>
                    </select>
                </div>
                <div class="form-group">
                    <label style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; display: block;">Amount (BHD)</label>
                    <input type="number" step="0.001" name="amount" class="form-control" required 
                        placeholder="0.000"
                        style="width: 100%; padding: 1rem; background: rgba(5,5,15,0.6); border: 1px solid rgba(234, 88, 12, 0.15); border-radius: 12px; color: #fff; font-weight: 600; font-size: 1.1rem;">
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; display: block;">Transaction Date</label>
                <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required 
                    style="width: 100%; padding: 1rem; background: rgba(5,5,15,0.6); border: 1px solid rgba(234, 88, 12, 0.15); border-radius: 12px; color: #fff;">
            </div>

            <div style="margin-bottom: 2.5rem;">
                <label style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; display: block;">Detailed Description</label>
                <textarea name="description" rows="4" class="form-control" placeholder="Describe the purpose of this expense..."
                    style="width: 100%; padding: 1rem; background: rgba(5,5,15,0.6); border: 1px solid rgba(234, 88, 12, 0.15); border-radius: 12px; color: #fff;"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 15px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 2rem;">
                <button type="submit" class="btn-new-project" style="padding: 1rem 2.5rem !important;">
                    <i class="fas fa-paper-plane"></i> Submit Operation
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const projectSelect = document.getElementById('project_id');
    const stageSelect = document.getElementById('stage_id');
    const projects = @json($projects);

    projectSelect.addEventListener('change', function() {
        const projectId = this.value;
        stageSelect.innerHTML = '<option value="">-- Select Stage --</option>';
        
        if (projectId) {
            const project = projects.find(p => p.id == projectId);
            if (project && project.stages) {
                project.stages.forEach(stage => {
                    const option = document.createElement('option');
                    option.value = stage.id;
                    option.textContent = stage.name;
                    stageSelect.appendChild(option);
                });
            }
        }
    });
</script>
@endsection

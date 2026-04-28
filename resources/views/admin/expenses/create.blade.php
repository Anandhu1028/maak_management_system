@extends('layouts.admin')

@section('title', 'Log New Expense')

@section('content')
<div class="card-premium" style="max-width: 800px; margin: 0 auto;">
    <h2 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 2rem;">Expense Entry</h2>

    <form action="{{ route('admin.expenses.store') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Project</label>
                <select name="project_id" id="project_id" class="form-control" required style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
                    <option value="">-- Select Project --</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ $selectedProjectId == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Stage</label>
                <select name="stage_id" id="stage_id" class="form-control" required style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
                    <option value="">-- Select Stage --</option>
                    @if($selectedProjectId)
                        @foreach($projects->find($selectedProjectId)->stages as $stage)
                            <option value="{{ $stage->id }}" {{ $selectedStageId == $stage->id ? 'selected' : '' }}>{{ $stage->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Category</label>
                <select name="category" class="form-control" required style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
                    <option>Materials</option>
                    <option>Labour</option>
                    <option>Transportation</option>
                    <option>Equipment Rental</option>
                    <option>Miscellaneous</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Amount (BHD)</label>
                <input type="number" step="0.001" name="amount" class="form-control" required style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
            </div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Date</label>
            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
        </div>

        <div style="margin-bottom: 2rem;">
            <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Description / Remarks</label>
            <textarea name="description" rows="3" class="form-control" style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);"></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px;">
            <a href="{{ route('admin.expenses.index') }}" class="btn-premium" style="background: #f1f5f9; color: #475569;">Cancel</a>
            <button type="submit" class="btn-premium">Submit Expense</button>
        </div>
    </form>
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

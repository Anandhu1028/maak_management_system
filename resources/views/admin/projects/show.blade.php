@extends('layouts.admin')

@section('title', 'Project Details: ' . $project->name)

@push('styles')
<style>
    /* ── Entrance Animation ── */
    .animated-entrance {
        animation: portalZoomIn 0.7s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        transform-origin: center top;
        opacity: 0;
    }
    @keyframes portalZoomIn {
        from { opacity: 0; transform: scale(0.96) translateY(10px); filter: blur(5px); }
        to { opacity: 1; transform: scale(1) translateY(0); filter: blur(0); }
    }

    /* ── Show Banner ── */
    .show-banner {
        background: linear-gradient(135deg, #0c3cea1a 0%, #0c32c23b 100%);
        border-radius: 30px;
        padding: 3rem;
        margin-bottom: 2.5rem;
        color: #fff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
    }
    .show-banner::after {
        content: "";
        position: absolute;
        right: -5%; top: -20%;
        width: 300px; height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        filter: blur(60px);
    }
    .banner-content { position: relative; z-index: 2; }
    .banner-status {
        display: inline-flex;
        padding: 6px 16px;
        background: rgba(255,255,255,0.15);
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        backdrop-filter: blur(10px);
        margin-bottom: 1rem;
    }
    .banner-title { font-size: 2.5rem; font-weight: 900; letter-spacing: -1.5px; margin: 0; }
    .banner-client { font-size: 1.1rem; opacity: 0.8; font-weight: 500; margin-top: 5px; }

    /* ── KPI Grid ── */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }
    .kpi-card {
        background: #fff;
        padding: 1.5rem;
        border-radius: 24px;
        border: 1px solid rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 1.2rem;
        transition: all 0.3s ease;
    }
    .kpi-card:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(0,0,0,0.08); }
    .kpi-icon {
        width: 54px; height: 54px;
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .kpi-label { font-size: 0.7rem; color: #94a3b8; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
    .kpi-value { font-size: 1.3rem; font-weight: 900; color: #0f172a; margin-top: 2px; }

    [data-theme="dark"] .kpi-card { background: rgba(20,20,25,0.6); border-color: rgba(255,255,255,0.06); }
    [data-theme="dark"] .kpi-value { color: #fff; }

    /* ── Stage System ── */
    .stage-item {
        background: #fff;
        border-radius: 22px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
    }
    .stage-item:hover { border-color: var(--primary); }
    [data-theme="dark"] .stage-item { background: rgba(20,20,25,0.4); border-color: rgba(255,255,255,0.05); }

    /* ── Tab System — Premium Pill ── */
    .tab-bar {
        display: flex;
        gap: 10px;
        background: #f1f5f9;
        padding: 6px;
        border-radius: 100px;
        width: fit-content;
        margin-bottom: 2.5rem;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .tab-btn {
        padding: 10px 24px;
        border-radius: 100px;
        font-size: 0.85rem;
        font-weight: 700;
        color: #64748b;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        background: transparent;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .tab-btn.active {
        background: var(--primary);
        color: #fff;
        box-shadow: 0 4px 15px rgba(234, 88, 12, 0.25);
    }
    .tab-btn i { font-size: 0.9rem; }
    
    .tab-content { display: none; }
    .tab-content.active { display: block; animation: tabFadeIn 0.4s ease; }
    @keyframes tabFadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    [data-theme="dark"] .tab-bar { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.08); }
    [data-theme="dark"] .tab-btn { color: #94a3b8; }
    [data-theme="dark"] .tab-btn.active { background: var(--primary); color: #fff; }

    /* ── Tactical Dropdown ── */
    .tactical-menu { position: relative; }
    .tactical-trigger {
        width: 34px; height: 34px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .tactical-trigger:hover { background: #e2e8f0; color: #0f172a; }
    .tactical-dropdown {
        position: absolute;
        top: 100%; right: 0;
        width: 180px;
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        border: 1px solid #f1f5f9;
        padding: 8px;
        margin-top: 8px;
        display: none;
        z-index: 100;
        animation: dropSlide 0.2s ease;
    }
    .tactical-dropdown.active { display: block; }
    @keyframes dropSlide {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .drop-item {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 14px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #475569;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none; background: transparent; width: 100%; text-align: left;
    }
    .drop-item:hover { background: #f8fafc; color: var(--primary); }
    .drop-item.danger { color: #ef4444; }
    .drop-item.danger:hover { background: #fef2f2; }

    [data-theme="dark"] .tactical-trigger { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.08); color: #94a3b8; }
    [data-theme="dark"] .tactical-dropdown { background: #0f1225; border-color: rgba(255,255,255,0.08); box-shadow: 0 15px 40px rgba(0,0,0,0.5); }
    [data-theme="dark"] .drop-item { color: #94a3b8; }
    [data-theme="dark"] .drop-item:hover { background: rgba(255,255,255,0.03); color: #fff; }

    /* Print styles */
    @media print {
        .btn-premium, .quick-actions, .portal-transition, .top-bar, .sidebar { display: none !important; }
        .card-premium, .show-banner, .stage-item { border: 1px solid #eee !important; box-shadow: none !important; color: #000 !important; }
    }
</style>
@endpush

@section('content')
<div class="animated-entrance" x-data="{ 
    showStrategyModal: false, 
    strategyStageId: '', 
    strategyTaskName: '',
    strategyTaskWeight: '',
    plannedTasks: [],
    async fetchPlannedTasks() {
        if(!this.strategyStageId) { this.plannedTasks = []; return; }
        const res = await fetch(`/admin/projects/{{ $project->id }}/stages/${this.strategyStageId}/tasks`, {
            headers: { 'Accept': 'application/json' }
        });
        const data = await res.json();
        this.plannedTasks = data.tasks || [];
    },
    async deployObjective() {
        if(!this.strategyStageId || !this.strategyTaskName || !this.strategyTaskWeight) return;
        const res = await fetch(`/admin/stages/${this.strategyStageId}/tasks`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json' },
            body: JSON.stringify({ name: this.strategyTaskName, weight: this.strategyTaskWeight })
        });
        const data = await res.json();
        if(data.success) {
            this.strategyTaskName = '';
            this.strategyTaskWeight = '';
            await this.fetchPlannedTasks();
            // Optional: window.location.reload(); if you want to update the main page too
        } else {
            alert(data.error || 'Validation failed');
        }
    }
}">
    {{-- Banner Header --}}
    <div class="show-banner">
        <div class="banner-content">
            <div class="banner-status">Project Mission: {{ $project->status }}</div>
            <h1 class="banner-title">{{ $project->name }}</h1>
            <div class="banner-client">Strategic Partner: {{ $project->client->name }}</div>
            
            <div style="margin-top: 2rem; display: flex; gap: 12px;">
                <a href="{{ route('admin.projects.edit', $project) }}" class="btn-premium" style="background: rgba(255,255,255,0.2); color: #fff; border: 1px solid rgba(255,255,255,0.3);">
                    <i class="fas fa-edit"></i> Edit Mission
                </a>
                <button class="btn-premium" onclick="window.print()" style="background: #fff; color: var(--primary);">
                    <i class="fas fa-file-pdf"></i> Export Dossier
                </button>
            </div>
        </div>
    </div>

    {{-- KPI Cluster --}}
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon" style="background: rgba(37, 99, 235, 0.1); color: #2563eb;">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Contract Value</div>
                <div class="kpi-value">BHD {{ number_format($project->project_value, 3) }}</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon" style="background: rgba(22, 163, 74, 0.1); color: #16a34a;">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Total Invoiced</div>
                <div class="kpi-value">BHD {{ number_format($project->payments->sum('amount'), 3) }}</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon" style="background: rgba(234, 88, 12, 0.1); color: #ea580c;">
                <i class="fas fa-receipt"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Active Expenses</div>
                @php $approvedExpenses = $project->expenses->where('status', 'Approved')->sum('amount'); @endphp
                <div class="kpi-value">BHD {{ number_format($approvedExpenses, 3) }}</div>
            </div>
        </div>
        <div class="kpi-card">
            @php $profit = $project->payments->sum('amount') - $approvedExpenses; @endphp
            <div class="kpi-icon" style="background: {{ $profit >= 0 ? 'rgba(22, 163, 74, 0.1)' : 'rgba(239, 68, 68, 0.1)' }}; color: {{ $profit >= 0 ? '#16a34a' : '#ef4444' }};">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Project P/L</div>
                <div class="kpi-value">BHD {{ number_format($profit, 3) }}</div>
            </div>
        </div>
    </div>

    {{-- Tab Navigation --}}
    <div class="tab-bar">
        <button class="tab-btn active" onclick="switchTab('stages')">
            <i class="fas fa-layer-group"></i> Stage Workflow
        </button>
        <button class="tab-btn" onclick="switchTab('client')">
            <i class="fas fa-user-tie"></i> Client Intelligence
        </button>
        <button class="tab-btn" onclick="switchTab('activity')">
            <i class="fas fa-history"></i> Mission Logs & Media
        </button>
    </div>

    {{-- Tab: Stages --}}
    <div id="tab-stages" class="tab-content active" x-data="{ activeTask: null, activeStageName: '' }">
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 0 0.5rem; margin-bottom: 2rem;">
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 900; letter-spacing: -0.5px; margin: 0; color: #0f172a;">Operational Phases</h2>
                <p style="font-size: 0.8rem; color: #64748b; margin-top: 5px; font-weight: 600;">{{ $project->stages->count() }} strategic milestones active.</p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2.5fr 1fr; gap: 3rem; align-items: start;">
            {{-- LEFT COLUMN: Operations --}}
            <div style="display: flex; flex-direction: column; gap: 2rem;">
                
                @foreach($project->stages as $stage)
                @php 
                    $stageCost = $stage->expenses->where('status', 'Approved')->sum('amount');
                    $clientPaid = (float)$stage->client_payment_amount;
                    $balance = $clientPaid - $stageCost;
                    $costPercentage = $clientPaid > 0 ? ($stageCost / $clientPaid) * 100 : 0;
                @endphp
                <div class="stage-item">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
                        <div>
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                                <span style="font-size: 0.7rem; font-weight: 800; color: var(--primary); text-transform: uppercase; background: rgba(234, 88, 12, 0.1); padding: 4px 10px; border-radius: 6px;">Phase {{ $loop->iteration }}</span>
                                <span style="padding: 4px 10px; border-radius: 6px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
                                    @if($stage->status == 'In Progress') background: #e0f2fe; color: #0369a1;
                                    @elseif($stage->status == 'Completed') background: #dcfce7; color: #15803d;
                                    @else background: #f1f5f9; color: #475569; @endif">
                                    {{ $stage->status }}
                                </span>
                            </div>
                            <h3 style="font-size: 1.25rem; font-weight: 800; margin: 0; color: #0f172a;">{{ $stage->name }}</h3>
                            <div style="font-size: 0.85rem; color: #94a3b8; margin-top: 4px; font-weight: 500;">
                                <i class="far fa-calendar-alt"></i> {{ $stage->start_date->format('d M') }} — {{ $stage->end_date->format('d M Y') }}
                            </div>
                        </div>
                        <div class="tactical-menu">
                            <button class="tactical-trigger" onclick="toggleTacticalMenu(this)">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="tactical-dropdown">
                                <a href="#" class="drop-item">
                                    <i class="fas fa-edit"></i> Edit Phase
                                </a>
                                <button type="button" class="drop-item" onclick="toggleExpenses('expenses-{{ $stage->id }}')">
                                    <i class="fas fa-receipt"></i> View Expenses
                                </button>
                                <div style="height: 1px; background: #f1f5f9; margin: 4px 0;"></div>
                                @if($stage->status !== 'Completed')
                                <form action="#" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="drop-item danger">
                                        <i class="fas fa-lock"></i> Finalize Phase
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div x-data="{ 
                        tasks: [
                            @foreach($stage->tasks as $task)
                            { 
                                id: {{ $task->id }}, 
                                name: '{{ $task->name }}', 
                                weight: {{ $task->weight }}, 
                                progress: {{ $task->progress }}, 
                                status: '{{ $task->status }}',
                                logs: [
                                    @foreach($task->logs as $log)
                                    { id: {{ $log->id }}, date: '{{ $log->date->format('d M Y') }}', increment: {{ $log->work_done_percent }}, notes: '{{ $log->notes }}' },
                                    @endforeach
                                ],
                                new_increment: '',
                                new_notes: ''
                            },
                            @endforeach
                        ],
                        get stageProgress() {
                            let total = 0;
                            this.tasks.forEach(t => {
                                total += (t.weight * t.progress) / 100;
                            });
                            return total.toFixed(1);
                        },
                        get cumulativeWeight() {
                            return this.tasks.reduce((sum, t) => sum + parseFloat(t.weight), 0).toFixed(2);
                        },
                        async addTask(e) {
                            const formData = new FormData(e.target);
                            const res = await fetch(`{{ route('admin.stage-tasks.store', $stage) }}`, {
                                method: 'POST',
                                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                                body: formData
                            });
                            
                            if (!res.ok) {
                                let errorData = { error: 'Mission Deployment Failed' };
                                try { errorData = await res.json(); } catch(e) {}
                                alert(errorData.error || errorData.message || 'Strategy Validation Error');
                                return;
                            }

                            const data = await res.json();
                            if(data.success) {
                                this.tasks.push({ ...data.task, logs: [], new_increment: '', new_notes: '' });
                                e.target.reset();
                            } else {
                                alert(data.error || 'Validation failed');
                            }
                        },
                        async submitDailyLog(task, index) {
                            if(!task.new_increment || task.new_increment <= 0) return;

                            const res = await fetch(`/admin/stage-tasks/${task.id}/logs`, {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                                body: JSON.stringify({
                                    work_done_percent: task.new_increment,
                                    date: new Date().toISOString().split('T')[0],
                                    notes: task.new_notes
                                })
                            });

                            if (!res.ok) {
                                let errorData = { error: 'Log Deployment Failed' };
                                try { errorData = await res.json(); } catch(e) {}
                                alert(errorData.error || errorData.message || 'Field Data Error');
                                return;
                            }

                            const data = await res.json();
                            if(data.success) {
                                task.progress = data.task_progress;
                                task.status = task.progress >= 100 ? 'Completed' : 'In Progress';
                                task.logs.unshift(data.log);
                                task.new_increment = '';
                                task.new_notes = '';
                            } else {
                                alert(data.error);
                            }
                        },
                        async removeTask(taskId, index) {
                            if(!confirm('Abort task?')) return;
                            const res = await fetch(`/admin/stage-tasks/${taskId}`, {
                                method: 'DELETE',
                                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                            });
                            if(res.ok) this.tasks.splice(index, 1);
                        }
                    }">
                        <div style="display: flex; flex-direction: column; gap: 2rem; margin-bottom: 2rem;">
                            {{-- Financial & Physical Summary Row --}}
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; background: #f8fafc; padding: 1.5rem; border-radius: 20px; border: 1px solid #f1f5f9;">
                                {{-- Financial Bar --}}
                                <div>
                                    <div style="display: flex; justify-content: space-between; font-size: 0.75rem; margin-bottom: 10px; font-weight: 800; text-transform: uppercase; color: #64748b;">
                                        <span>Financial Burn</span>
                                        <span style="color: {{ $costPercentage >= 100 ? '#ef4444' : ($costPercentage >= 80 ? '#f59e0b' : '#0f172a') }}">
                                            {{ number_format($costPercentage, 1) }}%
                                        </span>
                                    </div>
                                    <div style="width: 100%; height: 8px; background: #fff; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;">
                                        <div style="width: {{ min($costPercentage, 100) }}%; height: 100%; background: {{ $costPercentage >= 100 ? '#ef4444' : ($costPercentage >= 80 ? '#f59e0b' : 'var(--primary)') }};"></div>
                                    </div>
                                </div>
                                
                                {{-- Physical Velocity Bar --}}
                                <div>
                                    <div style="display: flex; justify-content: space-between; font-size: 0.75rem; margin-bottom: 10px; font-weight: 800; text-transform: uppercase; color: #64748b;">
                                        <span>Mission Progress</span>
                                        <span style="color: #0f172a;" x-text="stageProgress + '%'"></span>
                                    </div>
                                    <div style="width: 100%; height: 8px; background: #fff; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;">
                                        <div :style="'width: ' + stageProgress + '%; background: ' + (stageProgress < 100 ? 'var(--primary)' : '#10b981')" 
                                            style="height: 100%; transition: width 0.5s ease;"></div>
                                    </div>
                                </div>
                            </div>

                            {{-- Mission Objectives (Tasks) --}}
                            <div style="display: flex; flex-direction: column; gap: 1rem;">
                                <template x-for="(task, index) in tasks" :key="task.id">
                                    <div class="task-card-premium" style="background: #fff; border-radius: 20px; border: 1px solid #f1f5f9; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);">
                                        <div style="padding: 1.5rem; background: rgba(248, 250, 252, 0.5); border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                                            <div>
                                                <div style="font-weight: 900; font-size: 1.1rem; color: #0f172a;" x-text="task.name"></div>
                                                <div style="font-size: 0.7rem; color: #94a3b8; font-weight: 800; text-transform: uppercase; margin-top: 4px; letter-spacing: 0.5px;">
                                                    Weighted Impact: <span x-text="task.weight" style="color: #0f172a;"></span>%
                                                </div>
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 12px;">
                                                <span style="font-size: 0.65rem; font-weight: 900; text-transform: uppercase; padding: 6px 14px; border-radius: 50px;"
                                                    :style="task.status == 'Completed' ? 'background: #dcfce7; color: #15803d;' : (task.status == 'In Progress' ? 'background: #e0f2fe; color: #0369a1;' : 'background: #f1f5f9; color: #475569;')"
                                                    x-text="task.status">
                                                </span>
                                                <button type="button" @click="removeTask(task.id, index)" style="width: 32px; height: 32px; border-radius: 50%; border: none; background: #fee2e2; color: #ef4444; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                                                    <i class="fas fa-trash-alt" style="font-size: 0.75rem;"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                                </div>
                                                
                                                <div style="width: 100%; height: 8px; background: #f1f5f9; border-radius: 10px; overflow: hidden; margin-bottom: 1.5rem;">
                                                    <div :style="'width: ' + task.progress + '%; background: ' + (task.progress < 100 ? 'var(--primary)' : '#10b981')" 
                                                        style="height: 100%; transition: width 0.5s ease;"></div>
                                                </div>

                                                <div style="max-height: 120px; overflow-y: auto; display: flex; flex-direction: column; gap: 8px; padding-right: 5px;">
                                                    <template x-for="log in task.logs" :key="log.id">
                                                        <div style="background: #f8fafc; padding: 10px; border-radius: 10px; display: flex; justify-content: space-between; border: 1px solid #f1f5f9;">
                                                            <div>
                                                                <div style="font-size: 0.7rem; font-weight: 800; color: #0f172a;" x-text="log.date"></div>
                                                                <div style="font-size: 0.7rem; color: #64748b; margin-top: 2px;" x-text="log.notes || 'No field notes recorded.'"></div>
                                                            </div>
                                                            <div style="font-weight: 900; font-size: 0.8rem; color: #10b981;">+<span x-text="log.increment"></span>%</div>
                                                        </div>
                                                    </template>
                                                    <div x-show="task.logs.length == 0" style="text-align: center; color: #94a3b8; font-size: 0.75rem; padding: 20px 0;">
                                                        No operational logs recorded yet.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                {{-- Admin Setup: Removed and moved to Global Modal --}}
                            </div>
                        </div>{{-- /flex column wrapper --}}
                    </div>{{-- /x-data --}}

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div>
                            <div style="font-size: 0.65rem; color: #94a3b8; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px; margin-bottom: 4px;">Target Budget</div>
                            <div style="font-weight: 800; color: #e2e2e2ff; font-size: 1rem;">BHD {{ number_format($clientPaid, 3) }}</div>
                        </div>
                        <div>
                            <div style="font-size: 0.65rem; color: #94a3b8; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px; margin-bottom: 4px;">Actual Spend</div>
                            <div style="font-weight: 800; color: {{ $stageCost > $clientPaid ? '#ef4444' : '#dbdbdbff' }}; font-size: 1rem;">BHD {{ number_format($stageCost, 3) }}</div>
                        </div>
                        <div>
                            <div style="font-size: 0.65rem; color: #94a3b8; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px; margin-bottom: 4px;">Balance</div>
                            <div style="font-weight: 900; color: {{ $balance >= 0 ? '#10b981' : '#ef4444' }}; font-size: 1rem;">BHD {{ number_format($balance, 3) }}</div>
                        </div>
                    </div>

                    {{-- Review Action --}}
                    <div style="border-top: 1px solid rgba(255,255,255,0.05); padding-top: 1rem;">
                        <button onclick="toggleExpenses('expenses-{{ $stage->id }}')" style="background: rgba(99, 148, 255, 0.1); color: #6394ff; border: 1px solid rgba(99, 148, 255, 0.2); padding: 8px 16px; border-radius: 10px; font-size: 0.75rem; font-weight: 800; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-receipt"></i> View Stage Expense
                        </button>
                    </div>

                    {{-- Expanded Expense Dossier --}}
                    <div id="expenses-{{ $stage->id }}" style="display: none; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px dashed rgba(255,255,255,0.1);">
                        <div style="font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 1rem;">Financial Audit Log</div>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse; font-size: 0.8rem;">
                                <thead>
                                    <tr style="text-align: left; border-bottom: 1px solid rgba(255,255,255,0.05);">
                                        <th style="padding: 10px; color: #64748b;">Date</th>
                                        <th style="padding: 10px; color: #64748b;">Description</th>
                                        <th style="padding: 10px; color: #64748b;">Status</th>
                                        <th style="padding: 10px; color: #64748b; text-align: right;">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($stage->expenses as $expense)
                                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.02);">
                                        <td style="padding: 10px; font-weight: 600; white-space: nowrap;">{{ $expense->date->format('d M Y') }}</td>
                                        <td style="padding: 10px; color: #e2e8f0;">{{ $expense->description }}</td>
                                        <td style="padding: 10px;">
                                            <span style="font-size: 0.65rem; font-weight: 800; text-transform: uppercase; padding: 2px 8px; border-radius: 4px;
                                                @if($expense->status == 'Approved') background: rgba(16, 185, 129, 0.1); color: #10b981;
                                                @else background: rgba(245, 158, 11, 0.1); color: #f59e0b; @endif">
                                                {{ $expense->status }}
                                            </span>
                                        </td>
                                        <td style="padding: 10px; text-align: right; font-weight: 800; color: #fff;">BHD {{ number_format($expense->amount, 3) }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" style="padding: 20px; text-align: center; color: #64748b;">No expense logs found for this phase.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                @if($stage->expenses->count() > 0)
                                <tfoot>
                                    <tr style="background: rgba(255,255,255,0.02); border-top: 1px solid rgba(255,255,255,0.1);">
                                        <td colspan="3" style="padding: 12px 10px; text-align: right; font-weight: 800; color: #94a3b8; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 1px;">Total Expense</td>
                                        <td style="padding: 12px 10px; text-align: right; font-weight: 900; color: var(--primary); font-size: 0.9rem;">BHD {{ number_format($stage->expenses->sum('amount'), 3) }}</td>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>{{-- /stage-item --}}
                @endforeach
            </div>{{-- /LEFT COLUMN --}}

            {{-- RIGHT COLUMN: Tactical & Intelligence Sidebar --}}
            <div style="display: flex; flex-direction: column; gap: 1.5rem; position: sticky; top: 1.5rem;">
                {{-- Card 1: Tactical Command --}}
                <div class="card-premium" style="background: #0f172a; color: #fff; border: none;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1.5rem;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(99, 148, 255, 0.1); display: flex; align-items: center; justify-content: center; color: #6394ff;">
                            <i class="fas fa-crosshairs" style="font-size: 0.8rem;"></i>
                        </div>
                        <h2 style="font-size: 0.9rem; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; color: #fff; margin: 0;">Tactical Command</h2>
                    </div>
                    
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <button @click="showStrategyModal = true" class="btn-premium" style="width: 100%; background: #ea580c; color: #fff; border: none; justify-content: flex-start; padding: 12px 16px; border-radius: 14px; box-shadow: 0 4px 12px rgba(234, 88, 12, 0.3);">
                            <i class="fas fa-rocket" style="color: #fff; margin-right: 10px;"></i> Plan New Objective
                        </button>
                        <button @click="showStrategyModal = true" class="btn-premium" style="width: 100%; background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.08); justify-content: flex-start; padding: 12px 16px; border-radius: 14px;">
                            <i class="fas fa-rocket" style="color: #fff; margin-right: 10px;"></i> Plan New Objective
                        </button>
                        <button class="btn-premium" style="width: 100%; background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.08); justify-content: flex-start; padding: 12px 16px; border-radius: 14px;">
                            <i class="fas fa-plus-circle" style="color: #6394ff; margin-right: 10px;"></i> Add Payment
                        </button>
                        <button class="btn-premium" style="width: 100%; background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.08); justify-content: flex-start; padding: 12px 16px; border-radius: 14px;">
                            <i class="fas fa-receipt" style="color: #10b981; margin-right: 10px;"></i> Log Admin Expense
                        </button>
                    </div>
                </div>

                {{-- Card 2: Strategic Dossier / Tactical Ledger --}}
                <div class="card-premium" style="background: #fff; border: 1px solid #f1f5f9; position: relative; overflow: hidden;">
                    <template x-if="!activeTask">
                        <div>
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1.5rem;">
                                <div style="width: 32px; height: 32px; border-radius: 8px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #64748b;">
                                    <i class="fas fa-folder-open" style="font-size: 0.8rem;"></i>
                                </div>
                                <h2 style="font-size: 0.9rem; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; color: #0f172a; margin: 0;">Mission Dossier</h2>
                            </div>

                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                @forelse($project->documents->take(3) as $doc)
                                <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; background: #f8fafc; border: 1px solid #f1f5f9; border-radius: 14px; transition: all 0.2s hover:border-primary">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <i class="fas fa-file-pdf" style="color: #ef4444;"></i>
                                        <span style="font-size: 0.75rem; font-weight: 800; color: #334155;">{{ Str::limit($doc->file_name, 18) }}</span>
                                    </div>
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" style="color: #94a3b8; transition: color 0.2s hover:color-primary">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                                @empty
                                <div style="text-align: center; padding: 1rem; background: #f8fafc; border-radius: 14px; border: 1px dashed #e2e8f0;">
                                    <p style="font-size: 0.75rem; color: #94a3b8; font-weight: 700; margin: 0;">No active documents.</p>
                                </div>
                                @endforelse

                                <a href="#" style="display: block; text-align: center; margin-top: 10px; font-size: 0.75rem; font-weight: 900; color: var(--primary); text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px;">
                                    View Full Archive <i class="fas fa-arrow-right" style="margin-left: 5px;"></i>
                                </a>
                            </div>
                        </div>
                    </template>

                    <template x-if="activeTask">
                        <div style="animation: slideInRight 0.3s ease-out;">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: var(--primary); display: flex; align-items: center; justify-content: center; color: #fff;">
                                        <i class="fas fa-scroll" style="font-size: 0.8rem;"></i>
                                    </div>
                                    <div>
                                        <h2 style="font-size: 0.85rem; font-weight: 900; color: #0f172a; margin: 0; line-height: 1;" x-text="activeTask.name"></h2>
                                        <span style="font-size: 0.6rem; font-weight: 800; color: #94a3b8; text-transform: uppercase;" x-text="activeStageName"></span>
                                    </div>
                                </div>
                                <button @click="activeTask = null" style="background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 1.2rem;">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </div>

                            <div style="background: #f8fafc; padding: 1rem; border-radius: 16px; margin-bottom: 1.5rem; border: 1px solid #f1f5f9;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <span style="font-size: 0.65rem; font-weight: 800; color: #64748b; text-transform: uppercase;">Total Velocity</span>
                                    <span style="font-size: 0.9rem; font-weight: 900; color: var(--primary);" x-text="activeTask.progress + '%'"></span>
                                </div>
                                <div style="width: 100%; height: 6px; background: #fff; border-radius: 10px; overflow: hidden; border: 1px solid #e2e8f0;">
                                    <div :style="'width: ' + activeTask.progress + '%'" style="height: 100%; background: var(--primary); transition: width 0.5s ease;"></div>
                                </div>
                            </div>

                            <div style="display: flex; flex-direction: column; gap: 10px; max-height: 400px; overflow-y: auto; padding-right: 8px;">
                                <template x-for="log in activeTask.logs" :key="log.id">
                                    <div style="padding: 12px; background: #fff; border: 1px solid #f1f5f9; border-radius: 14px; position: relative; transition: all 0.2s hover:border-primary">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                            <div style="display: flex; align-items: center; gap: 6px;">
                                                <i class="fas fa-calendar-day" style="font-size: 0.65rem; color: #94a3b8;"></i>
                                                <span style="font-size: 0.7rem; font-weight: 800; color: #334155;" x-text="log.date"></span>
                                            </div>
                                            <span style="font-size: 0.75rem; font-weight: 900; color: #10b981;" x-text="'+' + log.increment + '%'"></span>
                                        </div>
                                        <p style="margin: 0; font-size: 0.75rem; color: #64748b; font-weight: 600; line-height: 1.4;" x-text="log.notes"></p>
                                    </div>
                                </template>
                                <template x-if="activeTask.logs.length === 0">
                                    <div style="text-align: center; padding: 2rem; color: #94a3b8; font-weight: 700; font-size: 0.75rem;">
                                        No operational data found for this objective.
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>{{-- /tab-stages --}}

    {{-- Tab: Client Details --}}
    <div id="tab-client" class="tab-content">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <div class="card-premium">
                <h2 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 1.5rem;">Client Identity</h2>
                <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 2rem; padding: 2rem; background: #f8fafc; border-radius: 24px;">
                    <div style="width: 80px; height: 80px; border-radius: 20px; background: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 2rem; color: #fff;">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div>
                        <div style="font-size: 1.5rem; font-weight: 900;">{{ $project->client->name }}</div>
                        <div style="color: #64748b; font-weight: 600;">{{ $project->client->email }}</div>
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div>
                        <div style="font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Direct Line</div>
                        <div style="font-size: 1.1rem; font-weight: 700;">{{ $project->client->phone ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Deployment Site</div>
                        <div style="font-size: 1.1rem; font-weight: 700;">{{ $project->site_address }}</div>
                    </div>
                </div>
            </div>
            <div class="card-premium">
                <h2 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 1.5rem;">Mission Command</h2>
                <div style="display: grid; grid-template-columns: 1fr; gap: 1rem;">
                    @forelse($project->supervisors as $supervisor)
                    <div style="display: flex; align-items: center; gap: 15px; padding: 1rem; background: #f8fafc; border-radius: 18px;">
                        <div style="width: 44px; height: 44px; border-radius: 12px; background: #0f172a; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800;">
                            {{ substr($supervisor->name, 0, 1) }}
                        </div>
                        <div>
                            <div style="font-weight: 800;">{{ $supervisor->name }}</div>
                            <div style="font-size: 0.8rem; color: #64748b;">{{ $supervisor->phone ?? 'No Phone' }}</div>
                        </div>
                    </div>
                    @empty
                    <p>No supervisors assigned.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>{{-- /tab-client --}}

    {{-- Tab: Activity --}}
    <div id="tab-activity" class="tab-content">
        <div class="card-premium">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 style="font-size: 1.4rem; font-weight: 800; margin: 0;">Operational Logs & Intelligence</h2>
                <button class="btn-premium" style="background: var(--primary); color: #fff; border: none;">Add Log Entry</button>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 2rem;">
                @forelse($project->workLogs as $log)
                <div style="padding: 2rem; background: #f8fafc; border-radius: 24px; border: 1px solid #f1f5f9; position: relative;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 10px; height: 10px; border-radius: 50%; background: var(--primary);"></div>
                            <div style="font-weight: 900; font-size: 1.1rem;">{{ $log->date->format('d F Y') }}</div>
                        </div>
                        <div style="font-size: 0.8rem; color: #64748b; font-weight: 800; text-transform: uppercase; background: #fff; padding: 4px 12px; border-radius: 50px;">{{ $log->stage->name }}</div>
                    </div>
                    <p style="font-size: 1rem; color: #334155; line-height: 1.7; margin-bottom: 1.5rem; font-weight: 500;">{{ $log->description }}</p>
                    
                    @if($log->photos->count() > 0)
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1.5rem;">
                        @foreach($log->photos as $photo)
                        <div style="position: relative; aspect-ratio: 1/1; border-radius: 18px; overflow: hidden; border: 4px solid #fff; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
                            <img src="{{ asset('storage/' . $photo->photo_path) }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        @endforeach
                    </div>
                    @endif
                    <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e2e8f0; font-size: 0.85rem; color: #64748b; font-weight: 700;">
                        Logged by Specialist: <span style="color: #0f172a;">{{ $log->user->name }}</span>
                    </div>
                </div>
                @empty
                <p style="text-align: center; padding: 4rem; color: #94a3b8;">No mission logs recorded.</p>
                @endforelse
            </div>
        </div>
    </div>{{-- /tab-activity --}}

</div>{{-- /animated-entrance --}}

@push('scripts')
<script>
    function switchTab(tabId) {
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
        
        event.currentTarget.classList.add('active');
        document.getElementById('tab-' + tabId).classList.add('active');
    }

    function toggleExpenses(id) {
        const el = document.getElementById(id);
        if (el.style.display === 'none') {
            el.style.display = 'block';
            el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } else {
            el.style.display = 'none';
        }
    }
    function toggleTacticalMenu(btn) {
        // Close all other menus first
        document.querySelectorAll('.tactical-dropdown').forEach(drop => {
            if (drop !== btn.nextElementSibling) drop.classList.remove('active');
        });
        btn.nextElementSibling.classList.toggle('active');
        event.stopPropagation();
    }

    // Close menus on outside click
    document.addEventListener('click', function() {
        document.querySelectorAll('.tactical-dropdown').forEach(drop => drop.classList.remove('active'));
    });
</script>

{{-- Global Strategy Modal --}}
<div x-show="showStrategyModal" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    style="position: fixed; inset: 0; z-index: 1000; display: flex; align-items: center; justify-content: center; padding: 2rem; backdrop-filter: blur(15px); background: rgba(15, 23, 42, 0.75);"
    x-cloak>
    
    <div @click.away="showStrategyModal = false" class="card-premium" style="width: 100%; max-width: 950px; background: #fff; padding: 0; border: none; box-shadow: 0 40px 100px -20px rgba(0,0,0,0.6); display: flex; height: 600px; overflow: hidden; border-radius: 28px;">
        {{-- Left Pane: Form --}}
        <div style="flex: 1.2; padding: 3.5rem; border-right: 1px solid #f1f5f9; display: flex; flex-direction: column;">
            <div style="margin-bottom: 2.5rem;">
                <h2 style="font-size: 1.8rem; font-weight: 900; color: #0f172a; margin: 0;">Strategic Planning</h2>
                <p style="font-size: 0.9rem; color: #64748b; font-weight: 600;">Define weighted sub-tasks for operational intelligence.</p>
            </div>
            <div style="display: flex; flex-direction: column; gap: 1.8rem; flex: 1;">
                <div>
                    <label style="display: block; font-size: 0.7rem; font-weight: 900; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px;">Target Phase</label>
                    <select x-model="strategyStageId" @change="fetchPlannedTasks()" style="width: 100%; padding: 15px; border: 2px solid #f1f5f9; border-radius: 16px; font-weight: 700; background: #f8fafc;">
                        <option value="">Select Phase...</option>
                        @foreach($project->stages as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 0.7rem; font-weight: 900; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px;">Objective Name</label>
                    <input type="text" x-model="strategyTaskName" placeholder="e.g. Columns reinforcement" style="width: 100%; padding: 15px; border: 2px solid #f1f5f9; border-radius: 16px; font-weight: 700;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.7rem; font-weight: 900; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px;">Weight (%)</label>
                    <input type="number" x-model="strategyTaskWeight" placeholder="0.00" style="width: 100%; padding: 15px; border: 2px solid #f1f5f9; border-radius: 16px; font-weight: 700;">
                </div>
                <button @click="deployObjective()" style="width: 100%; background: #0f172a; color: #fff; border: none; padding: 18px; border-radius: 20px; font-weight: 900; cursor: pointer; margin-top: auto;">
                    Deploy Objective
                </button>
            </div>
        </div>
        {{-- Right Pane: Ledger --}}
        <div style="width: 380px; background: #f8fafc; padding: 3rem; display: flex; flex-direction: column;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h3 style="font-size: 0.85rem; font-weight: 900; color: #0f172a; text-transform: uppercase;">Strategy Ledger</h3>
                <button @click="showStrategyModal = false" style="background: none; border: none; color: #94a3b8; cursor: pointer;"><i class="fas fa-times"></i></button>
            </div>
            <div style="flex: 1; overflow-y: auto; display: flex; flex-direction: column; gap: 12px;">
                <template x-for="ptask in plannedTasks" :key="ptask.id">
                    <div style="background: #fff; padding: 15px; border-radius: 16px; border: 1px solid #f1f5f9; display: flex; justify-content: space-between;">
                        <div style="font-size: 0.85rem; font-weight: 800;" x-text="ptask.name"></div>
                        <div style="font-size: 0.8rem; font-weight: 900; color: #10b981;" x-text="ptask.weight + '%'"></div>
                    </div>
                </template>
            </div>
            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 2px dashed #e2e8f0;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                    <span style="font-size: 0.75rem; font-weight: 900; color: #64748b;">TOTAL WEIGHT</span>
                    <span style="font-size: 1.1rem; font-weight: 900;" x-text="plannedTasks.reduce((acc, t) => acc + parseFloat(t.weight), 0).toFixed(1) + '%'"></span>
                </div>
            </div>
        </div>
    </div>
</div>
@endpush
@endsection
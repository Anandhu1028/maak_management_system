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

    [x-cloak] { display: none !important; }

    /* ── Strategy Modal Styles ── */
    .strategy-modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: grid;
        place-items: center;
        padding: 2rem;
        backdrop-filter: blur(20px);
        background: rgba(15, 23, 42, 0.75);
    }

    .strategy-modal-container {
        width: 100%;
        max-width: 950px;
        background: #fff;
        display: flex;
        height: 600px;
        overflow: hidden;
        border-radius: 28px;
        box-shadow: 0 40px 100px -20px rgba(0,0,0,0.6);
        border: none;
    }

    .modal-left-pane {
        flex: 1.2;
        padding: 3.5rem;
        border-right: 1px solid #f1f5f9;
        display: flex;
        flex-direction: column;
    }

    .modal-right-pane {
        width: 380px;
        background: #0d0f24;
        padding: 3rem;
        display: flex;
        flex-direction: column;
    }

    @media (max-width: 992px) {
        .strategy-modal-container {
            flex-direction: column;
            height: auto;
            max-height: 90vh;
            max-width: 600px;
            overflow-y: auto;
        }
        .modal-left-pane {
            border-right: none;
            border-bottom: 1px solid #f1f5f9;
            padding: 2rem;
        }
        .modal-right-pane {
            width: 100%;
            padding: 2rem;
        }
    }

    @media (max-width: 640px) {
        .strategy-modal-overlay {
            padding: 1rem;
        }
        .strategy-modal-container {
            max-width: 100%;
            border-radius: 20px;
        }
        .modal-left-pane, .modal-right-pane {
            padding: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<div x-data="{ 
    showStrategyModal: false, 
    strategyStageId: '', 
    strategyTaskName: '',
    strategyTaskWeight: '',
    plannedTasks: [],
    async fetchPlannedTasks() {
        if(!this.strategyStageId) { this.plannedTasks = []; return; }
        const res = await fetch(`/admin/stages/${this.strategyStageId}/tasks`, {
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
    <div class="animated-entrance">
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
        <button class="tab-btn" onclick="switchTab('daily-updates')">
            <i class="fas fa-calendar-check"></i> Daily Updates
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
                                ]
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

    {{-- Tab: Daily Updates --}}
    <div id="tab-daily-updates" class="tab-content" x-data="{
        showUpdateModal: false,
        showHistoryModal: false,
        activeTask: null,
        newIncrement: '',
        newNote: '',
        stages: [
            @foreach($project->stages as $stage)
            {
                id: {{ $stage->id }},
                name: '{{ addslashes($stage->name) }}',
                tasks: [
                    @foreach($stage->tasks as $task)
                    {
                        id: {{ $task->id }},
                        name: '{{ addslashes($task->name) }}',
                        weight: {{ (float)$task->weight }},
                        progress: {{ (float)$task->progress }},
                        status: '{{ $task->status }}',
                        logs: [
                            @foreach($task->logs()->latest()->get() as $log)
                            {
                                id: {{ $log->id }},
                                date: '{{ $log->date->isToday() ? 'Today' : ($log->date->isYesterday() ? 'Yesterday' : $log->date->format('d M Y')) }}',
                                increment: {{ (float)$log->work_done_percent }},
                                notes: '{{ addslashes($log->notes) }}'
                            },
                            @endforeach
                        ]
                    },
                    @endforeach
                ]
            },
            @endforeach
        ],
        get totalProgress() {
            let totalWeight = 0;
            let weightedProgress = 0;
            this.stages.forEach(s => {
                s.tasks.forEach(t => {
                    totalWeight += t.weight;
                    weightedProgress += (t.weight * t.progress);
                });
            });
            if(totalWeight === 0) return 0;
            return (weightedProgress / totalWeight).toFixed(1);
        },
        openUpdateModal(task) {
            this.activeTask = task;
            this.newIncrement = '';
            this.newNote = '';
            this.showUpdateModal = true;
        },
        openHistoryModal(task) {
            this.activeTask = task;
            this.showHistoryModal = true;
        },
        async submitUpdate() {
            if(!this.newIncrement || this.newIncrement <= 0) return;
            const res = await fetch(`/admin/stage-tasks/${this.activeTask.id}/logs`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({
                    work_done_percent: this.newIncrement,
                    date: new Date().toISOString().split('T')[0],
                    notes: this.newNote
                })
            });
            if(!res.ok) { alert('Update failed'); return; }
            const data = await res.json();
            if(data.success) {
                this.activeTask.progress = parseFloat(data.task_progress);
                this.activeTask.status = this.activeTask.progress >= 100 ? 'Completed' : 'In Progress';
                this.activeTask.logs.unshift({
                    id: data.log.id,
                    date: 'Today',
                    increment: parseFloat(data.log.work_done_percent),
                    notes: data.log.notes
                });
                this.showUpdateModal = false;
            } else {
                alert(data.error);
            }
        }
    }">
        {{-- Top Section --}}
        <div class="card-premium" style="background: #fff; border-radius: 20px; padding: 2rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; border: 1px solid #f1f5f9; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 900; margin: 0; color: #0f172a;">Daily Updates</h2>
                <div style="font-size: 0.85rem; color: #64748b; font-weight: 700; margin-top: 8px; display: flex; align-items: center;">
                    Stage Progress: <span style="margin-left: 5px; color: #0f172a; font-weight: 900;" x-text="totalProgress + '%'"></span>
                    <div style="display: inline-block; width: 120px; height: 8px; background: #e2e8f0; border-radius: 4px; margin-left: 15px; overflow: hidden;">
                        <div :style="'width: ' + totalProgress + '%; height: 100%; transition: width 0.5s; background: ' + (totalProgress < 30 ? '#ef4444' : (totalProgress < 70 ? '#f59e0b' : '#10b981'))"></div>
                    </div>
                </div>
                <div style="font-size: 0.75rem; color: #94a3b8; font-weight: 600; margin-top: 5px;">Last Updated: Today {{ now()->format('h:i A') }}</div>
            </div>
            <div style="display: flex; gap: 10px;">
                <button class="btn-premium" style="background: var(--primary); color: #fff; border: none; padding: 10px 20px; border-radius: 12px; font-weight: 700;">
                    <i class="fas fa-plus"></i> Add Update
                </button>
                <button class="btn-premium" style="background: #fff; color: #0f172a; border: 1px solid #e2e8f0; padding: 10px 20px; border-radius: 12px; font-weight: 700;">
                    Filter <i class="fas fa-caret-down"></i>
                </button>
            </div>
        </div>

        {{-- Task List (Cards) --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem;">
            <template x-for="stage in stages" :key="stage.id">
                <template x-for="task in stage.tasks" :key="task.id">
                    <div class="card-premium" style="background: #fff; border: 1px solid #f1f5f9; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); display: flex; flex-direction: column;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                            <div style="font-weight: 800; color: #0f172a; font-size: 1.1rem; line-height: 1.3;" x-text="task.name"></div>
                            <div style="font-weight: 900; font-size: 1rem;" 
                                :style="task.progress < 30 ? 'color: #ef4444;' : (task.progress < 70 ? 'color: #f59e0b;' : 'color: #10b981;')"
                                x-text="task.progress + '%'"></div>
                        </div>
                        
                        <div style="width: 100%; height: 6px; background: #f1f5f9; border-radius: 4px; overflow: hidden; margin-bottom: 1.2rem;">
                            <div :style="'width: ' + task.progress + '%; height: 100%; transition: width 0.3s; background: ' + (task.progress < 30 ? '#ef4444' : (task.progress < 70 ? '#f59e0b' : '#10b981'))"></div>
                        </div>

                        <div x-show="task.logs.length > 0" style="margin-bottom: 1.5rem;">
                            <div style="font-size: 0.7rem; color: #94a3b8; font-weight: 800; text-transform: uppercase;">Last update: <span x-text="task.logs[0].date"></span></div>
                            <div style="font-size: 0.85rem; color: #475569; font-weight: 600; margin-top: 4px; display: flex; flex-direction: column; gap: 2px;">
                                <div><span style="color: #10b981; font-weight: 800;">+<span x-text="task.logs[0].increment"></span>%</span></div>
                                <div style="font-style: italic;" x-text="task.logs[0].notes ? `&quot;${task.logs[0].notes}&quot;` : 'No notes provided'"></div>
                            </div>
                        </div>
                        <div x-show="task.logs.length === 0" style="margin-bottom: 1.5rem; font-size: 0.8rem; color: #94a3b8; font-style: italic;">
                            No updates logged yet.
                        </div>
                        
                        <div style="display: flex; gap: 10px; margin-top: auto;">
                            <button @click="openUpdateModal(task)" style="flex: 1; background: #f8fafc; border: 1px solid #e2e8f0; color: #0f172a; padding: 10px; border-radius: 10px; font-size: 0.8rem; font-weight: 800; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 6px;">
                                <i class="fas fa-plus" style="color: var(--primary);"></i> Add Update
                            </button>
                            <button @click="openHistoryModal(task)" style="flex: 1; background: #f8fafc; border: 1px solid #e2e8f0; color: #64748b; padding: 10px; border-radius: 10px; font-size: 0.8rem; font-weight: 800; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 6px;">
                                <i class="fas fa-history"></i> View History
                            </button>
                        </div>
                    </div>
                </template>
            </template>
        </div>

        {{-- Add Update Modal --}}
        <div x-show="showUpdateModal" class="strategy-modal-overlay" style="display: none;" x-cloak>
            <div @click.away="showUpdateModal = false" class="strategy-modal-container" style="max-width: 400px; height: auto; padding: 2.5rem; border-radius: 24px;">
                <div style="margin-bottom: 2rem;">
                    <h3 style="font-size: 1.4rem; font-weight: 900; margin: 0; color: #0f172a;">Add Daily Update</h3>
                    <div style="font-size: 0.85rem; color: #64748b; margin-top: 8px; font-weight: 700; background: #f1f5f9; padding: 8px 12px; border-radius: 8px;" x-text="'Task: ' + (activeTask ? activeTask.name : '')"></div>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: 900; color: #475569; text-transform: uppercase; margin-bottom: 8px;">Progress Today (%)</label>
                    <div style="position: relative;">
                        <input type="number" x-model="newIncrement" placeholder="+10" max="100" min="1" style="width: 100%; padding: 14px 14px 14px 35px; border: 2px solid #e2e8f0; border-radius: 12px; font-weight: 800; color: #0f172a; font-size: 1rem;">
                        <i class="fas fa-plus" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #10b981; font-size: 0.9rem;"></i>
                    </div>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: 900; color: #475569; text-transform: uppercase; margin-bottom: 8px;">Note</label>
                    <textarea x-model="newNote" rows="3" placeholder="Pipe installation completed in 2 rooms" style="width: 100%; padding: 14px; border: 2px solid #e2e8f0; border-radius: 12px; font-weight: 600; color: #0f172a; resize: none; font-size: 0.9rem;"></textarea>
                </div>

                <div style="display: flex; gap: 12px;">
                    <button @click="showUpdateModal = false" style="flex: 1; background: #f1f5f9; color: #475569; border: none; padding: 14px; border-radius: 12px; font-weight: 800; cursor: pointer; transition: all 0.2s;">
                        Cancel
                    </button>
                    <button @click="submitUpdate()" style="flex: 1; background: var(--primary); color: #fff; border: none; padding: 14px; border-radius: 12px; font-weight: 800; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(234,88,12,0.2);">
                        Save
                    </button>
                </div>
            </div>
        </div>

        {{-- History Modal --}}
        <div x-show="showHistoryModal" class="strategy-modal-overlay" style="display: none;" x-cloak>
            <div @click.away="showHistoryModal = false" class="strategy-modal-container" style="max-width: 480px; height: auto; max-height: 85vh; display: flex; flex-direction: column; border-radius: 24px;">
                <div style="padding: 2rem 2.5rem 1.5rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: #fff; border-radius: 24px 24px 0 0;">
                    <div>
                        <h3 style="font-size: 1.3rem; font-weight: 900; margin: 0; color: #0f172a;" x-text="activeTask ? activeTask.name : ''"></h3>
                        <div style="font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-top: 5px;">Full History</div>
                    </div>
                    <button @click="showHistoryModal = false" style="background: #f1f5f9; border: none; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #64748b; cursor: pointer; transition: all 0.2s;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div style="padding: 1.5rem 2.5rem; overflow-y: auto; flex: 1; background: #f8fafc;">
                    <template x-if="activeTask && activeTask.logs.length === 0">
                        <div style="text-align: center; padding: 2rem 0;">
                            <div style="width: 48px; height: 48px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                                <i class="fas fa-history" style="color: #94a3b8; font-size: 1.2rem;"></i>
                            </div>
                            <p style="color: #64748b; font-size: 0.9rem; font-weight: 600; margin: 0;">No history available yet.</p>
                        </div>
                    </template>
                    <div style="display: flex; flex-direction: column; gap: 1rem; position: relative;">
                        {{-- Timeline line --}}
                        <div style="position: absolute; left: 16px; top: 10px; bottom: 10px; width: 2px; background: #e2e8f0; z-index: 0;" x-show="activeTask && activeTask.logs.length > 0"></div>
                        
                        <template x-for="log in (activeTask ? activeTask.logs : [])" :key="log.id">
                            <div style="display: flex; gap: 15px; position: relative; z-index: 1;">
                                <div style="width: 34px; height: 34px; background: #fff; border: 2px solid #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 5px;">
                                    <div style="width: 10px; height: 10px; background: var(--primary); border-radius: 50%;"></div>
                                </div>
                                <div style="flex: 1; background: #fff; padding: 1.2rem; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);">
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                                        <div style="font-weight: 800; color: #0f172a; font-size: 0.85rem; display: flex; align-items: center; gap: 6px;">
                                            <i class="far fa-calendar-alt" style="color: #94a3b8;"></i>
                                            <span x-text="log.date"></span>
                                        </div>
                                        <div style="font-weight: 900; color: #10b981; font-size: 1.1rem; background: #dcfce7; padding: 2px 8px; border-radius: 6px;" x-text="'+' + log.increment + '%'"></div>
                                    </div>
                                    <div style="font-size: 0.85rem; color: #475569; font-weight: 500; line-height: 1.5;" x-text="log.notes || 'No notes provided'"></div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <div style="padding: 1.5rem 2.5rem; background: #fff; border-top: 1px solid #f1f5f9; border-radius: 0 0 24px 24px;">
                    <button @click="showHistoryModal = false" style="width: 100%; background: #f1f5f9; color: #475569; border: none; padding: 14px; border-radius: 12px; font-weight: 800; cursor: pointer; transition: all 0.2s;">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>{{-- /tab-daily-updates --}}

    </div>{{-- /animated-entrance --}}

    <div x-show="showStrategyModal" class="strategy-modal-overlay" x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95">
        
        <div @click.away="showStrategyModal = false" class="strategy-modal-container card-premium">
            {{-- Left Pane: Form --}}
            <div class="modal-left-pane">
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
            <div class="modal-right-pane">
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

</div>{{-- /x-data scope --}}

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


@endpush
@endsection
@extends('layouts.admin')

@section('title', 'Projects')

@push('styles')
<style>
/* ═══════════════════════════════════════════
   Premium Project List — Table Style
═══════════════════════════════════════════ */
.pl-wrap {
    font-family: 'Outfit', sans-serif;
    animation: plFade .6s cubic-bezier(.25,1,.5,1) both;
}
@keyframes plFade { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:none} }

/* ── Header ── */
.pl-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}
.pl-title {
    font-size: 2.2rem;
    font-weight: 900;
    letter-spacing: -1.5px;
    color: #0f172a;
    margin: 0;
}
.pl-subtitle { font-size: .88rem; color: #94a3b8; font-weight: 500; margin-top: 4px; }

.btn-new-project {
    background: linear-gradient(135deg,#06b6d4,#0891b2);
    color: #fff !important;
    padding: 11px 24px;
    border-radius: 12px;
    font-size: .83rem;
    font-weight: 800;
    text-decoration: none;
    display: inline-flex; align-items: center; gap: 8px;
    box-shadow: 0 6px 18px rgba(6,182,212,.35);
    transition: all .25s;
    border: none;
}
.btn-new-project:hover { transform: translateY(-2px) scale(1.02); box-shadow: 0 10px 26px rgba(6,182,212,.45); }

/* ── Stats Strip ── */
.pl-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 1.8rem;
}
.pl-stat {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #f1f5f9;
    padding: 1.2rem 1.4rem;
    box-shadow: 0 2px 10px rgba(0,0,0,.04);
    position: relative;
    overflow: hidden;
    z-index: 1;
}

.stat-total { background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%); border-left: 4px solid #6394ff; }
.stat-active { background: linear-gradient(135deg, #fffaf0 0%, #ffffff 100%); border-left: 4px solid #f59e0b; }
.stat-done { background: linear-gradient(135deg, #f0fff4 0%, #ffffff 100%); border-left: 4px solid #10b981; }
.stat-over { background: linear-gradient(135deg, #fff1f2 0%, #ffffff 100%); border-left: 4px solid #f43f5e; }

[data-theme="dark"] .stat-total { background: linear-gradient(135deg, rgba(99,148,255,0.08) 0%, rgba(13,13,35,0.7) 100%) !important; }
[data-theme="dark"] .stat-active { background: linear-gradient(135deg, rgba(245,158,11,0.08) 0%, rgba(13,13,35,0.7) 100%) !important; }
[data-theme="dark"] .stat-done { background: linear-gradient(135deg, rgba(16,185,129,0.08) 0%, rgba(13,13,35,0.7) 100%) !important; }
[data-theme="dark"] .stat-over { background: linear-gradient(135deg, rgba(244,63,94,0.08) 0%, rgba(13,13,35,0.7) 100%) !important; }
.pl-stat-lbl { font-size: .68rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: .6px; margin-bottom: .4rem; }
.pl-stat-val { font-size: 2rem; font-weight: 900; letter-spacing: -1px; line-height: 1; }

/* ── Alert Bar ── */
.over-alert-bar {
    display: flex; align-items: center; gap: 14px;
    background: linear-gradient(90deg,#fef2f2,#fff);
    border: 1px solid #fecaca;
    border-radius: 14px;
    padding: .9rem 1.4rem;
    margin-bottom: 1.5rem;
    animation: alertPulse 2.5s ease-in-out infinite;
}
@keyframes alertPulse {
    0%,100%{ box-shadow:0 0 0 0 rgba(220,38,38,0); }
    50%    { box-shadow:0 0 0 8px rgba(220,38,38,.07); }
}

/* ── Table Shell ── */
.pl-shell {
    background: #fff;
    border-radius: 22px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 4px 30px rgba(0,0,0,.06);
    overflow: visible;
    background: #f4f6fb;
    padding: 0 1rem 1rem;
}

/* ── Table ── */
.pl-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 8px;
}

.pl-table thead tr {
    background: transparent;
}
.pl-table th {
    padding: .7rem 1.4rem;
    font-size: .65rem;
    font-weight: 800;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: .8px;
    text-align: left;
    white-space: nowrap;
}

/* Row card */
.pl-table tbody tr {
    background: #fff;
    border-radius: 14px;
    transition: box-shadow .2s, transform .15s;
    animation: rowSlide .5s cubic-bezier(.25,1,.5,1) both;
}
@keyframes rowSlide { from{opacity:0;transform:translateX(-12px)} to{opacity:1;transform:none} }
.pl-table tbody tr:nth-child(1)  { animation-delay:.00s }
.pl-table tbody tr:nth-child(2)  { animation-delay:.05s }
.pl-table tbody tr:nth-child(3)  { animation-delay:.10s }
.pl-table tbody tr:nth-child(4)  { animation-delay:.15s }
.pl-table tbody tr:nth-child(5)  { animation-delay:.20s }
.pl-table tbody tr:nth-child(6)  { animation-delay:.25s }
.pl-table tbody tr:nth-child(7)  { animation-delay:.30s }
.pl-table tbody tr:nth-child(8)  { animation-delay:.35s }
.pl-table tbody tr:nth-child(9)  { animation-delay:.40s }
.pl-table tbody tr:nth-child(10) { animation-delay:.45s }

/* Card border via td */
.pl-table tbody tr td:first-child {
    border-radius: 14px 0 0 14px;
    border-left: 1px solid #e8edf6;
    border-top: 1px solid #e8edf6;
    border-bottom: 1px solid #e8edf6;
}
.pl-table tbody tr td:last-child {
    border-radius: 0 14px 14px 0;
    border-right: 1px solid #e8edf6;
    border-top: 1px solid #e8edf6;
    border-bottom: 1px solid #e8edf6;
}
.pl-table tbody tr td:not(:first-child):not(:last-child) {
    border-top: 1px solid #e8edf6;
    border-bottom: 1px solid #e8edf6;
}

.pl-table tbody tr:hover {
    box-shadow: 0 6px 24px rgba(0,0,0,.08);
    transform: translateY(-1px);
}
.pl-table tbody tr:hover td { border-color: #d0d9f0 !important; }
.pl-table td { padding: 1rem 1.4rem; vertical-align: middle; }

/* ── Over-expense rows ── */
.row-crisis td:first-child { border-left: 4px solid #dc2626 !important; }
.row-crisis { animation: rowSlide .5s ease both, bloodBlink 2.2s ease-in-out infinite !important; }
@keyframes bloodBlink {
    0%,100%{ background: linear-gradient(90deg,rgba(220,38,38,.06) 0%,#fff 40%); }
    50%    { background: linear-gradient(90deg,rgba(220,38,38,.13) 0%,#fff 50%); }
}
.row-warn td:first-child { border-left: 4px solid #f59e0b !important; }
.row-warn { background: linear-gradient(90deg,rgba(245,158,11,.05) 0%,#fff 40%) !important; }


/* ── Project Cell ── */
.proj-av {
    width: 44px; height: 44px;
    border-radius: 13px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; color: #fff; flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(0,0,0,.15);
}
.proj-name { font-weight: 800; font-size: .9rem; color: #0f172a; letter-spacing: -.2px; }
.proj-client { font-size: .73rem; color: #94a3b8; font-weight: 500; margin-top: 2px; }

/* ── Supervisor Cell ── */
.sv-av {
    width: 36px; height: 36px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .72rem; font-weight: 900; color: #fff;
    flex-shrink: 0;
    box-shadow: 0 3px 10px rgba(0,0,0,.15);
    border: 2px solid #fff;
}
.sv-name { font-weight: 700; font-size: .82rem; color: #0f172a; }
.sv-role { font-size: .68rem; color: #94a3b8; font-weight: 600; }

/* ── Stage Cell ── */
.stage-chip {
    display: inline-flex; align-items: center; gap: 6px;
    border-radius: 50px;
    padding: 5px 12px;
    font-size: .72rem; font-weight: 700;
    white-space: nowrap;
}
.stage-active  { background:#eff6ff; color:#1d4ed8; }
.stage-done    { background:#f0fdf4; color:#15803d; }
.stage-idle    { background:#f8fafc; color:#64748b; }

/* ── Amount Cell ── */
.amount-main { font-size: 1rem; font-weight: 900; color: #0f172a; letter-spacing: -.3px; }
.amount-sub  { font-size: .68rem; color: #94a3b8; font-weight: 600; margin-top: 2px; }

/* ── Circular Progress ── */
.cg-wrap {
    position: relative;
    width: 58px; height: 58px;
    display: inline-flex; align-items: center; justify-content: center;
}
.cg-wrap svg { position: absolute; inset: 0; transform: rotate(-90deg); }
.cg-bg   { fill: none; stroke: #f1f5f9; stroke-width: 5; }
.cg-fill { fill: none; stroke-width: 5; stroke-linecap: round; transition: stroke-dashoffset 1.3s cubic-bezier(.25,1,.5,1); }
.cg-text {
    position: relative; z-index: 1;
    font-size: .65rem; font-weight: 900;
    color: #0f172a; text-align: center; line-height: 1.1;
}

/* ── Action Buttons ── */
.act-wrap { display: flex; gap: 6px; justify-content: flex-end; }
.act-btn {
    width: 34px; height: 34px;
    border-radius: 10px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: .82rem;
    text-decoration: none;
    transition: all .2s cubic-bezier(.25,1,.5,1);
    border: 1px solid transparent;
}
.btn-view { background:#f1f5f9; color:#475569; }
.btn-view:hover { background:#0f172a; color:#fff; transform:scale(1.1); }
.btn-edit { background:#fff7ed; color:#ea580c; }
.btn-edit:hover { background:#ea580c; color:#fff; transform:scale(1.1); }

/* ── Badge ── */
.badge {
    display: inline-flex; align-items: center; gap: 4px;
    border-radius: 7px; padding: 3px 9px;
    font-size: .62rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: .4px;
}
.badge-over { background:#fef2f2; color:#dc2626; border: 1px solid #fecaca; }
.badge-near { background:#fffbeb; color:#d97706; border: 1px solid #fde68a; }
.badge-ok   { background:#f0fdf4; color:#16a34a; border: 1px solid #bbf7d0; }

/* ── Exceed Alert ── */
.alert-exceed {
    color: #dc2626;
    font-size: 0.62rem;
    font-weight: 800;
    margin-top: 6px;
    display: flex;
    align-items: center;
    gap: 5px;
    animation: alertBlink 1.8s ease-in-out infinite;
    text-transform: uppercase;
    letter-spacing: 0.2px;
}
@keyframes alertBlink {
    0%, 100% { opacity: 1; transform: translateY(0); }
    50%      { opacity: 0.4; transform: translateY(1px); }
}
[data-theme="dark"] .alert-exceed {
    color: #ff4d4d;
    text-shadow: 0 0 10px rgba(255, 77, 77, 0.3);
}

/* ── Stat Blink ── */
.stat-blink {
    border-color: #dc2626 !important;
    animation: statPulse 2s infinite !important;
}
@keyframes statPulse {
    0%, 100% { box-shadow: 0 4px 20px rgba(0,0,0,0.4); border-color: #dc2626; }
    50%      { box-shadow: 0 0 25px rgba(220, 38, 38, 0.4); border-color: #ef4444; }
}

/* ── Empty ── */
.pl-empty { text-align:center; padding:5rem 2rem; }

/* Mobile collapse */
@media(max-width:800px) {
    .pl-stats { grid-template-columns: repeat(2,1fr); }
    .pl-table th:nth-child(3),
    .pl-table td:nth-child(3),
    .pl-table th:nth-child(4),
    .pl-table td:nth-child(4) { display:none; }
}
</style>
@endpush

@section('content')
@php
/* ── Alert flags ── */
$overProjects = []; $nearProjects = [];
foreach ($projects as $proj) {
    $crisis = false; $warn = false;
    foreach ($proj->stages as $st) {
        $spent = $st->expenses->where('status','Approved')->sum('amount');
        $limit = (float)$st->client_payment_amount;
        if ($limit > 0) {
            if ($spent > $limit)            $crisis = true;
            elseif ($spent >= $limit * .85) $warn   = true;
        }
    }
    if ($crisis)    $overProjects[$proj->id] = true;
    elseif ($warn)  $nearProjects[$proj->id] = true;
}
$overCount = count($overProjects);

/* ── Palette ── */
$pals = [
    ['grad'=>'linear-gradient(135deg,#f97316,#ea580c)', 'clr'=>'#f97316'],
    ['grad'=>'linear-gradient(135deg,#06b6d4,#0891b2)', 'clr'=>'#06b6d4'],
    ['grad'=>'linear-gradient(135deg,#8b5cf6,#6d28d9)', 'clr'=>'#8b5cf6'],
    ['grad'=>'linear-gradient(135deg,#10b981,#059669)', 'clr'=>'#10b981'],
    ['grad'=>'linear-gradient(135deg,#ec4899,#db2777)', 'clr'=>'#ec4899'],
    ['grad'=>'linear-gradient(135deg,#f59e0b,#d97706)', 'clr'=>'#f59e0b'],
];
$typeIcon = ['Civil Construction'=>'fa-building','Interior Design'=>'fa-couch','Maintenance'=>'fa-wrench'];

/* Gauge constants */
$R = 22; $CIRC = 2 * M_PI * $R;

/* Stats */
$totalVal = $projects->sum('project_value');
$approved = \App\Models\Expense::where('status','Approved')->sum('amount');
@endphp

<div class="pl-wrap">

    {{-- Header --}}
    <div class="pl-header" style="margin-bottom: 2.5rem;">
        <div>
            <h1 class="pl-title">Strategic Projects</h1>
            <p class="pl-subtitle">Comprehensive lifecycle tracking for {{ $projects->count() }} active construction missions</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.projects.create') }}" class="btn-new-project">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Deploy Project
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="pl-stats" style="margin-bottom: 3rem;">
        <div class="pl-stat stat-total">
            <div class="stat-icon-shell">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="3" x2="9" y2="21"></line></svg>
            </div>
            <div class="pl-stat-lbl">Active Pipeline</div>
            <div class="pl-stat-val">{{ $projects->count() }}</div>
            <div class="stat-progress-bar" style="background: rgba(99, 148, 255, 0.2);"><div style="width: 100%; background: #6394ff;"></div></div>
        </div>
        <div class="pl-stat stat-active">
            <div class="stat-icon-shell">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
            </div>
            <div class="pl-stat-lbl">In Progress</div>
            <div class="pl-stat-val">{{ $projects->where('status','Active')->count() }}</div>
            <div class="stat-progress-bar" style="background: rgba(245, 158, 11, 0.2);"><div style="width: {{ $projects->count() > 0 ? ($projects->where('status','Active')->count() / $projects->count() * 100) : 0 }}%; background: #f59e0b;"></div></div>
        </div>
        <div class="pl-stat stat-done">
            <div class="stat-icon-shell">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>
            <div class="pl-stat-lbl">Operational Success</div>
            <div class="pl-stat-val">{{ $projects->where('status','Completed')->count() }}</div>
            <div class="stat-progress-bar" style="background: rgba(16, 185, 129, 0.2);"><div style="width: {{ $projects->count() > 0 ? ($projects->where('status','Completed')->count() / $projects->count() * 100) : 0 }}%; background: #10b981;"></div></div>
        </div>
        <div class="pl-stat stat-over {{ $overCount > 0 ? 'stat-blink' : '' }}">
            <div class="stat-icon-shell">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
            </div>
            <div class="pl-stat-lbl">Budget Alert</div>
            <div class="pl-stat-val">{{ $overCount }}</div>
            <div class="stat-progress-bar" style="background: rgba(244, 63, 94, 0.2);"><div style="width: {{ $projects->count() > 0 ? ($overCount / $projects->count() * 100) : 0 }}%; background: #f43f5e;"></div></div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; gap: 15px;">
        <div style="position: relative; flex: 1; max-width: 400px;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 0.85rem;"></i>
            <input type="text" placeholder="Search projects, clients, or locations..." 
                style="width: 100%; padding: 12px 12px 12px 45px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; color: #fff; font-size: 0.9rem; outline: none; transition: all 0.3s ease;">
        </div>
        <div style="display: flex; gap: 10px;">
            <div style="display: flex; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 4px;">
                <button class="active" style="padding: 6px 15px; border: none; background: rgba(99, 148, 255, 0.1); color: #6394ff; border-radius: 8px; font-size: 0.8rem; font-weight: 700; cursor: pointer;">All</button>
                <button style="padding: 6px 15px; border: none; background: transparent; color: #64748b; border-radius: 8px; font-size: 0.8rem; font-weight: 700; cursor: pointer;">Active</button>
                <button style="padding: 6px 15px; border: none; background: transparent; color: #64748b; border-radius: 8px; font-size: 0.8rem; font-weight: 700; cursor: pointer;">Completed</button>
            </div>
            <button style="display: flex; align-items: center; gap: 8px; padding: 10px 18px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; color: #e2e8f0; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                <i class="fas fa-filter" style="font-size: 0.75rem;"></i> Filters
            </button>
        </div>
    </div>


    {{-- Table --}}
    <div class="">
        @if($projects->isEmpty())
            <div class="pl-empty">
                <div style="font-size:3.5rem;opacity:.25;margin-bottom:1rem;"><i class="fas fa-folder-open"></i></div>
                <div style="font-weight:800;font-size:1.1rem;color:#334155;">No projects yet</div>
                <div style="margin-top:6px;font-size:.88rem;color:#94a3b8;">Start by creating your first project.</div>
                <a href="{{ route('admin.projects.create') }}" class="btn-new-project" style="margin-top:1.5rem;display:inline-flex;">
                    <i class="fas fa-plus"></i> New Project
                </a>
            </div>
        @else
        <table class="pl-table">
            <thead>
                <tr>
                    <th>Project</th>
                    <th>Supervisor</th>
                    <th>Current Stage</th>
                    <th>Stage Amount</th>
                    <th style="text-align:center;">Progress</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($projects as $idx => $project)
            @php
                /* Progress */
                $prog = 0;
                foreach ($project->stages as $st)
                    $prog += ($st->completion_percentage * $st->weight_percentage) / 100;
                $prog = min(100, round($prog, 0));

                /* Current stage */
                $curStage = $project->stages->firstWhere('status','In Progress')
                         ?? $project->stages->last();

                /* Stage amount for current stage */
                $stageAmt   = $curStage ? (float)$curStage->client_payment_amount : 0;
                $stageSpent = $curStage ? $curStage->expenses->where('status','Approved')->sum('amount') : 0;

                /* Supervisor */
                $sv = $project->supervisors->first();

                /* Flags */
                $isOver = isset($overProjects[$project->id]);
                $isNear = isset($nearProjects[$project->id]);

                /* Palette & icon */
                $pal  = $pals[$idx % count($pals)];
                $icon = $typeIcon[$project->type] ?? 'fa-folder';

                /* Stage chip class */
                $chipCls = 'stage-idle';
                if ($curStage) {
                    if ($curStage->status === 'In Progress') $chipCls = 'stage-active';
                    elseif ($curStage->status === 'Completed') $chipCls = 'stage-done';
                }

                /* Gauge color */
                $gc = $isOver ? '#dc2626' : ($isNear ? '#f59e0b' : $pal['clr']);

                /* SVG gauge dashoffset */
                $dashOff = $CIRC - ($prog / 100) * $CIRC;
            @endphp
            <tr class="{{ $isOver ? 'row-crisis' : ($isNear ? 'row-warn' : '') }}">

                {{-- ① Project --}}
                <td>
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div class="proj-av" style="background:{{ $pal['grad'] }};">
                            <i class="fas {{ $icon }}"></i>
                        </div>
                        <div>
                            <div class="proj-name">{{ $project->name }}</div>
                            <div class="proj-client">
                                <i class="fas fa-user" style="font-size:.6rem;"></i>
                                {{ $project->client->name ?? '—' }}
                            </div>
                        </div>
                    </div>
                </td>

                {{-- ② Supervisor --}}
                <td>
                    @if($sv)
                        <div style="display:flex;align-items:center;gap:9px;">
                            <div class="sv-av" style="background:{{ $pal['grad'] }};">
                                {{ strtoupper(substr($sv->name,0,2)) }}
                            </div>
                            <div>
                                <div class="sv-name">{{ \Illuminate\Support\Str::limit($sv->name,16) }}</div>
                                <div class="sv-role">Supervisor</div>
                            </div>
                        </div>
                    @else
                        <div style="display:flex;align-items:center;gap:9px;">
                            <div class="sv-av" style="background:linear-gradient(135deg,#94a3b8,#64748b);">—</div>
                            <div class="sv-role" style="color:#94a3b8;">Unassigned</div>
                        </div>
                    @endif
                </td>

                {{-- ③ Current Stage --}}
                <td>
                    @if($curStage)
                        <span class="stage-chip {{ $chipCls }}">
                            <i class="fas fa-{{ $chipCls==='stage-done' ? 'circle-check' : ($chipCls==='stage-active' ? 'bolt' : 'clock') }}"></i>
                            {{ \Illuminate\Support\Str::limit($curStage->name, 22) }}
                        </span>
                    @else
                        <span style="color:#94a3b8;font-size:.78rem;">No stages</span>
                    @endif
                </td>

                {{-- ④ Stage Amount --}}
                <td>
                    @if($curStage)
                        <div class="amount-main">
                            BHD {{ number_format($stageAmt, 3) }}
                        </div>
                        <div class="amount-sub">
                            Spent: BHD {{ number_format($stageSpent, 3) }}
                            @if($stageAmt > 0)
                                · {{ number_format(($stageSpent / $stageAmt) * 100, 0) }}%
                            @endif
                        </div>
                        @if($stageSpent > $stageAmt)
                            <div class="alert-exceed">
                                <i class="fas fa-triangle-exclamation"></i>
                                Expense has exceeded the budget! Please balance it.
                            </div>
                        @endif
                    @else
                        <span style="color:#94a3b8;font-size:.78rem;">—</span>
                    @endif
                </td>

                {{-- ⑤ Progress (Circular Gauge) --}}
                <td style="text-align:center;">
                    <div class="cg-wrap">
                        <svg width="58" height="58" viewBox="0 0 58 58">
                            <circle class="cg-bg"   cx="29" cy="29" r="{{ $R }}" />
                            <circle class="cg-fill"
                                    cx="29" cy="29" r="{{ $R }}"
                                    stroke="{{ $gc }}"
                                    stroke-dasharray="{{ $CIRC }}"
                                    stroke-dashoffset="{{ $CIRC }}"
                                    data-target="{{ $dashOff }}" />
                        </svg>
                        <div class="cg-text" style="color:{{ $gc }};">{{ $prog }}%</div>
                    </div>
                </td>

                {{-- ⑥ Status / Alert --}}
                <td>
                    @if($isOver)
                        <span class="badge badge-over">
                            <i class="fas fa-triangle-exclamation"></i> 
                            Over Limit - Please Balance Budget
                        </span>
                    @elseif($isNear)
                        <span class="badge badge-near"><i class="fas fa-circle-exclamation"></i> Near Limit</span>
                    @else
                        <span class="badge badge-ok"><i class="fas fa-circle-check"></i> On Track</span>
                    @endif
                </td>

                {{-- ⑦ Actions --}}
                <td>
                    <div class="act-wrap">
                        <a href="{{ route('admin.projects.show', $project) }}"
                           class="act-btn btn-view" title="View Project">
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </a>
                        <a href="{{ route('admin.projects.edit', $project) }}"
                           class="act-btn btn-edit" title="Edit Project">
                           <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                        </a>
                    </div>
                </td>

            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    /* Animate circular gauges */
    document.querySelectorAll('.cg-fill[data-target]').forEach((el, i) => {
        const target = parseFloat(el.dataset.target);
        setTimeout(() => {
            el.style.transition = 'stroke-dashoffset 1.2s cubic-bezier(.25,1,.5,1)';
            el.style.strokeDashoffset = target;
        }, 150 + i * 60);
    });
});
</script>
@endpush

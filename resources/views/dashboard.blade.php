@extends('layouts.admin')

@section('title', 'Intelligence Dashboard')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Outfit:wght@100;200;300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
/* ─── Premium Dashboard Core ─────────────────────────────────────── */
:root {
    --dash-bg: #fdfdfd;
    --dash-accent: #ea580c;
    --dash-text: #171717;
    --dash-text-sub: #737373;
    --dash-glass: rgba(255, 255, 255, 0.7);
    --dash-radius: 32px;
    --dash-shadow: 0 20px 50px rgba(0,0,0,0.05);
    --dash-glow: rgba(234, 88, 12, 0.15);
}

.intelligence-wrapper {
    font-family: 'Outfit', sans-serif;
    color: var(--dash-text);
    padding: 1rem;
    max-width: 1600px;
    margin: 0 auto;
}

/* ─── Bento Grid Layout ───────────────────────────────────────────── */
.bento-grid {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    grid-template-rows: auto;
    gap: 1.5rem;
}

/* ─── Bento Card Base ────────────────────────────────────────────── */
.bento-card {
    background: #fff;
    border-radius: var(--dash-radius);
    padding: 2.2rem;
    border: 1px solid rgba(0,0,0,0.04);
    box-shadow: 0 10px 30px rgba(0,0,0,0.02);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.bento-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--dash-shadow);
    border-color: rgba(234, 88, 12, 0.2);
}

/* ─── Header Section ─────────────────────────────────────────────── */
.dash-header {
    grid-column: span 12;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding: 1rem 0;
}

.welcome-text h1 {
    font-size: 3rem;
    font-weight: 900;
    letter-spacing: -2px;
    margin: 0;
    line-height: 1;
}

.welcome-text p {
    font-size: 1.1rem;
    color: var(--dash-text-sub);
    font-weight: 500;
    margin-top: 8px;
}

/* ─── KPI Cards (Bento) ──────────────────────────────────────────── */
.kpi-main { grid-column: span 3; }
@media (max-width: 1200px) { .kpi-main { grid-column: span 6; } }
@media (max-width: 768px) { .kpi-main { grid-column: span 12; } }

.kpi-label {
    font-size: 0.8rem;
    font-weight: 800;
    color: var(--dash-text-sub);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

.kpi-val {
    font-size: 3rem;
    font-weight: 900;
    letter-spacing: -2px;
    line-height: 1;
}

.kpi-trend {
    margin-top: 1rem;
    font-size: 0.9rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 5px;
}

/* ─── Hero Chart ─────────────────────────────────────────────────── */
.hero-chart-card {
    grid-column: span 8;
    background: #0a0a0a;
    color: #fff;
}

.hero-chart-card h2 {
    font-size: 1.5rem;
    font-weight: 800;
    margin-bottom: 2rem;
}

.side-status-card {
    grid-column: span 4;
}

@media (max-width: 1200px) {
    .hero-chart-card, .side-status-card { grid-column: span 12; }
}

/* ─── Activity Log (Glassy) ────────────────────────────────────────── */
.activity-card {
    grid-column: span 5;
}

.projects-card {
    grid-column: span 7;
}

@media (max-width: 1024px) {
    .activity-card, .projects-card { grid-column: span 12; }
}

/* ─── Micro-Animations ───────────────────────────────────────────── */
@keyframes slideUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.bento-card { animation: slideUp 0.6s cubic-bezier(0.25, 1, 0.5, 1) both; }
.bento-card:nth-child(1) { animation-delay: 0.1s; }
.bento-card:nth-child(2) { animation-delay: 0.15s; }
.bento-card:nth-child(3) { animation-delay: 0.2s; }
.bento-card:nth-child(4) { animation-delay: 0.25s; }
.bento-card:nth-child(5) { animation-delay: 0.3s; }

/* ─── Budget Alerts (Critical) ───────────────────────────────────── */
.critical-alert-bar {
    grid-column: span 12;
    background: #fff;
    border-radius: 24px;
    padding: 1.5rem 2rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    border: 1px solid #fee2e2;
    box-shadow: 0 10px 40px rgba(239, 68, 68, 0.08);
}

.alert-icon-ring {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #fef2f2;
    color: #ef4444;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    animation: alertPulse 2s infinite;
}

@keyframes alertPulse {
    0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
    70% { box-shadow: 0 0 0 15px rgba(239, 68, 68, 0); }
    100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
}

</style>
@endpush

@section('content')
<div class="intelligence-wrapper">
    
    {{-- ── Header ── --}}
    <header class="dash-header">
        <div class="welcome-text">
            <h1>Intelligence <span style="color: var(--dash-accent);">Terminal</span></h1>
            <p>MAAK Construction | Strategic Asset Management</p>
        </div>
        <div style="text-align: right;">
            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.85rem; background: #f1f1f1; padding: 8px 16px; border-radius: 50px; font-weight: 600;">
                <span style="color: var(--dash-accent);">●</span> SYNCED: {{ now()->format('H:i') }}
            </div>
        </div>
    </header>

    <div class="bento-grid">

        {{-- ── Alerts ── --}}
        @foreach($budgetAlerts as $alert)
        <div class="critical-alert-bar">
            <div class="alert-icon-ring">
                <i class="fas fa-triangle-exclamation"></i>
            </div>
            <div style="flex: 1;">
                <div style="font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: #ef4444; margin-bottom: 2px;">Risk Detected</div>
                <div style="font-weight: 700; font-size: 1rem;">{{ $alert['message'] }}</div>
            </div>
            <a href="{{ route('admin.projects.show', $alert['project_id']) }}" style="background: #171717; color: #fff; padding: 12px 24px; border-radius: 14px; text-decoration: none; font-weight: 800; font-size: 0.8rem; transition: all 0.2s;">RESOLVE ACTION <i class="fas fa-arrow-right" style="margin-left: 8px;"></i></a>
        </div>
        @endforeach

        {{-- ── KPI Row ── --}}
        <div class="bento-card kpi-main">
            <div class="kpi-label"><i class="fas fa-helmet-safety"></i> Active Units</div>
            <div class="kpi-val">{{ $activeProjects }}</div>
            <div class="kpi-trend" style="color: var(--dash-text-sub);">Current operational sites</div>
        </div>

        <div class="bento-card kpi-main">
            <div class="kpi-label"><i class="fas fa-vault"></i> Inflow</div>
            <div class="kpi-val" style="color: #059669;">{{ number_format($totalIncome / 1000, 1) }}k</div>
            <div class="kpi-trend" style="color: #059669;"><i class="fas fa-arrow-trend-up"></i> BHD Settled</div>
        </div>

        <div class="bento-card kpi-main">
            <div class="kpi-label"><i class="fas fa-receipt"></i> Verified Out</div>
            <div class="kpi-val" style="color: #ef4444;">{{ number_format(($totalProjectExpenses + $totalGeneralExpenses) / 1000, 1) }}k</div>
            <div class="kpi-trend" style="color: #ef4444;"><i class="fas fa-shield-check"></i> BHD Audited</div>
        </div>

        <div class="bento-card kpi-main" style="background: {{ $netProfit >= 0 ? '#f0fdf4' : '#fef2f2' }}; border: none;">
            <div class="kpi-label" style="color: {{ $netProfit >= 0 ? '#166534' : '#991b1b' }};"><i class="fas fa-chart-line"></i> Yield</div>
            <div class="kpi-val" style="color: {{ $netProfit >= 0 ? '#166534' : '#991b1b' }};">{{ number_format(abs($netProfit) / 1000, 1) }}k</div>
            <div class="kpi-trend" style="color: {{ $netProfit >= 0 ? '#16a34a' : '#ef4444' }};">
                {{ $netProfit >= 0 ? 'Surplus recorded' : 'Deficit detected' }}
            </div>
        </div>

        {{-- ── Hero Chart ── --}}
        <div class="bento-card hero-chart-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <h2>Capital Flow Velocity</h2>
                <div style="display: flex; gap: 1rem; font-size: 0.75rem; font-weight: 700;">
                    <span style="display: flex; align-items: center; gap: 5px;"><span style="width: 10px; height: 10px; background: #fff; border-radius: 2px;"></span> Revenue</span>
                    <span style="display: flex; align-items: center; gap: 5px;"><span style="width: 10px; height: 10px; background: var(--dash-accent); border-radius: 2px;"></span> Outflow</span>
                </div>
            </div>
            <div style="height: 350px;">
                <canvas id="bento-hero-chart"></canvas>
            </div>
        </div>

        <div class="bento-card side-status-card">
            <h2 style="font-size: 1.2rem; font-weight: 800; margin-bottom: 2rem;">Site Allocation</h2>
            <div style="height: 200px; position: relative;">
                <canvas id="bento-donut-chart"></canvas>
                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                    <div style="font-size: 2.2rem; font-weight: 900; line-height: 1;">{{ $totalProjects }}</div>
                    <div style="font-size: 0.65rem; font-weight: 800; color: var(--dash-text-sub); text-transform: uppercase;">Total</div>
                </div>
            </div>
            <div style="margin-top: 2rem; display: flex; flex-direction: column; gap: 12px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.85rem; font-weight: 700; color: var(--dash-text-sub);">Active Units</span>
                    <span style="font-size: 1.1rem; font-weight: 900;">{{ $activeProjects }}</span>
                </div>
                <div style="width: 100%; height: 6px; background: #f1f1f1; border-radius: 10px; overflow: hidden;">
                    <div style="width: {{ $totalProjects > 0 ? ($activeProjects / $totalProjects) * 100 : 0 }}%; height: 100%; background: var(--dash-accent); border-radius: 10px;"></div>
                </div>
            </div>
        </div>

        {{-- ── Bottom Row ── --}}
        <div class="bento-card projects-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 style="font-size: 1.2rem; font-weight: 800; margin: 0;">Operational Sites</h2>
                <a href="{{ route('admin.projects.index') }}" style="font-size: 0.8rem; font-weight: 800; color: var(--dash-accent); text-decoration: none;">View Archive <i class="fas fa-arrow-right"></i></a>
            </div>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                @foreach($recentProjects as $project)
                <a href="{{ route('admin.projects.show', $project) }}" style="display: flex; align-items: center; gap: 15px; padding: 1.2rem; background: #fafafa; border-radius: 20px; text-decoration: none; color: inherit; transition: all 0.2s;">
                    <div style="width: 48px; height: 48px; border-radius: 14px; background: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: var(--dash-accent); box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
                        <i class="fas fa-building"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 800; font-size: 1rem;">{{ $project->name }}</div>
                        <div style="font-size: 0.75rem; color: var(--dash-text-sub); font-weight: 600;">{{ $project->client->name }}</div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-weight: 900; font-size: 1.1rem; color: var(--dash-accent);">{{ number_format($project->project_value / 1000, 1) }}k</div>
                        <div style="font-size: 0.6rem; font-weight: 900; color: #059669; text-transform: uppercase;">{{ $project->status }}</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <div class="bento-card activity-card">
            <h2 style="font-size: 1.2rem; font-weight: 800; margin-bottom: 2rem;">Terminal Log</h2>
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                @foreach($recentActivities->take(6) as $activity)
                <div style="display: flex; gap: 15px; position: relative; padding-left: 15px;">
                    <div style="position: absolute; left: 0; top: 0; bottom: 0; width: 2px; background: #f1f1f1;"></div>
                    <div style="position: absolute; left: -4px; top: 6px; width: 10px; height: 10px; border-radius: 50%; background: {{ str_contains($activity->action, 'Approved') ? '#059669' : (str_contains($activity->action, 'Rejected') ? '#ef4444' : 'var(--dash-accent)') }};"></div>
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between;">
                            <div style="font-weight: 800; font-size: 0.9rem;">{{ $activity->action }}</div>
                            <div style="font-size: 0.7rem; font-weight: 600; color: var(--dash-text-sub);">{{ $activity->created_at->diffForHumans() }}</div>
                        </div>
                        <div style="font-size: 0.8rem; color: var(--dash-text-sub); margin-top: 4px; line-height: 1.4;">{{ $activity->description }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script>
(function () {
    Chart.defaults.font.family = "'Outfit', sans-serif";
    Chart.defaults.color = 'rgba(255,255,255,0.4)';

    const heroCtx = document.getElementById('bento-hero-chart');
    if (heroCtx) {
        new Chart(heroCtx, {
            type: 'line',
            data: {
                labels: ['Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr'],
                datasets: [
                    {
                        label: 'Revenue',
                        data: [65, 80, 75, 95, 85, 90],
                        borderColor: '#fff',
                        backgroundColor: 'rgba(255,255,255,0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 0
                    },
                    {
                        label: 'Outflow',
                        data: [45, 70, 60, 80, 95, 85],
                        borderColor: '#ea580c',
                        backgroundColor: 'rgba(234, 88, 12, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 0
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { color: 'rgba(255,255,255,0.3)' } },
                    y: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { display: false } }
                }
            }
        });
    }

    const donutCtx = document.getElementById('bento-donut-chart');
    if (donutCtx) {
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Active', 'Other'],
                datasets: [{
                    data: [{{ $activeProjects }}, {{ max(0, $totalProjects - $activeProjects) }}],
                    backgroundColor: ['#ea580c', '#f1f1f1'],
                    borderWidth: 0,
                    cutout: '85%',
                    spacing: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                animation: { duration: 2500, easing: 'easeOutQuart' }
            }
        });
    }
})();
</script>
@endpush
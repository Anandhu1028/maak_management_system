@extends('layouts.admin')

@section('title', 'Project Management')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon bg-blue-soft">
            <i class="fas fa-tasks"></i>
        </div>
        <div class="stat-info">
            <h3>Total Projects</h3>
            <p>{{ $projects->count() }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-green-soft">
            <i class="fas fa-check-double"></i>
        </div>
        <div class="stat-info">
            <h3>Active</h3>
            <p>{{ $projects->where('status', 'Active')->count() }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-orange-soft">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <h3>On Hold</h3>
            <p>{{ $projects->where('status', 'On Hold')->count() }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-purple-soft">
            <i class="fas fa-flag-checkered"></i>
        </div>
        <div class="stat-info">
            <h3>Completed</h3>
            <p>{{ $projects->where('status', 'Completed')->count() }}</p>
        </div>
    </div>
</div>

<div class="card-premium">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.2rem; font-weight: 600; margin: 0;">Active Projects List</h2>
        <a href="{{ route('admin.projects.create') }}" class="btn-premium">
            <i class="fas fa-plus"></i> New Project
        </a>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 1px solid var(--border);">
                    <th style="padding: 1rem 0.5rem; color: var(--text-muted); font-weight: 500;">Project Name</th>
                    <th style="padding: 1rem 0.5rem; color: var(--text-muted); font-weight: 500;">Type</th>
                    <th style="padding: 1rem 0.5rem; color: var(--text-muted); font-weight: 500;">Client</th>
                    <th style="padding: 1rem 0.5rem; color: var(--text-muted); font-weight: 500;">Value</th>
                    <th style="padding: 1rem 0.5rem; color: var(--text-muted); font-weight: 500;">Progress</th>
                    <th style="padding: 1rem 0.5rem; color: var(--text-muted); font-weight: 500;">Status</th>
                    <th style="padding: 1rem 0.5rem; color: var(--text-muted); font-weight: 500; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                <tr style="border-bottom: 1px solid var(--border); transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                    <td style="padding: 1.2rem 0.5rem;">
                        <div style="font-weight: 600; color: var(--text-main);">{{ $project->name }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $project->site_address }}</div>
                    </td>
                    <td style="padding: 1.2rem 0.5rem;">
                        <span style="padding: 4px 10px; border-radius: 6px; font-size: 0.8rem; font-weight: 500; background: #f1f5f9; color: #475569;">
                            {{ $project->type }}
                        </span>
                    </td>
                    <td style="padding: 1.2rem 0.5rem;">
                        <div style="font-weight: 500;">{{ $project->client->name }}</div>
                    </td>
                    <td style="padding: 1.2rem 0.5rem;">
                        <div style="font-weight: 600; color: var(--primary);">BHD {{ number_format($project->project_value, 3) }}</div>
                    </td>
                    <td style="padding: 1.2rem 0.5rem; width: 150px;">
                        @php
                            $progress = $project->stages->sum(function($stage) {
                                return ($stage->completion_percentage * $stage->weight_percentage) / 100;
                            });
                        @endphp
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 5px;">{{ number_format($progress, 0) }}% Completed</div>
                        <div style="width: 100%; height: 6px; background: #e2e8f0; border-radius: 10px; overflow: hidden;">
                            <div style="width: {{ $progress }}%; height: 100%; background: var(--primary);"></div>
                        </div>
                    </td>
                    <td style="padding: 1.2rem 0.5rem;">
                        <span style="padding: 4px 10px; border-radius: 50px; font-size: 0.75rem; font-weight: 600; 
                            @if($project->status == 'Active') background: #f0fdf4; color: #166534;
                            @elseif($project->status == 'Completed') background: #eff6ff; color: #1e40af;
                            @else background: #fff7ed; color: #9a3412; @endif">
                            {{ $project->status }}
                        </span>
                    </td>
                    <td style="padding: 1.2rem 0.5rem; text-align: right;">
                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                            <a href="{{ route('admin.projects.show', $project) }}" class="btn-premium" style="padding: 6px 10px; background: #f1f5f9; color: #475569;">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.projects.edit', $project) }}" class="btn-premium" style="padding: 6px 10px; background: #eff6ff; color: #2563eb;">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding: 3rem; text-align: center; color: var(--text-muted);">
                        <i class="fas fa-folder-open" style="font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.3;"></i>
                        No projects found. Create your first project to get started.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

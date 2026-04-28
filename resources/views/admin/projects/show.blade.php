@extends('layouts.admin')

@section('title', 'Project Details: ' . $project->name)

@section('content')
<div style="display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 1.5rem;">
    <a href="{{ route('admin.projects.edit', $project) }}" class="btn-premium" style="background: #f1f5f9; color: #475569;">
        <i class="fas fa-edit"></i> Edit Project
    </a>
    <button class="btn-premium" onclick="window.print()">
        <i class="fas fa-print"></i> Export PDF
    </button>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon bg-blue-soft">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div class="stat-info">
            <h3>Project Value</h3>
            <p>BHD {{ number_format($project->project_value, 3) }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-purple-soft">
            <i class="fas fa-hand-holding-usd"></i>
        </div>
        <div class="stat-info">
            <h3>Total Received</h3>
            <p>BHD {{ number_format($project->payments->sum('amount'), 3) }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-orange-soft">
            <i class="fas fa-file-invoice"></i>
        </div>
        <div class="stat-info">
            <h3>Total Expenses</h3>
            @php $approvedExpenses = $project->expenses->where('status', 'Approved')->sum('amount'); @endphp
            <p>BHD {{ number_format($approvedExpenses, 3) }}</p>
        </div>
    </div>
    <div class="stat-card">
        @php $profit = $project->payments->sum('amount') - $approvedExpenses; @endphp
        <div class="stat-icon {{ $profit >= 0 ? 'bg-green-soft' : 'bg-red-soft' }}" style="{{ $profit < 0 ? 'background: #fef2f2; color: #ef4444;' : '' }}">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="stat-info">
            <h3>Real-Time P/L</h3>
            <p>BHD {{ number_format($profit, 3) }}</p>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
    <div>
        <div class="card-premium">
            <h2 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 1.5rem;">Project Stages Workflow</h2>
            
            @foreach($project->stages as $stage)
            @php 
                $stageCost = $stage->expenses->where('status', 'Approved')->sum('amount');
                $clientPaid = $stage->client_payment_amount; // This is the amount client SHOULD pay for this stage
                $balance = $clientPaid - $stageCost;
                $costPercentage = $clientPaid > 0 ? ($stageCost / $clientPaid) * 100 : 0;
            @endphp
            <div style="margin-bottom: 1.5rem; padding: 1.5rem; border-radius: 16px; border: 1px solid var(--border); background: #fff; position: relative; overflow: hidden;">
                <!-- Status Ribbon -->
                <div style="position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: {{ $stage->status == 'In Progress' ? '#0ea5e9' : ($stage->status == 'Completed' ? '#16a34a' : '#64748b') }};"></div>

                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                            <span style="font-size: 0.7rem; font-weight: 800; color: var(--primary); text-transform: uppercase; background: #f1f5f9; padding: 2px 8px; border-radius: 4px;">Stage {{ $loop->iteration }}</span>
                            <span style="padding: 2px 8px; border-radius: 4px; font-size: 0.65rem; font-weight: 700; text-transform: uppercase;
                                @if($stage->status == 'In Progress') background: #e0f2fe; color: #0369a1;
                                @elseif($stage->status == 'Completed') background: #dcfce7; color: #15803d;
                                @else background: #f1f5f9; color: #475569; @endif">
                                {{ $stage->status }}
                            </span>
                        </div>
                        <h3 style="font-size: 1.1rem; font-weight: 600; margin: 0;">{{ $stage->name }}</h3>
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 4px;">
                            <i class="far fa-calendar-alt"></i> {{ $stage->start_date->format('d M') }} - {{ $stage->end_date->format('d M Y') }}
                        </div>
                    </div>
                        <div style="display: flex; gap: 8px;">
                            @if($stage->status !== 'Completed')
                            <form action="{{ route('admin.stages.update-status', $stage) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="Completed">
                                <button type="submit" class="btn-premium" style="padding: 6px 12px; font-size: 0.75rem; background: #fee2e2; color: #991b1b; border: 1px solid #fecaca;">
                                    <i class="fas fa-lock"></i> Close Stage
                                </button>
                            </form>
                            @else
                            <form action="{{ route('admin.stages.update-status', $stage) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="In Progress">
                                <button type="submit" class="btn-premium" style="padding: 6px 12px; font-size: 0.75rem; background: #f1f5f9; color: #475569; border: 1px solid var(--border);">
                                    <i class="fas fa-unlock"></i> Unlock
                                </button>
                            </form>
                            @endif
                            <button class="btn-premium" style="padding: 6px 12px; font-size: 0.75rem; background: #f8fafc; color: #475569; border: 1px solid var(--border);">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <a href="{{ route('admin.expenses.create', ['project_id' => $project->id, 'stage_id' => $stage->id]) }}" class="btn-premium" style="padding: 6px 12px; font-size: 0.75rem; background: var(--primary); color: #fff;">
                                <i class="fas fa-plus"></i> Log Expense
                            </a>
                        </div>
                </div>

                <!-- Financial Progress Bar -->
                <div style="margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.8rem; margin-bottom: 8px;">
                        <span style="font-weight: 600;">Spending vs Client Payment</span>
                        <span style="font-weight: 700; color: {{ $costPercentage >= 100 ? '#ef4444' : ($costPercentage >= 80 ? '#f59e0b' : 'inherit') }}">
                            {{ number_format($costPercentage, 1) }}%
                        </span>
                    </div>
                    <div style="width: 100%; height: 10px; background: #f1f5f9; border-radius: 10px; overflow: hidden;">
                        <div style="width: {{ min($costPercentage, 100) }}%; height: 100%; transition: width 0.5s ease; background: {{ $costPercentage >= 100 ? '#ef4444' : ($costPercentage >= 80 ? '#f59e0b' : 'var(--primary)') }};"></div>
                    </div>
                </div>

                <!-- Alerts -->
                @if($costPercentage >= 100)
                <div style="margin-bottom: 1.5rem; padding: 10px 15px; background: #fef2f2; border: 1px solid #fee2e2; border-radius: 8px; color: #991b1b; font-size: 0.8rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-exclamation-circle"></i>
                    <strong>CRITICAL:</strong> Over-expense detected! Spending has exceeded the client payment for this stage.
                </div>
                @elseif($costPercentage >= 80)
                <div style="margin-bottom: 1.5rem; padding: 10px 15px; background: #fffbeb; border: 1px solid #fef3c7; border-radius: 8px; color: #92400e; font-size: 0.8rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>WARNING:</strong> 80% spending reached. Budget nearing exhaustion for this stage.
                </div>
                @endif

                <!-- Stats Grid -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;">
                    <div style="background: #f8fafc; padding: 1rem; border-radius: 12px;">
                        <div style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 5px;">Int. Budget</div>
                        <div style="font-weight: 700; color: var(--text-main);">BHD {{ number_format($stage->budget, 3) }}</div>
                    </div>
                    <div style="background: #f8fafc; padding: 1rem; border-radius: 12px;">
                        <div style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 5px;">Client Payment</div>
                        <div style="font-weight: 700; color: #16a34a;">BHD {{ number_format($clientPaid, 3) }}</div>
                    </div>
                    <div style="background: #f8fafc; padding: 1rem; border-radius: 12px;">
                        <div style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 5px;">Actual Expense</div>
                        <div style="font-weight: 700; color: {{ $stageCost > $clientPaid ? '#ef4444' : 'inherit' }}">BHD {{ number_format($stageCost, 3) }}</div>
                    </div>
                    <div style="background: {{ $balance >= 0 ? '#f0fdf4' : '#fef2f2' }}; padding: 1rem; border-radius: 12px; border: 1px solid {{ $balance >= 0 ? '#dcfce7' : '#fee2e2' }};">
                        <div style="font-size: 0.7rem; color: {{ $balance >= 0 ? '#166534' : '#991b1b' }}; text-transform: uppercase; font-weight: 700; margin-bottom: 5px;">Remaining Balance</div>
                        <div style="font-weight: 800; color: {{ $balance >= 0 ? '#15803d' : '#ef4444' }};">BHD {{ number_format($balance, 3) }}</div>
                    </div>
                </div>

                <!-- Progress Section -->
                <div style="margin-top: 1.5rem; display: flex; align-items: center; justify-content: space-between; padding-top: 1rem; border-top: 1px solid #f1f5f9;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="font-size: 0.85rem; font-weight: 600;">Work Completion</div>
                        <div style="width: 150px; height: 6px; background: #f1f5f9; border-radius: 10px; overflow: hidden;">
                            <div style="width: {{ $stage->completion_percentage }}%; height: 100%; background: #16a34a;"></div>
                        </div>
                        <span style="font-size: 0.85rem; font-weight: 700;">{{ $stage->completion_percentage }}%</span>
                    </div>
                    <button type="button" onclick="toggleExpenses('expenses-{{ $stage->id }}')" style="font-size: 0.75rem; font-weight: 600; color: var(--primary); background: none; border: none; cursor: pointer;">
                        <i class="fas fa-list"></i> View Expenses ({{ $stage->expenses->count() }})
                    </button>
                </div>

                <!-- Detailed Expense List (Hidden by default) -->
                <div id="expenses-{{ $stage->id }}" style="display: none; margin-top: 1rem; padding: 1rem; background: #f8fafc; border-radius: 12px; border: 1px solid var(--border);">
                    <h4 style="font-size: 0.85rem; font-weight: 700; margin-bottom: 1rem; color: #475569;">Stage Expense Breakdown</h4>
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.8rem;">
                        <thead>
                            <tr style="text-align: left; border-bottom: 1px solid #e2e8f0;">
                                <th style="padding: 8px 0; font-weight: 600; color: #64748b;">Date</th>
                                <th style="padding: 8px 0; font-weight: 600; color: #64748b;">Category</th>
                                <th style="padding: 8px 0; font-weight: 600; color: #64748b;">Logged By</th>
                                <th style="padding: 8px 0; font-weight: 600; color: #64748b;">Status</th>
                                <th style="padding: 8px 0; font-weight: 600; color: #64748b; text-align: right;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stage->expenses as $expense)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 10px 0;">{{ $expense->date->format('d M Y') }}</td>
                                <td style="padding: 10px 0; font-weight: 500;">{{ $expense->category }}</td>
                                <td style="padding: 10px 0;">{{ $expense->user->name ?? 'System' }}</td>
                                <td style="padding: 10px 0;">
                                    <span style="padding: 2px 6px; border-radius: 4px; font-size: 0.65rem; font-weight: 700;
                                        {{ $expense->status == 'Approved' ? 'background: #dcfce7; color: #15803d;' : 'background: #fffbeb; color: #92400e;' }}">
                                        {{ $expense->status }}
                                    </span>
                                </td>
                                <td style="padding: 10px 0; text-align: right; font-weight: 700;">BHD {{ number_format($expense->amount, 3) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="padding: 1.5rem; text-align: center; color: var(--text-muted);">No expenses logged for this stage.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div>
        <div class="card-premium">
            <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1.5rem;">Client Information</h2>
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 1.5rem;">
                <div style="width: 50px; height: 50px; border-radius: 12px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: var(--primary);">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <div style="font-weight: 600;">{{ $project->client->name }}</div>
                    <div style="font-size: 0.85rem; color: var(--text-muted);">{{ $project->client->email }}</div>
                </div>
            </div>
            <div style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 5px;">Phone</div>
            <div style="font-weight: 500; margin-bottom: 1rem;">{{ $project->client->phone ?? 'N/A' }}</div>
            
            <div style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 5px;">Site Address</div>
            <div style="font-weight: 500; line-height: 1.5; margin-bottom: 1rem;">{{ $project->site_address }}</div>
            
            <div style="width: 100%; height: 200px; border-radius: 12px; overflow: hidden; border: 1px solid var(--border);">
                <iframe 
                    width="100%" 
                    height="100%" 
                    frameborder="0" 
                    style="border:0" 
                    src="https://maps.google.com/maps?q={{ urlencode($project->site_address) }}&t=&z=13&ie=UTF8&iwloc=&output=embed" 
                    allowfullscreen>
                </iframe>
            </div>
        </div>

        <div class="card-premium">
            <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1.5rem;">Assigned Supervisors</h2>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                @forelse($project->supervisors as $supervisor)
                <div style="display: flex; align-items: center; gap: 10px; padding: 10px; background: #f8fafc; border-radius: 8px; border: 1px solid var(--border);">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 600;">
                        {{ substr($supervisor->name, 0, 1) }}
                    </div>
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 600;">{{ $supervisor->name }}</div>
                        <div style="font-size: 0.7rem; color: var(--text-muted);">{{ $supervisor->phone ?? 'No Phone' }}</div>
                    </div>
                </div>
                @empty
                <p style="font-size: 0.85rem; color: var(--text-muted); text-align: center;">No supervisors assigned.</p>
                @endforelse
            </div>
        </div>

        <div class="card-premium">
            <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1.5rem;">Project Documents</h2>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                @forelse($project->documents as $doc)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px; background: #f8fafc; border-radius: 8px; border: 1px solid var(--border);">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-file-pdf" style="color: #ef4444;"></i>
                        <span style="font-size: 0.85rem; font-weight: 500;">{{ $doc->file_name }}</span>
                    </div>
                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn-premium" style="padding: 5px 10px; font-size: 0.75rem; background: #fff; color: var(--primary);">
                        <i class="fas fa-download"></i>
                    </a>
                </div>
                @empty
                <p style="font-size: 0.85rem; color: var(--text-muted); text-align: center;">No documents uploaded.</p>
                @endforelse
            </div>
        </div>

        <div class="card-premium">
            <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1.5rem;">Quick Actions</h2>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <button class="btn-premium" style="width: 100%; background: #f8fafc; color: #475569; border: 1px solid var(--border);">
                    <i class="fas fa-plus-circle"></i> Add Payment
                </button>
                <button class="btn-premium" style="width: 100%; background: #f8fafc; color: #475569; border: 1px solid var(--border);">
                    <i class="fas fa-receipt"></i> Log Admin Expense
                </button>
                <button class="btn-premium" style="width: 100%; background: #f8fafc; color: #475569; border: 1px solid var(--border);">
                    <i class="fas fa-exclamation-circle"></i> Pause Project
                </button>
            </div>
        </div>
    </div>
</div>

<div class="card-premium">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.2rem; font-weight: 600; margin: 0;">Recent Work Logs & Photos</h2>
        <a href="#" style="font-size: 0.85rem; color: var(--primary); font-weight: 600;">View All Logs</a>
    </div>

    @forelse($project->workLogs->take(5) as $log)
    <div style="padding: 1rem; border-bottom: 1px solid var(--border);">
        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
            <div style="font-weight: 600;">{{ $log->date->format('d M Y') }} - {{ $log->user->name }}</div>
            <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $log->stage->name }}</div>
        </div>
        <p style="font-size: 0.9rem; margin-bottom: 1rem; line-height: 1.6;">{{ $log->description }}</p>
        
        @if($log->photos->count() > 0)
        <div style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 10px;">
            @foreach($log->photos as $photo)
            <img src="{{ asset('storage/' . $photo->photo_path) }}" style="width: 120px; height: 120px; object-fit: cover; border-radius: 10px; border: 1px solid var(--border);">
            @endforeach
        </div>
        @endif
    </div>
    @empty
    <div style="text-align: center; padding: 2rem; color: var(--text-muted);">No work logs recorded yet.</div>
    @endforelse
</div>
@endsection

@push('scripts')
<script>
    function toggleExpenses(id) {
        const el = document.getElementById(id);
        if (el.style.display === 'none') {
            el.style.display = 'block';
            el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } else {
            el.style.display = 'none';
        }
    }
</script>
@endpush

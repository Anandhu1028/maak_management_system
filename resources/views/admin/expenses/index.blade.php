@extends('layouts.admin')

@section('title', 'Expense Management')

@section('content')
<div style="margin-bottom: 2rem;">
    <div style="display: flex; gap: 1rem; border-bottom: 1px solid var(--border); padding-bottom: 1px;">
        <button onclick="switchTab('project')" id="tab-project" class="tab-btn active" style="padding: 12px 24px; border: none; background: none; font-weight: 600; cursor: pointer; position: relative; font-family: inherit; font-size: 0.95rem; transition: all 0.2s ease;">
            <i class="fas fa-project-diagram" style="margin-right: 8px;"></i> Project Expenses
        </button>
        <button onclick="switchTab('company')" id="tab-company" class="tab-btn" style="padding: 12px 24px; border: none; background: none; font-weight: 600; cursor: pointer; color: var(--text-muted); position: relative; font-family: inherit; font-size: 0.95rem; transition: all 0.2s ease;">
            <i class="fas fa-building" style="margin-right: 8px;"></i> Company Overheads
        </button>
    </div>
</div>

<style>
    .tab-btn.active { color: var(--primary); }
    .tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        height: 3px;
        background: var(--primary);
        border-radius: 10px 10px 0 0;
    }
    .tab-btn:hover:not(.active) { color: var(--text-main); }
</style>

<!-- Project Expenses Tab -->
<div id="section-project" class="expense-section">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div>
            <h2 style="font-size: 1.2rem; font-weight: 600; margin: 0;">Project-Based Ledger</h2>
            <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 4px;">Operational costs tied strictly to construction stages.</p>
        </div>
        <a href="{{ route('admin.expenses.create') }}" class="btn-premium">
            <i class="fas fa-plus"></i> New Project Expense
        </a>
    </div>

    <div class="card-premium" style="padding: 0; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; text-align: left; border-bottom: 1px solid var(--border);">
                    <th style="padding: 1.2rem 1rem; font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Date</th>
                    <th style="padding: 1.2rem 1rem; font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Project / Stage</th>
                    <th style="padding: 1.2rem 1rem; font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Category</th>
                    <th style="padding: 1.2rem 1rem; font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Amount</th>
                    <th style="padding: 1.2rem 1rem; font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Status</th>
                    <th style="padding: 1.2rem 1rem; font-size: 0.85rem; color: var(--text-muted); font-weight: 600; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projectExpenses as $expense)
                <tr style="border-bottom: 1px solid var(--border); transition: all 0.2s ease;" onmouseover="this.style.background='#fcfcfc'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 1.2rem 1rem; font-size: 0.9rem;">{{ $expense->date->format('d M Y') }}</td>
                    <td style="padding: 1.2rem 1rem;">
                        <div style="font-weight: 600; font-size: 0.9rem; color: var(--text-main);">{{ $expense->project->name }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $expense->stage->name }}</div>
                    </td>
                    <td style="padding: 1.2rem 1rem;">
                        <span style="font-size: 0.85rem; padding: 4px 8px; background: #f1f5f9; border-radius: 6px; font-weight: 500;">{{ $expense->category }}</span>
                    </td>
                    <td style="padding: 1.2rem 1rem; font-weight: 700; color: #ef4444;">BHD {{ number_format($expense->amount, 3) }}</td>
                    <td style="padding: 1.2rem 1rem;">
                        <span style="padding: 4px 10px; border-radius: 50px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
                            @if($expense->status == 'Approved') background: #dcfce7; color: #166534;
                            @elseif($expense->status == 'Rejected') background: #fee2e2; color: #991b1b;
                            @else background: #fef9c3; color: #854d0e; @endif">
                            {{ $expense->status }}
                        </span>
                    </td>
                    <td style="padding: 1.2rem 1rem; text-align: right;">
                        @if($expense->status == 'Unverified')
                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                            <form action="{{ route('admin.expenses.approve', $expense) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn-premium" style="padding: 6px 10px; background: #dcfce7; color: #166534; border: none; cursor: pointer;" title="Approve">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.expenses.reject', $expense) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn-premium" style="padding: 6px 10px; background: #fee2e2; color: #991b1b; border: none; cursor: pointer;" title="Reject">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                        @else
                            <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">
                                <i class="fas fa-check-double" style="color: #16a34a;"></i> Verified
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 4rem; text-align: center; color: var(--text-muted);">
                        <i class="fas fa-receipt" style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.2;"></i>
                        <p>No project-based expenses found.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Company Expenses Tab -->
<div id="section-company" class="expense-section" style="display: none;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div>
            <h2 style="font-size: 1.2rem; font-weight: 600; margin: 0;">Company Overhead Ledger</h2>
            <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 4px;">Fixed and variable costs not linked to specific projects.</p>
        </div>
        <button class="btn-premium">
            <i class="fas fa-plus"></i> New Company Expense
        </button>
    </div>

    <div class="card-premium" style="padding: 0; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; text-align: left; border-bottom: 1px solid var(--border);">
                    <th style="padding: 1.2rem 1rem; font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Date</th>
                    <th style="padding: 1.2rem 1rem; font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Category</th>
                    <th style="padding: 1.2rem 1rem; font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Description</th>
                    <th style="padding: 1.2rem 1rem; font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Amount</th>
                    <th style="padding: 1.2rem 1rem; font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($companyExpenses as $expense)
                <tr style="border-bottom: 1px solid var(--border);">
                    <td style="padding: 1.2rem 1rem; font-size: 0.9rem;">{{ $expense->date->format('d M Y') }}</td>
                    <td style="padding: 1.2rem 1rem;"><span style="font-weight: 600; font-size: 0.9rem;">{{ $expense->category }}</span></td>
                    <td style="padding: 1.2rem 1rem; font-size: 0.85rem; color: var(--text-muted);">{{ $expense->description }}</td>
                    <td style="padding: 1.2rem 1rem; font-weight: 700; color: #ef4444;">BHD {{ number_format($expense->amount, 3) }}</td>
                    <td style="padding: 1.2rem 1rem;">
                        <span style="padding: 4px 10px; border-radius: 50px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
                            @if($expense->status == 'Approved') background: #dcfce7; color: #166534;
                            @else background: #fef9c3; color: #854d0e; @endif">
                            {{ $expense->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 4rem; text-align: center; color: var(--text-muted);">
                        <i class="fas fa-building" style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.2;"></i>
                        <p>No company overheads recorded yet.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function switchTab(type) {
        document.querySelectorAll('.expense-section').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.tab-btn').forEach(el => {
            el.classList.remove('active');
            el.style.color = 'var(--text-muted)';
        });

        document.getElementById('section-' + type).style.display = 'block';
        document.getElementById('tab-' + type).classList.add('active');
        document.getElementById('tab-' + type).style.color = 'var(--primary)';
    }
</script>
@endsection

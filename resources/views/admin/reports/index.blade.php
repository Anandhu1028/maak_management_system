@extends('layouts.admin')

@section('title', 'Reports & Analytics')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon bg-blue-soft">
            <i class="fas fa-file-pdf"></i>
        </div>
        <div class="stat-info">
            <h3 style="font-size: 1rem; font-weight: 600;">Monthly P&L Report</h3>
            <p style="font-size: 0.8rem; font-weight: 400; color: var(--text-muted);">Generate full financial summary for this month.</p>
            <a href="#" class="btn-premium" style="margin-top: 10px; padding: 5px 10px; font-size: 0.8rem;">Download PDF</a>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-green-soft">
            <i class="fas fa-file-excel"></i>
        </div>
        <div class="stat-info">
            <h3 style="font-size: 1rem; font-weight: 600;">Project Cost Analysis</h3>
            <p style="font-size: 0.8rem; font-weight: 400; color: var(--text-muted);">Detailed budget vs actual cost per stage.</p>
            <a href="#" class="btn-premium" style="margin-top: 10px; padding: 5px 10px; font-size: 0.8rem;">Export Excel</a>
        </div>
    </div>
</div>

<div class="card-premium">
    <h2 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 2rem;">Custom Report Generator</h2>
    
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; align-items: flex-end;">
        <div>
            <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Report Type</label>
            <select class="form-control" style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
                <option>Expense Summary</option>
                <option>Payment Tracking</option>
                <option>Supervisor Attendance</option>
                <option>Investor Returns</option>
            </select>
        </div>
        <div>
            <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Date Range</label>
            <input type="text" class="form-control" placeholder="Select dates..." style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
        </div>
        <div>
            <button class="btn-premium" style="width: 100%; justify-content: center; padding: 0.8rem;">
                <i class="fas fa-magic"></i> Generate Report
            </button>
        </div>
    </div>
</div>
@endsection

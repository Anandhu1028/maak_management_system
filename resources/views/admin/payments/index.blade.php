@extends('layouts.admin')

@section('title', 'Client Payments')

@section('content')
<div class="card-premium">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.2rem; font-weight: 600; margin: 0;">Payment Records</h2>
        <a href="{{ route('admin.payments.create') }}" class="btn-premium">
            <i class="fas fa-plus"></i> Record New Payment
        </a>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 1px solid var(--border);">
                    <th style="padding: 1rem 0.5rem; color: var(--text-muted); font-weight: 500;">Date</th>
                    <th style="padding: 1rem 0.5rem; color: var(--text-muted); font-weight: 500;">Project / Stage</th>
                    <th style="padding: 1rem 0.5rem; color: var(--text-muted); font-weight: 500;">Type</th>
                    <th style="padding: 1rem 0.5rem; color: var(--text-muted); font-weight: 500;">Method</th>
                    <th style="padding: 1rem 0.5rem; color: var(--text-muted); font-weight: 500;">Amount</th>
                    <th style="padding: 1rem 0.5rem; color: var(--text-muted); font-weight: 500; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr style="border-bottom: 1px solid var(--border);">
                    <td style="padding: 1.2rem 0.5rem; font-size: 0.9rem;">{{ $payment->date->format('d M Y') }}</td>
                    <td style="padding: 1.2rem 0.5rem;">
                        <div style="font-weight: 600;">{{ $payment->project->name }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $payment->stage ? $payment->stage->name : 'N/A' }}</div>
                    </td>
                    <td style="padding: 1.2rem 0.5rem;">
                        <span style="padding: 4px 10px; border-radius: 6px; font-size: 0.8rem; font-weight: 500; background: #f1f5f9; color: #475569;">
                            {{ $payment->type }}
                        </span>
                    </td>
                    <td style="padding: 1.2rem 0.5rem; font-size: 0.9rem;">
                        {{ $payment->method }}
                    </td>
                    <td style="padding: 1.2rem 0.5rem;">
                        <div style="font-weight: 700; color: #16a34a;">BHD {{ number_format($payment->amount, 3) }}</div>
                    </td>
                    <td style="padding: 1.2rem 0.5rem; text-align: right;">
                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                            <a href="#" class="btn-premium" style="padding: 6px 10px; background: #f1f5f9; color: #475569;">
                                <i class="fas fa-file-invoice"></i>
                            </a>
                            <a href="{{ route('admin.payments.edit', $payment) }}" class="btn-premium" style="padding: 6px 10px; background: #eff6ff; color: #2563eb;">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 3rem; text-align: center; color: var(--text-muted);">No payments recorded yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

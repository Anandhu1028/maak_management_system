@extends('layouts.admin')

@section('title', $title ?? 'User Management')

@section('content')
<div class="card-premium">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.2rem; font-weight: 600; margin: 0;">{{ $title ?? 'All Users' }}</h2>
        <a href="{{ route('admin.users.create') }}" class="btn-premium">
            <i class="fas fa-user-plus"></i> Add New User
        </a>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 1px solid var(--border);">
                    <th style="padding: 1rem 0.5rem; color: var(--text-muted); font-weight: 500;">User Info</th>
                    <th style="padding: 1rem 0.5rem; color: var(--text-muted); font-weight: 500;">Role</th>
                    <th style="padding: 1rem 0.5rem; color: var(--text-muted); font-weight: 500;">Phone</th>
                    <th style="padding: 1rem 0.5rem; color: var(--text-muted); font-weight: 500;">Status</th>
                    <th style="padding: 1rem 0.5rem; color: var(--text-muted); font-weight: 500; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr style="border-bottom: 1px solid var(--border);">
                    <td style="padding: 1.2rem 0.5rem;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 40px; height: 40px; border-radius: 10px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--primary);">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--text-main);">{{ $user->name }}</div>
                                <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 1.2rem 0.5rem;">
                        <span style="padding: 4px 10px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; text-transform: uppercase;
                            @if($user->role == 'admin') background: #fee2e2; color: #991b1b;
                            @elseif($user->role == 'supervisor') background: #fef9c3; color: #854d0e;
                            @elseif($user->role == 'client') background: #dcfce7; color: #166534;
                            @else background: #f1f5f9; color: #475569; @endif">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td style="padding: 1.2rem 0.5rem; font-size: 0.9rem;">
                        {{ $user->phone ?? '---' }}
                    </td>
                    <td style="padding: 1.2rem 0.5rem;">
                        @if($user->is_active)
                            <span style="color: #16a34a;"><i class="fas fa-check-circle"></i> Active</span>
                        @else
                            <span style="color: #94a3b8;"><i class="fas fa-times-circle"></i> Inactive</span>
                        @endif
                    </td>
                    <td style="padding: 1.2rem 0.5rem; text-align: right;">
                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn-premium" style="padding: 6px 10px; background: #eff6ff; color: #2563eb; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-premium" style="padding: 6px 10px; background: #fff1f2; color: #e11d48; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

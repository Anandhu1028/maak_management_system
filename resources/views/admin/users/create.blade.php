@extends('layouts.admin')

@section('title', 'Add New User')

@section('content')
<div class="card-premium" style="max-width: 600px; margin: 0 auto;">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Full Name</label>
            <input type="text" name="name" class="form-control" required style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Email Address</label>
            <input type="email" name="email" class="form-control" required style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Password</label>
            <input type="password" name="password" class="form-control" required style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Role</label>
                <select name="role" class="form-control" required style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
                    <option value="admin">Admin</option>
                    <option value="supervisor">Supervisor</option>
                    <option value="client">Client</option>
                    <option value="partner">Partner</option>
                    <option value="investor">Investor</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Phone Number</label>
                <input type="text" name="phone" class="form-control" style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 2rem;">
            <button type="submit" class="btn-premium" style="flex: 1; justify-content: center;">
                <i class="fas fa-save"></i> Save User
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn-premium" style="background: #f1f5f9; color: #475569; justify-content: center;">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection

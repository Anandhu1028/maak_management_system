@extends('layouts.admin')

@section('title', 'System Settings')

@section('content')
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem;">
    <div>
        <div class="card-premium" style="padding: 0;">
            <div style="padding: 1.5rem; border-bottom: 1px solid var(--border); background: var(--sidebar-active-bg); color: #fff; border-radius: 16px 16px 0 0;">
                <h3 style="margin: 0; font-size: 1rem;">Setting Categories</h3>
            </div>
            <div style="padding: 0.5rem;">
                <a href="#" class="nav-item active" style="margin: 5px; color: inherit;">General Settings</a>
                <a href="#" class="nav-item" style="margin: 5px; color: inherit;">Alert Configurations</a>
                <a href="#" class="nav-item" style="margin: 5px; color: inherit;">Company Details</a>
                <a href="#" class="nav-item" style="margin: 5px; color: inherit;">Backup & Security</a>
            </div>
        </div>
    </div>

    <div>
        <div class="card-premium">
            <h2 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 2rem;">General System Settings</h2>
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Company Name</label>
                <input type="text" class="form-control" value="MAAK Construction" style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Currency Symbol</label>
                <input type="text" class="form-control" value="BHD" style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Early Budget Warning (%)</label>
                    <input type="number" class="form-control" value="80" style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
                </div>
                <div>
                    <label style="display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">Hard Alert Threshold (%)</label>
                    <input type="number" class="form-control" value="20" style="width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border);">
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 2rem;">
                <button class="btn-premium">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

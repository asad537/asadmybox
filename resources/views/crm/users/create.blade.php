@extends('crm.layout')

@section('title', 'Add User')

@section('content')
<style>
    .content-card {
        background: var(--card-bg);
        border-radius: var(--border-radius-base);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: none;
        padding: 2.5rem;
        max-width: 600px;
        margin: 0 auto;
    }
    .form-group { margin-bottom: 1.5rem; }
    .form-label { display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.9rem; color: #475569; }
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.95rem;
        outline: none;
        transition: all 0.2s;
        box-sizing: border-box;
    }
    .form-control:focus { border-color: var(--primary-purple); ring: 2px solid var(--primary-purple); }
    
    .btn {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-size: 0.95rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: 1px solid transparent;
        transition: all 0.2s;
    }
    .btn-primary { background: var(--primary-purple); color: white; border-color: var(--primary-purple); }
    .btn-primary:hover { background: #5b4bc4; }
    .btn-light { background: white; border: 1px solid #cbd5e1; color: #475569; }
    .btn-light:hover { background: #f1f5f9; }
    
    .error-list {
        background: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;
    }
</style>

<div class="content-card">
    <h2 style="margin-top: 0; margin-bottom: 2rem; color: #1e293b; font-size: 1.5rem;">Create New User</h2>

    @if ($errors->any())
        <div class="error-list">
            <ul style="padding-left: 1.5rem; margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('crm.users.store') }}" method="POST">
        {{ csrf_field() }}
        
        <div class="form-group">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" required class="form-control" placeholder="e.g. John Doe">
        </div>

        <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" required class="form-control" placeholder="john@example.com">
        </div>

        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" required class="form-control" placeholder="••••••••">
        </div>

        <div class="form-group">
            <label class="form-label">Role</label>
            <div style="position: relative;">
                <select name="role" class="form-control" style="appearance: none;">
                    <option value="sales">Sales Team</option>
                    <option value="admin">Administrator</option>
                </select>
                <i class="fas fa-chevron-down" style="position: absolute; right: 1rem; top: 1rem; color: #94a3b8; pointer-events: none;"></i>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Allowed IP Address (Optional)</label>
            <input type="text" name="allowed_ip" class="form-control" placeholder="e.g. 192.168.1.1">
            <small style="color: #64748b; font-size: 0.85rem; margin-top: 0.25rem; display: block;">If set, this user will ONLY be able to access the CRM from this IP address.</small>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2.5rem;">
            <button type="submit" class="btn btn-primary">Create User</button>
            <a href="{{ route('crm.users.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </form>
</div>
@endsection

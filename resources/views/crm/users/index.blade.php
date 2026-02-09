@extends('crm.layout')

@section('title', 'Sales Team')

@section('content')
<style>
    .user-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .contact-card {
        background: var(--card-bg);
        border-radius: var(--border-radius-base);
        padding: 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid transparent;
    }
    .contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        border-color: #e2e8f0;
    }

    .card-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #e0e7ff;
        color: var(--primary-purple);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
        box-shadow: 0 4px 6px -1px rgba(108, 92, 231, 0.2);
        overflow: hidden;
    }
    .card-avatar img { width: 100%; height: 100%; object-fit: cover; }

    .card-name { font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 0.25rem; }
    .card-email { font-size: 0.9rem; color: #64748b; margin-bottom: 1rem; }
    
    .badge {
        display: inline-flex;
        padding: 0.35rem 0.85rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        margin-bottom: 1.5rem;
    }
    .badge-admin { background: #fee2e2; color: #ef4444; } /* Distinct Red for Admin Security */
    .badge-sales { background: #e0e7ff; color: var(--primary-purple); }

    .btn {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        border: 1px solid transparent;
        transition: all 0.2s;
    }
    .btn-primary { background: var(--primary-purple); color: white; border-color: var(--primary-purple); }
    .btn-primary:hover { background: #5b4bc4; }
    .btn-danger-soft { background: #fee2e2; color: #ef4444; width: 100%; justify-content: center; }
    .btn-danger-soft:hover { background: #fecaca; }
</style>

<div style="display: flex; justify-content: flex-end; margin-bottom: 2rem;">
    <a href="{{ route('crm.users.create') }}" class="btn btn-primary" style="padding: 0.75rem 1.5rem; box-shadow: 0 4px 12px rgba(108, 92, 231, 0.3);">
        <i class="fas fa-plus" style="margin-right: 8px;"></i> Add Team Member
    </a>
</div>

<div class="user-grid">
    @forelse($users as $user)
    <div class="contact-card">
        <div class="card-avatar">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        
        <div class="card-name">{{ $user->name }}</div>
        <span class="badge {{ $user->isAdmin() ? 'badge-admin' : 'badge-sales' }}">
            {{ $user->isAdmin() ? 'Administrator' : 'Sales Agent' }}
        </span>
        
        <div class="card-email">
            <i class="far fa-envelope" style="margin-right: 5px;"></i> {{ $user->email }}
        </div>
        
        @if(Auth::guard('crm')->user()->isAdmin())
            <div style="margin-top: auto; width: 100%;">
                @if(Auth::guard('crm')->id() !== $user->id)
                <form action="{{ route('crm.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Delete this user?');">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger-soft">
                        <i class="fas fa-trash-alt" style="margin-right: 6px;"></i> Remove User
                    </button>
                </form>
                @else
                <div style="font-size: 0.8rem; color: #cbd5e1; padding: 0.5rem;">Current Session</div>
                @endif
            </div>
        @endif
    </div>
    @empty
    <div style="grid-column: 1 / -1; text-align: center; padding: 4rem; color: #94a3b8;">
        <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.2;"></i>
        <p>No team members found.</p>
    </div>
    @endforelse
</div>

<div style="margin-top: 2rem;">
    {{ $users->links() }}
</div>
@endsection

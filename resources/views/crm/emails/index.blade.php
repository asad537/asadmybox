@extends('crm.layout')

@section('title', 'Inbox')

@section('header_actions')
<button type="button" onclick="refreshInbox()" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
    <i class="fas fa-sync-alt" style="margin-right: 8px;"></i> Refresh
</button>
@endsection

@section('content')
<style>
    /* Consistent Theme Styles - Reused from Leads/Dashboard */
    .content-card {
        background: var(--card-bg);
        border-radius: var(--border-radius-base);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: none;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    .filter-card {
        background: var(--card-bg);
        border-radius: var(--border-radius-base);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: none;
    }

    .table-responsive { overflow-x: auto; }
    .table { width: 100%; border-collapse: separate; border-spacing: 0; font-size: 0.9rem; }
    .table th {
        background: #f8fafc;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
    }
    .table td { padding: 1rem; border-bottom: 1px solid #f1f5f9; color: #334155; vertical-align: middle; }
    .table tr:hover td { background: #f8fafc; }
    .table tr:last-child td { border-bottom: none; }

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
    .btn-danger { background: #fee2e2; color: #ef4444; border: 1px solid #fecaca; }
    .btn-danger:hover { background: #fecaca; }
    .btn-light { background: white; border: 1px solid #cbd5e1; color: #475569; }
    .btn-light:hover { background: #f1f5f9; }
    .btn-active { background: #e0e7ff; color: var(--primary-purple); border: 1px solid #c7d2fe; }

    input, select {
        font-size: 0.9rem !important; 
        padding: 0.6rem !important; 
        border: 1px solid #cbd5e1 !important;
        border-radius: 10px !important;
        outline: none;
        background: white;
    }
    input:focus, select:focus { border-color: var(--primary-purple) !important; ring: 2px solid var(--primary-purple); }
</style>

<!-- Filters -->
<div class="filter-card">
    <form action="{{ route('crm.emails.index') }}" method="GET" style="display: flex; gap: 1.5rem; align-items: end; flex-wrap: wrap;">
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <label style="font-size: 0.85rem; font-weight: 600; color: #475569;">Date Range</label>
            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ route('crm.emails.index', array_merge(request()->all(), ['date_filter' => 'today'])) }}" class="btn {{ request('date_filter') == 'today' ? 'btn-active' : 'btn-light' }}">Today</a>
                <a href="{{ route('crm.emails.index', array_merge(request()->all(), ['date_filter' => 'yesterday'])) }}" class="btn {{ request('date_filter') == 'yesterday' ? 'btn-active' : 'btn-light' }}">Yesterday</a>
                <a href="{{ route('crm.emails.index', array_merge(request()->all(), ['date_filter' => 'this_week'])) }}" class="btn {{ request('date_filter') == 'this_week' ? 'btn-active' : 'btn-light' }}">Week</a>
            </div>
        </div>

         <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <label style="font-size: 0.85rem; font-weight: 600; color: #475569;">Status</label>
            <select name="status" onchange="this.form.submit()" style="width: 150px;">
                <option value="">All Statuses</option>
                <option value="New" {{ request('status') == 'New' ? 'selected' : '' }}>Unread</option>
                <option value="Viewed" {{ request('status') == 'Viewed' ? 'selected' : '' }}>Read</option>
                <option value="Responded" {{ request('status') == 'Responded' ? 'selected' : '' }}>Replied</option>
                <option value="Order Done" {{ request('status') == 'Order Done' ? 'selected' : '' }}>Order Completed</option>
                <option value="Closed" {{ request('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>

         <div style="margin-bottom: 2px;">
             <a href="{{ route('crm.emails.index') }}" class="btn btn-light" style="height: 37px;">Clear Filters</a>
        </div>
    </form>
</div>

<!-- Table -->
<div class="content-card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Subject</th>
                    <th>Client</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($emails as $index => $email)
                <tr>
                    <td style="color:#94a3b8; font-weight:500;">
                        {{ $emails->firstItem() + $index }}
                    </td>
                    <td style="font-weight: 600; color: #1e293b;">
                        @if($email->status == 'New') <span style="font-size:8px; vertical-align:middle; margin-right:6px; color:#3b82f6;"><i class="fas fa-circle"></i></span> @endif
                        {{ Str::limit($email->subject, 35) ?: 'No Subject' }}
                    </td>
                    <td>
                        <div style="font-weight: 500; display: flex; align-items: center; gap: 5px; white-space: nowrap;">
                            {{ $email->client_name }}
                            @if($email->customer_type == 'RC')
                                <span title="Returning Customer" style="background:#eff6ff; color:#3b82f6; font-size: 0.65rem; padding: 1px 5px; border-radius: 4px; border: 1px solid #dbeafe;">R</span>
                            @else
                                <span title="New Customer" style="background:#f0fdf4; color:#16a34a; font-size: 0.65rem; padding: 1px 5px; border-radius: 4px; border: 1px solid #dcfce7;">N</span>
                            @endif
                        </div>
                        <div style="font-size: 0.8rem; color: #64748b;">{{ $email->client_email }}</div>
                    </td>
                    <td>
                        <span style="background:#f1f5f9; padding:4px 8px; border-radius:6px; font-size:0.8rem; color:#475569; white-space: nowrap;">
                            {{ Str::limit($email->product_name, 20) ?: 'General' }}
                        </span>
                    </td>
                    <td style="font-size: 0.9rem; color: #1e293b; font-weight: 600;">{{ $email->quantity ?: '-' }}</td>
                    <td style="font-size: 0.85rem; color: #64748b;">{{ $email->created_at->format('M d, H:i') }}</td>
                    <td>
                        <form action="{{ route('crm.emails.status', $email->id) }}" method="POST">
                            {{ csrf_field() }}
                            <select name="status" onchange="this.form.submit()" 
                                style="padding: 0.35rem 0.5rem; font-size: 0.8rem; border-radius: 8px; border: 1px solid #e2e8f0; width: 110px;
                                background: {{ $email->status == 'New' ? '#eff6ff' : ($email->status == 'Order Done' ? '#dcfce7' : ($email->status == 'Responded' ? '#f3e8ff' : '#fff')) }};
                                color: {{ $email->status == 'New' ? '#1d4ed8' : ($email->status == 'Order Done' ? '#166534' : ($email->status == 'Responded' ? '#6b21a8' : '#475569')) }};">
                                    @foreach(['New'=>'Unread','Viewed'=>'Read','Responded'=>'Replied','Order Done'=>'Order Completed','Closed'=>'Closed'] as $val=>$label)
                                        <option value="{{ $val }}" {{ $email->status == $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                            </select>
                        </form>
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                            <a href="{{ route('crm.emails.show', $email->id) }}" class="btn btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">View</a>
                            
                            @if(Auth::guard('crm')->user()->isAdmin())
                            <form action="{{ route('crm.emails.destroy', $email->id) }}" method="POST" onsubmit="return confirm('Delete this email?');" style="margin:0;">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;"><i class="fas fa-trash-alt"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 4rem; color: #94a3b8;">
                         <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.2;"></i>
                        <p>No emails found.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 1.5rem; border-top: 1px solid #f1f5f9;">
        {{ $emails->links() }}
    </div>
</div>

<!-- Refresh Overlay -->
<!-- Refresh Overlay -->
<div id="refresh-overlay" class="refresh-overlay">
    <div id="refresh-content" class="refresh-content">
        <div class="refresh-spinner">
            <i class="fas fa-circle-notch"></i>
        </div>
        <div class="refresh-text">Refreshing...</div>
    </div>
</div>

<style>
    .refresh-overlay {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        pointer-events: none;
        opacity: 0;
        visibility: hidden;
        background: rgba(255, 255, 255, 0);
        transition: all 0.2s ease;
    }
    
    .refresh-overlay.active {
        visibility: visible;
        opacity: 1;
        pointer-events: all;
        background: rgba(255, 255, 255, 0.5);
    }

    .refresh-content {
        text-align: center;
        transform: scale(0.95);
        opacity: 0;
        transition: all 0.2s ease;
    }
    
    .refresh-overlay.active .refresh-content {
        transform: scale(1);
        opacity: 1;
    }

    .refresh-spinner {
        font-size: 2.8rem;
        color: #8b5cf6;
        animation: spin 0.8s linear infinite;
    }

    .refresh-text {
        margin-top: 1.5rem;
        font-weight: 600;
        color: #334155;
        font-size: 1.1rem;
        letter-spacing: 0.03em;
    }

    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
</style>

<script>
function refreshInbox() {
    const overlay = document.getElementById('refresh-overlay');
    
    // 1. Activate Overlay immediately
    requestAnimationFrame(() => {
        overlay.classList.add('active');
    });

    // 2. Minimum natural delay (3 seconds)
    const minDelay = new Promise(resolve => setTimeout(resolve, 3000));
    
    // 3. Fetch Data
    const fetchData = fetch(window.location.href, { 
        headers: { 'X-Requested-With': 'XMLHttpRequest' } 
    })
    .then(res => {
        if (!res.ok) throw new Error('Network response was not ok');
        return res.text();
    });

    Promise.all([minDelay, fetchData])
    .then(([_, html]) => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        
        // Surgical Update
        const newCard = doc.querySelector('.content-card');
        const oldCard = document.querySelector('.content-card');
        
        if (newCard && oldCard) {
            oldCard.innerHTML = newCard.innerHTML;
        }

        // 4. Smooth Exit
        overlay.classList.remove('active');
        
        showRefreshToast(true);
    })
    .catch(err => {
        console.error('Refresh failed:', err);
        overlay.classList.remove('active');
        showRefreshToast(false);
    });
}

function showRefreshToast(success) {
    const existing = document.getElementById('refresh-toast');
    if(existing) existing.remove();

    const toast = document.createElement('div');
    toast.id = 'refresh-toast';
    
    const bgColor = success ? '#10b981' : '#ef4444';
    const icon = success ? '<i class="fas fa-check"></i>' : '<i class="fas fa-exclamation-circle"></i>';
    const text = success ? 'Refreshed successfully' : 'Update Failed';

    toast.style.cssText = `position: fixed; top: 20px; left: 50%; transform: translateX(-50%) translateY(-20px); background: ${bgColor}; color: white; padding: 10px 24px; border-radius: 50px; box-shadow: 0 10px 25px ${success ? 'rgba(16, 185, 129, 0.3)' : 'rgba(239, 68, 68, 0.3)'}; font-weight: 600; font-size: 0.9rem; z-index: 10000; display: flex; align-items: center; gap: 8px; opacity: 0; transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);`;
    toast.innerHTML = `${icon} ${text}`;
    
    document.body.appendChild(toast);
    
    requestAnimationFrame(() => {
        toast.style.opacity = '1';
        toast.style.transform = 'translateX(-50%) translateY(0)';
    });
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(-50%) translateY(-10px)';
        setTimeout(() => toast.remove(), 500);
    }, 2500);
}
</script>
@endsection

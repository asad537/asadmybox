@extends('crm.layout')

@section('title', 'Leads Managements')

@section('header_actions')
<button type="submit" name="export" value="true" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem;" form="leadsFilterForm">
    <i class="fas fa-file-excel" style="margin-right: 8px;"></i> Export
</button>
@endsection

@section('content')
<style>
    /* Consistent Theme Styles */
    .leads-card {
        background: var(--card-bg);
        border-radius: var(--border-radius-base);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: none;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    .leads-filter {
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

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.85rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    .status-new { background: #eff6ff; color: #3b82f6; } /* Blue */
    .status-viewed { background: #f1f5f9; color: #475569; } /* Gray */
    .status-responded { background: #f3e8ff; color: #9333ea; } /* Purple match */
    .status-order { background: #dcfce7; color: #16a34a; } /* Green match */
    .status-closed { background: #fee2e2; color: #ef4444; } /* Red match */

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
    .btn-light { background: white; border: 1px solid #cbd5e1; color: #475569; }
    .btn-light:hover { background: #f1f5f9; }
    
    input, select {
        font-size: 0.9rem !important; 
        padding: 0.6rem !important; 
        border: 1px solid #cbd5e1 !important;
        border-radius: 10px !important;
        outline: none;
    }
    input:focus, select:focus { border-color: var(--primary-purple) !important; ring: 2px solid var(--primary-purple); }
</style>

<!-- Filters -->
<!-- Filters -->
<div class="leads-filter" style="position: relative;">
    <form id="leadsFilterForm" action="{{ route('crm.leads.index') }}" method="GET" style="display: flex; gap: 1rem; align-items: flex-end; width: 100%;">
        
        <div style="flex: 1.5; min-width: 0;">
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Search</label>
           <div style="position: relative;">
                <i class="fas fa-search"
                   style="
                    position: absolute;
                    left: 1rem;
                    top: 50%;
                    transform: translateY(-50%);
                    color: #94a3b8;
                    pointer-events: none;
                   ">
                </i>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by Name, Email or Phone"
                    oninput="debounceSearch(this)"
                    style="
                    width: 100%;
                     padding: 0.75rem 2.2rem !important;
                    border: 1px solid #cbd5e1;
                    border-radius: 10px;
                    font-size: 0.9rem;
                    outline: none;
                    transition: all 0.2s;
                    "
                >
            </div>
        </div>

        <div style="flex: 1; min-width: 0;">
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Product</label>
            <div style="position: relative;">
                <select name="product" onchange="this.form.submit()" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 0.9rem; outline: none; appearance: none; background: white;">
                    <option value="">All Products</option>
                    @foreach($products as $prod)
                        <option value="{{ $prod }}" {{ request('product') == $prod ? 'selected' : '' }}>{{ Str::limit($prod, 25) }}</option>
                    @endforeach
                </select>
                <i class="fas fa-chevron-down" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; font-size: 0.8rem;"></i>
            </div>
        </div>

        <div style="flex: 1; min-width: 0;">
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Status</label>
            <div style="position: relative;">
                <select name="status" onchange="this.form.submit()" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 0.9rem; outline: none; appearance: none; background: white;">
                    <option value="">All Statuses</option>
                    @foreach(['New'=>'Unread','Viewed'=>'Read','Responded'=>'Replied','Order Done'=>'Order Completed','Closed'=>'Closed'] as $v=>$l)
                        <option value="{{ $v }}" {{ request('status') == $v ? 'selected' : '' }}>{{ $l }}</option>
                    @endforeach
                </select>
                <i class="fas fa-chevron-down" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; font-size: 0.8rem;"></i>
            </div>
        </div>

        <div style="flex: 1.2; min-width: 0;">
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Date Range</label>
            <div style="position: relative;">
                <input type="text" id="daterange" placeholder="Select Date Range"
                       value="{{ request('start_date') && request('end_date') ? request('start_date') . ' - ' . request('end_date') : '' }}"
                       style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 0.9rem; outline: none; background: white; cursor: pointer;">
                <i class="far fa-calendar-alt" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none;"></i>
            </div>
            <input type="hidden" name="start_date" id="start_date" value="{{ request('start_date') }}">
            <input type="hidden" name="end_date" id="end_date" value="{{ request('end_date') }}">
        </div>

        <a href="{{ route('crm.leads.index') }}" class="btn btn-light" style="padding: 0.75rem 1rem; font-size: 0.9rem; white-space: nowrap; height: 42px;">
            <i class="fas fa-undo" style="margin-right: 5px;"></i> Reset
        </a>

    </form>

</div>

<!-- Table -->
<div class="leads-card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Client</th>
                    <th>Contact</th>
                    <th>Source / Product</th>
                    <th>Qty</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leads as $index => $lead)
                <tr>
                    <td style="color:#6b7280; font-weight:500;">
                        {{ ($leads->currentPage() - 1) * $leads->perPage() + $loop->iteration }}
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #111827; display: flex; align-items: center; gap: 5px; white-space: nowrap;">
                            {{ $lead->client_name ?: 'Unknown' }}
                            @if($lead->customer_type == 'RC')
                                <span title="Returning Customer" style="background:#eff6ff; color:#3b82f6; font-size: 0.7rem; padding: 1px 6px; border-radius: 4px; border: 1px solid #dbeafe;">R</span>
                            @else
                                <span title="New Customer" style="background:#f0fdf4; color:#16a34a; font-size: 0.7rem; padding: 1px 6px; border-radius: 4px; border: 1px solid #dcfce7;">N</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div style="display: flex; flex-direction: column; gap: 0.15rem;">
                            <a href="mailto:{{ $lead->client_email }}" style="color: #4f46e5; text-decoration: none; font-size: 0.8rem;">
                                {{ Str::limit($lead->client_email, 25) }}
                            </a>
                            @if($lead->client_phone)
                            <a href="tel:{{ $lead->client_phone }}" style="color: #6b7280; text-decoration: none; font-size: 0.75rem;">
                                {{ $lead->client_phone }}
                            </a>
                            @endif
                        </div>
                    </td>
                    <td>
                        @php
                            $sourceIcon = 'fa-box';
                            if (stripos($lead->product_name, 'Quote') !== false) $sourceIcon = 'fa-file-invoice';
                            elseif (stripos($lead->product_name, 'Contact') !== false) $sourceIcon = 'fa-paper-plane';
                        @endphp
                        <div style="display: flex; align-items: center; gap: 0.5rem; color: #4b5563; font-size: 0.8rem;">
                            <span style="width: 20px; height: 20px; background: #f3f4f6; border-radius: 3px; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                                <i class="fas {{ $sourceIcon }}" style="font-size: 0.65rem;"></i>
                            </span>
                            {{ Str::limit($lead->product_name, 25) }}
                        </div>
                    </td>
                    <td style="font-size: 0.9rem; color: #1e293b; font-weight: 600;">{{ $lead->quantity ?? '-' }}</td>
                    <td>
                        @php
                            $badgeClass = 'status-new';
                            if($lead->status == 'Viewed') $badgeClass = 'status-viewed';
                            elseif($lead->status == 'Responded') $badgeClass = 'status-responded';
                            elseif($lead->status == 'Order Done') $badgeClass = 'status-order';
                            elseif($lead->status == 'Closed') $badgeClass = 'status-closed';
                        @endphp
                        @php
                            $labels = ['New'=>'Unread','Viewed'=>'Read','Responded'=>'Replied','Order Done'=>'Order Completed','Closed'=>'Closed'];
                        @endphp
                        <span class="status-badge {{ $badgeClass }}">{{ $labels[$lead->status] ?? $lead->status }}</span>
                    </td>
                    <td style="color: #6b7280; font-size: 0.8rem;">
                        {{ $lead->created_at->format('M d') }}<br>
                        <span style="font-size: 0.7rem;">{{ $lead->created_at->format('H:i') }}</span>
                    </td>
                    <td style="text-align: right;">
                        <a href="{{ route('crm.emails.show', $lead->id) }}" class="btn btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">
                            View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 4rem; color: #9ca3af;">
                        <i class="fas fa-search" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.2;"></i>
                        <p>No leads found matching your criteria.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div style="padding: 1rem; border-top: 1px solid #e5e7eb;">
        {{ $leads->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
    let timeout = null;
    function debounceSearch(input) {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            // Use AJAX instead of form.submit() to prevent focus loss
            const form = input.form;
            const url = new URL(form.action);
            const formData = new FormData(form);
            const params = new URLSearchParams();
            
            for(const pair of formData.entries()) {
                params.append(pair[0], pair[1]);
            }
            
            // Show a small loader or opacity change if needed, 
            // but user asked for strictly "focus lose na kare", 
            // so we keep it subtle.
            
            fetch(`${url.pathname}?${params.toString()}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('.leads-card');
                const currentContent = document.querySelector('.leads-card');
                
                if (newContent && currentContent) {
                    currentContent.innerHTML = newContent.innerHTML;
                }
                
                // Update URL without reload to persist state
                window.history.pushState({}, '', `${url.pathname}?${params.toString()}`);
            })
            .catch(err => console.error('Search failed', err));

        }, 500); // 500ms delay
    }

    $(document).ready(function() {
        // Initialize DateRangePicker
        $('#daterange').daterangepicker({
            autoUpdateInput: false,
            opens: 'left',
            locale: {
                cancelLabel: 'Clear',
                format: 'YYYY-MM-DD',
                applyLabel: 'Filter'
            }
        });

        // Apply Date Range
        $('#daterange').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            $('input[name="start_date"]').val(picker.startDate.format('YYYY-MM-DD'));
            $('input[name="end_date"]').val(picker.endDate.format('YYYY-MM-DD'));
            $(this).closest('form').submit();
        });

        // Cancel/Clear Date Range
        $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            $('input[name="start_date"]').val('');
            $('input[name="end_date"]').val('');
            $(this).closest('form').submit();
        });
    });
</script>
@endsection

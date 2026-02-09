@extends('crm.layout')

@section('title', 'Team Performance')

@section('content')
<div class="dashboard-container">
    <!-- Header -->
    <div style="margin-bottom: 2rem;">
     
        <p style="color: #64748b; font-size: 0.9rem; margin-top: 4px;">Monthly overview of team members</p>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('crm.team_performance') }}" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; gap: 1rem; flex-wrap: wrap;">
        <!-- Search -->
        <div style="position: relative; flex-grow: 1; min-width: 200px; display:flex; align-items: center;">
            <i class="fas fa-search" style="position: absolute; left: 1rem; z-index: 10; color: #94a3b8;"></i>
            <input type="text" name="search" value="{{ $search }}" placeholder="Search by name" 
                style="width: 100%; padding: 0.8rem 1rem 0.8rem 2.8rem; border: none; background: #fff; border-radius: 12px; box-shadow: 0 2px 5px rgba(0,0,0,0.03); outline: none; font-size: 0.95rem;">
        </div>

        <!-- Date Range Filter -->
        <div style="flex-grow: 1; max-width: 300px; min-width: 250px;">
            <div style="position: relative;">
                <input type="text" id="daterange" placeholder="Select Date Range"
                       value="{{ request('start_date') && request('end_date') ? request('start_date') . ' - ' . request('end_date') : '' }}"
                       style="width: 100%; padding: 0.8rem 1rem; border: none; background: #fff; border-radius: 12px; box-shadow: 0 2px 5px rgba(0,0,0,0.03); outline: none; font-size: 0.95rem; cursor: pointer;">
                <i class="far fa-calendar-alt" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none;"></i>
            </div>
            <input type="hidden" name="start_date" id="start_date" value="{{ request('start_date') }}">
            <input type="hidden" name="end_date" id="end_date" value="{{ request('end_date') }}">
        </div>

        <!-- Quick Filter (Dropdown) -->
        <div style="display: flex; align-items: center; background: #fff; padding: 0.4rem 1rem; border-radius: 12px; box-shadow: 0 2px 5px rgba(0,0,0,0.03);">
            <label style="margin-right: 0.5rem; color: #64748b; font-size: 0.9rem; font-weight: 500;">Quick:</label>
            <select name="range" onchange="this.form.submit()" style="border: none; background: transparent; cursor: pointer; color: #1e293b; font-weight: 700; font-size: 0.95rem; outline: none; -webkit-appearance: none; padding-right: 1rem;">
                <option value="today" {{ $range == 'today' ? 'selected' : '' }}>Today</option>
                <option value="this_week" {{ $range == 'this_week' ? 'selected' : '' }}>This Week</option>
                <option value="this_month" {{ $range == 'this_month' ? 'selected' : '' }}>This Month</option>
                <option value="this_year" {{ $range == 'this_year' ? 'selected' : '' }}>This Year</option>
            </select>
            <i class="fas fa-chevron-down" style="font-size: 0.8rem; color: #1e293b;"></i>
        </div>
    </form>

    <!-- Table -->
    <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="color: #94a3b8; font-size: 0.85rem; text-align: left;">
                    <th style="padding: 1rem; font-weight: 600; border-bottom: 1px solid #e2e8f0;">Name</th>
                    <th style="padding: 1rem; font-weight: 600; border-bottom: 1px solid #e2e8f0;">Emails Read</th>
                    <th style="padding: 1rem; font-weight: 600; border-bottom: 1px solid #e2e8f0;">Replied Emails</th>
                    <th style="padding: 1rem; font-weight: 600; border-bottom: 1px solid #e2e8f0;">Order Completed</th>
                </tr>
            </thead>
            <tbody>
                @foreach($performanceData as $data)
                <tr style="font-weight: 600; color: #1e293b;">
                    <td style="padding: 1.2rem 1rem; border-bottom: 1px solid #e2e8f0;">
                         <div style="display: flex; align-items: center; gap: 1rem;">
                            <!-- Avatar placeholder with initials -->
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: #e2e8f0; color: #64748b; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 700;">
                                {{ strtoupper(substr($data['name'], 0, 2)) }}
                            </div>
                            {{ $data['name'] }}
                        </div>
                    </td>
                    <td style="padding: 1.2rem 1rem; border-bottom: 1px solid #e2e8f0;">
                        <span style="background: #e0f2fe; color: #0284c7; padding: 8px 18px; border-radius: 8px; font-weight: 700; font-size: 0.95rem;">{{ $data['viewed'] }}</span>
                    </td>
                    <td style="padding: 1.2rem 1rem; border-bottom: 1px solid #e2e8f0;">
                        <span style="background: #f3e8ff; color: #9333ea; padding: 8px 18px; border-radius: 8px; font-weight: 700; font-size: 0.95rem;">{{ $data['responded'] }}</span>
                    </td>
                    <td style="padding: 1.2rem 1rem; border-bottom: 1px solid #e2e8f0;">
                        <span style="background: #dcfce7; color: #16a34a; padding: 8px 18px; border-radius: 8px; font-weight: 700; font-size: 0.95rem;">{{ $data['orders'] }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
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

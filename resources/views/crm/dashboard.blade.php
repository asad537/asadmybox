@extends('crm.layout')

@section('title', 'Quotation Analytics Dashboard')

@section('header_actions')
<div style="display: flex; gap: 0.5rem; background: #fff; padding: 4px; border-radius: 12px; box-shadow: 0 2px 5px rgba(0,0,0,0.03);">
    <button class="filter-btn active">Today</button>
    <button class="filter-btn">Weekly</button>
    <button class="filter-btn">Monthly</button>
    <button class="filter-btn">Yearly</button>
</div>
@endsection

@section('content')
<style>
    /* FILTER BUTTONS */
    .filter-btn {
        border: none;
        background: transparent;
        color: #64748b;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .filter-btn.active {
        background: #6c5ce7;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(108, 92, 231, 0.4);
    }
    .filter-btn:hover:not(.active) {
        background: #f1f5f9;
        color: #1e293b;
    }

    /* DASHBOARD LAYOUT */
    .dashboard-container {
        max-width: 1600px;
        margin: 0 auto;
        /* Removed zoom to fix chart tooltip coordinates */
    }
    
    /* TOP ROW: STATS */
    /* TOP ROW: STATS */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    /* NEW CARD DESIGN (Compact & Clean) */
    .stat-box {
        background: #ffffff;
        border-radius: 20px;
        padding: 1rem; /* Reduced padding to fit 4 in a row */
        display: flex;
        justify-content: space-between;
        align-items: flex-start; /* Align top */
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        border: 1px solid #f1f5f9;
        transition: transform 0.2s;
        min-height: 120px; /* Reduced Height to ~120px */
    }
    .stat-box:hover { transform: translateY(-3px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); }

    .stat-content { display: flex; flex-direction: column; justify-content: space-between; height: 100%; width: 100%; }
    
    .stat-label { font-size: 0.9rem; font-weight: 700; color: #475569; margin-bottom: 0.5rem; }
    .stat-number { font-size: 2.5rem; font-weight: 800; color: #1e293b; margin-bottom: 0.5rem; letter-spacing: -1px; line-height: 1; }
    
    .stat-trend { font-size: 0.85rem; font-weight: 800; display: flex; align-items: center; gap: 6px; margin-top: auto; flex-wrap: nowrap; }
    .trend-up { color: #16a34a; }
    .trend-down { color: #dc2626; }
    .trend-text { color: #94a3b8; font-weight: 500; font-size: 0.75rem; letter-spacing: 0.2px; white-space: nowrap; }
    
    .icon-box {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
        margin-left: 1rem;
    }
    .box-blue { background: #eff6ff; color: #3b82f6; } 
    .box-red { background: #fef2f2; color: #ef4444; }   
    .box-purple { background: #fdf4ff; color: #a855f7; } 
    .box-green { background: #f0fdf4; color: #22c55e; } 

    /* MIDDLE ROW: CHARTS & MAP */
    .middle-grid {
        display: grid;
        grid-template-columns: 2.5fr 1fr;
        gap: 2rem;
        align-items: stretch; /* Stretch to match heights */
        margin-bottom: 2rem; /* Spacing between rows */
    }

    /* RESPONSIVE LAYOUT */
    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr); /* 2 Columns on Laptops/Tablets */
        }
        .middle-grid {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        .chart-card {
            width: 100%;
        }
    }
    
    @media (max-width: 700px) {
        .stats-grid {
            grid-template-columns: 1fr; /* 1 Column on Mobile */
        }
        .chart-card {
            padding: 1rem;
        }
        .stat-box {
            min-height: auto; /* Allow auto height on mobile */
        }
    }
    
    .chart-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 1.5rem;
        display: flex; flex-direction: column;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        border: 1px solid #f1f5f9;
        min-height: 400px; /* Increased Height */
    }

    .chart-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem; }
    .chart-title h3 { margin: 0; font-size: 1.1rem; font-weight: 700; color: #1e293b; }
    .chart-title p { margin: 4px 0 0 0; color: #94a3b8; font-size: 0.8rem; }
    .year-drop { display: flex; align-items: center; font-weight: 600; font-size: 0.8rem; color: #1e293b; gap: 0.5rem; }

    /* LOCATIONS CARD */
    .location-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-top: 1rem;
    }
    .loc-item {
        display: grid;
        grid-template-columns: 80px 1fr 40px;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: #475569;
        font-weight: 600;
    }
    .loc-bar-bg {
        width: 100%;
        height: 8px;
        background: #f1f5f9;
        border-radius: 99px;
        position: relative;
        overflow: hidden;
    }
    .loc-bar-fill {
        height: 100%;
        border-radius: 99px;
        position: absolute; left: 0; top: 0;
    }

    /* BOTTOM ROW: WAVE CHART */
    .bottom-chart-container {
        background: #ffffff;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        border: 1px solid #f1f5f9;
        min-height: 300px;
        display: flex; /* Flexbox for child sizing */
        flex-direction: column;
    }
</style>

<div class="dashboard-container">
    
    <!-- STATS CARDS -->
    <div class="stats-grid">
        <!-- Card 1: Total -->
        <div class="stat-box">
            <div class="stat-content">
                <div class="stat-label">Total Quotations</div>
                <div class="stat-number" id="stat-total">{{ number_format($totalEmails) }}</div>
                @php $t = $trends['total']; $color = $t >= 0 ? 'trend-up' : 'trend-down'; @endphp
                <div class="stat-trend {{ $color }}" id="trend-total-container">
                    <span id="trend-total">{{ $t > 0 ? '+' : '' }}{{ $t }}%</span> 
                    <span class="trend-text">vs last period</span>
                </div>
            </div>
            <div class="icon-box box-blue">
                <i class="far fa-envelope"></i>
            </div>
        </div>

        <!-- Card 2: Spam -->
        <div class="stat-box">
             <div class="stat-content">
                <div class="stat-label">Spam </div>
                <div class="stat-number" id="stat-spam">{{ number_format($spamEmails) }}</div>
                @php $t = $trends['spam']; $color = $t <= 0 ? 'trend-up' : 'trend-down'; /* Less spam is good (Green) */ @endphp
                <div class="stat-trend {{ $color }}" id="trend-spam-container">
                     <span id="trend-spam">{{ $t > 0 ? '+' : '' }}{{ $t }}%</span>
                     <span class="trend-text">vs last period</span>
                </div>
            </div>
             <div class="icon-box box-red">
                <i class="fas fa-ban"></i>
            </div>
        </div>

        <!-- Card 3: Responded -->
        <div class="stat-box">
            <div class="stat-content">
                <div class="stat-label">Replied </div>
                <div class="stat-number" id="stat-replied">{{ number_format($repliedEmails) }}</div>
                @php $t = $trends['replied']; $color = $t >= 0 ? 'trend-up' : 'trend-down'; @endphp
                <div class="stat-trend {{ $color }}" id="trend-replied-container">
                     <span id="trend-replied">{{ $t > 0 ? '+' : '' }}{{ $t }}%</span>
                     <span class="trend-text">vs last period</span>
                </div>
            </div>
            <div class="icon-box box-purple">
                <i class="far fa-comments"></i>
            </div>
        </div>

        <!-- Card 4: Orders -->
        <div class="stat-box">
             <div class="stat-content">
                <div class="stat-label">Order Completed</div>
                <div class="stat-number" id="stat-orders">{{ number_format($ordersDone) }}</div>
                @php $t = $trends['orders']; $color = $t >= 0 ? 'trend-up' : 'trend-down'; @endphp
                <div class="stat-trend {{ $color }}" id="trend-orders-container">
                    <span id="trend-orders">{{ $t > 0 ? '+' : '' }}{{ $t }}%</span>
                    <span class="trend-text">vs last period</span>
                </div>
            </div>
            <div class="icon-box box-green">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
    </div>

    <!-- MIDDLE ROW: BAR CHART + LOCATIONS -->
    <div class="middle-grid">
        <!-- Chart 1: Bar -->
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">
                    <h3>Response Overview</h3>
                    <p>Responded vs Pending</p>
                </div>
                <div class="year-drop">2026 <i class="far fa-calendar"></i></div>
            </div>
            <div style="flex:1; position:relative; min-height: 0;">
                <canvas id="topBarChart"></canvas>
            </div>
        </div>

        <!-- NEW: Locations Widget -->
        <div class="chart-card">
            <div class="chart-header" style="margin-bottom: 0.5rem;">
                <div class="chart-title">
                    <h3>Inquiries by Location</h3>
                    <p>Traffic from top regions</p>
                </div>
                <div style="cursor: pointer; color: #94a3b8;"><i class="fas fa-ellipsis-h"></i></div>
            </div>
            
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; margin-top: 2rem; gap: 2rem; flex: 1;">
                 <!-- Colorful Map Image -->
                 <div style="display: flex; justify-content: center; position: relative; width: 100%; height: 160px; align-items: center;">
                    <img src="{{ asset('world_map_colored.png') }}" alt="World Map" style="width: 100%; height: 100%; object-fit: contain;">
                    
                    <!-- Soft Dots (Positioned for World Map) -->
                    <!-- Blue (North America) -->
                    <div style="position: absolute; top: 35%; left: 25%; width: 12px; height: 12px; background: #3b82f6; border-radius: 50%; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);"></div>
                    
                    <!-- Green (Europe) -->
                    <div style="position: absolute; top: 30%; left: 52%; width: 12px; height: 12px; background: #10b981; border-radius: 50%; box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);"></div>
                    
                    <!-- Red (Asia) -->
                    <div style="position: absolute; top: 45%; left: 75%; width: 12px; height: 12px; background: #ef4444; border-radius: 50%; box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.2);"></div>
                 </div>

                <!-- List below Globe -->
                <div class="location-list" style="width: 100%;">
                    @php $locColors = ['#3b82f6', '#ef4444', '#10b981']; @endphp
                    @forelse($locationData as $index => $loc)
                        @php
                            $cName = $loc['name'] ?: 'Unknown';
                            $cMap = [
                                'Australia' => ['au', 'AUS'], 'India' => ['in', 'IND'], 'United States' => ['us', 'USA'],
                                'United Kingdom' => ['gb', 'GBR'], 'Canada' => ['ca', 'CAN'], 'New Zealand' => ['nz', 'NZL'],
                                'China' => ['cn', 'CHN'], 'Japan' => ['jp', 'JPN'], 'Germany' => ['de', 'DEU'],
                                'France' => ['fr', 'FRA'], 'Italy' => ['it', 'ITA'], 'Spain' => ['es', 'ESP'],
                                'Brazil' => ['br', 'BRA'], 'Mexico' => ['mx', 'MEX'], 'Russia' => ['ru', 'RUS'],
                                'South Africa' => ['za', 'ZAF'], 'Singapore' => ['sg', 'SGP'], 'Malaysia' => ['my', 'MYS'],
                                'Philippines' => ['ph', 'PHL'], 'Indonesia' => ['id', 'IDN'], 'Thailand' => ['th', 'THA'],
                                'Vietnam' => ['vn', 'VNM'], 'Pakistan' => ['pk', 'PAK'], 'Bangladesh' => ['bd', 'BGD'],
                                'Sri Lanka' => ['lk', 'LKA'], 'Nepal' => ['np', 'NPL'], 'Saudi Arabia' => ['sa', 'SAU'],
                                'United Arab Emirates' => ['ae', 'ARE'], 'Netherlands' => ['nl', 'NLD'], 'Sweden' => ['se', 'SWE'],
                                'Norway' => ['no', 'NOR'], 'Denmark' => ['dk', 'DNK'], 'Finland' => ['fi', 'FIN'],
                                'Poland' => ['pl', 'POL'], 'Turkey' => ['tr', 'TUR'], 'Israel' => ['il', 'ISR'],
                                'Egypt' => ['eg', 'EGY'], 'South Korea' => ['kr', 'KOR'], 'Taiwan' => ['tw', 'TWN'],
                                'Hong Kong' => ['hk', 'HKG'], 'Argentina' => ['ar', 'ARG'], 'Chile' => ['cl', 'CHL'],
                                'Colombia' => ['co', 'COL'], 'Peru' => ['pe', 'PER'], 'Ireland' => ['ie', 'IRL'],
                                'Switzerland' => ['ch', 'CHE'], 'Austria' => ['at', 'AUT'], 'Belgium' => ['be', 'BEL']
                            ];
                            $cCode = $cMap[$cName][0] ?? null;
                            $cIso = $cMap[$cName][1] ?? strtoupper(substr($cName, 0, 3));
                        @endphp
                        <div class="loc-item">
                             <div style="display: flex; align-items: center; gap: 8px;">
                                 @if($cCode)
                                    <img src="https://flagcdn.com/w40/{{ $cCode }}.png" 
                                         srcset="https://flagcdn.com/w80/{{ $cCode }}.png 2x" 
                                         alt="{{ $cName }}" 
                                         style="width: 20px; height: auto; border-radius: 2px; box-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                                 @else
                                    <i class="fas fa-globe" style="color: #64748b; font-size: 0.9rem;"></i>
                                 @endif
                                 <span>{{ $cIso }}</span>
                            </div>
                            <div class="loc-bar-bg">
                                <div class="loc-bar-fill" style="width: {{ $loc['percent'] }}%; background: {{ $locColors[$index] ?? '#cbd5e1' }};"></div>
                            </div>
                            <span style="text-align: right;">{{ $loc['percent'] }}%</span>
                        </div>
                    @empty
                        <div style="text-align: center; color: #94a3b8; font-size: 0.8rem;">No data available</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- BOTTOM ROW: WAVE CHART -->
    <div class="bottom-chart-container">
        <div class="chart-header">
            <div class="chart-title">
                <h3>Trend Analysis</h3>
                <p>Monthly Performance</p>
            </div>
            <div style="background:#eff6ff; padding:6px 12px; border-radius:6px; color:#10b981; font-weight:700; font-size:0.8rem;">+12.5% Growth</div>
        </div>
        <div style="flex: 1; position: relative; min-height: 0;">
            <canvas id="waveChart"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script>
    Chart.defaults.font.family = "'DM Sans', sans-serif";
    Chart.register(ChartDataLabels); // Register the plugin globally

    // 1. TOP BAR CHART (Purple/Orange)
    const ctxBar = document.getElementById('topBarChart').getContext('2d');
    window.topBarChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartTrends['labels']) !!},
            datasets: [
                {
                    label: 'Replied',
                    data: {!! json_encode($chartTrends['replied']) !!},
                    backgroundColor: '#a855f7', // Purple
                    borderRadius: 6,
                    barThickness: 16
                },
                {
                    label: 'Pending',
                    data: {!! json_encode($chartTrends['pending']) !!},
                    backgroundColor: '#fed7aa', /* lighter orange */
                    borderRadius: 6,
                    barThickness: 16
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { position: 'bottom', labels: { usePointStyle: true, pointStyle: 'circle', padding: 20, color: '#64748b' } },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: '#1e293b',
                    font: { weight: 'bold', size: 10 },
                    offset: -2,
                    display: function(context) {
                        return context.dataset.data[context.dataIndex] > 0;
                    }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { color: '#f8fafc' }, 
                    border: { display: false }, 
                    ticks: { color: '#94a3b8' } 
                },
                x: { grid: { display: false }, border: { display: false }, ticks: { color: '#64748b' } }
            },
            layout: { padding: { top: 20 } },
            interaction: {
                intersect: false,
                mode: 'index',
            }
        }
    });

    // 2. BOTTOM WAVE CHART (Smooth Curves)
    const ctxWave = document.getElementById('waveChart').getContext('2d');
    window.waveChart = new Chart(ctxWave, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartTrends['labels']) !!},
            datasets: [
                {
                    label: 'Total',
                    data: {!! json_encode($chartTrends['total'] ?? []) !!},
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.05)',
                    fill: 'start',
                    tension: 0.4,
                    pointRadius: 0,
                    borderWidth: 3
                },
                {
                    label: 'Replied',
                    data: {!! json_encode($chartTrends['replied']) !!},
                    borderColor: '#a855f7',
                    tension: 0.4,
                    pointRadius: 0,
                    borderWidth: 3
                },
                {
                    label: 'Orders',
                    data: {!! json_encode($chartTrends['orders'] ?? []) !!}, 
                    borderColor: '#10b981',
                    tension: 0.4,
                    pointRadius: 0,
                    borderWidth: 3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                datalabels: { display: false }
            },
            scales: {
                y: { display: true, beginAtZero: true, grid: { color: '#f8fafc' }, border: { display: false }, ticks: { color: '#94a3b8' } },
                x: { grid: { display: false }, border: { display: false }, ticks: { color: '#64748b' } }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
        }
    });

    // 4. HANDLE TIME FILTER CLICKS
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const range = this.innerText.toLowerCase(); 
            
            // Visual Loade state
            ['stat-total', 'stat-spam', 'stat-replied', 'stat-orders'].forEach(id => {
                document.getElementById(id).style.opacity = '0.4';
                document.getElementById(id).innerText = '...';
            });
            
            fetchData(range);
        });
    });

    function fetchData(range) {
        fetch(`{{ route('crm.dashboard') }}?range=${range}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            // Update Stats Numbers
            const updateStat = (id, value) => {
                const el = document.getElementById(id);
                if(el) {
                    el.innerText = value;
                    el.style.opacity = '1';
                }
            };

            const updateTrend = (id, value, invert = false) => {
                const container = document.getElementById(id + '-container');
                const text = document.getElementById(id);
                
                if (!container || !text) return;

                // Format Value
                const val = parseFloat(value);
                text.innerText = (val > 0 ? '+' : '') + val + '%';
                
                let isGood = val >= 0; 
                if (invert) {
                    isGood = val <= 0; 
                }

                container.className = 'stat-trend ' + (isGood ? 'trend-up' : 'trend-down');
            };

            updateStat('stat-total', data.stats.total);
            updateStat('stat-spam', data.stats.spam);
            updateStat('stat-replied', data.stats.replied);
            updateStat('stat-orders', data.stats.orders);

            // Update Trends
            if (data.trends) {
                updateTrend('trend-total', data.trends.total);
                updateTrend('trend-spam', data.trends.spam, true); // Invert logic for spam
                updateTrend('trend-replied', data.trends.replied);
                updateTrend('trend-orders', data.trends.orders);
            }

            // Update Main Charts
            if (window.topBarChart && data.chart) {
                window.topBarChart.data.labels = data.chart.labels;
                window.topBarChart.data.datasets[0].data = data.chart.replied;
                window.topBarChart.data.datasets[1].data = data.chart.pending;
                window.topBarChart.update('none'); // Update without full animation
            }

            if (window.waveChart && data.chart) {
                window.waveChart.data.labels = data.chart.labels;
                window.waveChart.data.datasets[0].data = data.chart.total;
                window.waveChart.data.datasets[1].data = data.chart.replied;
                window.waveChart.data.datasets[2].data = data.chart.orders;
                window.waveChart.update('none');
            }
        })
        .catch(err => console.error('Error fetching data:', err));
    }

    // Auto Refresh Dashboard every 30 seconds
    setInterval(() => {
        const activeBtn = document.querySelector('.filter-btn.active');
        const range = activeBtn ? activeBtn.innerText.toLowerCase() : 'today';
        fetchData(range);
    }, 30000);
</script>
@endsection
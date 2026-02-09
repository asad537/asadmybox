<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM Panel - @yield('title')</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <!-- DateRangePicker CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    
    <style>
        /* GLOBAL STYLES & VARIABLES */
        * { box-sizing: border-box; }
        :root {
            --bg-body: #F4F5F9; 
            --primary-purple: #6c5ce7;
            --text-dark: #1e293b;
            --text-gray: #94a3b8;
            --card-bg: #ffffff;
            --border-radius-base: 16px; 
            --success-green: #00b894;
            --danger-red: #ff7675;
            --sidebar-width: 230px; 
        }

        body {
            background-color: var(--bg-body);
            font-family: 'DM Sans', 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            color: var(--text-dark);
            height: 100vh; /* Fallback */
            height: 100dvh; /* Dynamic Height for Mobile */
            display: flex;
            overflow: hidden;
            font-size: 0.9rem;
            /* zoom: 0.95;  */
        }

        /* SIDEBAR */
        .custom-sidebar {
            width: var(--sidebar-width);
            background: white;
        
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            height: 100vh;
            border-right: 1px solid #f1f5f9;
            transition: all 0.3s ease;
        }

        .brand-logo {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 3rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #1e293b;
        }
        .brand-logo i { 
            background: #1e293b; 
            color: white; padding: 8px; border-radius: 8px; font-size: 1rem; 
            display: flex; align-items: center; justify-content: center;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            flex: 1;
            overflow-y: auto;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.85rem 1rem;
            border-radius: 12px;
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.2s;
        }
        .nav-item i { width: 24px; margin-right: 12px; font-size: 1.1rem; }
        
        .nav-item.active {
            background-color: var(--primary-purple);
            color: white;
            box-shadow: 0 4px 12px rgba(108, 92, 231, 0.3);
        }
        .nav-item:hover:not(.active) { background-color: #f8fafc; color: #1e293b; }
        .nav-item .arrow { margin-left: auto; font-size: 0.8rem; opacity: 0.6; }

        /* USER PROFILE BOTTOM */
        .sidebar-footer {
            margin-top: auto;
            border-top: 1px solid #f1f5f9;
            padding-top: 1.5rem;
        }
        .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .user-avatar {
            width: 40px; height: 40px;
            background: #e0e7ff; color: var(--primary-purple);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
        }
        .user-info { display: flex; flex-direction: column; }
        .user-name { font-size: 0.9rem; font-weight: 700; color: #1e293b; }
        .user-role { font-size: 0.75rem; color: #94a3b8; }

        /* MAIN AREA */
        .main-area {
            flex: 1;
            min-width: 0;
            padding: 1.5rem 2rem 4rem 2rem;
            overflow-y: auto;
            position: relative;
            width: 100%;
            height: 100%;
            overflow-x: hidden;
        }

        /* TOP HEADER */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }
        .top-title h1 { margin: 0; font-size: 1.5rem; font-weight: 700; color: #1e293b; }
        .top-title p { margin: 5px 0 0 0; color: #94a3b8; font-size: 0.9rem; }

        .top-actions { display: flex; align-items: center; gap: 1.5rem; }
        .search-bar {
            background: white;
            padding: 0.65rem 1.25rem;
            border-radius: 99px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            width: 250px;
            color: #94a3b8;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }
        .search-bar input { border: none; outline: none; width: 100%; font-size: 0.9rem; color: #475569; }
        .notif-btn { width: 44px; height: 44px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 10px rgba(0,0,0,0.02); color: #1e293b; cursor: pointer; }

        /* MENU TOGGLE FOR MOBILE */
        .menu-toggle {
            display: none;
            font-size: 1.5rem;
            color: #1e293b;
            cursor: pointer;
            margin-right: 1rem;
        }

        /* OVERLAY FOR MOBILE */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.4);
            z-index: 998;
        }

        /* RESPONSIVE MEDIA QUERIES */
        @media (max-width: 900px) {
            .custom-sidebar {
                position: fixed;
                left: -260px;
                top: 0;
                z-index: 999;
                box-shadow: 5px 0 15px rgba(0,0,0,0.05);
            }
            .custom-sidebar.open {
                left: 0;
            }
            .menu-toggle {
                display: block;
            }
            .sidebar-overlay.open {
                display: block;
            }
            .main-area {
                padding: 1rem 1rem;
            }
            .top-bar {
                margin-bottom: 1.5rem;
            }
            .search-bar {
                width: 100%;
                max-width: 220px;
            }
        }
        
        @media (max-width: 600px) {
             .top-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
             }
             .top-actions {
                 width: 100%;
                 justify-content: space-between;
             }
             .search-bar {
                 flex: 1;
                 max-width: none;
             }
             .nav-menu {
                 height: auto;
             }
             .sidebar-footer {
                 padding-bottom: 2rem; /* iOS safe area */
             }
        }

        /* SCROLLBAR */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }

        /* ALERTS */
        .alert { padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-error { background: #fee2e2; color: #991b1b; }

        /* PAGINATION CUSTOMIZATION */
        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            gap: 0.5rem;
            justify-content: center;
            margin-top: 1rem;
            flex-wrap: wrap;
        }
        .page-link {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            padding: 0;
            margin-left: 0;
            line-height: 1;
            color: #64748b;
            background-color: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        .page-link:hover {
            background-color: #f1f5f9;
            color: var(--primary-purple);
            border-color: #cbd5e1;
        }
        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: var(--primary-purple);
            border-color: var(--primary-purple);
            box-shadow: 0 2px 6px rgba(108, 92, 231, 0.4);
        }
        .page-item.disabled .page-link {
            color: #cbd5e1;
            pointer-events: none;
            background-color: #fff;
            border-color: #e2e8f0;
        }

        @yield('styles')
    </style>
</head>
<body>

    <!-- OVERLAY -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR -->
    <div class="custom-sidebar" id="sidebar">
        <div class="brand-logo" style="justify-content: space-between;">
            <div style="display:flex; align-items:center; gap:0.75rem; margin-left: 15px; margin-top: 12px;">
                <i class="fas fa-cube"></i> <span style="font-size: 1.4rem;">Dashboard</span>
            </div>
            <i class="fas fa-times d-block d-md-none" style="cursor: pointer; font-size: 1.2rem; color: #cbd5e1; background:none;" onclick="toggleSidebar()"></i>
        </div>
        
        <nav class="nav-menu">
            <a href="{{ route('crm.dashboard') }}" class="nav-item {{ request()->routeIs('crm.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>
            
            <a href="{{ route('crm.emails.index') }}" class="nav-item {{ request()->routeIs('crm.emails.index') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i> Inbox
                <i class="fas fa-chevron-right arrow"></i>
            </a>

            <a href="{{ route('crm.emails.spam') }}" class="nav-item {{ request()->routeIs('crm.emails.spam') ? 'active' : '' }}">
                <i class="fas fa-exclamation-circle"></i> Spam
                <i class="fas fa-chevron-right arrow"></i>
            </a>

            @if(Auth::guard('crm')->user()->isAdmin())
            <div style="font-size: 0.75rem; font-weight: 700; color: #cbd5e1; margin: 1rem 0 0.5rem 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Admin</div>
            
            <a href="{{ route('crm.users.index') }}" class="nav-item {{ request()->routeIs('crm.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Team
                <i class="fas fa-chevron-right arrow"></i>
            </a>

            <a href="{{ route('crm.team_performance') }}" class="nav-item {{ request()->routeIs('crm.team_performance') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Performance
                <i class="fas fa-chevron-right arrow"></i>
            </a>
            
            <a href="{{ route('crm.leads.index') }}" class="nav-item {{ request()->routeIs('crm.leads.*') ? 'active' : '' }}">
                <i class="fas fa-address-book"></i> Leads
                <i class="fas fa-chevron-right arrow"></i>
            </a>
            
            <a href="{{ route('crm.logs.index') }}" class="nav-item {{ request()->routeIs('crm.logs.*') ? 'active' : '' }}">
                <i class="fas fa-history"></i> Logs
                <i class="fas fa-chevron-right arrow"></i>
            </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="user-avatar">
                   {{ strtoupper(substr(Auth::guard('crm')->user()->name, 0, 1)) }}
                </div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::guard('crm')->user()->name }}</div>
                    <div class="user-role">{{ Auth::guard('crm')->user()->isAdmin() ? 'Administrator' : 'Sales Agent' }}</div>
                </div>
                <form action="{{ route('crm.logout') }}" method="POST" style="margin-left: auto;">
                    {{ csrf_field() }}
                    <button type="submit" style="background:none; border:none; cursor:pointer; color:#000000; font-size: 1.6rem;margin-right: 15px;"><i class="fas fa-power-off"></i></button>
                </form>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT AREA -->
    <div class="main-area">
        <!-- TOP NAV -->
        <div class="top-bar">
            <div class="top-title" style="display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-bars menu-toggle" onclick="toggleSidebar()"></i>
                <div>
                    <h1>
                        @hasSection('title')
                            @yield('title')
                        @else
                            Dashboard
                        @endif
                    </h1>
                    <p>{{ now()->format('l, F j, Y') }}</p>
                </div>
            </div>
            <div style="margin-left: auto;">
                @yield('header_actions')
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
        <div style="height: 3rem; width: 100%;"></div>
    </div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        sidebar.classList.toggle('open');
        overlay.classList.toggle('open');
    }

    // AJAX Auto-Refresh for Listing Pages (Inbox, Spam, Leads, Logs, etc.)
    document.addEventListener('DOMContentLoaded', function() {
        const autoRefreshKeywords = ['inbox', 'spam', 'leads', 'logs', 'show-orders', 'team-performance'];
        const currentPath = window.location.pathname;
        const isListingPage = autoRefreshKeywords.some(keyword => currentPath.includes(keyword));

        if (isListingPage) {
            // Create a small status indicator
            const statusDiv = document.createElement('div');
            statusDiv.style.cssText = "position: fixed; bottom: 10px; right: 10px; font-size: 0.75rem; color: #94a3b8; background: white; padding: 4px 8px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); opacity: 0; transition: opacity 0.3s;";
            statusDiv.innerText = "Updated just now";
            document.body.appendChild(statusDiv);

            setInterval(() => {
                // Don't refresh if user is interacting with filters or forms (checking if any input has focus)
                if (document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'SELECT' || document.querySelector('.sidebar-overlay.open')) {
                    return;
                }

                fetch(window.location.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        
                        // Find the new content container (Table area)
                        const newContent = doc.querySelector('.content-card');
                        const currentContent = document.querySelector('.content-card');

                        if (newContent && currentContent) {
                            // Update HTML only if different (simple check, or just replace)
                            if (newContent.innerHTML !== currentContent.innerHTML) {
                                currentContent.innerHTML = newContent.innerHTML;
                                
                                // Show "Updated" toast
                                statusDiv.innerText = "New data loaded";
                                statusDiv.style.opacity = '1';
                                setTimeout(() => { statusDiv.style.opacity = '0'; }, 3000);
                            }
                        }
                    })
                    .catch(e => console.error('Auto-refresh failed', e));

            }, 15000); // Check every 15 seconds
        }
    });
</script>

<!-- DateRangePicker Dependencies (Order is important) -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

@yield('scripts')
</body>
</html>

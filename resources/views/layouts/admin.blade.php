<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MAAK CMS') }} - Premium Terminal</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Leaflet Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #ea580c;
            --primary-light: #fff7ed;
            --primary-dark: #c2410c;
            --primary-glow: rgba(234, 88, 12, 0.25);
            --accent: #f59e0b;
            --accent-light: #fffbeb;
            --bg-main: #fafaf9;
            --bg-warm: #fff7ed;
            --bg-glass: rgba(255, 255, 255, 0.88);
            --text-main: #1c1917;
            --text-muted: #78716c;
            --border: rgba(231, 229, 228, 0.9);
            --border-warm: rgba(253, 186, 116, 0.3);
            --shadow-sm: 0 1px 3px 0 rgba(124, 45, 18, 0.06), 0 1px 2px -1px rgba(124, 45, 18, 0.04);
            --shadow: 0 4px 8px -2px rgba(124, 45, 18, 0.1), 0 2px 4px -2px rgba(124, 45, 18, 0.06);
            --shadow-md: 0 12px 20px -4px rgba(124, 45, 18, 0.12), 0 4px 8px -4px rgba(124, 45, 18, 0.08);
            --shadow-orange: 0 8px 20px -4px rgba(234, 88, 12, 0.35);
            --glass-border: 1px solid rgba(255, 255, 255, 0.5);
            --glass-bg: rgba(255, 255, 255, 0.75);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #eaecf1;
            background-image: radial-gradient(circle at 1px 1px, rgba(234, 88, 12, 0.04) 1px, transparent 0);
            background-size: 32px 32px;
            color: var(--text-main);
            margin: 0;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* Glassmorphism Effect */
        .glass-effect {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: var(--glass-border);
        }

        /* Sidebar - Desktop Only */
        .sidebar {
            width: 280px;
            height: 94vh;
            background: rgb(11 19 30);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            position: fixed;
            left: 20px;
            top: 3vh;
            border-radius: 32px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-header {
            padding: 3rem 2rem;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-box {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #f97316, #ea580c);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.3rem;
            box-shadow: 0 8px 20px rgba(234, 88, 12, 0.3);
            position: relative;
        }

        .logo-box::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 18px;
            border: 1px solid rgba(234, 88, 12, 0.3);
            opacity: 0.5;
        }

        .logo-text {
            color: #fff;
            font-weight: 900;
            font-size: 1.5rem;
            letter-spacing: -1px;
            font-family: 'Outfit', sans-serif;
        }

        .sidebar-nav {
            flex: 1;
            padding: 0 1.2rem;
            overflow-y: auto;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.4rem;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 20px;
            margin-bottom: 0.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.2px;
        }

        .nav-item i {
            width: 24px;
            font-size: 1.1rem;
            margin-right: 15px;
            opacity: 0.7;
            transition: all 0.3s ease;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.03);
            color: #fff;
            transform: translateX(5px);
        }

        .nav-item:hover i {
            opacity: 1;
            color: var(--primary);
        }

        .nav-item.active {
            background: linear-gradient(135deg, rgba(234, 88, 12, 0.2), rgba(234, 88, 12, 0.05));
            color: #fff;
            border: 1px solid rgba(234, 88, 12, 0.2);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .nav-item.active i {
            color: var(--primary);
            opacity: 1;
            filter: drop-shadow(0 0 8px var(--primary));
        }

        .sidebar-footer {
            padding: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .user-profile-mini {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .user-avatar-mini {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #fff;
            font-size: 0.9rem;
        }

        .user-info-mini {
            flex: 1;
            min-width: 0;
        }

        .user-name-mini {
            font-size: 0.85rem;
            font-weight: 700;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role-mini {
            font-size: 0.65rem;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Main Content */
        .main-content {
            margin-left: 320px;
            padding: 3vh 40px 100px 20px;
            transition: all 0.4s ease;
        }

        /* Premium Top Bar */
        .top-bar {
            background: var(--bg-glass);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 1rem 1.5rem;
            margin-bottom: 2.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid var(--border);
            position: sticky;
            top: 20px;
            z-index: 900;
            box-shadow: var(--shadow-sm);
        }

        .page-title h1 {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin: 0;
            background: linear-gradient(to right, #0f172a, #334155);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Premium Components */
        .card-premium {
            background: #fff;
            border-radius: 24px;
            padding: 2rem;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .card-premium:hover {
            box-shadow: var(--shadow);
            transform: translateY(-2px);
        }

        .btn-premium {
            background: var(--primary);
            color: #fff;
            padding: 0.8rem 1.5rem;
            border-radius: 14px;
            font-weight: 700;
            border: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
        }

        .btn-premium:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
            background: var(--primary-dark);
        }

        /* Mobile Bottom Nav */
        .mobile-nav {
            display: none;
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            height: 70px;
            border-radius: 24px;
            z-index: 2000;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
            padding: 0 15px;
            align-items: center;
            justify-content: space-around;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .m-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.65rem;
            font-weight: 700;
            transition: all 0.3s ease;
            width: 60px;
        }

        .m-nav-item i {
            font-size: 1.2rem;
        }

        .m-nav-item.active {
            color: #fff;
        }

        .m-nav-item.active i {
            color: var(--primary);
            transform: scale(1.1);
        }

        /* Mobile Specific */
        @media (max-width: 992px) {
            .sidebar {
                display: none;
            }
            .main-content {
                margin-left: 0;
                padding: 20px;
                padding-bottom: 110px;
            }
            .mobile-nav {
                display: flex;
            }
            .top-bar {
                margin-bottom: 1.5rem;
                padding: 0.8rem 1.2rem;
            }
            .page-title h1 {
                font-size: 1.2rem;
            }
            .card-premium {
                padding: 1.2rem;
                border-radius: 20px;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 24px;
            border: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            gap: 12px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar for Desktop -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="logo-box">
                <i class="fas fa-building"></i>
            </div>
            <span class="logo-text">MAAK</span>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-grid-2"></i> Dashboard
            </a>
            <a href="{{ route('admin.projects.index') }}" class="nav-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                <i class="fas fa-shapes"></i> Projects
            </a>
            <a href="{{ route('admin.expenses.index') }}" class="nav-item {{ request()->routeIs('admin.expenses.*') ? 'active' : '' }}">
                <i class="fas fa-receipt"></i> Expenses
            </a>
            <a href="{{ route('admin.payments.index') }}" class="nav-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <i class="fas fa-wallet"></i> Payments
            </a>
            <a href="{{ route('admin.reports.index') }}" class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Reports
            </a>
            <div style="margin: 1rem 1rem 0.5rem; font-size: 0.7rem; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 1px;">People</div>
            <a href="{{ route('admin.supervisors.index') }}" class="nav-item {{ request()->routeIs('admin.supervisors.*') ? 'active' : '' }}">
                <i class="fas fa-user-shield"></i> Supervisors
            </a>
            <a href="{{ route('admin.clients.index') }}" class="nav-item {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
                <i class="fas fa-user-tie"></i> Clients
            </a>
        </nav>

        <div class="sidebar-footer" style="padding: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05);">
            <a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Settings
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-item" style="width: 100%; border: none; background: none; cursor: pointer; color: #ef4444;">
                    <i class="fas fa-power-off"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <nav class="mobile-nav">
        <a href="{{ route('dashboard') }}" class="m-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <a href="{{ route('admin.projects.index') }}" class="m-nav-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
            <i class="fas fa-tasks"></i>
            <span>Projects</span>
        </a>
        <a href="{{ route('admin.expenses.index') }}" class="m-nav-item {{ request()->routeIs('admin.expenses.*') ? 'active' : '' }}">
            <i class="fas fa-receipt"></i>
            <span>Expenses</span>
        </a>
        <a href="{{ route('admin.reports.index') }}" class="m-nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i>
            <span>Insight</span>
        </a>
        <a href="{{ route('admin.settings.index') }}" class="m-nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i class="fas fa-user"></i>
            <span>Profile</span>
        </a>
    </nav>

    <div class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h1>@yield('title', 'Terminal')</h1>
            </div>
            <div class="user-menu">
                <div class="profile-pill" style="display: flex; align-items: center; gap: 10px; background: #fff; padding: 6px 16px; border-radius: 50px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
                    <div style="width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), #8b5cf6); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem;">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span style="font-weight: 700; font-size: 0.85rem; color: var(--text-main);">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="card-premium" style="background: #f0fdf4; border-color: #bbf7d0; color: #166534; padding: 1rem 1.5rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 0.9rem;">
                <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="card-premium" style="background: #fef2f2; border-color: #fecaca; color: #991b1b; padding: 1.5rem; margin-bottom: 1.5rem; border-radius: 20px;">
                <div style="font-weight: 800; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-shield-exclamation"></i> Action Required
                </div>
                <ul style="margin: 0; padding-left: 1.5rem; font-size: 0.9rem; font-weight: 500;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>

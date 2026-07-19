<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <script>
        const savedTheme = localStorage.getItem('admin-theme') || 'dark';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') — Cyber-Logistic Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* ── DESIGN TOKENS ── */
        :root {
            --clh-bg-primary: #081021;
            --clh-bg-secondary: #0C1629;
            --clh-bg-panel: rgba(16, 24, 40, 0.6);
            --clh-bg-panel-solid: #101828;
            --clh-bg-input: rgba(255, 255, 255, 0.04);
            --clh-bg-hover: rgba(255, 255, 255, 0.06);
            --clh-text-primary: #F2F4F7;
            --clh-text-secondary: #7B8794;
            --clh-text-muted: #4A5568;
            --clh-accent: #00E5FF;
            --clh-accent-rgb: 0, 229, 255;
            --clh-accent-secondary: #6366F1;
            --clh-positive: #34D399;
            --clh-negative: #F87171;
            --clh-warning: #FBBF24;
            --clh-border: rgba(255, 255, 255, 0.06);
            --clh-border-accent: rgba(0, 229, 255, 0.2);
            --clh-glow: 0 0 20px rgba(0, 229, 255, 0.15);
            --clh-radius-sm: 8px;
            --clh-radius-md: 12px;
            --clh-radius-lg: 16px;
            --clh-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --clh-font-sans: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            --clh-font-mono: 'JetBrains Mono', 'Fira Code', monospace;
            --clh-sidebar-width: 260px;
        }

        [data-theme="light"] {
            --clh-bg-primary: #F0F2F5;
            --clh-bg-secondary: #E8EBF0;
            --clh-bg-panel: rgba(255, 255, 255, 0.85);
            --clh-bg-panel-solid: #FFFFFF;
            --clh-bg-input: rgba(0, 0, 0, 0.04);
            --clh-bg-hover: rgba(0, 0, 0, 0.04);
            --clh-text-primary: #0D1117;
            --clh-text-secondary: #4A5568;
            --clh-text-muted: #9CA3AF;
            --clh-accent: #0891B2;
            --clh-accent-rgb: 8, 145, 178;
            --clh-accent-secondary: #4F46E5;
            --clh-positive: #059669;
            --clh-negative: #DC2626;
            --clh-warning: #D97706;
            --clh-border: rgba(0, 0, 0, 0.08);
            --clh-border-accent: rgba(8, 145, 178, 0.2);
            --clh-glow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0; padding: 0;
            background-color: var(--clh-bg-primary);
            color: var(--clh-text-primary);
            font-family: var(--clh-font-sans);
            overflow-x: hidden;
            transition: background-color 0.4s ease, color 0.4s ease;
            -webkit-font-smoothing: antialiased;
        }

        body::before {
            content: '';
            position: fixed; top: 0; left: 0;
            width: 100%; height: 100%;
            background-image:
                linear-gradient(rgba(var(--clh-accent-rgb), 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(var(--clh-accent-rgb), 0.02) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none; z-index: 0;
            opacity: 0.5;
        }

        /* ── SIDEBAR ── */
        #sidebar {
            min-width: var(--clh-sidebar-width);
            max-width: var(--clh-sidebar-width);
            min-height: 100vh;
            background: var(--clh-bg-panel-solid);
            border-right: 1px solid var(--clh-border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; height: 100vh;
            z-index: 100;
            transition: var(--clh-transition);
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid var(--clh-border);
            display: flex; align-items: center; gap: 12px;
        }

        .sidebar-header-logo {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #6366F1, #00E5FF);
            border-radius: var(--clh-radius-sm);
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
        }

        .sidebar-header h4 { margin: 0; font-weight: 700; font-size: 0.95rem; }
        .sidebar-header small { color: var(--clh-text-muted); font-size: 0.7rem; }

        #sidebar ul.components { padding: 16px 8px; list-style: none; }

        #sidebar ul li a {
            padding: 10px 16px;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--clh-text-secondary);
            text-decoration: none;
            border-radius: var(--clh-radius-sm);
            margin-bottom: 2px;
            transition: var(--clh-transition);
            font-weight: 500;
            border-left: 3px solid transparent;
        }

        #sidebar ul li a:hover {
            color: var(--clh-text-primary);
            background: var(--clh-bg-hover);
        }

        #sidebar ul li.active > a {
            color: var(--clh-accent);
            background: rgba(var(--clh-accent-rgb), 0.08);
            border-left-color: var(--clh-accent);
            font-weight: 600;
            border-radius: 0 var(--clh-radius-sm) var(--clh-radius-sm) 0;
        }

        #sidebar ul li a i { width: 20px; text-align: center; font-size: 1rem; }

        .sidebar-logout {
            margin-top: auto;
            padding: 16px;
            border-top: 1px solid var(--clh-border);
        }

        .sidebar-logout .btn {
            background: transparent;
            color: var(--clh-negative);
            border: 1px solid rgba(248, 113, 113, 0.2);
            border-radius: var(--clh-radius-sm);
            font-weight: 600;
            font-size: 0.82rem;
            padding: 8px 16px;
            width: 100%;
            transition: var(--clh-transition);
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }

        .sidebar-logout .btn:hover {
            background: rgba(248, 113, 113, 0.1);
        }

        /* ── MAIN CONTENT ── */
        #content {
            width: 100%;
            padding: 0;
            min-height: 100vh;
            margin-left: var(--clh-sidebar-width);
            position: relative;
            z-index: 1;
        }

        /* ── TOP NAVBAR ── */
        .admin-navbar {
            background: var(--clh-bg-panel);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--clh-border);
            border-radius: 0;
            padding: 14px 24px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
            margin-bottom: 0;
        }

        .admin-navbar .page-title {
            font-weight: 700;
            font-size: 1rem;
            color: var(--clh-text-primary);
        }

        .admin-navbar .user-info {
            display: flex; align-items: center; gap: 12px;
        }

        .admin-navbar .user-name {
            font-weight: 600;
            font-size: 0.82rem;
            color: var(--clh-text-secondary);
        }

        .admin-navbar .user-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            border: 2px solid var(--clh-border);
        }

        .theme-toggle-btn {
            width: 38px; height: 38px;
            border-radius: 50%;
            border: 1px solid var(--clh-border);
            background: var(--clh-bg-input);
            color: var(--clh-text-secondary);
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; cursor: pointer;
            transition: var(--clh-transition);
        }
        .theme-toggle-btn:hover { border-color: var(--clh-accent); color: var(--clh-accent); }

        /* ── CARDS ── */
        .cyber-card {
            background: var(--clh-bg-panel);
            backdrop-filter: blur(20px);
            border: 1px solid var(--clh-border);
            border-radius: var(--clh-radius-lg);
            overflow: hidden;
            transition: var(--clh-transition);
        }

        .cyber-card:hover {
            border-color: var(--clh-border-accent);
            box-shadow: var(--clh-glow);
        }

        .cyber-card .card-header {
            background: transparent;
            border-bottom: 1px solid var(--clh-border);
            padding: 16px 20px;
            display: flex; align-items: center; justify-content: space-between;
        }

        .cyber-card .card-header h5 {
            margin: 0;
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--clh-text-primary);
        }

        .cyber-card .card-body { padding: 20px; }
        .cyber-card .card-footer { background: transparent; border-top: 1px solid var(--clh-border); padding: 12px 20px; }

        /* ── TABLES ── */
        .cyber-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.85rem;
        }

        .cyber-table thead th {
            background: rgba(var(--clh-accent-rgb), 0.05);
            color: var(--clh-accent);
            font-weight: 600;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 12px 16px;
            border-bottom: 1px solid var(--clh-border-accent);
        }

        .cyber-table tbody td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--clh-border);
            color: var(--clh-text-primary);
            vertical-align: middle;
        }

        .cyber-table tbody tr { transition: var(--clh-transition); }
        .cyber-table tbody tr:hover { background: var(--clh-bg-hover); }

        /* ── FORMS ── */
        .cyber-form-control {
            background: var(--clh-bg-input);
            border: 1px solid var(--clh-border);
            color: var(--clh-text-primary);
            border-radius: var(--clh-radius-sm);
            padding: 10px 14px;
            font-family: var(--clh-font-sans);
            font-size: 0.85rem;
            transition: var(--clh-transition);
            width: 100%;
        }

        .cyber-form-control:focus {
            border-color: var(--clh-accent);
            box-shadow: 0 0 0 3px rgba(var(--clh-accent-rgb), 0.15);
            color: var(--clh-text-primary);
            background: var(--clh-bg-input);
            outline: none;
        }

        .cyber-form-control::placeholder { color: var(--clh-text-muted); }

        .cyber-form-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--clh-text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 6px;
        }

        .btn-cyber-primary {
            background: linear-gradient(135deg, var(--clh-accent), var(--clh-accent-secondary));
            color: #fff;
            border: none;
            border-radius: var(--clh-radius-sm);
            padding: 10px 20px;
            font-weight: 700;
            font-size: 0.85rem;
            transition: var(--clh-transition);
            position: relative; overflow: hidden;
        }

        .btn-cyber-primary:hover { box-shadow: 0 0 25px rgba(var(--clh-accent-rgb), 0.3); color: #fff; transform: translateY(-1px); }

        /* ── BADGES ── */
        .cyber-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            font-family: var(--clh-font-mono);
        }

        .cyber-badge.primary { background: rgba(var(--clh-accent-rgb), 0.1); color: var(--clh-accent); }
        .cyber-badge.success { background: rgba(52, 211, 153, 0.15); color: var(--clh-positive); }
        .cyber-badge.danger { background: rgba(248, 113, 113, 0.15); color: var(--clh-negative); }
        .cyber-badge.secondary { background: var(--clh-bg-input); color: var(--clh-text-secondary); border: 1px solid var(--clh-border); }

        /* ── ALERTS ── */
        .cyber-alert-success {
            background: rgba(52, 211, 153, 0.1);
            border: 1px solid rgba(52, 211, 153, 0.2);
            border-radius: var(--clh-radius-md);
            color: var(--clh-positive);
            padding: 12px 20px;
            font-size: 0.85rem;
            display: flex; align-items: center; gap: 10px;
        }

        .cyber-alert-danger {
            background: rgba(248, 113, 113, 0.1);
            border: 1px solid rgba(248, 113, 113, 0.2);
            border-radius: var(--clh-radius-md);
            color: var(--clh-negative);
            padding: 12px 20px;
            font-size: 0.85rem;
        }

        .cyber-alert-danger ul { margin: 0; padding-left: 16px; }

        /* ── PAGINATION ── */
        .pagination .page-link {
            background: var(--clh-bg-input);
            border: 1px solid var(--clh-border);
            color: var(--clh-text-secondary);
            font-size: 0.82rem;
            transition: var(--clh-transition);
        }

        .pagination .page-link:hover { background: var(--clh-bg-hover); color: var(--clh-accent); border-color: var(--clh-border-accent); }
        .pagination .page-item.active .page-link { background: rgba(var(--clh-accent-rgb), 0.15); border-color: var(--clh-accent); color: var(--clh-accent); }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--clh-border); border-radius: 3px; }

        /* ── BTN OUTLINES ── */
        .btn-cyber-outline-danger {
            background: transparent;
            color: var(--clh-negative);
            border: 1px solid rgba(248, 113, 113, 0.3);
            border-radius: var(--clh-radius-sm);
            font-size: 0.78rem;
            font-weight: 600;
            padding: 5px 12px;
            transition: var(--clh-transition);
        }
        .btn-cyber-outline-danger:hover { background: rgba(248, 113, 113, 0.1); color: var(--clh-negative); }
        /* ── MOBILE RESPONSIVE ── */
        @media (max-width: 991.98px) {
            #sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 1040;
                position: fixed;
                height: 100vh;
            }
            #sidebar.show {
                transform: translateX(0);
            }
            #content {
                margin-left: 0 !important;
                width: 100%;
            }
        }
    </style>

    @yield('styles')
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-header-logo"><i class="bi bi-shield-lock-fill"></i></div>
            <div>
                <h4>Admin Panel</h4>
                <small>Cyber-Logistic Hub</small>
            </div>
        </div>

        <ul class="list-unstyled components">
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
            </li>
            <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <a href="{{ route('admin.users.index') }}"><i class="bi bi-people"></i> Kelola User</a>
            </li>
            <li class="{{ request()->routeIs('admin.ports.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ports.index') }}"><i class="bi bi-geo-alt"></i> Dataset Pelabuhan</a>
            </li>
            <li class="{{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                <a href="{{ route('admin.articles.index') }}"><i class="bi bi-journal-text"></i> Artikel Analisis</a>
            </li>
            <li class="{{ request()->routeIs('admin.cargo.*') ? 'active' : '' }}">
                <a href="{{ route('admin.cargo.index') }}"><i class="bi bi-box-seam"></i> Input Barang/Cargo</a>
            </li>
        </ul>

        <div class="sidebar-logout">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="btn"><i class="bi bi-box-arrow-left"></i> Logout</button>
            </form>
        </div>
    </nav>

    <!-- Page Content -->
    <div id="content">
        <nav class="admin-navbar">
            <div class="d-flex align-items-center gap-2">
                <button class="btn d-lg-none" id="adminSidebarToggle" style="color: var(--clh-text-primary); border: 1px solid var(--clh-border); border-radius: var(--clh-radius-sm); padding: 4px 10px;">
                    <i class="bi bi-list"></i>
                </button>
                <span class="page-title">@yield('page_title', 'Overview')</span>
            </div>
            <div class="user-info">
                <button id="themeToggle" class="theme-toggle-btn" title="Toggle Theme">
                    <i class="bi bi-moon-stars-fill"></i>
                </button>
                <span class="user-name">Hello, {{ Auth::user()->name ?? 'Admin' }}</span>
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=0891B2&color=fff&bold=true&format=svg" alt="Profile" class="user-avatar">
            </div>
        </nav>

        <div class="p-4" style="position: relative; z-index: 1;">
            @if(session('success'))
                <div class="cyber-alert-success mb-3">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Theme Toggle
    const themeToggle = document.getElementById('themeToggle');
    const icon = themeToggle.querySelector('i');
    function updateThemeIcon() {
        const current = document.documentElement.getAttribute('data-theme');
        icon.className = current === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
    }
    updateThemeIcon();
    themeToggle.addEventListener('click', () => {
        const current = document.documentElement.getAttribute('data-theme');
        const next = current === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', next);
        localStorage.setItem('admin-theme', next);
        updateThemeIcon();
    });

    // Mobile Sidebar Toggle
    const adminSidebarToggle = document.getElementById('adminSidebarToggle');
    if (adminSidebarToggle) {
        adminSidebarToggle.addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('show');
        });
    }
</script>
@yield('scripts')
</body>
</html>

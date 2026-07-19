<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <script>
        const savedTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <meta name="description" content="Real-time vessel tracking, port infrastructure monitoring, and cargo tracking for global supply chains.">
    <title>Monitoring — Cyber-Logistic Hub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
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
            --clh-glow-strong: 0 0 40px rgba(0, 229, 255, 0.25);
            --clh-radius-sm: 8px;
            --clh-radius-md: 12px;
            --clh-radius-lg: 16px;
            --clh-radius-xl: 20px;
            --clh-sidebar-width: 270px;
            --clh-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --clh-font-sans: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            --clh-font-mono: 'JetBrains Mono', 'Fira Code', monospace;
            --clh-sidebar-bg: rgba(8, 16, 33, 0.95);
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
            --clh-glow-strong: 0 8px 40px rgba(0, 0, 0, 0.1);
            --clh-sidebar-bg: rgba(255, 255, 255, 0.95);
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
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-image:
                linear-gradient(rgba(var(--clh-accent-rgb), 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(var(--clh-accent-rgb), 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
            z-index: 0;
            animation: gridPulse 8s ease-in-out infinite;
        }

        @keyframes gridPulse {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 0.8; }
        }

        #wrapper { display: flex; min-height: 100vh; position: relative; z-index: 1; }

        /* ── SIDEBAR ── */
        #sidebar-wrapper {
            min-width: var(--clh-sidebar-width);
            max-width: var(--clh-sidebar-width);
            background: var(--clh-sidebar-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid var(--clh-border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            z-index: 100;
            transition: var(--clh-transition);
        }

        .sidebar-heading {
            padding: 20px 24px;
            font-size: 1rem;
            font-weight: 700;
            color: var(--clh-text-primary);
            border-bottom: 1px solid var(--clh-border);
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: -0.02em;
        }

        .sidebar-logo {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--clh-accent), var(--clh-accent-secondary));
            border-radius: var(--clh-radius-sm);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 0 20px rgba(var(--clh-accent-rgb), 0.3);
        }

        .sidebar-brand-text { display: flex; flex-direction: column; line-height: 1.2; }
        .sidebar-brand-text small {
            font-size: 0.65rem; font-weight: 500;
            color: var(--clh-text-muted);
            text-transform: uppercase; letter-spacing: 0.15em;
        }

        .nav-section-label {
            padding: 20px 24px 8px;
            font-size: 0.65rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.15em;
            color: var(--clh-text-muted);
        }

        #sidebar-wrapper .list-group-item {
            background-color: transparent;
            color: var(--clh-text-secondary);
            border: none;
            padding: 11px 24px;
            font-weight: 500; font-size: 0.875rem;
            transition: var(--clh-transition);
            border-left: 3px solid transparent;
            display: flex; align-items: center; gap: 12px;
            margin: 2px 8px;
            border-radius: var(--clh-radius-sm);
        }

        #sidebar-wrapper .list-group-item i { font-size: 1.1rem; width: 22px; text-align: center; }
        #sidebar-wrapper .list-group-item:hover { color: var(--clh-text-primary); background-color: var(--clh-bg-hover); }
        #sidebar-wrapper .list-group-item.active {
            color: var(--clh-accent);
            background: rgba(var(--clh-accent-rgb), 0.08);
            border-left-color: var(--clh-accent);
            font-weight: 600;
            border-radius: 0 var(--clh-radius-sm) var(--clh-radius-sm) 0;
            margin-left: 0; padding-left: 21px;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 16px;
            border-top: 1px solid var(--clh-border);
        }

        /* ── MAIN ── */
        #page-content-wrapper { flex-grow: 1; width: 100%; margin-left: var(--clh-sidebar-width); min-height: 100vh; }

        .enterprise-navbar {
            background: var(--clh-bg-panel);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--clh-border);
            padding: 12px 24px;
            position: sticky; top: 0; z-index: 50;
        }

        .search-wrapper { position: relative; }
        .search-wrapper i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--clh-text-muted); font-size: 0.85rem; }

        .search-bar-custom {
            background: var(--clh-bg-input);
            border: 1px solid var(--clh-border);
            color: var(--clh-text-primary);
            border-radius: var(--clh-radius-xl);
            padding: 8px 18px 8px 40px;
            width: 320px; font-size: 0.85rem;
            font-family: var(--clh-font-sans);
            transition: var(--clh-transition);
        }
        .search-bar-custom:focus { border-color: var(--clh-accent); box-shadow: 0 0 0 3px rgba(var(--clh-accent-rgb), 0.15); color: var(--clh-text-primary); background: var(--clh-bg-input); outline: none; }
        .search-bar-custom::placeholder { color: var(--clh-text-muted); }

        .theme-toggle-btn {
            width: 42px; height: 42px;
            border-radius: 50%;
            border: 1px solid var(--clh-border);
            background: var(--clh-bg-input);
            color: var(--clh-text-secondary);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; cursor: pointer;
            transition: var(--clh-transition);
        }
        .theme-toggle-btn:hover { border-color: var(--clh-accent); color: var(--clh-accent); box-shadow: var(--clh-glow); }

        .profile-avatar {
            width: 38px; height: 38px; border-radius: 50%;
            border: 2px solid var(--clh-border);
            transition: var(--clh-transition);
        }
        .profile-avatar:hover { border-color: var(--clh-accent); box-shadow: 0 0 15px rgba(var(--clh-accent-rgb), 0.3); }

        .status-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 6px; }
        .status-dot.online { background: var(--clh-positive); box-shadow: 0 0 8px rgba(52,211,153,0.5); animation: statusPulse 2s ease-in-out infinite; }
        @keyframes statusPulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }

        /* ── DASHBOARD PANEL ── */
        .dashboard-panel {
            background: var(--clh-bg-panel);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--clh-border);
            border-radius: var(--clh-radius-lg);
            padding: 24px;
            transition: var(--clh-transition);
        }
        .dashboard-panel:hover { border-color: var(--clh-border-accent); box-shadow: var(--clh-glow); }

        .panel-title {
            font-size: 0.75rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.12em;
            color: var(--clh-accent); margin-bottom: 16px;
            display: flex; align-items: center; gap: 8px;
        }
        .panel-title i { font-size: 1rem; }

        /* ── TAB NAV ── */
        .cyber-tabs {
            border-bottom: 1px solid var(--clh-border);
            padding-bottom: 0;
            gap: 4px;
        }

        .cyber-tabs .nav-link {
            background: transparent;
            border: 1px solid transparent;
            border-bottom: none;
            border-radius: var(--clh-radius-sm) var(--clh-radius-sm) 0 0;
            color: var(--clh-text-secondary);
            font-weight: 600;
            font-size: 0.85rem;
            padding: 12px 20px;
            transition: var(--clh-transition);
            display: flex; align-items: center; gap: 8px;
            font-family: var(--clh-font-sans);
        }

        .cyber-tabs .nav-link:hover {
            color: var(--clh-text-primary);
            background: var(--clh-bg-hover);
        }

        .cyber-tabs .nav-link.active {
            color: var(--clh-accent) !important;
            background: rgba(var(--clh-accent-rgb), 0.08);
            border-color: var(--clh-border);
            border-bottom: 2px solid var(--clh-accent);
            margin-bottom: -1px;
        }

        .cyber-tabs .nav-link i { font-size: 1rem; }

        /* ── MAP/VESSEL CONTAINER ── */
        .vessel-container {
            border-radius: var(--clh-radius-lg);
            overflow: hidden;
            border: 1px solid var(--clh-border-accent);
            box-shadow: var(--clh-glow);
        }

        #map-ports {
            height: 75vh; width: 100%;
            border-radius: var(--clh-radius-lg);
            border: 1px solid var(--clh-border-accent);
            box-shadow: var(--clh-glow);
        }

        /* ── TRACK INPUT ── */
        .track-input-group {
            display: flex;
            gap: 0;
            border-radius: var(--clh-radius-md);
            overflow: hidden;
            border: 1px solid var(--clh-border);
            transition: var(--clh-transition);
        }

        .track-input-group:focus-within {
            border-color: var(--clh-accent);
            box-shadow: 0 0 0 3px rgba(var(--clh-accent-rgb), 0.15);
        }

        .track-input-group input {
            flex: 1;
            background: var(--clh-bg-input);
            border: none;
            color: var(--clh-text-primary);
            padding: 14px 20px;
            font-family: var(--clh-font-mono);
            font-size: 0.9rem;
        }

        .track-input-group input::placeholder { color: var(--clh-text-muted); }
        .track-input-group input:focus { outline: none; background: var(--clh-bg-input); }

        .track-input-group button {
            background: linear-gradient(135deg, var(--clh-accent), var(--clh-accent-secondary));
            border: none;
            color: #fff;
            padding: 14px 24px;
            font-weight: 700;
            font-family: var(--clh-font-sans);
            cursor: pointer;
            transition: var(--clh-transition);
            white-space: nowrap;
        }

        .track-input-group button:hover { filter: brightness(1.1); }

        .ship-search-group {
            display: flex; gap: 0;
            border-radius: var(--clh-radius-md);
            overflow: hidden;
            border: 1px solid var(--clh-border);
            max-width: 400px;
        }

        .ship-search-group input {
            flex: 1;
            background: var(--clh-bg-input);
            border: none;
            color: var(--clh-text-primary);
            padding: 10px 16px;
            font-size: 0.85rem;
            font-family: var(--clh-font-sans);
        }
        .ship-search-group input::placeholder { color: var(--clh-text-muted); }
        .ship-search-group input:focus { outline: none; }

        .ship-search-group button {
            background: var(--clh-accent);
            border: none;
            color: #081021;
            padding: 10px 16px;
            font-weight: 700;
            font-size: 0.8rem;
            cursor: pointer;
            transition: var(--clh-transition);
        }

        /* ── TRACK RESULT ── */
        .track-card {
            background: var(--clh-bg-input);
            border-radius: var(--clh-radius-md);
            padding: 20px;
            border: 1px solid var(--clh-border);
        }

        /* ── DROPDOWN ── */
        .dropdown-menu.cyber-dropdown {
            background: var(--clh-bg-panel-solid);
            border: 1px solid var(--clh-border);
            border-radius: var(--clh-radius-md);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            padding: 8px;
        }

        .cyber-dropdown .dropdown-item {
            color: var(--clh-text-primary);
            border-radius: var(--clh-radius-sm);
            padding: 8px 16px;
            font-size: 0.85rem;
            transition: var(--clh-transition);
        }

        .cyber-dropdown .dropdown-item:hover {
            background: var(--clh-bg-hover);
            color: var(--clh-accent);
        }

        .cyber-dropdown .dropdown-divider {
            border-color: var(--clh-border);
            margin: 4px 0;
        }

        .cyber-dropdown .dropdown-item.text-danger-cyber {
            color: var(--clh-negative);
        }

        .cyber-dropdown .dropdown-item.text-danger-cyber:hover {
            background: rgba(248, 113, 113, 0.1);
            color: var(--clh-negative);
        }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--clh-border); border-radius: 3px; }

        @media (max-width: 991px) {
            #sidebar-wrapper { transform: translateX(-100%); position: fixed; }
            #sidebar-wrapper.show { transform: translateX(0); }
            #page-content-wrapper { margin-left: 0; }
            .search-bar-custom { width: 200px; }
        }
        /* ── MOBILE RESPONSIVE ── */
        @media (max-width: 991.98px) {
            #sidebar-wrapper {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 1040;
            }
            #sidebar-wrapper.show {
                transform: translateX(0);
            }
            #page-content-wrapper {
                margin-left: 0 !important;
                width: 100%;
            }
            .sidebar-toggler {
                display: block !important;
            }
        }
    </style>
</head>
<body>

<div id="wrapper">
    <!-- SIDEBAR -->
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">
            <div class="sidebar-logo">🌐</div>
            <div class="sidebar-brand-text">
                Cyber-Logistic Hub
                <small>Supply Chain Intelligence</small>
            </div>
        </div>

        <div class="nav-section-label">Navigation</div>
        <div class="list-group list-group-flush">
            <a href="/dashboard" class="list-group-item list-group-item-action">
                <i class="bi bi-grid-1x2-fill"></i> Overview
            </a>
            <a href="/monitoring" class="list-group-item list-group-item-action active">
                <i class="bi bi-broadcast"></i> Monitoring
            </a>
            <a href="/news" class="list-group-item list-group-item-action">
                <i class="bi bi-newspaper"></i> News Intel
            </a>
        </div>

        <div class="sidebar-footer">
            <a href="/about" class="list-group-item list-group-item-action" style="background:transparent; border:none; color: var(--clh-text-secondary); padding: 10px 12px; border-radius: var(--clh-radius-sm); display:flex; align-items:center; gap:10px; font-size:0.85rem; text-decoration:none;">
                <i class="bi bi-info-circle"></i> About System
            </a>
        </div>
    </div>

    <!-- MAIN -->
    <div id="page-content-wrapper">
        <nav class="enterprise-navbar">
            <div class="d-flex align-items-center justify-content-between">
                <button class="btn d-lg-none me-2" id="sidebarToggle" style="color: var(--clh-text-primary); border: 1px solid var(--clh-border); border-radius: var(--clh-radius-sm);">
                    <i class="bi bi-list"></i>
                </button>

                <div class="d-flex align-items-center gap-2">
                    <span class="status-dot online"></span>
                    <span style="font-size: 0.78rem; color: var(--clh-text-muted); font-weight: 500;">System Online</span>
                </div>

                <div class="d-flex align-items-center gap-3">

                    <button id="themeToggle" class="theme-toggle-btn" title="Toggle Theme">
                        <i class="bi bi-moon-stars-fill"></i>
                    </button>
                    <div class="dropdown">
                        <a href="#" class="d-block text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="line-height: 0;">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=0891B2&color=fff&bold=true&format=svg" alt="Profile" class="profile-avatar">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end cyber-dropdown">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger-cyber"><i class="bi bi-box-arrow-left me-2"></i>Sign out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container-fluid px-4 py-4 mb-5">
            <div class="row">
                <div class="col-12">
                    <div class="dashboard-panel">

                        <!-- TABS -->
                        <ul class="nav nav-pills mb-4 cyber-tabs" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-ais-tab" data-bs-toggle="pill" data-bs-target="#pills-ais" type="button" role="tab">
                                    <i class="bi bi-broadcast-pin"></i> Live Vessel Tracking
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-ports-tab" data-bs-toggle="pill" data-bs-target="#pills-ports" type="button" role="tab">
                                    <i class="bi bi-geo-alt-fill"></i> Port Infrastructure
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-track-tab" data-bs-toggle="pill" data-bs-target="#pills-track" type="button" role="tab">
                                    <i class="bi bi-box-seam-fill"></i> Track & Trace
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <!-- TAB: Live Vessels -->
                            <div class="tab-pane fade show active" id="pills-ais" role="tabpanel">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                                    <p style="color: var(--clh-text-muted); font-size: 0.85rem; margin: 0;">
                                        <i class="bi bi-satellite me-1" style="color: var(--clh-accent);"></i>
                                        Real-time global cargo vessel satellite monitoring.
                                    </p>

                                </div>
                                <div class="vessel-container">
                                    <script type="text/javascript">
                                        var width = "100%"; var height = "800"; var names = true; var lat = 2.0; var lon = 104.0; var zoom = 4;
                                    </script>
                                    <script type="text/javascript" src="https://www.vesselfinder.com/aismap.js"></script>
                                </div>
                            </div>

                            <!-- TAB: Port Infrastructure -->
                            <div class="tab-pane fade" id="pills-ports" role="tabpanel">
                                <p style="color: var(--clh-text-muted); font-size: 0.85rem; margin-bottom: 16px;">
                                    <i class="bi bi-pin-map me-1" style="color: var(--clh-accent);"></i>
                                    Major port infrastructure across 35 supply chain nations.
                                </p>
                                <div id="map-ports"></div>
                            </div>

                            <!-- TAB: Track & Trace -->
                            <div class="tab-pane fade" id="pills-track" role="tabpanel">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <div class="text-center mb-4">
                                            <i class="bi bi-box-seam" style="font-size: 2.5rem; color: var(--clh-accent); opacity: 0.5;"></i>
                                            <h5 style="font-weight: 700; margin-top: 12px; color: var(--clh-text-primary);">Cargo Tracking System</h5>
                                            <p style="color: var(--clh-text-muted); font-size: 0.85rem;">Enter your receipt/cargo number to track shipments in real-time.</p>
                                        </div>
                                        <div class="track-input-group mb-4">
                                            <input type="text" id="trackInput" placeholder="Enter Receipt/Cargo Number (e.g., INV-2026-JKT)">
                                            <button id="trackBtn"><i class="bi bi-search me-1"></i> Track</button>
                                        </div>
                                        <div id="trackResult" class="d-none"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

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
        localStorage.setItem('theme', next);
        updateThemeIcon();
    });

    // Mobile Sidebar
    const sidebarToggle = document.getElementById('sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            document.getElementById('sidebar-wrapper').classList.toggle('show');
        });
    }
</script>

<script src="{{ asset('js/monitoring.js') }}?v={{ time() }}"></script>

</body>
</html>
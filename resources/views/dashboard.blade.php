<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <script>
        const savedTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Global Supply Chain Risk Intelligence Platform — Real-time monitoring and analytics for global logistics.">
    <title>Overview — Cyber-Logistic Hub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* ================================================================
           CYBER-LOGISTIC HUB — DESIGN SYSTEM 2026
           ================================================================ */

        /* ── COLOR TOKENS (DARK MODE DEFAULT) ── */
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
            --clh-sidebar-bg: rgba(8, 16, 33, 0.95);
            --clh-sidebar-width: 270px;
            --clh-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --clh-font-sans: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            --clh-font-mono: 'JetBrains Mono', 'Fira Code', monospace;
        }

        /* ── LIGHT MODE ── */
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

        /* ── BASE RESET ── */
        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 0;
            background-color: var(--clh-bg-primary);
            color: var(--clh-text-primary);
            font-family: var(--clh-font-sans);
            overflow-x: hidden;
            transition: background-color 0.4s ease, color 0.4s ease;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ── ANIMATED GRID BACKGROUND ── */
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

        /* ── LAYOUT ── */
        #wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

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
            top: 0;
            left: 0;
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
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--clh-accent), var(--clh-accent-secondary));
            border-radius: var(--clh-radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 0 20px rgba(var(--clh-accent-rgb), 0.3);
        }

        .sidebar-brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .sidebar-brand-text small {
            font-size: 0.65rem;
            font-weight: 500;
            color: var(--clh-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.15em;
        }

        #sidebar-wrapper .nav-section-label {
            padding: 20px 24px 8px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--clh-text-muted);
        }

        #sidebar-wrapper .list-group-item {
            background-color: transparent;
            color: var(--clh-text-secondary);
            border: none;
            padding: 11px 24px;
            font-weight: 500;
            font-size: 0.875rem;
            transition: var(--clh-transition);
            border-left: 3px solid transparent;
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 2px 8px;
            border-radius: var(--clh-radius-sm);
        }

        #sidebar-wrapper .list-group-item i {
            font-size: 1.1rem;
            width: 22px;
            text-align: center;
        }

        #sidebar-wrapper .list-group-item:hover {
            color: var(--clh-text-primary);
            background-color: var(--clh-bg-hover);
        }

        #sidebar-wrapper .list-group-item.active {
            color: var(--clh-accent);
            background: rgba(var(--clh-accent-rgb), 0.08);
            border-left-color: var(--clh-accent);
            font-weight: 600;
            border-radius: 0 var(--clh-radius-sm) var(--clh-radius-sm) 0;
            margin-left: 0;
            padding-left: 21px;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 16px;
            border-top: 1px solid var(--clh-border);
        }

        /* ── MAIN CONTENT ── */
        #page-content-wrapper {
            flex-grow: 1;
            width: 100%;
            margin-left: var(--clh-sidebar-width);
            min-height: 100vh;
        }

        /* ── TOP NAVBAR ── */
        .enterprise-navbar {
            background: var(--clh-bg-panel);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--clh-border);
            padding: 12px 24px;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .search-bar-custom {
            background: var(--clh-bg-input);
            border: 1px solid var(--clh-border);
            color: var(--clh-text-primary);
            border-radius: var(--clh-radius-xl);
            padding: 8px 18px 8px 40px;
            width: 320px;
            font-size: 0.85rem;
            font-family: var(--clh-font-sans);
            transition: var(--clh-transition);
        }

        .search-bar-custom:focus {
            border-color: var(--clh-accent);
            box-shadow: 0 0 0 3px rgba(var(--clh-accent-rgb), 0.15);
            color: var(--clh-text-primary);
            background: var(--clh-bg-input);
            outline: none;
        }

        .search-bar-custom::placeholder {
            color: var(--clh-text-muted);
        }

        .search-wrapper {
            position: relative;
        }

        .search-wrapper i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--clh-text-muted);
            font-size: 0.85rem;
        }

        /* Theme Toggle */
        .theme-toggle-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 1px solid var(--clh-border);
            background: var(--clh-bg-input);
            color: var(--clh-text-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            cursor: pointer;
            transition: var(--clh-transition);
        }

        .theme-toggle-btn:hover {
            border-color: var(--clh-accent);
            color: var(--clh-accent);
            box-shadow: var(--clh-glow);
        }

        /* Profile Avatar */
        .profile-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 2px solid var(--clh-border);
            transition: var(--clh-transition);
            cursor: pointer;
        }

        .profile-avatar:hover {
            border-color: var(--clh-accent);
            box-shadow: 0 0 15px rgba(var(--clh-accent-rgb), 0.3);
        }

        /* ── DASHBOARD PANELS (GLASSMORPHISM) ── */
        .dashboard-panel {
            background: var(--clh-bg-panel);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--clh-border);
            border-radius: var(--clh-radius-lg);
            padding: 24px;
            margin-bottom: 20px;
            transition: var(--clh-transition);
        }

        .dashboard-panel:hover {
            border-color: var(--clh-border-accent);
            box-shadow: var(--clh-glow);
        }

        .panel-title {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--clh-accent);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .panel-title i {
            font-size: 1rem;
        }

        /* ── MAP CONTAINER ── */
        #map {
            width: 100%;
            height: 100%;
            min-height: 850px;
            border-radius: var(--clh-radius-lg);
            border: 1px solid var(--clh-border-accent);
            box-shadow: var(--clh-glow);
            overflow: hidden;
        }

        /* ── DATA DISPLAY ── */
        .data-value {
            font-family: var(--clh-font-mono);
            font-weight: 600;
            font-size: 1.5rem;
        }

        .data-label {
            font-size: 0.75rem;
            color: var(--clh-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 500;
        }

        .risk-score-card {
            background: var(--clh-bg-input);
            border: 1px solid var(--clh-border);
            border-radius: var(--clh-radius-md);
            padding: 16px 20px;
            transition: var(--clh-transition);
        }

        .risk-badge {
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        .risk-badge.low { background: rgba(52, 211, 153, 0.15); color: var(--clh-positive); }
        .risk-badge.medium { background: rgba(251, 191, 36, 0.15); color: var(--clh-warning); }
        .risk-badge.high { background: rgba(248, 113, 113, 0.15); color: var(--clh-negative); }

        /* ── INDICATOR CARDS ── */
        .indicator-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-top: 16px;
        }

        .indicator-item {
            background: var(--clh-bg-input);
            border: 1px solid var(--clh-border);
            border-radius: var(--clh-radius-sm);
            padding: 12px;
            text-align: center;
            transition: var(--clh-transition);
        }

        .indicator-item:hover {
            border-color: var(--clh-border-accent);
        }

        .indicator-item strong {
            display: block;
            font-size: 0.7rem;
            color: var(--clh-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }

        .indicator-item span {
            font-family: var(--clh-font-mono);
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--clh-text-primary);
        }

        /* ── WEATHER PANEL ── */
        .weather-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            font-size: 0.82rem;
        }

        .weather-item {
            padding: 8px 12px;
            background: var(--clh-bg-input);
            border-radius: var(--clh-radius-sm);
            border: 1px solid var(--clh-border);
        }

        .weather-item strong {
            color: var(--clh-text-muted);
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .wind-panel {
            grid-column: 1 / -1;
            background: rgba(var(--clh-accent-rgb), 0.05);
            border: 1px solid var(--clh-border-accent);
            border-radius: var(--clh-radius-sm);
            padding: 12px;
        }

        /* ── BUTTONS ── */
        .btn-cyber {
            background: linear-gradient(135deg, var(--clh-accent), var(--clh-accent-secondary));
            color: #fff;
            border: none;
            border-radius: var(--clh-radius-sm);
            padding: 10px 20px;
            font-weight: 600;
            font-size: 0.85rem;
            font-family: var(--clh-font-sans);
            transition: var(--clh-transition);
            position: relative;
            overflow: hidden;
        }

        .btn-cyber::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s ease;
        }

        .btn-cyber:hover::before {
            left: 100%;
        }

        .btn-cyber:hover {
            box-shadow: var(--clh-glow-strong);
            transform: translateY(-1px);
            color: #fff;
        }

        .btn-cyber-outline {
            background: transparent;
            color: var(--clh-accent);
            border: 1px solid var(--clh-border-accent);
            border-radius: var(--clh-radius-sm);
            padding: 8px 16px;
            font-weight: 600;
            font-size: 0.8rem;
            font-family: var(--clh-font-sans);
            transition: var(--clh-transition);
        }

        .btn-cyber-outline:hover {
            background: rgba(var(--clh-accent-rgb), 0.1);
            color: var(--clh-accent);
            box-shadow: var(--clh-glow);
        }

        /* ── TABLE STYLING ── */
        .cyber-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.85rem;
        }

        .cyber-table thead th {
            background: rgba(var(--clh-accent-rgb), 0.08);
            color: var(--clh-accent);
            font-weight: 600;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 12px 16px;
            border-bottom: 1px solid var(--clh-border-accent);
            white-space: nowrap;
        }

        .cyber-table thead th:first-child { border-radius: var(--clh-radius-sm) 0 0 0; }
        .cyber-table thead th:last-child { border-radius: 0 var(--clh-radius-sm) 0 0; }

        .cyber-table tbody td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--clh-border);
            color: var(--clh-text-primary);
            font-family: var(--clh-font-mono);
            font-size: 0.82rem;
        }

        .cyber-table tbody tr {
            transition: var(--clh-transition);
        }

        .cyber-table tbody tr:hover {
            background: var(--clh-bg-hover);
        }

        /* ── MODALS ── */
        .modal-content.cyber-modal {
            background: var(--clh-bg-panel-solid);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--clh-border);
            border-radius: var(--clh-radius-lg);
            color: var(--clh-text-primary);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
        }

        .cyber-modal .modal-header {
            border-bottom: 1px solid var(--clh-border);
            padding: 20px 24px;
        }

        .cyber-modal .modal-title {
            font-weight: 700;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cyber-modal .modal-body {
            padding: 24px;
            background: var(--clh-bg-secondary);
        }

        .cyber-modal .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
            opacity: 0.5;
        }

        [data-theme="light"] .cyber-modal .btn-close {
            filter: none;
        }

        /* ── FORM CONTROLS ── */
        .form-select.cyber-select {
            background-color: var(--clh-bg-input);
            border: 1px solid var(--clh-border);
            color: var(--clh-text-primary);
            border-radius: var(--clh-radius-sm);
            font-family: var(--clh-font-sans);
            padding: 10px 16px;
        }

        .form-select.cyber-select option {
            background-color: var(--clh-bg-panel-solid);
            color: var(--clh-text-primary);
        }

        .form-select.cyber-select:focus {
            border-color: var(--clh-accent);
            box-shadow: 0 0 0 3px rgba(var(--clh-accent-rgb), 0.15);
        }

        /* ── WATCHLIST IN SIDEBAR ── */
        .watchlist-item {
            padding: 6px 24px;
            font-size: 0.8rem;
            color: var(--clh-text-secondary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .watchlist-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--clh-accent);
            box-shadow: 0 0 8px rgba(var(--clh-accent-rgb), 0.5);
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

        /* ── CHARTS ── */
        canvas {
            border-radius: var(--clh-radius-sm);
        }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb {
            background: var(--clh-border);
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--clh-text-muted);
        }

        /* ── STATUS INDICATOR ── */
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }

        .status-dot.online {
            background: var(--clh-positive);
            box-shadow: 0 0 8px rgba(52, 211, 153, 0.5);
            animation: statusPulse 2s ease-in-out infinite;
        }

        @keyframes statusPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* ── COUNTRY HEADER ── */
        .country-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--clh-accent);
            letter-spacing: -0.02em;
        }

        .country-meta {
            display: flex;
            gap: 16px;
            margin-top: 8px;
            flex-wrap: wrap;
        }

        .country-meta-item {
            font-size: 0.78rem;
            color: var(--clh-text-secondary);
        }

        .country-meta-item strong {
            color: var(--clh-text-primary);
            font-family: var(--clh-font-mono);
        }

        /* ── WEATHER STATUS ── */
        .weather-status-bar {
            background: var(--clh-bg-input);
            border: 1px solid var(--clh-border);
            border-radius: var(--clh-radius-sm);
            padding: 10px 16px;
            text-align: center;
            font-size: 0.85rem;
            color: var(--clh-text-secondary);
            margin-bottom: 16px;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 991px) {
            #sidebar-wrapper {
                transform: translateX(-100%);
                position: fixed;
            }
            #sidebar-wrapper.show {
                transform: translateX(0);
            }
            #page-content-wrapper {
                margin-left: 0;
            }
            .search-bar-custom { width: 200px; }
        }

        /* ── CURRENCY CHART AREA ── */
        .chart-container {
            background: var(--clh-bg-input);
            border: 1px solid var(--clh-border);
            border-radius: var(--clh-radius-md);
            padding: 20px;
        }

        .chart-title {
            text-align: center;
            font-size: 0.78rem;
            color: var(--clh-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 16px;
        }

        /* ── LOADING SHIMMER ── */
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .shimmer {
            background: linear-gradient(90deg, var(--clh-bg-input) 25%, var(--clh-bg-hover) 50%, var(--clh-bg-input) 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        /* ── CHANGE INDICATORS ── */
        .change-positive {
            color: var(--clh-positive);
            font-family: var(--clh-font-mono);
            font-weight: 600;
        }

        .change-negative {
            color: var(--clh-negative);
            font-family: var(--clh-font-mono);
            font-weight: 600;
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
    <!-- ═══════════════════════════════════════════ -->
    <!-- SIDEBAR                                     -->
    <!-- ═══════════════════════════════════════════ -->
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
            <a href="/dashboard" class="list-group-item list-group-item-action active">
                <i class="bi bi-grid-1x2-fill"></i> Overview
            </a>
            <a href="/monitoring" class="list-group-item list-group-item-action">
                <i class="bi bi-broadcast"></i> Monitoring
            </a>
            <a href="/news" class="list-group-item list-group-item-action">
                <i class="bi bi-newspaper"></i> News Intel
            </a>
        </div>

        <div class="nav-section-label">Watchlists</div>
        <div id="watchlistContainer">
            <div class="watchlist-item" style="color: var(--clh-text-muted);">
                <i class="bi bi-hourglass-split" style="font-size: 0.75rem;"></i>
                <small>Loading watchlist...</small>
            </div>
        </div>

        <div class="sidebar-footer">
            <a href="/about" class="list-group-item list-group-item-action" style="background:transparent; border:none; color: var(--clh-text-secondary); padding: 10px 12px; border-radius: var(--clh-radius-sm); display:flex; align-items:center; gap:10px; font-size:0.85rem; text-decoration:none; transition: var(--clh-transition);">
                <i class="bi bi-info-circle"></i> About System
            </a>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════ -->
    <!-- MAIN CONTENT                                -->
    <!-- ═══════════════════════════════════════════ -->
    <div id="page-content-wrapper">

        <!-- TOP NAVBAR -->
        <nav class="enterprise-navbar">
            <div class="d-flex align-items-center justify-content-between">
                <!-- Mobile Toggle -->
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

        <!-- DASHBOARD CONTENT -->
        <div class="container-fluid px-4 py-4">
            <div class="row g-4">

                <!-- ── MAP COLUMN ── -->
                <div class="col-lg-8 d-flex flex-column">
                    <div id="map" class="flex-grow-1"></div>
                </div>

                <!-- ── RIGHT SIDEBAR COLUMN ── -->
                <div class="col-lg-4 d-flex flex-column">

                    <!-- Country Info Panel -->
                    <div class="dashboard-panel flex-grow-1 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h4 id="countryName" class="country-name mb-0">Select a Country...</h4>
                                <div class="country-meta">
                                    <span class="country-meta-item">Code: <strong id="countryCode">-</strong></span>
                                    <span class="country-meta-item">Region: <strong id="countryRegion">-</strong></span>
                                    <span class="country-meta-item">Currency: <strong id="countryCurrency">-</strong></span>
                                </div>
                            </div>
                            <button id="btnWatchlist" class="btn-cyber-outline d-none" onclick="toggleWatchlist()">
                                <i class="bi bi-star"></i> Watch
                            </button>
                        </div>

                        <!-- Risk Score -->
                        <div class="risk-score-card d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <div class="data-label">Country Risk Score</div>
                                <div id="riskScoreLabel" class="risk-badge medium mt-1">Awaiting Data...</div>
                            </div>
                            <div class="text-end">
                                <div id="riskScoreValue" class="data-value" style="color: var(--clh-accent);">-</div>
                                <small class="data-label">/100</small>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2 mb-3">
                            <button class="btn-cyber" data-bs-toggle="modal" data-bs-target="#compareModal">
                                <i class="bi bi-arrow-left-right me-2"></i>Compare Countries
                            </button>
                            <button class="btn-cyber-outline w-100" data-bs-toggle="modal" data-bs-target="#countryNewsModal">
                                <i class="bi bi-newspaper me-2"></i>Country News Feed
                            </button>
                        </div>

                        <hr style="border-color: var(--clh-border); opacity: 1;">

                        <!-- Macro Indicators -->
                        <div class="panel-title"><i class="bi bi-bar-chart-line"></i> Macro Economic Indicators</div>
                        <div class="indicator-grid">
                            <div class="indicator-item">
                                <strong>GDP</strong>
                                <span id="val-gdp">-</span>
                            </div>
                            <div class="indicator-item">
                                <strong>Inflation</strong>
                                <span id="val-inf">-</span>
                            </div>
                            <div class="indicator-item">
                                <strong>Population</strong>
                                <span id="val-pop">-</span>
                            </div>
                        </div>
                        <div class="indicator-grid mt-2" style="grid-template-columns: 1fr 1fr;">
                            <div class="indicator-item">
                                <strong>Export (GDP%)</strong>
                                <span id="val-exp">-</span>
                            </div>
                            <div class="indicator-item">
                                <strong>Import (GDP%)</strong>
                                <span id="val-imp">-</span>
                            </div>
                        </div>

                        <canvas id="gdpChart" class="mt-3" style="width: 100%; max-height: 180px;"></canvas>
                    </div>

                    <!-- Weather Panel -->
                    <div class="dashboard-panel">
                        <div class="panel-title"><i class="bi bi-cloud-sun"></i> Weather & Logistics Airspace</div>

                        <div id="weatherStatus" class="weather-status-bar">
                            <i class="bi bi-cursor-fill me-1"></i> Click on a country to load weather data...
                        </div>

                        <div class="weather-grid">
                            <div class="weather-item">
                                <strong>Surface Temp</strong><br>
                                <span id="w-t2" style="font-family: var(--clh-font-mono);">-</span>°C
                            </div>
                            <div class="weather-item">
                                <strong>Temp (80m)</strong><br>
                                <span id="w-t80" style="font-family: var(--clh-font-mono);">-</span>°C
                            </div>
                            <div class="weather-item">
                                <strong>Cloud Cover</strong><br>
                                <span id="w-cld" style="font-family: var(--clh-font-mono);">-</span>%
                            </div>
                            <div class="weather-item">
                                <strong>Weather Code</strong><br>
                                <span id="w-code" style="font-family: var(--clh-font-mono);">-</span>
                            </div>
                            <div class="weather-item">
                                <strong>Precipitation</strong><br>
                                <span id="w-prec" style="font-family: var(--clh-font-mono);">-</span> mm
                            </div>
                            <div class="weather-item">
                                <strong>Rainfall</strong><br>
                                <span id="w-rain" style="font-family: var(--clh-font-mono);">-</span> mm
                            </div>
                            <div class="weather-item">
                                <strong>Snowfall</strong><br>
                                <span id="w-snowf" style="font-family: var(--clh-font-mono);">-</span> cm
                            </div>
                            <div class="weather-item">
                                <strong>Snow Depth</strong><br>
                                <span id="w-snowd" style="font-family: var(--clh-font-mono);">-</span> m
                            </div>

                            <div class="wind-panel">
                                <strong style="color: var(--clh-accent);"><i class="bi bi-wind me-1"></i> Logistics Wind Data</strong><br>
                                <div class="mt-1" style="font-family: var(--clh-font-mono); font-size: 0.82rem;">
                                    Level 10m: <span id="w-w10">-</span> km/h (Dir: <span id="w-d10">-</span>°)<br>
                                    Level 180m: <span id="w-w180">-</span> km/h (Dir: <span id="w-d180">-</span>°)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── CURRENCY DASHBOARD ── -->
            <div class="row mt-4 mb-5">
                <div class="col-12">
                    <div class="dashboard-panel">
                        <div class="panel-title"><i class="bi bi-currency-exchange"></i> Currency Impact Dashboard (Real-Time)</div>

                        <div class="chart-container mb-4">
                            <div class="chart-title">7-Day Fluctuation Trend — Top 5 World Currencies</div>
                            <canvas id="currencyChart" style="width: 100%; max-height: 250px;"></canvas>
                        </div>

                        <div class="table-responsive">
                            <table class="cyber-table">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="30%" class="text-start">Currency</th>
                                        <th width="30%">Value (IDR)</th>
                                        <th width="35%">Change</th>
                                    </tr>
                                </thead>
                                <tbody id="exchangeTableBody">
                                    <tr><td colspan="4" class="text-center py-4" style="color: var(--clh-text-muted);"><em>Fetching real-time exchange rates...</em></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════ -->
<!-- MODAL: COUNTRY NEWS                         -->
<!-- ═══════════════════════════════════════════ -->
<div class="modal fade" id="countryNewsModal" tabindex="-1" aria-labelledby="countryNewsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content cyber-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="countryNewsModalLabel">
                    <i class="bi bi-newspaper" style="color: var(--clh-accent);"></i>
                    Latest News: <span id="newsModalCountryName">-</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="countryNewsContainer">
                <div class="text-center py-4" style="color: var(--clh-text-muted);">
                    <i class="bi bi-globe2" style="font-size: 2rem; opacity: 0.3;"></i>
                    <p class="mt-2">Select a country on the map first...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════ -->
<!-- MODAL: COMPARE COUNTRIES                    -->
<!-- ═══════════════════════════════════════════ -->
<div class="modal fade" id="compareModal" tabindex="-1" aria-labelledby="compareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content cyber-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="compareModalLabel">
                    <i class="bi bi-arrow-left-right" style="color: var(--clh-accent);"></i>
                    Country Comparison Engine
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3 g-3">
                    <div class="col-6">
                        <select id="compareCountry1" class="form-select cyber-select">
                            <option value="">Select Country 1</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <select id="compareCountry2" class="form-select cyber-select">
                            <option value="">Select Country 2</option>
                        </select>
                    </div>
                </div>
                <div class="d-grid mb-4">
                    <button id="btnCompare" class="btn-cyber">
                        <i class="bi bi-lightning-charge me-2"></i>Compare Now
                    </button>
                </div>

                <div class="table-responsive d-none" id="compareResultWrapper">
                    <table class="cyber-table">
                        <thead>
                            <tr>
                                <th width="33%">Parameter</th>
                                <th width="33%" id="thCountry1">-</th>
                                <th width="33%" id="thCountry2">-</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="color: var(--clh-text-muted); font-family: var(--clh-font-sans); font-weight: 600;">Risk Score</td>
                                <td id="tdRisk1">-</td>
                                <td id="tdRisk2">-</td>
                            </tr>
                            <tr>
                                <td style="color: var(--clh-text-muted); font-family: var(--clh-font-sans); font-weight: 600;">GDP (Billion USD)</td>
                                <td id="tdGdp1">-</td>
                                <td id="tdGdp2">-</td>
                            </tr>
                            <tr>
                                <td style="color: var(--clh-text-muted); font-family: var(--clh-font-sans); font-weight: 600;">Inflation</td>
                                <td id="tdInf1">-</td>
                                <td id="tdInf2">-</td>
                            </tr>
                            <tr>
                                <td style="color: var(--clh-text-muted); font-family: var(--clh-font-sans); font-weight: 600;">Weather (Code)</td>
                                <td id="tdWea1">-</td>
                                <td id="tdWea2">-</td>
                            </tr>
                            <tr>
                                <td style="color: var(--clh-text-muted); font-family: var(--clh-font-sans); font-weight: 600;">Export (% GDP)</td>
                                <td id="tdExp1">-</td>
                                <td id="tdExp2">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4" id="compareChartWrapper" style="display: none;">
                    <canvas id="compareChart" style="width: 100%; max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // ── THEME TOGGLE ──
    const themeToggle = document.getElementById('themeToggle');
    const icon = themeToggle.querySelector('i');

    function updateThemeIcon() {
        const current = document.documentElement.getAttribute('data-theme');
        if (current === 'dark') {
            icon.className = 'bi bi-sun-fill';
        } else {
            icon.className = 'bi bi-moon-stars-fill';
        }
    }

    updateThemeIcon();

    themeToggle.addEventListener('click', () => {
        const current = document.documentElement.getAttribute('data-theme');
        const next = current === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', next);
        localStorage.setItem('theme', next);
        updateThemeIcon();
    });

    // ── MOBILE SIDEBAR TOGGLE ──
    const sidebarToggle = document.getElementById('sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            document.getElementById('sidebar-wrapper').classList.toggle('show');
        });
    }
</script>

<script src="{{ asset('js/dashboard.js') }}?v={{ time() }}"></script>

</body>
</html>
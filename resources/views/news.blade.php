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
    <meta name="description" content="Real-time global logistics news intelligence with AI-powered sentiment analysis.">
    <title>News Intelligence — Cyber-Logistic Hub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            position: fixed; top: 0; left: 0;
            width: 100%; height: 100%;
            background-image:
                linear-gradient(rgba(var(--clh-accent-rgb), 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(var(--clh-accent-rgb), 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none; z-index: 0;
            animation: gridPulse 8s ease-in-out infinite;
        }

        @keyframes gridPulse { 0%, 100% { opacity: 0.4; } 50% { opacity: 0.8; } }

        #wrapper { display: flex; min-height: 100vh; position: relative; z-index: 1; }

        /* ── SIDEBAR ── */
        #sidebar-wrapper {
            min-width: var(--clh-sidebar-width); max-width: var(--clh-sidebar-width);
            background: var(--clh-sidebar-bg);
            backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid var(--clh-border);
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; height: 100vh; z-index: 100;
            transition: var(--clh-transition);
        }
        .sidebar-heading { padding: 20px 24px; font-size: 1rem; font-weight: 700; color: var(--clh-text-primary); border-bottom: 1px solid var(--clh-border); display: flex; align-items: center; gap: 12px; letter-spacing: -0.02em; }
        .sidebar-logo { width: 36px; height: 36px; background: linear-gradient(135deg, var(--clh-accent), var(--clh-accent-secondary)); border-radius: var(--clh-radius-sm); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; box-shadow: 0 0 20px rgba(var(--clh-accent-rgb), 0.3); }
        .sidebar-brand-text { display: flex; flex-direction: column; line-height: 1.2; }
        .sidebar-brand-text small { font-size: 0.65rem; font-weight: 500; color: var(--clh-text-muted); text-transform: uppercase; letter-spacing: 0.15em; }
        .nav-section-label { padding: 20px 24px 8px; font-size: 0.65rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.15em; color: var(--clh-text-muted); }
        #sidebar-wrapper .list-group-item { background-color: transparent; color: var(--clh-text-secondary); border: none; padding: 11px 24px; font-weight: 500; font-size: 0.875rem; transition: var(--clh-transition); border-left: 3px solid transparent; display: flex; align-items: center; gap: 12px; margin: 2px 8px; border-radius: var(--clh-radius-sm); }
        #sidebar-wrapper .list-group-item i { font-size: 1.1rem; width: 22px; text-align: center; }
        #sidebar-wrapper .list-group-item:hover { color: var(--clh-text-primary); background-color: var(--clh-bg-hover); }
        #sidebar-wrapper .list-group-item.active { color: var(--clh-accent); background: rgba(var(--clh-accent-rgb), 0.08); border-left-color: var(--clh-accent); font-weight: 600; border-radius: 0 var(--clh-radius-sm) var(--clh-radius-sm) 0; margin-left: 0; padding-left: 21px; }
        .sidebar-footer { margin-top: auto; padding: 16px; border-top: 1px solid var(--clh-border); }

        /* ── MAIN ── */
        #page-content-wrapper { flex-grow: 1; width: 100%; margin-left: var(--clh-sidebar-width); min-height: 100vh; }
        .enterprise-navbar { background: var(--clh-bg-panel); backdrop-filter: blur(20px); border-bottom: 1px solid var(--clh-border); padding: 12px 24px; position: sticky; top: 0; z-index: 1030; }
        .theme-toggle-btn { width: 42px; height: 42px; border-radius: 50%; border: 1px solid var(--clh-border); background: var(--clh-bg-input); color: var(--clh-text-secondary); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; cursor: pointer; transition: var(--clh-transition); }
        .theme-toggle-btn:hover { border-color: var(--clh-accent); color: var(--clh-accent); box-shadow: var(--clh-glow); }
        .status-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 6px; }
        .status-dot.online { background: var(--clh-positive); box-shadow: 0 0 8px rgba(52,211,153,0.5); animation: statusPulse 2s ease-in-out infinite; }
        @keyframes statusPulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }

        /* ── NEWS CARDS ── */
        .news-card {
            background: var(--clh-bg-panel);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--clh-border);
            border-radius: var(--clh-radius-lg);
            overflow: hidden;
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .news-card:hover {
            transform: translateY(-6px);
            border-color: var(--clh-border-accent);
            box-shadow: var(--clh-glow-strong);
        }

        .news-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid var(--clh-border);
        }

        .news-card .card-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex: 1;
            background: transparent;
        }

        .news-card .card-title {
            font-weight: 700;
            font-size: 0.95rem;
            line-height: 1.4;
            color: var(--clh-text-primary);
            margin-bottom: 8px;
        }

        .news-card .card-text {
            color: var(--clh-text-secondary);
            font-size: 0.82rem;
            line-height: 1.5;
        }

        /* Sentiment Badges */
        .sentiment-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.03em;
        }
        .sentiment-badge.positive { background: rgba(52, 211, 153, 0.15); color: var(--clh-positive); }
        .sentiment-badge.negative { background: rgba(248, 113, 113, 0.15); color: var(--clh-negative); }
        .sentiment-badge.neutral { background: rgba(251, 191, 36, 0.15); color: var(--clh-warning); }

        .source-badge {
            background: rgba(var(--clh-accent-rgb), 0.1);
            color: var(--clh-accent);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .news-date {
            font-family: var(--clh-font-mono);
            font-size: 0.72rem;
            color: var(--clh-text-muted);
        }

        /* Read More Button */
        .btn-read-more {
            background: linear-gradient(135deg, var(--clh-accent), var(--clh-accent-secondary));
            color: #fff;
            border: none;
            border-radius: var(--clh-radius-sm);
            padding: 10px 20px;
            font-weight: 600;
            font-size: 0.82rem;
            width: 100%;
            text-align: center;
            text-decoration: none;
            display: block;
            transition: var(--clh-transition);
            position: relative;
            overflow: hidden;
        }

        .btn-read-more::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s ease;
        }

        .btn-read-more:hover::before { left: 100%; }
        .btn-read-more:hover { color: #fff; box-shadow: var(--clh-glow); transform: translateY(-1px); }

        /* Load More */
        .btn-load-more {
            background: transparent;
            color: var(--clh-accent);
            border: 1px solid var(--clh-border-accent);
            border-radius: var(--clh-radius-xl);
            padding: 12px 40px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: var(--clh-transition);
            cursor: pointer;
        }

        .btn-load-more:hover {
            background: rgba(var(--clh-accent-rgb), 0.1);
            box-shadow: var(--clh-glow);
        }

        .btn-load-more:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            color: var(--clh-text-muted);
            border-color: var(--clh-border);
        }

        /* Spinner */
        .cyber-spinner {
            width: 48px; height: 48px;
            border: 3px solid var(--clh-border);
            border-top-color: var(--clh-accent);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .page-header {
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 24px;
        }

        .page-header h4 {
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0;
            color: var(--clh-text-primary);
        }

        .page-header .header-icon {
            width: 40px; height: 40px;
            background: rgba(var(--clh-accent-rgb), 0.1);
            border-radius: var(--clh-radius-sm);
            display: flex; align-items: center; justify-content: center;
            color: var(--clh-accent);
            font-size: 1.2rem;
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
            <a href="/monitoring" class="list-group-item list-group-item-action">
                <i class="bi bi-broadcast"></i> Monitoring
            </a>
            <a href="/news" class="list-group-item list-group-item-action active">
                <i class="bi bi-newspaper"></i> News Intel
            </a>
        </div>
        <div class="sidebar-footer">
            <a href="/about" class="list-group-item list-group-item-action" style="background:transparent; border:none; color: var(--clh-text-secondary); padding: 10px 12px; border-radius: var(--clh-radius-sm); display:flex; align-items:center; gap:10px; font-size:0.85rem; text-decoration:none;">
                <i class="bi bi-info-circle"></i> About System
            </a>
        </div>
    </div>

    <div id="page-content-wrapper">
        <nav class="enterprise-navbar">
            <div class="d-flex align-items-center justify-content-between">
                <button class="btn d-lg-none me-2" id="sidebarToggle" style="color: var(--clh-text-primary); border: 1px solid var(--clh-border); border-radius: var(--clh-radius-sm);"><i class="bi bi-list"></i></button>
                <div class="d-flex align-items-center gap-2">
                    <span class="status-dot online"></span>
                    <span style="font-size: 0.78rem; color: var(--clh-text-muted); font-weight: 500;">System Online</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <button id="themeToggle" class="theme-toggle-btn" title="Toggle Theme"><i class="bi bi-moon-stars-fill"></i></button>
                    <div class="dropdown">
                        <a href="#" class="d-block text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="line-height: 0;">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=0891B2&color=fff&bold=true&format=svg" alt="Profile" class="profile-avatar" style="width: 38px; height: 38px; border-radius: 50%; border: 2px solid var(--clh-border); transition: var(--clh-transition);">
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
            <div class="page-header">
                <div class="header-icon"><i class="bi bi-newspaper"></i></div>
                <div>
                    <h4>Global News Intelligence</h4>
                    <p style="margin: 0; font-size: 0.78rem; color: var(--clh-text-muted);">Real-Time API • AI Sentiment Analysis</p>
                </div>
            </div>

            <div class="row g-4" id="newsContainer">
                <div class="col-12 text-center py-5" id="initialLoader">
                    <div class="cyber-spinner mx-auto"></div>
                    <p class="mt-3" style="color: var(--clh-text-muted); font-size: 0.85rem;">Fetching global logistics news data...</p>
                </div>
            </div>

            <div class="text-center mt-4 mb-5" id="loadMoreContainer" style="display:none;">
                <button id="loadMoreBtn" class="btn-load-more">Load More Articles</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

    // ── NEWS LOGIC ──
    const container = document.getElementById('newsContainer');
    const loadMoreContainer = document.getElementById('loadMoreContainer');
    const loadMoreBtn = document.getElementById('loadMoreBtn');

    let currentPage = 1;
    let hasMorePages = false;

    function loadNews(page = 1) {
        if (page === 1) {
            container.innerHTML = `<div class="col-12 text-center py-5"><div class="cyber-spinner mx-auto"></div><p class="mt-3" style="color: var(--clh-text-muted); font-size: 0.85rem;">Fetching news history...</p></div>`;
            loadMoreContainer.style.display = 'none';
        } else {
            loadMoreBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Loading...';
            loadMoreBtn.disabled = true;
        }

        fetch('/api/news?page=' + page)
            .then(async (res) => {
                if (!res.ok) throw new Error(`Server Error: ${res.status}`);
                return res.json();
            })
            .then(data => {
                if (page === 1) container.innerHTML = '';

                if (data.status === 'success') {
                    data.data.forEach(article => {
                        let img = article.image || 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=800&q=80';
                        let pubDate = new Date(article.publishedAt || Date.now());
                        let dateStr = pubDate.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });

                        let sentimentBadge = '';
                        if (article.sentiment === 'Positive') {
                            sentimentBadge = '<span class="sentiment-badge positive"><i class="bi bi-arrow-up-circle me-1"></i>Positive</span>';
                        } else if (article.sentiment === 'Negative') {
                            sentimentBadge = '<span class="sentiment-badge negative"><i class="bi bi-arrow-down-circle me-1"></i>Negative</span>';
                        } else if (article.sentiment === 'Neutral') {
                            sentimentBadge = '<span class="sentiment-badge neutral"><i class="bi bi-dash-circle me-1"></i>Neutral</span>';
                        }

                        container.innerHTML += `
                            <div class="col-md-6 col-lg-4">
                                <div class="news-card">
                                    <img src="${img}" class="news-img" alt="News" onerror="this.src='https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=800&q=80'">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                            <div class="d-flex gap-2 align-items-center flex-wrap">
                                                <span class="source-badge">${article.source.name}</span>
                                                ${sentimentBadge}
                                            </div>
                                            <span class="news-date">${dateStr}</span>
                                        </div>
                                        <h5 class="card-title" style="display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">${article.title}</h5>
                                        <p class="card-text mb-3" style="display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden;">${article.description}</p>
                                        <a href="${article.url}" target="_blank" class="btn-read-more mt-auto">Read Full Article <i class="bi bi-arrow-up-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    if (data.pagination && data.pagination.has_more_pages) {
                        hasMorePages = true;
                        loadMoreContainer.style.display = 'block';
                        loadMoreBtn.innerHTML = 'Load More Articles';
                        loadMoreBtn.disabled = false;
                    } else {
                        hasMorePages = false;
                        if (page > 1 || data.data.length > 0) {
                            loadMoreContainer.style.display = 'block';
                            loadMoreBtn.innerHTML = 'All articles loaded';
                            loadMoreBtn.disabled = true;
                        }
                    }
                } else {
                    if (page === 1) container.innerHTML = `<div class="col-12"><div class="text-center py-5" style="color: var(--clh-negative);"><i class="bi bi-exclamation-triangle" style="font-size: 2rem;"></i><p class="mt-2">Failed to load API format.</p></div></div>`;
                }
            })
            .catch(err => {
                console.error("DEBUG ERROR API:", err);
                if (page === 1) container.innerHTML = `<div class="col-12"><div class="text-center py-5" style="color: var(--clh-negative);"><i class="bi bi-wifi-off" style="font-size: 2rem;"></i><p class="mt-2"><strong>API Connection Failed:</strong> ${err.message}</p></div></div>`;
                else {
                    loadMoreBtn.innerHTML = 'Failed to load. Try again.';
                    loadMoreBtn.disabled = false;
                }
            });
    }

    loadMoreBtn.addEventListener('click', () => {
        if (hasMorePages) {
            currentPage++;
            loadNews(currentPage);
        }
    });

    loadNews(currentPage);
</script>
</body>
</html>
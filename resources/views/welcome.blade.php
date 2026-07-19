<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Cyber-Logistic Hub — Global Supply Chain Risk Intelligence Platform. Real-time monitoring, AI-powered analytics, and risk assessment.">
    <title>{{ config('app.name', 'Cyber-Logistic Hub') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: #081021;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #F2F4F7;
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* ── ANIMATED GRID ── */
        body::before {
            content: '';
            position: fixed; top: 0; left: 0;
            width: 100%; height: 100%;
            background-image:
                linear-gradient(rgba(0, 229, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 229, 255, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none; z-index: 0;
            animation: gridPulse 8s ease-in-out infinite;
        }

        @keyframes gridPulse { 0%, 100% { opacity: 0.4; } 50% { opacity: 0.8; } }

        /* ── GLOW ORBS ── */
        .orb-1 {
            position: fixed; width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(0, 229, 255, 0.06), transparent 70%);
            top: -200px; right: -100px;
            border-radius: 50%; z-index: 0;
            animation: orbFloat1 12s ease-in-out infinite;
        }
        .orb-2 {
            position: fixed; width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.06), transparent 70%);
            bottom: -150px; left: -100px;
            border-radius: 50%; z-index: 0;
            animation: orbFloat2 15s ease-in-out infinite;
        }

        @keyframes orbFloat1 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-40px, 40px); } }
        @keyframes orbFloat2 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(30px, -30px); } }

        /* ── HEADER ── */
        header {
            position: fixed; top: 0; left: 0; right: 0;
            z-index: 100;
            background: rgba(8, 16, 33, 0.8);
            backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            padding: 16px 40px;
            display: flex; align-items: center; justify-content: space-between;
        }

        .header-brand {
            display: flex; align-items: center; gap: 12px;
            text-decoration: none; color: #F2F4F7;
        }

        .header-logo {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #00E5FF, #6366F1);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 0 20px rgba(0, 229, 255, 0.3);
        }

        .header-brand-text { font-weight: 700; font-size: 0.95rem; letter-spacing: -0.02em; }

        .header-nav { display: flex; gap: 8px; }

        .header-nav a {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 9px 20px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-login {
            color: #7B8794;
            border: 1px solid transparent;
        }
        .btn-login:hover { color: #F2F4F7; border-color: rgba(255, 255, 255, 0.1); }

        .btn-register {
            background: rgba(0, 229, 255, 0.1);
            color: #00E5FF;
            border: 1px solid rgba(0, 229, 255, 0.2);
        }
        .btn-register:hover { background: rgba(0, 229, 255, 0.2); box-shadow: 0 0 20px rgba(0, 229, 255, 0.15); }

        .btn-dashboard {
            background: linear-gradient(135deg, #00E5FF, #6366F1);
            color: #fff;
            border: none;
        }
        .btn-dashboard:hover { box-shadow: 0 0 30px rgba(0, 229, 255, 0.3); transform: translateY(-1px); }

        /* ── HERO ── */
        .hero {
            position: relative; z-index: 1;
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            text-align: center;
            padding: 120px 24px 60px;
        }

        .hero-content { max-width: 800px; }

        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(0, 229, 255, 0.08);
            border: 1px solid rgba(0, 229, 255, 0.15);
            border-radius: 24px;
            padding: 8px 20px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #00E5FF;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 24px;
            animation: badgePulse 3s ease-in-out infinite;
        }

        @keyframes badgePulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(0, 229, 255, 0.1); }
            50% { box-shadow: 0 0 0 8px rgba(0, 229, 255, 0); }
        }

        .hero h1 {
            font-weight: 900;
            font-size: clamp(2.2rem, 5vw, 3.8rem);
            line-height: 1.1;
            letter-spacing: -0.04em;
            margin-bottom: 20px;
        }

        .hero h1 .gradient-text {
            background: linear-gradient(135deg, #00E5FF, #6366F1, #00E5FF);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 4s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% center; }
            50% { background-position: 100% center; }
            100% { background-position: 0% center; }
        }

        .hero-description {
            font-size: 1.05rem;
            color: #7B8794;
            line-height: 1.7;
            max-width: 580px;
            margin: 0 auto 40px;
        }

        .hero-cta {
            display: flex; gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .cta-primary {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(135deg, #00E5FF, #6366F1);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px 32px;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative; overflow: hidden;
        }

        .cta-primary::before {
            content: '';
            position: absolute; top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        .cta-primary:hover::before { left: 100%; }
        .cta-primary:hover { box-shadow: 0 0 40px rgba(0, 229, 255, 0.3); transform: translateY(-2px); color: #fff; }

        .cta-secondary {
            display: inline-flex; align-items: center; gap: 8px;
            background: transparent;
            color: #00E5FF;
            border: 1px solid rgba(0, 229, 255, 0.2);
            border-radius: 12px;
            padding: 14px 32px;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .cta-secondary:hover { background: rgba(0, 229, 255, 0.1); box-shadow: 0 0 20px rgba(0, 229, 255, 0.15); color: #00E5FF; }

        /* ── FEATURES ── */
        .features {
            position: relative; z-index: 1;
            padding: 60px 24px 100px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .features-title {
            text-align: center;
            font-weight: 800;
            font-size: 1.8rem;
            letter-spacing: -0.03em;
            margin-bottom: 48px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .feature-card {
            background: rgba(16, 24, 40, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 16px;
            padding: 28px;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            border-color: rgba(0, 229, 255, 0.2);
            box-shadow: 0 0 30px rgba(0, 229, 255, 0.1);
            transform: translateY(-4px);
        }

        .feature-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 16px;
        }

        .feature-icon.cyan { background: rgba(0, 229, 255, 0.1); color: #00E5FF; }
        .feature-icon.indigo { background: rgba(99, 102, 241, 0.1); color: #6366F1; }
        .feature-icon.emerald { background: rgba(52, 211, 153, 0.1); color: #34D399; }
        .feature-icon.amber { background: rgba(251, 191, 36, 0.1); color: #FBBF24; }
        .feature-icon.rose { background: rgba(248, 113, 113, 0.1); color: #F87171; }
        .feature-icon.purple { background: rgba(168, 85, 247, 0.1); color: #A855F7; }

        .feature-card h3 {
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 8px;
            letter-spacing: -0.01em;
        }

        .feature-card p {
            color: #7B8794;
            font-size: 0.82rem;
            line-height: 1.6;
            margin: 0;
        }

        /* ── FOOTER ── */
        footer {
            position: relative; z-index: 1;
            text-align: center;
            padding: 32px 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
            color: #4A5568;
            font-size: 0.78rem;
        }

        footer a { color: #00E5FF; text-decoration: none; }

        @media (max-width: 768px) {
            header { padding: 12px 16px; }
            .header-brand-text { display: none; }
            .hero { padding: 100px 16px 40px; }
            .features { padding: 40px 16px 60px; }
        }
    </style>
</head>
<body>

<div class="orb-1"></div>
<div class="orb-2"></div>

<header>
    <a href="/" class="header-brand">
        <div class="header-logo">🌐</div>
        <span class="header-brand-text">Cyber-Logistic Hub</span>
    </a>

    @if (Route::has('login'))
        <nav class="header-nav">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-dashboard">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-login">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-register">
                        <i class="bi bi-person-plus"></i> Register
                    </a>
                @endif
            @endauth
        </nav>
    @endif
</header>

<section class="hero">
    <div class="hero-content">
        <div class="hero-badge">
            <span style="width: 6px; height: 6px; background: #00E5FF; border-radius: 50%; box-shadow: 0 0 8px rgba(0,229,255,0.5);"></span>
            Supply Chain Intelligence Platform
        </div>

        <h1>
            Global Risk Monitoring<br>
            <span class="gradient-text">Powered by Intelligence</span>
        </h1>

        <p class="hero-description">
            Monitor global supply chains in real-time. Track vessels, analyze country risks,
            and stay ahead with AI-powered news intelligence — all from one unified dashboard.
        </p>

        <div class="hero-cta">
            @auth
                <a href="{{ url('/dashboard') }}" class="cta-primary">
                    <i class="bi bi-lightning-charge-fill"></i> Open Dashboard
                </a>
            @else
                <a href="{{ route('register') }}" class="cta-primary">
                    <i class="bi bi-rocket-takeoff-fill"></i> Get Started Free
                </a>
                <a href="{{ route('login') }}" class="cta-secondary">
                    <i class="bi bi-shield-lock"></i> Sign In
                </a>
            @endauth
        </div>
    </div>
</section>

<section class="features">
    <h2 class="features-title">Platform <span style="color: #00E5FF;">Capabilities</span></h2>

    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon cyan"><i class="bi bi-globe2"></i></div>
            <h3>Global Risk Intelligence</h3>
            <p>Real-time risk scoring for 35+ countries using macro economic indicators, political stability, and weather data.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon indigo"><i class="bi bi-broadcast-pin"></i></div>
            <h3>Live Vessel Tracking</h3>
            <p>AIS-powered satellite monitoring of cargo vessels worldwide with real-time position updates.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon emerald"><i class="bi bi-currency-exchange"></i></div>
            <h3>Currency Impact Dashboard</h3>
            <p>Track exchange rate fluctuations and their impact on global supply chain costs.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon amber"><i class="bi bi-newspaper"></i></div>
            <h3>AI News Intelligence</h3>
            <p>Automated news monitoring with Lexicon AI sentiment analysis for proactive risk detection.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon rose"><i class="bi bi-cloud-sun"></i></div>
            <h3>Weather & Logistics</h3>
            <p>Real-time weather data including wind patterns at logistics-critical altitudes.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon purple"><i class="bi bi-box-seam"></i></div>
            <h3>Cargo Track & Trace</h3>
            <p>End-to-end cargo tracking with route visualization and ETA monitoring.</p>
        </div>
    </div>
</section>

<footer>
    <p>Cyber-Logistic Hub &copy; {{ date('Y') }} — v{{ app()->version() }} • 
        <a href="https://github.com/laravel/framework/blob/13.x/CHANGELOG.md" target="_blank">Changelog</a>
    </p>
</footer>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login to Cyber-Logistic Hub — Global Supply Chain Risk Intelligence Platform">
    <title>Login — Cyber-Logistic Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: #081021;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #F2F4F7;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            -webkit-font-smoothing: antialiased;
        }

        /* ── ANIMATED GRID ── */
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-image:
                linear-gradient(rgba(0, 229, 255, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 229, 255, 0.04) 1px, transparent 1px);
            background-size: 60px 60px;
            animation: gridPulse 8s ease-in-out infinite;
            z-index: 0;
        }

        @keyframes gridPulse { 0%, 100% { opacity: 0.4; } 50% { opacity: 0.8; } }

        /* ── GLOW ORBS ── */
        body::after {
            content: '';
            position: fixed;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(0, 229, 255, 0.08), transparent 70%);
            top: -100px; right: -100px;
            border-radius: 50%;
            z-index: 0;
            animation: orbFloat 10s ease-in-out infinite;
        }

        @keyframes orbFloat {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-30px, 30px); }
        }

        .glow-orb-bottom {
            position: fixed;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.08), transparent 70%);
            bottom: -80px; left: -80px;
            border-radius: 50%;
            z-index: 0;
            animation: orbFloat2 12s ease-in-out infinite;
        }

        @keyframes orbFloat2 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, -20px); }
        }

        /* ── AUTH CARD ── */
        .auth-card {
            background: rgba(16, 24, 40, 0.6);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.06);
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
            position: relative;
            z-index: 1;
            animation: cardEntrance 0.6s ease-out;
        }

        @keyframes cardEntrance {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-logo {
            width: 52px; height: 52px;
            background: linear-gradient(135deg, #00E5FF, #6366F1);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 20px;
            box-shadow: 0 0 30px rgba(0, 229, 255, 0.3);
        }

        .auth-title {
            font-weight: 800;
            font-size: 1.4rem;
            letter-spacing: -0.03em;
            text-align: center;
            margin-bottom: 4px;
        }

        .auth-subtitle {
            color: #7B8794;
            font-size: 0.82rem;
            text-align: center;
            margin-bottom: 28px;
        }

        /* ── FORM ── */
        .form-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: #7B8794;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 6px;
        }

        .cyber-input {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: #F2F4F7;
            border-radius: 10px;
            padding: 12px 16px;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            width: 100%;
        }

        .cyber-input:focus {
            background: rgba(255, 255, 255, 0.06);
            border-color: #00E5FF;
            box-shadow: 0 0 0 3px rgba(0, 229, 255, 0.15);
            color: #F2F4F7;
            outline: none;
        }

        .cyber-input::placeholder { color: #4A5568; }

        /* ── SUBMIT BUTTON ── */
        .btn-cyber-submit {
            background: linear-gradient(135deg, #00E5FF, #6366F1);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-weight: 700;
            font-size: 0.9rem;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.02em;
        }

        .btn-cyber-submit::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-cyber-submit:hover::before { left: 100%; }

        .btn-cyber-submit:hover {
            box-shadow: 0 0 30px rgba(0, 229, 255, 0.3);
            transform: translateY(-1px);
        }

        /* ── LINKS ── */
        .auth-link {
            color: #7B8794;
            font-size: 0.82rem;
            text-align: center;
        }

        .auth-link a {
            color: #00E5FF;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
        }

        .auth-link a:hover {
            color: #6366F1;
            text-shadow: 0 0 10px rgba(0, 229, 255, 0.3);
        }

        /* ── ERROR ALERT ── */
        .cyber-alert {
            background: rgba(248, 113, 113, 0.1);
            border: 1px solid rgba(248, 113, 113, 0.2);
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 0.82rem;
        }

        .cyber-alert ul { margin: 0; padding-left: 16px; }
        .cyber-alert li { color: #F87171; margin-bottom: 2px; }
    </style>
</head>
<body>

<div class="glow-orb-bottom"></div>

<div class="auth-card">
    <div class="auth-logo">🌐</div>
    <h1 class="auth-title">Welcome Back</h1>
    <p class="auth-subtitle">Cyber-Logistic Hub • Supply Chain Intelligence</p>

    @if ($errors->any())
        <div class="cyber-alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="cyber-input" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="your@email.com">
        </div>
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="cyber-input" id="password" name="password" required placeholder="••••••••">
        </div>
        <button type="submit" class="btn-cyber-submit mb-3">
            <i class="bi bi-shield-lock me-2"></i>Secure Login
        </button>

        <div class="auth-link">
            Don't have an account? <a href="/register">Register here</a>
        </div>
    </form>
</div>

</body>
</html>

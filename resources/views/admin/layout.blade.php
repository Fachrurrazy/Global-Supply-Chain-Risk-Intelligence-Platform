<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Global Supply Chain</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9;
        }
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
            background: #2c3e50;
            color: #fff;
            transition: all 0.3s;
        }
        #sidebar .sidebar-header {
            padding: 20px;
            background: #1a252f;
        }
        #sidebar ul.components {
            padding: 20px 0;
        }
        #sidebar ul li a {
            padding: 10px 20px;
            font-size: 1.1em;
            display: block;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
        }
        #sidebar ul li a:hover, #sidebar ul li.active > a {
            color: #fff;
            background: #34495e;
        }
        #content {
            width: 100%;
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s;
        }
        .navbar-light {
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            border-radius: 8px;
        }
        @yield('styles')
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h4 class="mb-0 fw-bold">Admin Panel</h4>
            <small class="text-white-50">Global Supply Chain</small>
        </div>

        <ul class="list-unstyled components">
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
            </li>
            <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <a href="{{ route('admin.users.index') }}"><i class="bi bi-people me-2"></i> Kelola User</a>
            </li>
            <li class="{{ request()->routeIs('admin.ports.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ports.index') }}"><i class="bi bi-geo-alt me-2"></i> Dataset Pelabuhan</a>
            </li>
            <li class="{{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                <a href="{{ route('admin.articles.index') }}"><i class="bi bi-journal-text me-2"></i> Artikel Analisis</a>
            </li>
            <li class="{{ request()->routeIs('admin.cargo.*') ? 'active' : '' }}">
                <a href="{{ route('admin.cargo.index') }}"><i class="bi bi-box-seam me-2"></i> Input Barang/Cargo</a>
            </li>
        </ul>
        
        <div class="p-3 mt-5">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100"><i class="bi bi-box-arrow-left me-2"></i> Logout</button>
            </form>
        </div>
    </nav>

    <!-- Page Content -->
    <div id="content" class="bg-light">
        <nav class="navbar navbar-expand-lg navbar-light mb-4 p-3">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">@yield('page_title', 'Overview')</span>
                <div class="ms-auto d-flex align-items-center">
                    <span class="me-3 fw-semibold">Hello, {{ Auth::user()->name ?? 'Admin' }}</span>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=2c3e50&color=fff" alt="Profile" class="rounded-circle" width="40">
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>

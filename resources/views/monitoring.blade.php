<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <script>
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.documentElement.setAttribute('data-theme', savedTheme);
        }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Port Monitoring - Global Supply Chain</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    
    <style>
        :root { --bg-main: #FFFFFF; --bg-panel: #8F8F8F; --text-main: #000000; --accent-color: #74BCC4; }
        [data-theme="dark"] { --bg-main: #000000; --bg-panel: #361E6B; --text-main: #FFFFFF; --accent-color: #026902; }
        
        body { background-color: var(--bg-main); color: var(--text-main); font-family: 'Segoe UI', sans-serif; transition: all 0.3s; overflow-x: hidden; }
        
        /* ========================================= */
        /* CSS UNTUK SIDEBAR ENTERPRISE              */
        /* ========================================= */
        #wrapper { display: flex; min-height: 100vh; }
        
        #sidebar-wrapper {
            min-width: 260px;
            max-width: 260px;
            background-color: #161b22;
            border-right: 1px solid #30363d;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-heading {
            padding: 15px 20px;
            font-size: 1.2rem;
            font-weight: bold;
            color: white;
            border-bottom: 1px solid #30363d;
            display: flex;
            align-items: center;
        }

        #sidebar-wrapper .list-group-item {
            background-color: transparent;
            color: #8b949e;
            border: none;
            padding: 15px 20px;
            font-weight: 500;
            transition: all 0.2s;
        }

        #sidebar-wrapper .list-group-item:hover {
            color: #ffffff;
            background-color: rgba(255,255,255,0.05);
        }

        /* Penanda Menu Aktif */
        #sidebar-wrapper .list-group-item.active {
            color: #ffffff;
            background-color: rgba(116, 188, 196, 0.1); /* Warna accent transparan */
            border-left: 4px solid var(--accent-color);
        }

        #page-content-wrapper { flex-grow: 1; width: 100%; }
        
        /* ========================================= */
        /* CSS UNTUK TOP NAVBAR (Search & Profile)   */
        /* ========================================= */
        .enterprise-navbar { background-color: var(--bg-main); border-bottom: 1px solid #ccc; padding: 10px 20px; }
        [data-theme="dark"] .enterprise-navbar { background-color: #0d1117; border-bottom: 1px solid #30363d; }
        
        .search-bar-custom { background-color: #0d1117; border: 1px solid #30363d; color: #c9d1d9; border-radius: 6px; padding: 6px 15px; width: 300px; }
        .search-bar-custom:focus { border-color: var(--accent-color); color: #ffffff; box-shadow: none; }
        .profile-avatar { width: 35px; height: 35px; border-radius: 50%; border: 1px solid #30363d; }
        
        .dashboard-panel { background-color: var(--bg-panel); color: #FFFFFF; border-radius: 12px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        .track-card { background-color: rgba(0,0,0,0.2); border-radius: 8px; padding: 20px; border: 1px solid rgba(255,255,255,0.1); }
    </style>
</head>
<body>

<div id="wrapper">
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">
            <span style="font-size: 1.5rem; margin-right: 10px;">🌐</span>
            Global Supply
        </div>
        <div class="list-group list-group-flush mt-3">
            <a href="/" class="list-group-item list-group-item-action">📊 Overview</a>
            <a href="/monitoring" class="list-group-item list-group-item-action active">⚓ Monitoring</a>
            <a href="/news" class="list-group-item list-group-item-action">📰 News Intelligence</a>
            <a href="/about" class="list-group-item list-group-item-action mt-4 border-top border-secondary">ℹ️ About System</a>
        </div>
    </div>

    <div id="page-content-wrapper">
        
        <nav class="navbar navbar-expand-lg enterprise-navbar mb-4">
            <div class="container-fluid px-2">
                <div class="me-auto"></div> 
                
                <div class="d-flex align-items-center gap-3">
                    <input class="form-control search-bar-custom d-none d-md-block" type="search" placeholder="Search global records..." aria-label="Search">
                    <button id="themeToggle" class="btn btn-sm btn-outline-secondary border-secondary">🌗 Tema</button>
                    <img src="https://ui-avatars.com/api/?name=Admin+User&background=74BCC4&color=fff" alt="Profile" class="profile-avatar">
                </div>
            </div>
        </nav>

        <div class="container-fluid px-4 mb-5">
            <div class="row">
                <div class="col-12">
                    <div class="dashboard-panel">
                        
                        <ul class="nav nav-pills mb-4 custom-tabs" id="pills-tab" role="tablist" style="border-bottom: 2px solid #30363d; padding-bottom: 10px;">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-bold text-white" id="pills-ais-tab" data-bs-toggle="pill" data-bs-target="#pills-ais" type="button" role="tab" style="background-color: transparent; border-radius: 8px;">
                                    🚢 Live Vessel Tracking
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold text-info" id="pills-ports-tab" data-bs-toggle="pill" data-bs-target="#pills-ports" type="button" role="tab" style="background-color: transparent; border-radius: 8px;">
                                    ⚓ Port Infrastructure
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold text-warning" id="pills-track-tab" data-bs-toggle="pill" data-bs-target="#pills-track" type="button" role="tab" style="background-color: transparent; border-radius: 8px;">
                                    📦 Track & Trace
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            
                            <div class="tab-pane fade show active" id="pills-ais" role="tabpanel">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                                    <h6 class="text-muted mb-0">Satelit pemantau kapal kargo real-time global.</h6>
                                    <div class="input-group shadow-sm" style="max-width: 350px;">
                                        <input type="text" id="liveShipSearch" class="form-control bg-dark text-white border-secondary" placeholder="Cari nama kapal asli (Misal: Ever Given)...">
                                        <button class="btn btn-info fw-bold px-3" id="liveShipBtn">Cari 🚢</button>
                                    </div>
                                </div>
                                <div style="border-radius: 12px; overflow: hidden; border: 4px solid var(--accent-color);">
                                    <script type="text/javascript">
                                        var width = "100%"; var height = "800"; var names = true; var lat = 2.0; var lon = 104.0; var zoom = 4;
                                    </script>
                                    <script type="text/javascript" src="https://www.vesselfinder.com/aismap.js"></script>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-ports" role="tabpanel">
                                <h6 class="text-muted mb-3">Infrastruktur pelabuhan utama dari 35 negara rantai pasok.</h6>
                                <div id="map-ports" style="height: 75vh; width: 100%; border-radius: 12px; border: 4px solid #0b4b7c;"></div>
                            </div>

                            <div class="tab-pane fade" id="pills-track" role="tabpanel">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <h5 class="text-warning mb-3">Cari Kargo Anda</h5>
                                        <div class="input-group mb-4 shadow-sm">
                                            <input type="text" id="trackInput" class="form-control form-control-lg bg-dark text-white border-secondary" placeholder="Masukkan Nomor Resi/Kargo (Contoh: INV-2026-JKT)">
                                            <button class="btn btn-warning fw-bold px-4" id="trackBtn">Lacak 🔍</button>
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
<script src="{{ asset('js/monitoring.js') }}"></script>

</body>
</html>
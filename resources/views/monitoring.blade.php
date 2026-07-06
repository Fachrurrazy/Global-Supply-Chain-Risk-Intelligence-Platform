<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Port Monitoring - Global Supply Chain</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    
    <style>
        :root { --bg-main: #FFFFFF; --bg-panel: #8F8F8F; --text-main: #000000; --accent-color: #74BCC4; }
        [data-theme="dark"] { --bg-main: #000000; --bg-panel: #361E6B; --text-main: #FFFFFF; --accent-color: #026902; }
        
        body { background-color: var(--bg-main); color: var(--text-main); font-family: 'Segoe UI', sans-serif; transition: all 0.3s; }
        
        .enterprise-navbar { background-color: #161b22; border-bottom: 1px solid #30363d; padding: 10px 20px; }
        .enterprise-navbar .nav-link { color: #8b949e; font-weight: 500; margin-right: 15px; transition: color 0.2s; }
        .enterprise-navbar .nav-link:hover, .enterprise-navbar .nav-link.active { color: #ffffff; }
        .profile-avatar { width: 35px; height: 35px; border-radius: 50%; border: 1px solid #30363d; }
        
        .dashboard-panel { background-color: var(--bg-panel); color: #FFFFFF; border-radius: 12px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        .track-card { background-color: rgba(0,0,0,0.2); border-radius: 8px; padding: 20px; border: 1px solid rgba(255,255,255,0.1); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg enterprise-navbar mb-4">
    <div class="container-fluid px-2">
        <a class="navbar-brand d-flex align-items-center text-white text-decoration-none" href="/">
            <span style="font-size: 1.5rem; margin-right: 10px;">⚓</span>
            <span class="fw-bold" style="letter-spacing: 0.5px; font-size: 1.1rem;">Port Monitoring</span>
        </a>

        <button class="navbar-toggler bg-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#topNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="topNav">
            <ul class="navbar-nav me-auto ms-4 mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="/">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="/monitoring">Monitoring</a></li>
                <li class="nav-item"><a class="nav-link" href="#">About</a></li>
            </ul>
            <div class="d-flex align-items-center gap-3">
                <button id="themeToggle" class="btn btn-sm btn-outline-secondary text-white border-secondary">🌗 Tema</button>
                <img src="https://ui-avatars.com/api/?name=Admin+User&background=74BCC4&color=fff" alt="Profile" class="profile-avatar">
            </div>
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
                            🚢 Live Vessel Tracking (AIS)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold text-info" id="pills-ports-tab" data-bs-toggle="pill" data-bs-target="#pills-ports" type="button" role="tab" style="background-color: transparent; border-radius: 8px;">
                            ⚓ Port Infrastructure (35 Hubs)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold text-warning" id="pills-track-tab" data-bs-toggle="pill" data-bs-target="#pills-track" type="button" role="tab" style="background-color: transparent; border-radius: 8px;">
                            📦 Track & Trace (Dynamic ETA)
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    
                    <div class="tab-pane fade show active" id="pills-ais" role="tabpanel">
                        <h6 class="text-muted mb-3">Satelit pemantau kapal kargo real-time global.</h6>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="{{ asset('js/monitoring.js') }}"></script>

</body>
</html>
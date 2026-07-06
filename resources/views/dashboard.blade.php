<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Supply Chain Risk Intelligence</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <style>
        /* Sesuai spesifikasi warnamu */
        :root {
            --bg-main: #FFFFFF;
            --bg-panel: #8F8F8F;
            --text-main: #000000;
            --accent-color: #74BCC4;
        }

        [data-theme="dark"] {
            --bg-main: #000000;
            --bg-panel: #361E6B;
            --text-main: #FFFFFF;
            --accent-color: #026902;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-main);
            transition: all 0.3s ease;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .dashboard-panel {
            background-color: var(--bg-panel);
            color: #FFFFFF;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            margin-bottom: 20px;
        }

        #map {
            height: 550px;
            width: 100%;
            border-radius: 12px;
            border: 4px solid var(--accent-color);
        }
        
        .btn-custom {
            background-color: var(--accent-color);
            color: #FFFFFF;
            border: none;
            font-weight: bold;
        }
        
        .btn-custom:hover {
            opacity: 0.8;
            color: #FFFFFF;
        }
        .enterprise-navbar {
            background-color: #161b22; /* Warna gelap khas dashboard profesional */
            border-bottom: 1px solid #30363d;
            padding: 10px 20px;
        }
        .enterprise-navbar .nav-link {
            color: #8b949e;
            font-weight: 500;
            margin-right: 15px;
            transition: color 0.2s;
        }
        .enterprise-navbar .nav-link:hover, .enterprise-navbar .nav-link.active {
            color: #ffffff;
        }
        .search-bar-custom {
            background-color: #0d1117;
            border: 1px solid #30363d;
            color: #c9d1d9;
            border-radius: 6px;
            padding: 6px 15px;
            width: 250px;
        }
        .search-bar-custom:focus {
            background-color: #0d1117;
            border-color: var(--accent-color);
            color: #ffffff;
            box-shadow: none;
        }
        .search-bar-custom::placeholder {
            color: #6e7681;
        }
        .profile-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #30363d;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg enterprise-navbar mb-4">
    <div class="container-fluid px-2">
        <a class="navbar-brand d-flex align-items-center text-white text-decoration-none" href="#">
            <span style="font-size: 1.5rem; margin-right: 10px;">🌐</span>
            <span class="fw-bold" style="letter-spacing: 0.5px; font-size: 1.1rem;">Global Supply Chain</span>
        </a>

        <button class="navbar-toggler bg-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#topNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="topNav">
            <ul class="navbar-nav me-auto ms-4 mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="/dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/monitoring">Monitoring</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/about">About</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <input class="form-control search-bar-custom d-none d-md-block" type="search" placeholder="Search..." aria-label="Search">
                
                <button id="themeToggle" class="btn btn-sm btn-outline-secondary text-white border-secondary" style="white-space: nowrap;">
                    🌗 Tema
                </button>
                
                <div class="dropdown">
                    <a href="#" class="d-block text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name=Admin+User&background=74BCC4&color=fff" alt="Profile" class="profile-avatar">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" style="background-color: var(--bg-panel); border-color: gray;">
                        <li><a class="dropdown-item text-white" href="#">Settings</a></li>
                        <li><hr class="dropdown-divider bg-secondary"></li>
                        <li><a class="dropdown-item text-warning" href="#">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="container-fluid px-4">

    <div class="row">
        <div class="col-lg-8">
            <div id="map"></div>
        </div>

        <div class="col-lg-4">
            
            <div class="dashboard-panel mb-3">
                <h4 id="countryName" class="text-warning">Pilih Negara...</h4>
                <div class="d-flex justify-content-between text-sm mb-3">
                    <span>Kode: <strong id="countryCode">-</strong></span>
                    <span>Region: <strong id="countryRegion">-</strong></span>
                    <span>Mata Uang: <strong id="countryCurrency">-</strong></span>
                </div>
                
                <hr style="border-color: gray;">
                <h6 class="text-info">📊 Indikator Makro Ekonomi</h6>
                <div class="row text-center text-sm" style="font-size: 0.85rem;">
                    <div class="col-4 mb-2"><strong>GDP</strong><br><span id="val-gdp">-</span></div>
                    <div class="col-4 mb-2"><strong>Inflasi</strong><br><span id="val-inf">-</span></div>
                    <div class="col-4 mb-2"><strong>Populasi</strong><br><span id="val-pop">-</span></div>
                    <div class="col-6 mb-2"><strong>Ekspor (dari GDP)</strong><br><span id="val-exp">-</span></div>
                    <div class="col-6 mb-2"><strong>Impor (dari GDP)</strong><br><span id="val-imp">-</span></div>
                </div>

                <canvas id="gdpChart" class="mt-2" style="width: 100%; max-height: 180px;"></canvas>
            </div>

            <div class="dashboard-panel">
                <h6 class="text-info">🌤️ Kondisi Cuaca & Logistik Udara</h6>
                
                <div id="weatherStatus" class="alert p-2 text-center" style="background-color: var(--bg-main); color: var(--text-main); font-size: 0.9rem;">
                    Menunggu klik dari peta...
                </div>

                <div class="row text-sm" style="font-size: 0.85rem;">
                    <div class="col-6 mb-2">
                        <strong>Suhu Permukaan:</strong> <span id="w-t2">-</span>°C<br>
                        <strong>Suhu (80m):</strong> <span id="w-t80">-</span>°C<br>
                        <strong>Tutupan Awan:</strong> <span id="w-cld">-</span>%<br>
                        <strong>Kode Cuaca:</strong> <span id="w-code">-</span>
                    </div>
                    <div class="col-6 mb-2">
                        <strong>Presipitasi:</strong> <span id="w-prec">-</span> mm<br>
                        <strong>Curah Hujan:</strong> <span id="w-rain">-</span> mm<br>
                        <strong>Salju Turun:</strong> <span id="w-snowf">-</span> cm<br>
                        <strong>Tebal Salju:</strong> <span id="w-snowd">-</span> m
                    </div>
                    <div class="col-12 mt-1 p-2" style="background-color: rgba(0,0,0,0.2); border-radius: 5px;">
                        <strong>💨 Data Angin Logistik:</strong><br>
                        Level 10m: <span id="w-w10">-</span> km/h (Arah: <span id="w-d10">-</span>°)<br>
                        Level 180m: <span id="w-w180">-</span> km/h (Arah: <span id="w-d180">-</span>°)
                    </div>
                </div>
            </div>
            
        </div>
    </div> <div class="row mt-4 mb-5">
        <div class="col-12">
            <div class="dashboard-panel">
                <h5 class="text-info mb-3">💱 Kurs Mata Uang Asing terhadap Rupiah (IDR) - Realtime</h5>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-center" style="background-color: var(--bg-main); color: var(--text-main); border-color: gray;">
                        <thead style="background-color: #0b4b7c; color: white;">
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%" class="text-start">Mata Uang</th>
                                <th width="20%">Nilai (IDR)</th>
                                <th width="20%">Perubahan</th>
                            </tr>
                        </thead>
                        <tbody id="exchangeTableBody">
                            <tr>
                                <td colspan="4" class="text-center py-4"><em>Mengambil data kurs real-time dari satelit...</em></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div> <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="{{ asset('js/dashboard.js') }}"></script>

</body>
</html>
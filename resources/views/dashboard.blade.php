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
    <title>Global Supply Chain Risk Intelligence</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <style>
        /* Sesuai spesifikasi warnamu */
        :root { --bg-main: #FFFFFF; --bg-panel: #8F8F8F; --text-main: #000000; --accent-color: #74BCC4; }
        [data-theme="dark"] { --bg-main: #000000; --bg-panel: #361E6B; --text-main: #FFFFFF; --accent-color: #026902; }

        body { background-color: var(--bg-main); color: var(--text-main); font-family: 'Segoe UI', sans-serif; transition: all 0.3s ease; overflow-x: hidden; }

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
        
        .sidebar-heading { padding: 15px 20px; font-size: 1.2rem; font-weight: bold; color: white; border-bottom: 1px solid #30363d; display: flex; align-items: center; }

        #sidebar-wrapper .list-group-item { background-color: transparent; color: #8b949e; border: none; padding: 15px 20px; font-weight: 500; transition: all 0.2s; }
        #sidebar-wrapper .list-group-item:hover { color: #ffffff; background-color: rgba(255,255,255,0.05); }

        /* Penanda Menu Aktif (Sekarang di Overview) */
        #sidebar-wrapper .list-group-item.active {
            color: #ffffff;
            background-color: rgba(116, 188, 196, 0.1); 
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

        /* CSS KHUSUS KONTEN DASHBOARD */
        .dashboard-panel { background-color: var(--bg-panel); color: #FFFFFF; border-radius: 12px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); margin-bottom: 20px; }
        #map { height: 800px; width: 100%; border-radius: 12px; border: 4px solid var(--accent-color); }
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
            <a href="/dashboard" class="list-group-item list-group-item-action active">📊 Overview</a>
            <a href="/monitoring" class="list-group-item list-group-item-action">⚓ Monitoring</a>
            <a href="/news" class="list-group-item list-group-item-action">📰 News Intelligence</a>
            
            
            <div class="mt-4 px-3 mb-2 text-white fw-bold" style="font-size: 0.9rem;">⭐ WATCHLISTS</div>
            <div id="watchlistContainer" class="mb-2">
                <small class="px-3 text-muted">Memuat watchlist...</small>
            </div>

            <a href="/about" class="list-group-item list-group-item-action mt-auto border-top border-secondary">ℹ️ About System</a>
        </div>
    </div>

    <div id="page-content-wrapper">
        
        <nav class="navbar navbar-expand-lg enterprise-navbar mb-4">
            <div class="container-fluid px-2">
                <div class="me-auto"></div> 
                
                <div class="d-flex align-items-center gap-3">
                    <input class="form-control search-bar-custom d-none d-md-block" type="search" placeholder="Search global records..." aria-label="Search">
                    <button id="themeToggle" class="btn btn-sm btn-outline-secondary border-secondary">🌗 Tema</button>
                    
                    <div class="dropdown">
                        <a href="#" class="d-block text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=74BCC4&color=fff" alt="Profile" class="profile-avatar">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" style="background-color: var(--bg-panel); border-color: gray;">
                            <li><a class="dropdown-item text-white" href="#">Settings</a></li>
                            <li><hr class="dropdown-divider bg-secondary"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-warning">Sign out</button>
                                </form>
                            </li>
                        </ul>
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
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4 id="countryName" class="text-warning mb-0">Pilih Negara...</h4>
                            <button id="btnWatchlist" class="btn btn-sm btn-outline-warning d-none" onclick="toggleWatchlist()">⭐ Add to Watchlist</button>
                        </div>
                        <div class="d-flex justify-content-between text-sm mb-3">
                            <span>Kode: <strong id="countryCode">-</strong></span>
                            <span>Region: <strong id="countryRegion">-</strong></span>
                            <span>Mata Uang: <strong id="countryCurrency">-</strong></span>
                        </div>
                        
                        <div class="alert p-3 mb-3 d-flex align-items-center justify-content-between shadow-sm" style="background-color: var(--bg-main); color: var(--text-main); border: 1px solid gray;">
                            <div>
                                <h6 class="mb-1 fw-bold">Country Risk Score</h6>
                                <div id="riskScoreLabel" class="badge bg-secondary text-white">Menunggu Data...</div>
                            </div>
                            <div class="text-end">
                                <h2 id="riskScoreValue" class="mb-0 fw-bold" style="color: var(--accent-color);">-</h2>
                                <small class="text-muted">/100</small>
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button class="btn fw-bold text-white mb-2" style="background-color: #0b4b7c; border:none;" data-bs-toggle="modal" data-bs-target="#compareModal">⚖️ Compare with another Country</button>
                            <button class="btn fw-bold text-white" style="background-color: var(--accent-color); border:none;" data-bs-toggle="modal" data-bs-target="#countryNewsModal">📰 Lihat Berita Negara Ini</button>
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
            </div> 

           <div class="row mt-4 mb-5">
                <div class="col-12">
                    <div class="dashboard-panel">
                        <h5 class="text-info mb-3">💱 Currency Impact Dashboard (Real-Time)</h5>
                        
                        <div class="mb-4" style="background-color: rgba(0,0,0,0.2); padding: 15px; border-radius: 8px;">
                            <h6 class="text-muted text-center mb-3">Tren Fluktuasi 7 Hari Terakhir (Top 5 Mata Uang Dunia)</h6>
                            <canvas id="currencyChart" style="width: 100%; max-height: 250px;"></canvas>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle text-center" style="background-color: var(--bg-main); color: var(--text-main); border-color: gray;">
                                <thead style="background-color: #0b4b7c; color: white;">
                                    <tr>
                                        <th width="5%">No</th><th width="20%" class="text-start">Mata Uang</th><th width="20%">Nilai (IDR)</th><th width="20%">Perubahan</th>
                                    </tr>
                                </thead>
                                <tbody id="exchangeTableBody">
                                    <tr><td colspan="4" class="text-center py-4"><em>Mengambil data kurs real-time...</em></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div> </div> </div> 

<!-- Modal Country News -->
<div class="modal fade" id="countryNewsModal" tabindex="-1" aria-labelledby="countryNewsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content" style="background-color: var(--bg-panel); color: var(--text-main);">
      <div class="modal-header border-secondary">
        <h5 class="modal-title text-white" id="countryNewsModalLabel">📰 Berita Terkini: <span id="newsModalCountryName">-</span></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body bg-light text-dark p-4" id="countryNewsContainer">
        <div class="text-center py-4 text-muted">
            <p>Silakan pilih negara di peta terlebih dahulu...</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Compare -->
<div class="modal fade" id="compareModal" tabindex="-1" aria-labelledby="compareModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" style="background-color: var(--bg-panel); color: var(--text-main);">
      <div class="modal-header border-secondary">
        <h5 class="modal-title text-white" id="compareModalLabel">⚖️ Country Comparison Engine</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body bg-light text-dark text-center" style="border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
        <div class="row mb-3">
            <div class="col-6">
                <select id="compareCountry1" class="form-select form-select-lg mb-2 shadow-sm border-secondary">
                    <option value="">Select Country 1</option>
                </select>
            </div>
            <div class="col-6">
                <select id="compareCountry2" class="form-select form-select-lg mb-2 shadow-sm border-secondary">
                    <option value="">Select Country 2</option>
                </select>
            </div>
        </div>
        <div class="d-grid mb-4">
            <button id="btnCompare" class="btn btn-lg text-white fw-bold shadow" style="background-color: var(--accent-color); border:none;">Compare Now</button>
        </div>

        <div class="table-responsive d-none" id="compareResultWrapper">
            <table class="table table-hover table-bordered align-middle shadow-sm">
                <thead style="background-color: #0b4b7c; color: white;">
                    <tr>
                        <th width="33%">Parameter</th>
                        <th width="33%" id="thCountry1">-</th>
                        <th width="33%" id="thCountry2">-</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-bold bg-light">Risk Score</td>
                        <td id="tdRisk1" class="fw-bold fs-5">-</td>
                        <td id="tdRisk2" class="fw-bold fs-5">-</td>
                    </tr>
                    <tr>
                        <td class="fw-bold bg-light">GDP (Billion USD)</td>
                        <td id="tdGdp1">-</td>
                        <td id="tdGdp2">-</td>
                    </tr>
                    <tr>
                        <td class="fw-bold bg-light">Inflation</td>
                        <td id="tdInf1">-</td>
                        <td id="tdInf2">-</td>
                    </tr>
                    <tr>
                        <td class="fw-bold bg-light">Weather (Code)</td>
                        <td id="tdWea1">-</td>
                        <td id="tdWea2">-</td>
                    </tr>
                    <tr>
                        <td class="fw-bold bg-light">Export (% GDP)</td>
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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/dashboard.js') }}?v={{ time() }}"></script>

</body>
</html>
<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Intelligence - Global Supply Chain</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --bg-main: #FFFFFF; --bg-panel: #F8F9FA; --text-main: #000000; --text-muted: #6c757d; --accent-color: #74BCC4; }
        [data-theme="dark"] { --bg-main: #000000; --bg-panel: #161b22; --text-main: #FFFFFF; --text-muted: #8b949e; --accent-color: #026902; }
        
        body { background-color: var(--bg-main); color: var(--text-main); font-family: 'Segoe UI', sans-serif; transition: all 0.3s; overflow-x: hidden; }
        
        #wrapper { display: flex; min-height: 100vh; }
        #sidebar-wrapper { min-width: 260px; max-width: 260px; background-color: #161b22; border-right: 1px solid #30363d; display: flex; flex-direction: column; }
        .sidebar-heading { padding: 15px 20px; font-size: 1.2rem; font-weight: bold; color: white; border-bottom: 1px solid #30363d; display: flex; align-items: center; }
        #sidebar-wrapper .list-group-item { background-color: transparent; color: #8b949e; border: none; padding: 15px 20px; font-weight: 500; transition: all 0.2s; }
        #sidebar-wrapper .list-group-item:hover { color: #ffffff; background-color: rgba(255,255,255,0.05); }
        #sidebar-wrapper .list-group-item.active { color: #ffffff; background-color: rgba(116, 188, 196, 0.1); border-left: 4px solid var(--accent-color); }
        #page-content-wrapper { flex-grow: 1; width: 100%; }
        
        .enterprise-navbar { background-color: var(--bg-main); border-bottom: 1px solid #ccc; padding: 10px 20px; }
        [data-theme="dark"] .enterprise-navbar { background-color: #0d1117; border-bottom: 1px solid #30363d; }
        
        .news-card { 
            background-color: var(--bg-panel); 
            border: 1px solid #ccc; 
            border-radius: 12px; 
            overflow: hidden; 
            height: 100%; 
            transition: transform 0.3s, box-shadow 0.3s; 
        }
        [data-theme="dark"] .news-card { border: 1px solid #30363d; }
        .news-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.15); }
        .news-img { width: 100%; height: 200px; object-fit: cover; border-bottom: 1px solid rgba(0,0,0,0.1); }
    </style>
</head>
<body>
<div id="wrapper">
    <div id="sidebar-wrapper">
        <div class="sidebar-heading"><span style="font-size: 1.5rem; margin-right: 10px;">🌐</span> Global Supply</div>
        <div class="list-group list-group-flush mt-3">
            <a href="/" class="list-group-item list-group-item-action {{ Request::is('dashboard') || Request::is('/') ? 'active' : '' }}">📊 Overview</a>
            <a href="/monitoring" class="list-group-item list-group-item-action {{ Request::is('monitoring') ? 'active' : '' }}">⚓ Monitoring</a>
            <a href="/news" class="list-group-item list-group-item-action {{ Request::is('news') ? 'active' : '' }}">📰 News Intelligence</a>
            <a href="#" class="list-group-item list-group-item-action">📦 Inventory</a>
            <a href="#" class="list-group-item list-group-item-action">👥 Customers</a>
            <a href="#" class="list-group-item list-group-item-action">🛒 Products</a>
            <a href="/about" class="list-group-item list-group-item-action mt-4 border-top border-secondary {{ Request::is('about') ? 'active' : '' }}">ℹ️ About System</a>
        </div>
    </div>
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg enterprise-navbar mb-4">
            <div class="container-fluid px-2">
                <div class="me-auto"></div> 
                <div class="d-flex align-items-center gap-3">
                    <button id="themeToggle" class="btn btn-sm btn-outline-secondary border-secondary" style="color: var(--text-main);">🌗 Tema</button>
                </div>
            </div>
        </nav>
        
        <div class="container-fluid px-4 mb-5">
            <h4 class="text-info mb-4 fw-bold">📰 Global News Intelligence (Real-Time API)</h4>
            
            <div class="row" id="newsContainer">
                <div class="col-12 text-center py-5">
                    <div class="spinner-border text-info" role="status"></div>
                    <h5 class="mt-3 text-muted">Mengambil data berita logistik dunia...</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            let currentTheme = document.documentElement.getAttribute('data-theme');
            let targetTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', targetTheme);
        });
    }

    const container = document.getElementById('newsContainer');
    
    fetch('/api/news')
        .then(async (res) => {
            if (!res.ok) {
                const text = await res.text();
                throw new Error(`Server Error: ${res.status}`);
            }
            return res.json();
        })
        .then(data => {
            container.innerHTML = ''; 
            
            if (data.status === 'success') {
                if (data.note === 'using_mock_data') {
                    container.innerHTML = `<div class="col-12 mb-3"><div class="alert alert-warning text-center fw-bold">⚠️ Menampilkan Data Simulasi (API Key GNews mungkin limit atau ada kesalahan jaringan).</div></div>`;
                }

                data.data.forEach(article => {
                    let img = article.image || 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=800&q=80';
                    let pubDate = new Date(article.publishedAt || Date.now());
                    let dateStr = pubDate.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });

                    container.innerHTML += `
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card news-card shadow-sm d-flex flex-column h-100" style="background-color: var(--bg-panel); border: 1px solid rgba(128,128,128,0.2);">
                                <img src="${img}" class="card-img-top news-img" alt="News" style="height:200px; object-fit:cover;">
                                <div class="card-body d-flex flex-column p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="badge bg-info text-dark fw-bold px-3 py-2">${article.source.name}</span>
                                        <small class="text-muted fw-bold">${dateStr}</small>
                                    </div>
                                    <h5 class="card-title fw-bold" style="display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">${article.title}</h5>
                                    <p class="card-text text-muted" style="display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden;">${article.description}</p>
                                    <a href="${article.url}" target="_blank" class="btn btn-warning fw-bold w-100 mt-auto py-2" style="border-radius: 8px;">Baca Selengkapnya ↗</a>
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                container.innerHTML = `<div class="alert alert-danger w-100 text-center">Gagal memuat format API.</div>`;
            }
        })
        .catch(err => {
            console.error("DEBUG ERROR API:", err);
            container.innerHTML = `<div class="alert alert-danger w-100 text-center"><b>Gagal Terhubung ke API:</b> ${err.message}</div>`;
        });
</script>
</body>
</html>
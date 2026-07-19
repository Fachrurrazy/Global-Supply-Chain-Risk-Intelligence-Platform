document.addEventListener("DOMContentLoaded", function() {
    // Tema ditangani di inline script monitoring.blade.php


    // 2. LOGIKA PETA PELABUHAN (DINAMIS DARI MYSQL)
    const mapElement = document.getElementById('map-ports');
    if (mapElement) {
        const map = L.map('map-ports').setView([20, 10], 2); 
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors', maxZoom: 18
        }).addTo(map);

        const portIcon = L.divIcon({
            html: '<div style="font-size: 22px; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">⚓</div>',
            className: 'custom-div-icon', iconSize: [24, 24], iconAnchor: [12, 12]
        });

        // ===============================================
        // MENGAMBIL DATA PELABUHAN DARI DATABASE LARAVEL
        // ===============================================
        fetch('/api/ports')
            .then(res => res.json())
            .then(response => {
                if(response.status === 'success') {
                    response.data.forEach(port => {
                        L.marker([port.lat, port.lng], {icon: portIcon})
                         .addTo(map)
                         .bindTooltip(`<b>${port.name}</b><br>${port.country}`);
                    });
                }
            })
            .catch(err => console.error("Gagal memuat pelabuhan:", err));

        const portsTab = document.getElementById('pills-ports-tab');
        if(portsTab) {
            portsTab.addEventListener('shown.bs.tab', () => setTimeout(() => map.invalidateSize(), 100));
        }
    }

    // 3. LOGIKA TRACK & TRACE (DINAMIS DARI MYSQL)
    const trackBtn = document.getElementById('trackBtn');
    const trackInput = document.getElementById('trackInput');
    const trackResult = document.getElementById('trackResult');

    if (trackBtn) {
        trackBtn.addEventListener('click', function() {
            const resi = trackInput.value.trim().toUpperCase();
            if (resi === "") return alert("Harap masukkan nomor resi!");

            trackResult.classList.remove('d-none');
            trackResult.innerHTML = `<div class="text-center p-4 text-info"><h5>🛰️ Memindai Database & Satelit...</h5><div class="spinner-border mt-2"></div></div>`;

            // ===============================================
            // MENGAMBIL DATA RESI DARI DATABASE LARAVEL
            // ===============================================
            fetch(`/api/track-cargo/${resi}`)
                .then(res => res.json())
                .then(dbRes => {
                    if (dbRes.status !== 'success') {
                        trackResult.innerHTML = `<div class="alert alert-danger">Nomor resi <b>${resi}</b> tidak ditemukan di sistem Database.</div>`;
                        return;
                    }

                    const cargoData = dbRes.data;

                    // Lanjut tembak API Cuaca Open-Meteo menggunakan kordinat dari MySQL
                    fetch(`https://api.open-meteo.com/v1/forecast?latitude=${cargoData.current_lat}&longitude=${cargoData.current_lng}&current_weather=true`)
                        .then(res => res.json())
                        .then(weatherData => {
                            const windSpeed = weatherData.current_weather.windspeed;
                            
                            let etaStatus = windSpeed > 35 
                                ? `<span class="badge bg-danger fs-6">🔴 DELAYED (Cuaca Buruk)</span>` 
                                : `<span class="badge bg-success fs-6">🟢 ON-SCHEDULE (Tepat Waktu)</span>`;
                                
                            let weatherAlert = windSpeed > 35 
                                ? `<div class="alert alert-danger mt-3 mb-0"><b>Peringatan Badai:</b> Kecepatan angin ${windSpeed} km/h. Estimasi ditunda 2-3 Hari.</div>` 
                                : `<div class="alert alert-success mt-3 mb-0">Cuaca rute aman (${windSpeed} km/h). Kapal optimal.</div>`;
                            
                            let finalETA = windSpeed > 35 ? "Ditunda karena cuaca" : cargoData.standard_eta;

                            let miniMapHtml = `
                                <div class="mt-4">
                                    <p class="mb-2 text-muted" style="font-size: 0.9rem;">📍 Pantauan Lalu Lintas Satelit di Titik Kargo</p>
                                    <div style="border-radius: 8px; overflow: hidden; border: 2px solid var(--accent-color); height: 500px;">
                                        <iframe name="vesselfinder" id="vesselfinder" width="100%" height="100%" frameborder="0" 
                                            src="https://www.vesselfinder.com/aismap?zoom=7&lat=${cargoData.current_lat}&lon=${cargoData.current_lng}&track=true&names=true&fleet=false&status=false">
                                        </iframe>
                                    </div>
                                </div>
                            `;

                            // Render Hasil ke Layar beserta Peta Mini
                            trackResult.innerHTML = `
                                <div class="track-card shadow-lg">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4>📜 Resi: ${cargoData.resi_number}</h4>
                                        ${etaStatus}
                                    </div>
                                    <hr style="border-color: gray;">
                                    <div class="row">
                                        <div class="col-md-6 mb-3"><p class="mb-1 text-muted">Isi Kargo</p><h6 class="fw-bold">${cargoData.item}</h6></div>
                                        <div class="col-md-6 mb-3"><p class="mb-1 text-muted">Rute Pengiriman</p><h6 class="fw-bold">${cargoData.route}</h6></div>
                                        <div class="col-md-6 mb-3"><p class="mb-1 text-muted">Kapal (Vessel)</p><h6 class="fw-bold text-info">🚢 ${cargoData.vessel}</h6></div>
                                        <div class="col-md-6 mb-3"><p class="mb-1 text-muted">Estimasi Tiba (ETA)</p><h6 class="fw-bold text-warning">📅 ${finalETA}</h6></div>
                                    </div>
                                    ${weatherAlert}
                                    ${miniMapHtml}
                                </div>`;
                        });
                })
                .catch(err => {
                    trackResult.innerHTML = `<div class="alert alert-danger">Terjadi kesalahan sistem/jaringan.</div>`;
                });
        });
    }
});
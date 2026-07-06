document.addEventListener("DOMContentLoaded", function() {
    // 1. Logika Tema
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            let currentTheme = document.documentElement.getAttribute('data-theme');
            let targetTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', targetTheme);
            themeToggle.innerText = targetTheme === 'dark' ? 'Beralih Mode Terang' : 'Beralih Mode Gelap';
        });
    }

    let gdpChartInstance = null;

    // 2. Inisialisasi Peta
    const mapElement = document.getElementById('map');
    if (mapElement) {
        const map = L.map('map').setView([20, 0], 2); 
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 18
        }).addTo(map);

        const weatherStatus = document.getElementById('weatherStatus');

        // 3. Fetch Data Negara
        fetch('/api/countries')
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    if (weatherStatus) weatherStatus.innerHTML = `<strong>Berhasil memuat negara. Silakan klik peta!</strong>`;
                    
                    const customIcon = L.icon({
                        iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
                        iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
                        shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                        iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34]
                    });

                    data.data.forEach(country => {
                        let marker = L.marker([country.lat, country.lng], {icon: customIcon}).addTo(map);
                        marker.bindTooltip(`<b>${country.name}</b>`);
                        
                        marker.on('click', function() {
                            // Update Info Dasar
                            document.getElementById('countryName').innerText = country.name;
                            document.getElementById('countryCode').innerText = country.code;
                            document.getElementById('countryRegion').innerText = country.region;
                            document.getElementById('countryCurrency').innerText = country.currency || 'N/A';
                            
                            weatherStatus.innerHTML = `<em>Mengambil data API Real-time...</em>`;

                            fetch(`/api/country-data/${country.code}?lat=${country.lat}&lng=${country.lng}`)
                                .then(res => res.json())
                                .then(detail => {
                                    if(detail.status === 'success') {
                                        // --- A. ISI DATA EKONOMI ---
                                        const e = detail.economy;
                                        document.getElementById('val-gdp').innerText = e.GDP ? '$' + (e.GDP / 1e9).toFixed(1) + 'B' : 'N/A';
                                        document.getElementById('val-inf').innerText = e.Inflasi ? e.Inflasi.toFixed(1) + '%' : 'N/A';
                                        document.getElementById('val-pop').innerText = e.Populasi ? (e.Populasi / 1e6).toFixed(1) + 'M' : 'N/A';
                                        document.getElementById('val-exp').innerText = e.Ekspor ? e.Ekspor.toFixed(1) + '%' : 'N/A';
                                        document.getElementById('val-imp').innerText = e.Impor ? e.Impor.toFixed(1) + '%' : 'N/A';

                                        // --- B. ISI DATA CUACA LENGKAP ---
                                        const w = detail.weather;
                                        document.getElementById('w-t2').innerText = w.temp_2m;
                                        document.getElementById('w-t80').innerText = w.temp_80m;
                                        document.getElementById('w-cld').innerText = w.cloud_cover;
                                        document.getElementById('w-code').innerText = w.weather_code;
                                        document.getElementById('w-prec').innerText = w.precipitation;
                                        document.getElementById('w-rain').innerText = w.rain;
                                        document.getElementById('w-snowf').innerText = w.snowfall;
                                        document.getElementById('w-snowd').innerText = w.snow_depth;
                                        document.getElementById('w-w10').innerText = w.wind_speed_10m;
                                        document.getElementById('w-d10').innerText = w.wind_dir_10m;
                                        document.getElementById('w-w180').innerText = w.wind_speed_180m;
                                        document.getElementById('w-d180').innerText = w.wind_dir_180m;

                                        weatherStatus.innerHTML = `<strong>Data berhasil diperbarui!</strong>`;

                                        // --- C. RENDER GRAFIK CHART.JS ---
                                        const ctx = document.getElementById('gdpChart');
                                        if (gdpChartInstance) gdpChartInstance.destroy();
                                        
                                        gdpChartInstance = new Chart(ctx.getContext('2d'), {
                                            type: 'line',
                                            data: {
                                                labels: detail.chart.labels,
                                                datasets: [{
                                                    label: 'GDP (Miliar USD)',
                                                    data: detail.chart.data,
                                                    borderColor: '#74BCC4',
                                                    backgroundColor: 'rgba(116, 188, 196, 0.2)',
                                                    borderWidth: 2,
                                                    fill: true,
                                                    tension: 0.3
                                                }]
                                            },
                                            options: {
                                                responsive: true,
                                                maintainAspectRatio: false, // Penting agar grafik tidak terlalu besar
                                                plugins: { legend: { labels: { color: 'gray' } } }
                                            }
                                        });
                                    }
                                })
                                .catch(err => {
                                    console.error(err);
                                    if (weatherStatus) weatherStatus.innerHTML = `<strong class="text-danger">Gagal menarik data!</strong>`;
                                });
                        });
                    });
                }
            });
    }
    // ==========================================
    // 4. FETCH DATA KURS MATA UANG (DI BAWAH PETA)
    // ==========================================
    fetch('/api/exchange-rates')
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('exchangeTableBody');
            if(data.status === 'success' && tbody) {
                tbody.innerHTML = ''; // Kosongkan tulisan "Mengambil data..."
                
                data.data.forEach(item => {
                    // Format angka menjadi Rupiah yang cantik (misal: Rp 15.503,00)
                    let valStr = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.value);
                    
                    // Logika warna dan ikon panah (Naik = Biru/Hijau, Turun = Merah)
                    let isUp = item.change >= 0;
                    let changeColor = isUp ? 'text-primary' : 'text-danger'; // Biru untuk naik, merah untuk turun
                    let changeIcon = isUp ? '▲' : '▼';
                    let changeStr = `${Math.abs(item.change).toFixed(2)} ${changeIcon}`;

                    // Trik Cerdas: Mengambil bendera otomatis menggunakan 2 huruf depan mata uang
                    // (misal: USD -> US, EUR -> EU)
                    let flagCode = item.code.substring(0, 2).toLowerCase();
                    let flagUrl = `https://flagcdn.com/24x18/${flagCode}.png`;

                    tbody.innerHTML += `
                        <tr>
                            <td>${item.no}</td>
                            <td class="text-start">
                                <img src="${flagUrl}" alt="${item.code}" class="me-2 shadow-sm" style="border: 1px solid #ccc; border-radius: 2px;">
                                ${item.name} (${item.code})
                            </td>
                            <td><strong>${valStr}</strong></td>
                            <td class="${changeColor}"><strong>${changeStr}</strong></td>
                        </tr>
                    `;
                });
            }
        })
        .catch(err => console.error('Gagal memuat kurs:', err));
});
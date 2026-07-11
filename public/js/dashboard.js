document.addEventListener("DOMContentLoaded", function() {
    // 1. Logika Tema
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        // Inisialisasi teks tombol berdasarkan tema saat ini
        let currentTheme = document.documentElement.getAttribute('data-theme');
        themeToggle.innerText = currentTheme === 'dark' ? 'Beralih Mode Terang' : 'Beralih Mode Gelap';

        themeToggle.addEventListener('click', () => {
            currentTheme = document.documentElement.getAttribute('data-theme');
            let targetTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', targetTheme);
            localStorage.setItem('theme', targetTheme);
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

        window.appMap = map;
        window.appMarkers = {};

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
                        // Populate select options for compare
                        let sel1 = document.getElementById('compareCountry1');
                        let sel2 = document.getElementById('compareCountry2');
                        if (sel1 && sel2) {
                            sel1.options.add(new Option(country.name, country.code));
                            sel1.options[sel1.options.length - 1].dataset.lat = country.lat;
                            sel1.options[sel1.options.length - 1].dataset.lng = country.lng;
                            
                            sel2.options.add(new Option(country.name, country.code));
                            sel2.options[sel2.options.length - 1].dataset.lat = country.lat;
                            sel2.options[sel2.options.length - 1].dataset.lng = country.lng;
                        }

                        let marker = L.marker([country.lat, country.lng], {icon: customIcon}).addTo(map);
                        marker.bindTooltip(`<b>${country.name}</b>`);
                        window.appMarkers[country.code] = marker;
                        
                        marker.on('click', function() {
                            // Update Info Dasar
                            document.getElementById('countryName').innerText = country.name;
                            document.getElementById('countryCode').innerText = country.code;
                            document.getElementById('countryRegion').innerText = country.region;
                            document.getElementById('countryCurrency').innerText = country.currency || 'N/A';
                            
                            weatherStatus.innerHTML = `<em>Mengambil data API Real-time...</em>`;
                            document.getElementById('riskScoreLabel').innerText = "Menghitung...";
                            document.getElementById('riskScoreValue').innerText = "-";
                            document.getElementById('riskScoreLabel').className = "badge bg-secondary text-white";

                            fetch(`/api/country-data/${country.code}?lat=${country.lat}&lng=${country.lng}&name=${encodeURIComponent(country.name)}`)
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

                                        // --- C. UPDATE RISK SCORE ---
                                        if (detail.risk) {
                                            const risk = detail.risk;
                                            document.getElementById('riskScoreValue').innerText = risk.score;
                                            let labelClass = 'bg-success';
                                            if(risk.score > 30) labelClass = 'bg-warning text-dark';
                                            if(risk.score > 60) labelClass = 'bg-danger';
                                            
                                            const rLabel = document.getElementById('riskScoreLabel');
                                            rLabel.innerText = risk.label;
                                            rLabel.className = `badge ${labelClass} text-white`;
                                        }

                                        if (window.updateWatchlistButton) {
                                            window.updateWatchlistButton(country.code);
                                        }

                                        // --- D. RENDER GRAFIK CHART.JS ---
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
    // 4. FETCH DATA KURS MATA UANG & RENDER CHART.JS
    // ==========================================
    fetch('/api/exchange-rates')
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('exchangeTableBody');
            if(data.status === 'success' && tbody) {
                tbody.innerHTML = ''; 
                data.data.forEach(item => {
                    let valStr = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.value);
                    let isUp = item.change >= 0;
                    let changeColor = isUp ? 'text-primary' : 'text-danger';
                    let changeIcon = isUp ? '▲' : '▼';
                    let changeStr = `${Math.abs(item.change).toFixed(2)} ${changeIcon}`;
                    let flagCode = item.code.substring(0, 2).toLowerCase();
                    let flagUrl = `https://flagcdn.com/24x18/${flagCode}.png`;

                    tbody.innerHTML += `
                        <tr>
                            <td>${item.no}</td>
                            <td class="text-start"><img src="${flagUrl}" class="me-2 shadow-sm" style="border: 1px solid #ccc;"> ${item.name} (${item.code})</td>
                            <td><strong>${valStr}</strong></td>
                            <td class="${changeColor}"><strong>${changeStr}</strong></td>
                        </tr>
                    `;
                });

                // RENDER CHART.JS MATA UANG
                const ctxCurrency = document.getElementById('currencyChart');
                if (ctxCurrency) {
                    // Warna garis untuk setiap negara agar estetik
                    const colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'];
                    
                    data.chart.datasets.forEach((dataset, index) => {
                        dataset.borderColor = colors[index % colors.length];
                        dataset.backgroundColor = 'transparent';
                    });

                    new Chart(ctxCurrency.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: data.chart.labels,
                            datasets: data.chart.datasets
                        },
                        options: {
                            responsive: true, maintainAspectRatio: false,
                            plugins: { legend: { labels: { color: 'white' } } },
                            scales: {
                                y: { ticks: { color: 'gray' }, grid: { color: 'rgba(255,255,255,0.1)' } },
                                x: { ticks: { color: 'gray' }, grid: { color: 'rgba(255,255,255,0.1)' } }
                            }
                        }
                    });
                }
            }
        })
        .catch(err => console.error('Gagal memuat kurs:', err));

    // ==========================================
    // 5. COMPARE ENGINE LOGIC
    // ==========================================
    const btnCompare = document.getElementById('btnCompare');
    if (btnCompare) {
        btnCompare.addEventListener('click', () => {
            const sel1 = document.getElementById('compareCountry1');
            const sel2 = document.getElementById('compareCountry2');
            
            if(!sel1.value || !sel2.value) {
                alert("Pilih kedua negara terlebih dahulu!");
                return;
            }
            if(sel1.value === sel2.value) {
                alert("Pilih dua negara yang berbeda!");
                return;
            }

            btnCompare.innerText = "Membandingkan...";
            
            const opt1 = sel1.options[sel1.selectedIndex];
            const opt2 = sel2.options[sel2.selectedIndex];

            Promise.all([
                fetch(`/api/country-data/${opt1.value}?lat=${opt1.dataset.lat}&lng=${opt1.dataset.lng}&name=${encodeURIComponent(opt1.text)}`).then(r => r.json()),
                fetch(`/api/country-data/${opt2.value}?lat=${opt2.dataset.lat}&lng=${opt2.dataset.lng}&name=${encodeURIComponent(opt2.text)}`).then(r => r.json())
            ]).then(([data1, data2]) => {
                btnCompare.innerText = "Compare Now";
                
                if(data1.status === 'success' && data2.status === 'success') {
                    document.getElementById('compareResultWrapper').classList.remove('d-none');
                    
                    document.getElementById('thCountry1').innerText = opt1.text;
                    document.getElementById('thCountry2').innerText = opt2.text;

                    // Risk
                    document.getElementById('tdRisk1').innerText = `${data1.risk.score} (${data1.risk.label})`;
                    document.getElementById('tdRisk2').innerText = `${data2.risk.score} (${data2.risk.label})`;
                    document.getElementById('tdRisk1').className = data1.risk.score > 60 ? 'text-danger fw-bold fs-5' : (data1.risk.score > 30 ? 'text-warning fw-bold fs-5' : 'text-success fw-bold fs-5');
                    document.getElementById('tdRisk2').className = data2.risk.score > 60 ? 'text-danger fw-bold fs-5' : (data2.risk.score > 30 ? 'text-warning fw-bold fs-5' : 'text-success fw-bold fs-5');

                    // GDP
                    document.getElementById('tdGdp1').innerText = data1.economy.GDP ? (data1.economy.GDP / 1e9).toFixed(1) : 'N/A';
                    document.getElementById('tdGdp2').innerText = data2.economy.GDP ? (data2.economy.GDP / 1e9).toFixed(1) : 'N/A';

                    // Inflation
                    document.getElementById('tdInf1').innerText = data1.economy.Inflasi ? data1.economy.Inflasi.toFixed(1) + '%' : 'N/A';
                    document.getElementById('tdInf2').innerText = data2.economy.Inflasi ? data2.economy.Inflasi.toFixed(1) + '%' : 'N/A';

                    // Weather
                    document.getElementById('tdWea1').innerText = data1.weather.weather_code || 'N/A';
                    document.getElementById('tdWea2').innerText = data2.weather.weather_code || 'N/A';

                    // Export
                    document.getElementById('tdExp1').innerText = data1.economy.Ekspor ? data1.economy.Ekspor.toFixed(1) + '%' : 'N/A';
                    document.getElementById('tdExp2').innerText = data2.economy.Ekspor ? data2.economy.Ekspor.toFixed(1) + '%' : 'N/A';

                    // --- RENDER COMPARE CHART ---
                    const chartWrapper = document.getElementById('compareChartWrapper');
                    if (chartWrapper) {
                        chartWrapper.style.display = 'block';
                        const ctx = document.getElementById('compareChart').getContext('2d');
                        
                        if (window.compareChartInstance) {
                            window.compareChartInstance.destroy();
                        }
                        
                        const labels = ['Risk Score', 'Inflation (%)', 'Export (% GDP)'];
                        const dataset1 = [
                            data1.risk.score || 0,
                            data1.economy.Inflasi || 0,
                            data1.economy.Ekspor || 0
                        ];
                        const dataset2 = [
                            data2.risk.score || 0,
                            data2.economy.Inflasi || 0,
                            data2.economy.Ekspor || 0
                        ];

                        window.compareChartInstance = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [
                                    {
                                        label: opt1.text,
                                        data: dataset1,
                                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 1,
                                        borderRadius: 4
                                    },
                                    {
                                        label: opt2.text,
                                        data: dataset2,
                                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                                        borderColor: 'rgba(255, 99, 132, 1)',
                                        borderWidth: 1,
                                        borderRadius: 4
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        labels: {
                                            color: '#333',
                                            font: {
                                                size: 14
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            color: 'rgba(0,0,0,0.1)'
                                        },
                                        ticks: {
                                            color: '#555'
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false
                                        },
                                        ticks: {
                                            color: '#555',
                                            font: {
                                                size: 13
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }
                } else {
                    alert("Gagal mengambil data perbandingan.");
                }
            }).catch(err => {
                console.error(err);
                btnCompare.innerText = "Compare Now";
                alert("Terjadi kesalahan teknis saat membandingkan negara.");
            });
        });
    }

    // ==========================================
    // 6. WATCHLIST LOGIC
    // ==========================================
    window.watchlists = []; // global store

    function fetchWatchlists() {
        fetch('/api/watchlist')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    window.watchlists = data.data;
                    renderWatchlists();
                }
            })
            .catch(err => console.error(err));
    }

    function renderWatchlists() {
        const container = document.getElementById('watchlistContainer');
        if (!container) return;
        container.innerHTML = '';
        if (window.watchlists.length === 0) {
            container.innerHTML = '<small class="px-3 text-muted">Belum ada negara yang dipantau.</small>';
            return;
        }
        window.watchlists.forEach(w => {
            container.innerHTML += `
                <a href="#" onclick="focusCountry('${w.country_code}')" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" style="padding-left: 25px;">
                    <span>${w.country_name} (${w.country_code})</span>
                    <button class="btn btn-sm btn-outline-danger px-2 py-0" onclick="event.stopPropagation(); removeFromWatchlist('${w.country_code}')">x</button>
                </a>
            `;
        });
    }

    window.toggleWatchlist = function() {
        const code = document.getElementById('countryCode').innerText;
        const name = document.getElementById('countryName').innerText;
        if (!code || code === '-') return;

        const isWatched = window.watchlists.find(w => w.country_code === code);
        
        if (isWatched) {
            removeFromWatchlist(code);
        } else {
            fetch('/api/watchlist', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                body: JSON.stringify({ country_code: code, country_name: name })
            }).then(res => res.json()).then(data => {
                if (data.status === 'success') {
                    fetchWatchlists();
                    updateWatchlistButton(code);
                }
            });
        }
    }

    window.removeFromWatchlist = function(code) {
        fetch(`/api/watchlist/${code}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }
        }).then(res => res.json()).then(data => {
            if (data.status === 'success') {
                fetchWatchlists();
                updateWatchlistButton(document.getElementById('countryCode').innerText);
            }
        });
    }

    window.updateWatchlistButton = function(code) {
        const btn = document.getElementById('btnWatchlist');
        if (!btn) return;
        btn.classList.remove('d-none');
        const isWatched = window.watchlists.find(w => w.country_code === code);
        if (isWatched) {
            btn.innerHTML = '⭐ Remove Watchlist';
            btn.className = 'btn btn-sm btn-warning';
        } else {
            btn.innerHTML = '⭐ Add to Watchlist';
            btn.className = 'btn btn-sm btn-outline-warning';
        }
    }

    window.focusCountry = function(code) {
        if (window.appMarkers && window.appMarkers[code] && window.appMap) {
            window.appMap.setView(window.appMarkers[code].getLatLng(), 4);
            window.appMarkers[code].fire('click');
        }
    }

    // Call initially
    fetchWatchlists();
});
# 🌐 Cyber-Logistic Hub: Global Supply Chain Risk Intelligence

Platform Monitoring Risiko Rantai Pasok Global Berbasis Multi-API dan Analitik Data.
Dibangun secara eksklusif untuk memenuhi seluruh spesifikasi **PROJECT FINAL**.

---

## 🚀 Teknologi & Stack

Projek ini dibangun menggunakan *stack* teknologi modern dengan sentuhan antarmuka tingkat *Enterprise* (*Dark Mode / Glassmorphism*):
- **Backend:** PHP 8.3 & Laravel 13
- **Database:** MySQL (15+ Tabel Relasional)
- **Frontend:** Bootstrap 5, Vanilla CSS, AJAX, JavaScript ES6
- **Visualisasi Data:** Chart.js & Leaflet.js
- **Environment:** Windows (Laragon) / Docker Ready

---

## 🔗 Integrasi 6 API Eksternal (Gratis)

Sistem ini tidak hanya menyimpan data statis, tetapi juga berkomunikasi secara *real-time* dengan 6 layanan API global:
1. **Open-Meteo API:** Pemantauan cuaca (suhu, curah hujan, arah & kecepatan angin, dsb) tanpa API Key.
2. **World Bank API:** Pengambilan indikator makro ekonomi negara (GDP, Inflasi, Populasi, Ekspor, Impor).
3. **REST Countries API:** Sinkronisasi master data geografis, bendera, mata uang, dan benua.
4. **ExchangeRate API (open.er-api.com):** Data kurs mata uang dunia *real-time* terhadap Rupiah (IDR).
5. **World Port Index Dataset:** Data infrastruktur dan koordinat pelabuhan dunia.
6. **GNews API:** Sumber intelijen berita global terkait ekonomi, perdagangan, dan logistik.

---

## 🧠 Fitur Data Science / AI (Lexicon Based Sentiment Analysis)

Sesuai instruksi khusus, projek ini **TIDAK** menggunakan layanan AI berbayar untuk analisis teks, melainkan menggunakan sistem klasifikasi berbasis *Lexicon (Dictionary)* yang dibuat murni dengan logika PHP:
*   Sistem membedah judul dan deskripsi berita dari API.
*   Kata-kata dicocokkan dengan ratusan kata di tabel `positive_words` (contoh: *growth, stable*) dan `negative_words` (contoh: *crisis, delay, war*).
*   Sistem menghitung persentase sentimen (Positif / Negatif / Netral) yang hasil akhirnya akan **mempengaruhi angka Risk Score** negara tersebut secara otomatis.

---

## ✨ 10 Fitur Utama Sistem

Sesuai dengan *blueprint* proyek, 10 sistem wajib ini telah tersedia dan berjalan 100%:

1.  **Global Country Dashboard:** Pengguna bisa mengklik peta atau memilih negara untuk melihat rincian komprehensif logistik, ekonomi, dan cuaca.
2.  **Risk Scoring Engine:** Algoritma yang menghitung tingkat risiko suatu negara secara sistematis.
    *   `Risk Score = Cuaca + Inflasi + Kurs Mata Uang + Sentimen Berita`
    *   *Output:* Angka *Score* (0-100) beserta Label (*Low Risk, Medium Risk, High Risk*).
3.  **Global Weather Monitoring:** Peta dunia interaktif (*Leaflet.js*) beserta data cuaca terkini untuk rute pengiriman laut dan udara.
4.  **Currency Impact Dashboard:** Grafik *Chart.js* yang mensimulasikan tren fluktuasi 5 mata uang top dunia selama 7 hari, beserta tabel kurs puluhan mata uang.
5.  **News Intelligence:** *Feed* daftar berita terbaru (terkait *supply chain / economy*) lengkap dengan label hasil *Sentiment Analysis*.
6.  **Port Location Dashboard:** Pemetaan dinamis lokasi pelabuhan dunia. Terdapat fitur peta interaktif di admin panel untuk klik koordinat secara *live* saat menambah pelabuhan baru.
7.  **Data Visualization Dashboard:** Deretan grafik tren indikator (GDP dll).
8.  **Country Comparison Engine:** Fitur menjejerkan 2 negara secara berdampingan untuk mengkomparasi parameter (Risk, GDP, Inflasi, Cuaca) dalam bentuk tabel dan radar/bar chart.
9.  **Favorite Monitoring List (Watchlist):** Pengguna dapat menyimpan/bookmark negara prioritas tinggi di daftar sisi navigasi *(sidebar)*.
10. **Admin Dashboard:** Panel administratif tertutup untuk kelola Kargo, Pelabuhan, Master Data, hingga Kamus Sentimen.

---

## 📡 Daftar Internal REST API

Projek ini telah memuat arsitektur API yang kompleks (>30 endpoint) dengan perlindungan sistem cache. Endpoint wajib untuk sistem monitoring antara lain:
- `GET /api/countries` — Mengambil daftar wilayah geografis.
- `GET /api/risk` — Mengambil daftar skor risiko berbasis kalkulasi sistem.
- `GET /api/ports` — Mengambil data infrastruktur dan koordinat titik pelabuhan global.
- `GET /api/news` — Menarik feed berita tersimpan yang telah dianalisis sentimennya.
- `GET /api/currency` — Endpoint data nilai tukar mata uang dan seri grafik riwayat 7 hari.

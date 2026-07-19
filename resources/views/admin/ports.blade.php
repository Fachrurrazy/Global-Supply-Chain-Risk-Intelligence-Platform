@extends('admin.layout')

@section('title', 'Dataset Pelabuhan')
@section('page_title', 'Kelola Dataset Pelabuhan')

@section('content')
<div class="row g-4">
    <!-- Form Input Port -->
    <div class="col-lg-4">
        <div class="cyber-card">
            <div class="card-header">
                <h5><i class="bi bi-plus-circle me-2" style="color: var(--clh-accent);"></i>Tambah Pelabuhan Baru</h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="cyber-alert-danger mb-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.ports.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="cyber-form-label">Nama Pelabuhan</label>
                        <input type="text" name="name" class="cyber-form-control" placeholder="Contoh: Port of Shanghai" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="cyber-form-label">Negara</label>
                        <input type="text" name="country" class="cyber-form-control" placeholder="Contoh: China (CN)" value="{{ old('country') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="cyber-form-label">Pilih Lokasi di Peta</label>
                        <div id="mapPicker" style="height: 250px; border-radius: var(--clh-radius-sm); border: 1px solid var(--clh-border);"></div>
                        <small style="color: var(--clh-text-muted); font-size: 0.75rem;">Klik pada peta untuk otomatis mengisi Latitude & Longitude.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="cyber-form-label">Latitude</label>
                            <input type="number" step="any" name="lat" class="cyber-form-control" placeholder="31.22" value="{{ old('lat') }}" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="cyber-form-label">Longitude</label>
                            <input type="number" step="any" name="lng" class="cyber-form-control" placeholder="121.48" value="{{ old('lng') }}" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-cyber-primary w-100">
                        <i class="bi bi-save me-2"></i>Simpan Pelabuhan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Data Port -->
    <div class="col-lg-8">
        <div class="cyber-card">
            <div class="card-header">
                <h5><i class="bi bi-geo-alt me-2" style="color: var(--clh-positive);"></i>Daftar Pelabuhan Aktif</h5>
                <span class="cyber-badge success">{{ $ports->total() }} Pelabuhan</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="cyber-table">
                        <thead>
                            <tr>
                                <th class="ps-3">ID</th>
                                <th>Nama Pelabuhan</th>
                                <th>Negara</th>
                                <th>Koordinat (Lat, Lng)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ports as $port)
                                <tr>
                                    <td class="ps-3" style="color: var(--clh-text-muted); font-family: var(--clh-font-mono);">#{{ $port->id }}</td>
                                    <td style="font-weight: 600; color: var(--clh-accent);">{{ $port->name }}</td>
                                    <td>{{ $port->country }}</td>
                                    <td>
                                        <span style="font-family: var(--clh-font-mono); font-size: 0.78rem; color: var(--clh-text-secondary);">
                                            <i class="bi bi-pin-map me-1" style="color: var(--clh-accent);"></i>{{ $port->lat }}, {{ $port->lng }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5" style="color: var(--clh-text-muted);">
                                        <i class="bi bi-geo-alt" style="font-size: 2rem; opacity: 0.3;"></i>
                                        <p class="mt-2 mb-0">Belum ada data pelabuhan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($ports->hasPages())
                <div class="card-footer">
                    {{ $ports->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* Fix leaflet dark mode styling if needed */
    .leaflet-container {
        font-family: var(--clh-font-sans);
    }
</style>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var map = L.map('mapPicker').setView([20, 0], 2);
        
        // Using dark theme tiles to match the UI
        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        var marker;

        map.on('click', function(e) {
            var lat = e.latlng.lat.toFixed(6);
            var lng = e.latlng.lng.toFixed(6);

            document.querySelector('input[name="lat"]').value = lat;
            document.querySelector('input[name="lng"]').value = lng;

            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker([lat, lng]).addTo(map);
        });

        // Invalidate size to ensure map loads properly when visible
        setTimeout(function() {
            map.invalidateSize();
        }, 100);
    });
</script>
@endsection

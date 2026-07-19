@extends('admin.layout')

@section('title', 'Kelola Cargo')
@section('page_title', 'Input Barang/Cargo')

@section('content')
<div class="row g-4">
    <!-- Form Input Cargo -->
    <div class="col-lg-4">
        <div class="cyber-card">
            <div class="card-header">
                <h5><i class="bi bi-plus-circle me-2" style="color: var(--clh-accent);"></i>Tambah Cargo Baru</h5>
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

                <form action="{{ route('admin.cargo.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="cyber-form-label">Nomor Resi / ID</label>
                        <input type="text" name="resi_number" class="cyber-form-control" placeholder="INV-2026-..." value="{{ old('resi_number') }}" required style="font-family: var(--clh-font-mono);">
                    </div>

                    <div class="mb-3">
                        <label class="cyber-form-label">Nama Barang</label>
                        <input type="text" name="item" class="cyber-form-control" placeholder="Contoh: Komponen Elektronik" value="{{ old('item') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="cyber-form-label">Nama Kapal (Vessel)</label>
                        <input type="text" name="vessel" class="cyber-form-control" placeholder="Contoh: Ever Given" value="{{ old('vessel') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="cyber-form-label">Rute</label>
                        <input type="text" name="route" class="cyber-form-control" placeholder="Shanghai → Jakarta" value="{{ old('route') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="cyber-form-label">Pilih Lokasi Terkini di Peta</label>
                        <div id="mapPicker" style="height: 250px; border-radius: var(--clh-radius-sm); border: 1px solid var(--clh-border);"></div>
                        <small style="color: var(--clh-text-muted); font-size: 0.75rem;">Klik pada peta untuk otomatis mengisi Latitude & Longitude terkini.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="cyber-form-label">Latitude</label>
                            <input type="number" step="any" name="current_lat" class="cyber-form-control" placeholder="5.500" value="{{ old('current_lat') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="cyber-form-label">Longitude</label>
                            <input type="number" step="any" name="current_lng" class="cyber-form-control" placeholder="110.00" value="{{ old('current_lng') }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="cyber-form-label">Estimasi Tiba (ETA)</label>
                        <input type="text" name="standard_eta" class="cyber-form-control" placeholder="Contoh: 10 Juli 2026" value="{{ old('standard_eta') }}" required>
                    </div>

                    <button type="submit" class="btn-cyber-primary w-100">
                        <i class="bi bi-save me-2"></i>Simpan Cargo
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Data Cargo -->
    <div class="col-lg-8">
        <div class="cyber-card">
            <div class="card-header">
                <h5><i class="bi bi-box-seam me-2" style="color: var(--clh-warning);"></i>Data Cargo Terdaftar</h5>
                <span class="cyber-badge primary">{{ $cargos->total() }} Entries</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="cyber-table">
                        <thead>
                            <tr>
                                <th class="ps-3">Resi</th>
                                <th>Barang</th>
                                <th>Kapal</th>
                                <th>Rute</th>
                                <th>ETA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cargos as $cargo)
                                <tr>
                                    <td class="ps-3">
                                        <span class="cyber-badge secondary">{{ $cargo->resi_number }}</span>
                                    </td>
                                    <td style="font-weight: 600; font-family: var(--clh-font-sans);">{{ $cargo->item }}</td>
                                    <td style="color: var(--clh-text-secondary);">{{ $cargo->vessel }}</td>
                                    <td><small style="font-family: var(--clh-font-mono); font-size: 0.78rem;">{{ $cargo->route }}</small></td>
                                    <td style="font-family: var(--clh-font-mono); font-size: 0.8rem;">{{ $cargo->standard_eta }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5" style="color: var(--clh-text-muted);">
                                        <i class="bi bi-box-seam" style="font-size: 2rem; opacity: 0.3;"></i>
                                        <p class="mt-2 mb-0">Belum ada data cargo.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($cargos->hasPages())
                <div class="card-footer">
                    {{ $cargos->links('pagination::bootstrap-5') }}
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

            document.querySelector('input[name="current_lat"]').value = lat;
            document.querySelector('input[name="current_lng"]').value = lng;

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

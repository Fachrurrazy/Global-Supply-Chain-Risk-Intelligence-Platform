@extends('admin.layout')

@section('title', 'Dataset Pelabuhan')
@section('page_title', 'Kelola Dataset Pelabuhan')

@section('content')
<div class="row">
    <!-- Form Input Port -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Tambah Pelabuhan Baru</h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger p-2 text-sm">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.ports.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Nama Pelabuhan</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Port of Shanghai" value="{{ old('name') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Negara</label>
                        <input type="text" name="country" class="form-control" placeholder="Contoh: China (CN)" value="{{ old('country') }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-muted fw-semibold">Latitude</label>
                            <input type="number" step="any" name="lat" class="form-control" placeholder="31.22" value="{{ old('lat') }}" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-muted fw-semibold">Longitude</label>
                            <input type="number" step="any" name="lng" class="form-control" placeholder="121.48" value="{{ old('lng') }}" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold">Simpan Pelabuhan</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Data Port -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Daftar Pelabuhan Aktif</h5>
                <span class="badge bg-success rounded-pill">{{ $ports->total() }} Pelabuhan</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
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
                                    <td class="ps-3 text-muted">#{{ $port->id }}</td>
                                    <td class="fw-semibold text-primary">{{ $port->name }}</td>
                                    <td>{{ $port->country }}</td>
                                    <td>
                                        <small class="text-muted"><i class="bi bi-geo-alt"></i> {{ $port->lat }}, {{ $port->lng }}</small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada data pelabuhan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($ports->hasPages())
                <div class="card-footer bg-white pt-3 border-top-0">
                    {{ $ports->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

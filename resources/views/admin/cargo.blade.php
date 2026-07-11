@extends('admin.layout')

@section('title', 'Kelola Cargo')
@section('page_title', 'Input Barang/Cargo')

@section('content')
<div class="row">
    <!-- Form Input Cargo -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Tambah Cargo Baru</h5>
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

                <form action="{{ route('admin.cargo.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Nomor Resi / ID</label>
                        <input type="text" name="resi_number" class="form-control" placeholder="INV-2026-..." value="{{ old('resi_number') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Nama Barang</label>
                        <input type="text" name="item" class="form-control" placeholder="Contoh: Komponen Elektronik" value="{{ old('item') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Nama Kapal (Vessel)</label>
                        <input type="text" name="vessel" class="form-control" placeholder="Contoh: Ever Given" value="{{ old('vessel') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Rute</label>
                        <input type="text" name="route" class="form-control" placeholder="Shanghai -> Jakarta" value="{{ old('route') }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted fw-semibold">Latitude</label>
                            <input type="number" step="any" name="current_lat" class="form-control" placeholder="5.500" value="{{ old('current_lat') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted fw-semibold">Longitude</label>
                            <input type="number" step="any" name="current_lng" class="form-control" placeholder="110.00" value="{{ old('current_lng') }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted fw-semibold">Estimasi Tiba (ETA)</label>
                        <input type="text" name="standard_eta" class="form-control" placeholder="Contoh: 10 Juli 2026" value="{{ old('standard_eta') }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold">Simpan Cargo</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Data Cargo -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Data Cargo Terdaftar</h5>
                <span class="badge bg-primary rounded-pill">{{ $cargos->total() }} Entries</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
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
                                    <td class="ps-3"><span class="badge bg-secondary">{{ $cargo->resi_number }}</span></td>
                                    <td class="fw-semibold">{{ $cargo->item }}</td>
                                    <td class="text-muted">{{ $cargo->vessel }}</td>
                                    <td><small>{{ $cargo->route }}</small></td>
                                    <td>{{ $cargo->standard_eta }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada data cargo.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($cargos->hasPages())
                <div class="card-footer bg-white pt-3 border-top-0">
                    {{ $cargos->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

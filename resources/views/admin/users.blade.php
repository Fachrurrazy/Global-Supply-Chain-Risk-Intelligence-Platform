@extends('admin.layout')

@section('title', 'Kelola User')
@section('page_title', 'Daftar User')

@section('content')
<div class="row">
    <!-- Tabel Data User -->
    <div class="col-lg-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Data User Terdaftar</h5>
                <span class="badge bg-primary rounded-pill">{{ $users->total() }} Entries</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Tanggal Daftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                                <tr>
                                    <td class="ps-3">{{ $users->firstItem() + $index }}</td>
                                    <td class="fw-semibold">{{ $user->name }}</td>
                                    <td class="text-muted">{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada user yang mendaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($users->hasPages())
                <div class="card-footer bg-white pt-3 border-top-0">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

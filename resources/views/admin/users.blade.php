@extends('admin.layout')

@section('title', 'Kelola User')
@section('page_title', 'Daftar User')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="cyber-card">
            <div class="card-header">
                <h5><i class="bi bi-people me-2" style="color: var(--clh-accent);"></i>Data User Terdaftar</h5>
                <span class="cyber-badge primary">{{ $users->total() }} Entries</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="cyber-table">
                        <thead>
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
                                    <td class="ps-3" style="color: var(--clh-text-muted); font-family: var(--clh-font-mono);">{{ $users->firstItem() + $index }}</td>
                                    <td style="font-weight: 600; font-family: var(--clh-font-sans);">{{ $user->name }}</td>
                                    <td style="color: var(--clh-text-secondary); font-family: var(--clh-font-mono); font-size: 0.8rem;">{{ $user->email }}</td>
                                    <td style="font-family: var(--clh-font-mono); font-size: 0.8rem;">{{ $user->created_at->format('d M Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5" style="color: var(--clh-text-muted);">
                                        <i class="bi bi-people" style="font-size: 2rem; opacity: 0.3;"></i>
                                        <p class="mt-2 mb-0">Belum ada user yang mendaftar.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($users->hasPages())
                <div class="card-footer">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

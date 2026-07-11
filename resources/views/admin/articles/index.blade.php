@extends('admin.layout')

@section('title', 'Artikel & Berita Analisis')
@section('page_title', 'Arsip Berita Intelligence')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Monitoring Berita Otomatis</h5>
                <span class="badge bg-primary">Otomatis dari GNews</span>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">
                    Tabel ini menampilkan daftar artikel berita yang diambil secara otomatis oleh sistem saat modul <strong>News Intelligence</strong> diakses. Sistem Lexicon AI kita juga langsung memberikan skor sentimen pada setiap berita yang masuk.
                </p>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Sumber</th>
                                <th style="width: 40%">Judul Berita</th>
                                <th>Sentimen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($articles as $article)
                            <tr>
                                <td>
                                    @if($article->published_at)
                                        {{ \Carbon\Carbon::parse($article->published_at)->format('d M Y H:i') }}
                                    @else
                                        {{ $article->created_at->format('d M Y') }}
                                    @endif
                                </td>
                                <td><span class="badge bg-secondary">{{ $article->source_name ?? 'Internal' }}</span></td>
                                <td>
                                    <a href="{{ $article->url }}" target="_blank" class="text-decoration-none fw-semibold">
                                        {{ $article->title }}
                                    </a>
                                    <div class="small text-muted text-truncate" style="max-width: 400px;">
                                        {{ $article->content }}
                                    </div>
                                </td>
                                <td>
                                    @if($article->sentiment == 'Positive')
                                        <span class="badge bg-success"><i class="bi bi-emoji-smile"></i> Positif</span>
                                    @elseif($article->sentiment == 'Negative')
                                        <span class="badge bg-danger"><i class="bi bi-emoji-frown"></i> Negatif</span>
                                    @else
                                        <span class="badge bg-warning text-dark"><i class="bi bi-emoji-neutral"></i> Netral</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyembunyikan/menghapus berita ini dari database?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486747.png" alt="No data" width="80" class="mb-3 opacity-50">
                                    <p class="text-muted">Belum ada berita yang tersimpan di arsip.</p>
                                    <small>Akses halaman News Intelligence di Dashboard User untuk men-trigger sistem penarikan data.</small>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $articles->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

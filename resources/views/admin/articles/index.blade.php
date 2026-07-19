@extends('admin.layout')

@section('title', 'Artikel & Berita Analisis')
@section('page_title', 'Arsip Berita Intelligence')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="cyber-card">
            <div class="card-header">
                <h5><i class="bi bi-journal-text me-2" style="color: var(--clh-accent);"></i>Monitoring Berita Otomatis</h5>
                <span class="cyber-badge primary">Otomatis dari GNews</span>
            </div>
            <div class="card-body">
                <p style="color: var(--clh-text-secondary); font-size: 0.85rem; margin-bottom: 20px;">
                    Tabel ini menampilkan daftar artikel berita yang diambil secara otomatis oleh sistem saat modul <strong style="color: var(--clh-accent);">News Intelligence</strong> diakses. Sistem Lexicon AI kita juga langsung memberikan skor sentimen pada setiap berita yang masuk.
                </p>

                <div class="table-responsive">
                    <table class="cyber-table">
                        <thead>
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
                                <td style="font-family: var(--clh-font-mono); font-size: 0.78rem; white-space: nowrap;">
                                    @if($article->published_at)
                                        {{ \Carbon\Carbon::parse($article->published_at)->format('d M Y H:i') }}
                                    @else
                                        {{ $article->created_at->format('d M Y') }}
                                    @endif
                                </td>
                                <td><span class="cyber-badge secondary">{{ $article->source_name ?? 'Internal' }}</span></td>
                                <td style="font-family: var(--clh-font-sans);">
                                    <a href="{{ $article->url }}" target="_blank" style="text-decoration: none; color: var(--clh-accent); font-weight: 600; transition: all 0.2s;">
                                        {{ $article->title }}
                                    </a>
                                    <div style="font-size: 0.78rem; color: var(--clh-text-muted); max-width: 400px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; margin-top: 4px;">
                                        {{ $article->content }}
                                    </div>
                                </td>
                                <td>
                                    @if($article->sentiment == 'Positive')
                                        <span class="cyber-badge success"><i class="bi bi-arrow-up-circle me-1"></i>Positif</span>
                                    @elseif($article->sentiment == 'Negative')
                                        <span class="cyber-badge danger"><i class="bi bi-arrow-down-circle me-1"></i>Negatif</span>
                                    @else
                                        <span style="padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; background: rgba(251, 191, 36, 0.15); color: var(--clh-warning);">
                                            <i class="bi bi-dash-circle me-1"></i>Netral
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-cyber-outline-danger">
                                            <i class="bi bi-trash me-1"></i>Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="bi bi-inbox" style="font-size: 2.5rem; color: var(--clh-text-muted); opacity: 0.3;"></i>
                                    <p class="mt-2" style="color: var(--clh-text-muted); font-size: 0.85rem;">Belum ada berita yang tersimpan di arsip.</p>
                                    <small style="color: var(--clh-text-muted);">Akses halaman News Intelligence di Dashboard User untuk men-trigger sistem penarikan data.</small>
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

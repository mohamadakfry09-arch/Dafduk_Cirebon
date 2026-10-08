@extends('layouts.app')

@section('title', $artikel['judul'] . ' - Informasi Disdukcapil')

@section('content')

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="breadcrumb__container">
        <span class="breadcrumb__item"><a href="{{ url('/') }}">Beranda</a></span>
        <span class="breadcrumb__sep">›</span>
        <span class="breadcrumb__item"><a href="{{ url('/informasi') }}">Informasi</a></span>
        <span class="breadcrumb__sep">›</span>
        <span class="breadcrumb__item">{{ Str::limit($artikel['judul'], 50) }}</span>
    </div>
</div>

<!-- Content -->
<div style="max-width:1280px;margin:0 auto;padding:40px 24px 80px;display:grid;grid-template-columns:1fr 360px;gap:40px;align-items:start;">

    <!-- Main Article -->
    <article>
        @if(!empty($artikel['foto']))
        <div style="width:100%;border-radius:12px;overflow:hidden;margin-bottom:32px;box-shadow:var(--shadow-lg);">
            <img src="{{ $artikel['foto'] }}" alt="{{ $artikel['judul'] }}" style="width:100%;max-height:480px;object-fit:cover;">
        </div>
        @endif

        <div style="background:#fff;border-radius:12px;padding:36px;border:1px solid var(--color-border);box-shadow:var(--shadow-sm);">
            <!-- Ringkasan -->
            <p style="font-size:17px;font-weight:500;color:var(--color-text-secondary);line-height:1.8;border-left:4px solid var(--color-accent);padding-left:20px;margin-bottom:28px;font-style:italic;">
                {{ $artikel['ringkasan'] }}
            </p>

            <!-- Isi Artikel -->
            <div style="font-size:15px;line-height:1.9;color:var(--color-text);">
                {!! nl2br(e($artikel['isi'])) !!}
            </div>

            <!-- Footer artikel -->
            <div style="margin-top:36px;padding-top:20px;border-top:1px solid var(--color-border);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
                <span style="font-size:12px;color:var(--color-text-muted);">
                    Diterbitkan: {{ \Carbon\Carbon::parse($artikel['created_at'])->isoFormat('D MMMM YYYY') }}
                    @if(isset($artikel['updated_at']) && $artikel['updated_at'] !== $artikel['created_at'])
                        &nbsp;|&nbsp; Diperbarui: {{ \Carbon\Carbon::parse($artikel['updated_at'])->isoFormat('D MMMM YYYY') }}
                    @endif
                </span>
                <a href="{{ url('/informasi') }}" style="font-size:13px;font-weight:600;color:var(--color-accent);">← Kembali ke Informasi</a>
            </div>
        </div>
    </article>

    <!-- Sidebar -->
    <aside style="position:sticky;top:80px;">
        <div style="background:#fff;border-radius:12px;padding:24px;border:1px solid var(--color-border);box-shadow:var(--shadow-sm);">
            <h3 style="font-size:16px;font-weight:700;color:var(--color-text);margin-bottom:20px;padding-bottom:12px;border-bottom:1px solid var(--color-border);">
                📰 Berita Lainnya
            </h3>
            @if(count($beritaLain) > 0)
                @foreach($beritaLain as $bl)
                <a href="{{ url('/berita/'.$bl['id']) }}" style="display:flex;gap:12px;text-decoration:none;color:inherit;padding:12px 0;border-bottom:1px solid #f1f5f9;transition:.2s;" onmouseover="this.style.opacity='.7'" onmouseout="this.style.opacity='1'">
                    <div style="width:60px;height:60px;border-radius:8px;overflow:hidden;flex-shrink:0;background:linear-gradient(135deg,#001a33,#003060);display:flex;align-items:center;justify-content:center;">
                        @if(!empty($bl['foto']))
                            <img src="{{ $bl['foto'] }}" alt="" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.3)" stroke-width="1.5"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10l4 4v12a2 2 0 0 1-2 2z"/></svg>
                        @endif
                    </div>
                    <div>
                        <div style="font-size:13px;font-weight:600;color:var(--color-text);line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $bl['judul'] }}</div>
                        <div style="font-size:11px;color:var(--color-text-muted);margin-top:4px;">{{ \Carbon\Carbon::parse($bl['created_at'])->isoFormat('D MMM YYYY') }}</div>
                    </div>
                </a>
                @endforeach
            @else
                <p style="font-size:13px;color:var(--color-text-muted);">Belum ada berita lain.</p>
            @endif
            <a href="{{ url('/informasi') }}" style="display:block;text-align:center;margin-top:16px;font-size:13px;font-weight:600;color:var(--color-accent);">Lihat Semua Berita →</a>
        </div>
    </aside>

</div>

@endsection

@section('styles')
<style>
@media (max-width: 900px) {
    div[style*="grid-template-columns:1fr 360px"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection

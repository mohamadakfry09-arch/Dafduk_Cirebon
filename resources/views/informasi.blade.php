@extends('layouts.app')

@section('title', 'Informasi & Berita - Dinas Kependudukan dan Pencatatan Sipil')

@section('content')

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="breadcrumb__container">
        <span class="breadcrumb__item"><a href="{{ url('/') }}">Beranda</a></span>
        <span class="breadcrumb__sep">›</span>
        <span class="breadcrumb__item">Informasi</span>
    </div>
</div>

<!-- Konten Berita -->
<div style="max-width:1280px; margin:0 auto; padding:40px 24px 80px;">

    <button type="button" class="page-back-link" onclick="window.history.back()">
        <span aria-hidden="true">←</span>
        <span>Kembali</span>
    </button>

    @if(count($berita) === 0)
    <div style="text-align:center; padding:80px 24px; color:var(--color-text-muted);">
        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" style="margin:0 auto 20px; display:block; opacity:0.3;"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10l4 4v12a2 2 0 0 1-2 2z"/></svg>
        <p style="font-size:16px;">Belum ada berita yang dipublikasikan.</p>
    </div>
    @else

    <!-- Berita Utama (featured) -->
    @php $featured = $berita[0]; @endphp
    <a href="{{ url('/berita/'.$featured['id']) }}" class="news-featured-card" id="newsCard0">
        <div class="news-featured-card__img">
            @if(!empty($featured['foto']))
                <img src="{{ $featured['foto'] }}" alt="{{ $featured['judul'] }}" style="width:100%;height:100%;object-fit:cover;">
            @else
                <div class="news-featured-card__placeholder">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.25)" stroke-width="1"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10l4 4v12a2 2 0 0 1-2 2z"/><polyline points="17 20 17 13 7 13 7 20"/><polyline points="7 4 7 8 15 8"/></svg>
                </div>
            @endif
            <div class="news-featured-card__overlay"></div>
        </div>
        <div class="news-featured-card__body">
            <span class="news-tag">{{ $featured['kategori'] }}</span>
            <h2 class="news-featured-card__title">{{ $featured['judul'] }}</h2>
            <p class="news-featured-card__excerpt">{{ Str::limit($featured['ringkasan'], 180) }}</p>
            <div class="news-featured-card__meta">
                <span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    {{ \Carbon\Carbon::parse($featured['created_at'])->isoFormat('D MMMM YYYY') }}
                </span>
                <span>✍️ {{ $featured['penulis'] }}</span>
                <span class="news-read-more">Baca Selengkapnya →</span>
            </div>
        </div>
    </a>

    <!-- Grid Berita Lainnya -->
    @if(count($berita) > 1)
    <div style="margin-top:40px;">
        <h2 style="font-size:20px;font-weight:700;color:var(--color-text);margin-bottom:24px;border-left:4px solid var(--color-accent);padding-left:16px;">Berita Lainnya</h2>
        <div class="news-grid">
            @foreach(array_slice($berita, 1) as $item)
            <a href="{{ url('/berita/'.$item['id']) }}" class="news-card">
                <div class="news-card__img">
                    @if(!empty($item['foto']))
                        <img src="{{ $item['foto'] }}" alt="{{ $item['judul'] }}" style="width:100%;height:100%;object-fit:cover;transition:.4s;">
                    @else
                        <div class="news-card__placeholder">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="1"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10l4 4v12a2 2 0 0 1-2 2z"/></svg>
                        </div>
                    @endif
                </div>
                <div class="news-card__body">
                    <span class="news-tag" style="font-size:10px;">{{ $item['kategori'] }}</span>
                    <h3 class="news-card__title">{{ $item['judul'] }}</h3>
                    <p class="news-card__excerpt">{{ Str::limit($item['ringkasan'], 100) }}</p>
                    <div class="news-card__meta">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        {{ \Carbon\Carbon::parse($item['created_at'])->isoFormat('D MMM YYYY') }}
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    @endif
</div>

@endsection

@section('styles')
<style>
/* News Featured Card */
.news-featured-card {
    display: grid;
    grid-template-columns: 1fr 1fr;
    border-radius: 16px;
    overflow: hidden;
    background: var(--color-primary);
    text-decoration: none;
    color: inherit;
    box-shadow: 0 20px 60px rgba(0,0,0,0.12);
    transition: transform .3s, box-shadow .3s;
    min-height: 380px;
}
.news-featured-card:hover { transform: translateY(-4px); box-shadow: 0 28px 80px rgba(0,0,0,0.18); }
.news-featured-card__img {
    position: relative;
    min-height: 300px;
    background: linear-gradient(135deg,#001a33,#003060);
}
.news-featured-card__placeholder {
    position:absolute;inset:0;display:flex;align-items:center;justify-content:center;
    background: linear-gradient(135deg,#001a33,#003060);
}
.news-featured-card__overlay {
    position:absolute;inset:0;background:linear-gradient(to right,transparent 60%,rgba(0,36,64,0.9));pointer-events:none;
}
.news-featured-card__body {
    padding: 48px 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    background: var(--color-primary);
    color: #fff;
}
.news-featured-card__title {
    font-size: clamp(18px,2.5vw,26px);font-weight:800;color:#fff;line-height:1.35;margin:12px 0 14px;
}
.news-featured-card__excerpt { font-size:14px;color:rgba(255,255,255,.75);line-height:1.7;margin-bottom:24px; }
.news-featured-card__meta { display:flex;align-items:center;gap:16px;font-size:12px;color:rgba(255,255,255,.6);flex-wrap:wrap; }
.news-featured-card__meta span { display:flex;align-items:center;gap:5px; }
.news-read-more { color:var(--color-gold);font-weight:700;margin-left:auto; }
.news-tag {
    display:inline-block;background:var(--color-tag-bg);color:var(--color-tag-text);
    padding:4px 10px;border-radius:30px;font-size:11px;font-weight:700;text-transform:uppercase;
    letter-spacing:.06em;border:1px solid rgba(245,166,35,.3);
}

/* News Grid */
.news-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:24px; }
.news-card {
    background:var(--color-card-bg);border-radius:12px;overflow:hidden;border:1px solid var(--color-border);
    text-decoration:none;color:inherit;transition:transform .25s,box-shadow .25s;display:flex;flex-direction:column;
}
.news-card:hover { transform:translateY(-4px);box-shadow:var(--shadow-lg); }
.news-card__img { height:180px;position:relative;background:linear-gradient(135deg,#001a33,#003060);overflow:hidden; }
.news-card__placeholder { position:absolute;inset:0;display:flex;align-items:center;justify-content:center; }
.news-card:hover .news-card__img img { transform:scale(1.05); }
.news-card__body { padding:18px;flex:1;display:flex;flex-direction:column;gap:8px; }
.news-card__title { font-size:15px;font-weight:700;color:var(--color-text);line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden; }
.news-card__excerpt { font-size:13px;color:var(--color-text-muted);line-height:1.6;flex:1;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden; }
.news-card__meta { font-size:11px;color:var(--color-text-muted);display:flex;align-items:center;gap:5px; }
.news-card .news-tag { align-self:flex-start;background:rgba(30,95,168,.08);color:var(--color-accent); border:none; }

@media (max-width:768px) {
    .news-featured-card { grid-template-columns:1fr; }
    .news-featured-card__img { min-height:200px; }
    .news-featured-card__overlay { background:none; }
    .news-featured-card__body { padding:24px 20px; }
}
</style>
@endsection

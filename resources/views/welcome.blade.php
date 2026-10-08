@extends('layouts.app')

@section('title', 'Beranda - Dinas Kependudukan Dan Pencatatan Sipil')

@php
    $kontakAdmin = \App\Services\ContentRepository::getKontak();
    $waAdminNumber = preg_replace('/[^0-9+]/', '', $kontakAdmin['whatsapp'] ?? '');
    $waAdminText = urlencode($kontakAdmin['pesan_wa'] ?? 'Halo Admin Disdukcapil, saya ingin menanyakan informasi layanan kependudukan.');
    $waAdminUrl = $waAdminNumber ? 'https://wa.me/' . $waAdminNumber . '?text=' . $waAdminText : '#';
@endphp

@section('content')

    <div class="home-intro-reveal" id="homeIntroReveal" aria-live="polite">
        <video class="home-intro-reveal__video" autoplay muted loop playsinline poster="{{ asset('images/megamendung1.png') }}">
            <source src="https://assets.mixkit.co/videos/preview/mixkit-office-workers-using-laptops-28567-large.mp4" type="video/mp4">
        </video>
        <div class="home-intro-reveal__backdrop"></div>

        <a href="#services-home" class="home-intro-reveal__arrow" aria-label="Buka beranda (Klik Disini)">
            <span class="home-intro-reveal__arrow-text">KLIK DISINI</span>
            <span class="home-intro-reveal__arrow-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M12 5v14" />
                    <path d="M5 12l7 7 7-7" />
                </svg>
            </span>
        </a>
    </div>


    <div class="home-services-layout" id="services-home">
        <!-- Layanan Kependudukan -->
        <section class="services section">
            <div class="section__container">
                <div class="services__header">
                    <h2 class="services__title">Layanan Kependudukan</h2>
                    <a href="{{ url('/pelayanan') }}" class="services__all-link">
                        Lihat Semua Layanan
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14" />
                            <path d="M12 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <form class="search-bar home-service-search" action="{{ url('/pelayanan') }}" method="GET">
                    <svg class="search-bar__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" class="search-bar__input" name="q" placeholder="Cari layanan, contoh: KTP, Akta Kelahiran, Pindah..." aria-label="Cari layanan">
                    <button type="submit" class="search-bar__btn">Cari</button>
                </form>

                <div class="services__grid">
                    @foreach(array_slice($services, 0, 2) as $service)
                        <a href="{{ url('/pelayanan/' . ($service['slug'] ?? '')) }}" class="service-card">
                            <div class="service-card__image-wrap">
                            <div style="width:100%;height:100%;background:linear-gradient(135deg,#1a2e44,#2d4a6b);display:flex;align-items:center;justify-content:center;">
                                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.3)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="5" width="20" height="14" rx="2" />
                                    <line x1="2" y1="10" x2="22" y2="10" />
                                </svg>
                            </div>
                            <div class="service-card__image-overlay"></div>
                            <div class="service-card__icon-wrap">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="5" width="20" height="14" rx="2" />
                                    <line x1="2" y1="10" x2="22" y2="10" />
                                </svg>
                            </div>
                            <div class="service-card__image-title">
                                <h3>{{ $service['title'] ?? 'Layanan Adminduk' }}</h3>
                            </div>
                        </div>
                        <div class="service-card__body">
                            <p class="service-card__desc">{{ Str::limit($service['desc'] ?? '', 110) }}</p>
                        </div>
                        <div class="service-card__footer">
                            <span class="service-card__link">
                                Lihat Detail
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14" />
                                    <path d="M12 5l7 7-7 7" />
                                </svg>
                            </span>
                        </div>
                    </a>
                @endforeach

                @if(!empty($permohonan))
                    @foreach($permohonan as $service)
                        @php
                            $targetUrl = session('is_warga') ? url('/pelayanan/' . ($service['slug'] ?? '')) : url('/pelayanan/jemput-bola/login');
                        @endphp
                        <a href="{{ $targetUrl }}" class="service-card" style="border:1px solid var(--color-border); background:var(--color-card-bg);">
                            <div class="service-card__body" style="padding:24px 20px 20px;">
                                <div style="display:flex; gap:6px; flex-wrap:wrap; margin-bottom:10px;">
                                    <span class="service-card__tag" style="background:var(--color-tag-bg); color:var(--color-tag-text);">Permohonan</span>
                                    <span class="service-card__tag" style="background:#fff3ed; color:#ea580c; border:1px solid #fed7aa; font-weight:700;">Login Google</span>
                                </div>
                                <h3 class="service-card__title" style="font-size:18px;margin-bottom:10px; color:var(--color-text);">{{ $service['title'] ?? 'Jemput Bola' }}</h3>
                                <p class="service-card__desc" style="color:var(--color-text-muted);">{{ Str::limit($service['desc'] ?? '', 120) }}</p>
                                <div style="font-size:12px; color:#ea580c; font-weight:600; margin-top:8px;">
                                    ✉️ Login menggunakan akun Google (Pelayanan Adminduk)
                                </div>
                            </div>
                            <div class="service-card__footer">
                                <span class="service-card__link" style="color:var(--color-accent);">
                                    Ajukan Permohonan
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14" />
                                        <path d="M12 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </div>
                        </a>
                    @endforeach
                @endif
                </div>
            </div>
        </section>

        @if(request()->is('/'))
            <div class="home-rail-stack" aria-label="Menu utama">
                <div class="service-rail">
                    <div class="service-rail__inner">
                        <a href="{{ url('/') }}" class="service-rail__item {{ request()->is('/') ? 'active' : '' }}">Beranda</a>
                        <a href="{{ url('/pelayanan') }}" class="service-rail__item {{ request()->is('pelayanan*') ? 'active' : '' }}">Layanan</a>
                        <a href="{{ url('/informasi') }}" class="service-rail__item {{ request()->is('informasi*') ? 'active' : '' }}">Informasi</a>
                        <a href="{{ url('/tentang') }}" class="service-rail__item {{ request()->is('tentang*') ? 'active' : '' }}">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px; flex-shrink:0;" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="16" x2="12" y2="12"/>
                                <line x1="12" y1="8" x2="12.01" y2="8"/>
                            </svg>
                            <span>Tentang</span>
                        </a>
                        <a href="{{ url('/Kontak') }}" class="service-rail__item {{ request()->is('Kontak*') || request()->is('kontak*') ? 'active' : '' }}">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px; flex-shrink:0;" aria-hidden="true">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.59 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                            <span>Kontak</span>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Info / Berita Terbaru -->
    @if(count($berita) > 0)
        <section class="section section--alt">
            <div class="section__container">
                <div class="section__header">
                    <h2 class="section__title">Informasi Terbaru</h2>
                    <p class="section__subtitle">Berita, pengumuman, dan foto yang tercantum di artikel dapat Anda buka melalui menu informasi.</p>
                </div>

                <div class="news-grid" style="display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:24px;">
                    @foreach($berita as $item)
                        <a href="{{ url('/informasi') }}" class="news-card" style="text-decoration:none; color:inherit; display:flex; flex-direction:column; border:1px solid var(--color-border); border-radius:16px; overflow:hidden; background:var(--color-card-bg); box-shadow:var(--shadow-sm); transition:transform .25s, box-shadow .25s;">
                            <div class="news-card__img" style="height:180px; position:relative; background:var(--color-primary);">
                                @if(!empty($item['foto']))
                                    <img src="{{ $item['foto'] }}" alt="{{ $item['judul'] }}" style="width:100%; height:100%; object-fit:cover; display:block;">
                                @else
                                    <div style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center;">
                                        <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="1"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10l4 4v12a2 2 0 0 1-2 2z"/><polyline points="17 20 17 13 7 13 7 20"/><polyline points="7 4 7 8 15 8"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="news-card__body" style="padding:20px; display:flex; flex-direction:column; gap:10px;">
                                <span class="news-tag" style="display:inline-block; width:max-content; font-size:10px; background:var(--color-tag-bg); color:var(--color-tag-text); border-radius:999px; padding:4px 10px; font-weight:700; text-transform:uppercase; letter-spacing:.06em;">{{ $item['kategori'] ?? 'Informasi' }}</span>
                                <h3 class="news-card__title" style="font-size:16px; font-weight:700; line-height:1.4; margin:0; color:var(--color-text);">{{ $item['judul'] }}</h3>
                                <p class="news-card__excerpt" style="margin:0; color:var(--color-text-muted); font-size:13px; line-height:1.6;">{{ Str::limit($item['ringkasan'], 110) }}</p>
                                <div style="margin-top:auto; display:flex; justify-content:space-between; align-items:center; gap:12px; font-size:12px; color:var(--color-text-muted);">
                                    <span>{{ \Carbon\Carbon::parse($item['created_at'])->isoFormat('D MMM YYYY') }}</span>
                                    <span style="font-weight:700; color:var(--color-accent);">Lihat Info →</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div style="text-align:center; margin-top:28px;">
                    <a href="{{ url('/informasi') }}" class="hero__cta" style="display:inline-flex; align-items:center; justify-content:center; text-decoration:none;">
                        Lihat Semua Informasi
                    </a>
                </div>
            </div>
        </section>
    @endif

@endsection
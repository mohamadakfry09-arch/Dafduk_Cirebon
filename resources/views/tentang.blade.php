@extends('layouts.app')

@section('title', 'Tentang Kami & Profil Instansi - Dinas Kependudukan dan Pencatatan Sipil')

@section('content')

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="breadcrumb__container">
        <span class="breadcrumb__item"><a href="{{ url('/') }}">Beranda</a></span>
        <span class="breadcrumb__sep">›</span>
        <span class="breadcrumb__item">Tentang Kami (Profil Instansi)</span>
    </div>
</div>

<div class="profile-container">

    <a href="{{ url('/') }}" class="page-back-link" onclick="if(history.length > 1 && document.referrer){ history.back(); return false; }">
        <span aria-hidden="true">←</span>
        <span>Kembali</span>
    </a>

    <!-- Hero / Header Profil Instansi -->
    <header class="profile-hero">
        <div class="profile-hero__badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            <span>PROFIL RESMI INSTANSI PEMERINTAH</span>
        </div>

        <h1 class="profile-hero__title">{{ $tentang['nama_instansi'] ?? 'Dinas Kependudukan dan Pencatatan Sipil' }}</h1>
        <div class="profile-hero__subtitle">{{ $tentang['nama_kabupaten'] ?? 'Kabupaten Cirebon' }}</div>

        @if(!empty($tentang['slogan']))
            <p class="profile-hero__slogan">“{{ $tentang['slogan'] }}”</p>
        @endif

        <div class="profile-hero__pills">
            <div class="profile-pill">
                <span class="profile-pill__icon">🛡️</span>
                <span>Layanan Bebas Biaya (100% GRATIS)</span>
            </div>
            <div class="profile-pill">
                <span class="profile-pill__icon">⚡</span>
                <span>Terintegrasi SIAK &amp; IKD Digital</span>
            </div>
            <div class="profile-pill">
                <span class="profile-pill__icon">⏱️</span>
                <span>Pelayanan Cepat &amp; Transparan</span>
            </div>
            <div class="profile-pill">
                <span class="profile-pill__icon">🤝</span>
                <span>Program Jemput Bola Warga</span>
            </div>
        </div>
    </header>

    <!-- Sambutan & Profil Pimpinan -->
    <section class="profile-card profile-leader" aria-label="Profil Kepala Dinas">
        <div class="profile-leader__avatar-box">
            @if(!empty($tentang['foto_kepala']))
                <img src="{{ $tentang['foto_kepala'] }}" alt="{{ $tentang['kepala_dinas'] }}" class="profile-leader__img">
            @else
                <div class="profile-leader__avatar-fallback">
                    <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
            @endif
            <div class="profile-leader__badge">Kepala Dinas</div>
            <h2 class="profile-leader__name">{{ $tentang['kepala_dinas'] ?? 'Kepala Dinas' }}</h2>
            <div class="profile-leader__nip">NIP: {{ $tentang['nip_kepala'] ?? '-' }}</div>
        </div>

        <div class="profile-leader__speech">
            <div class="profile-leader__speech-header">
                <div class="profile-leader__quote-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                    </svg>
                </div>
                <div>
                    <h3 style="font-size:17px; font-weight:800; color:var(--color-primary); margin:0;">Sambutan Kepala Dinas</h3>
                    <p style="font-size:12px; color:var(--color-text-muted); margin:2px 0 0;">Komitmen Pelayanan Publik Prima Disdukcapil</p>
                </div>
            </div>
            <blockquote class="profile-leader__quote-text">
                {{ $tentang['sambutan_kepala'] ?? 'Selamat datang di portal resmi Dinas Kependudukan dan Pencatatan Sipil. Kami berkomitmen memberikan pelayanan administrasi kependudukan yang prima, ramah, dan bebas biaya untuk membahagiakan seluruh warga masyarakat.' }}
            </blockquote>
        </div>
    </section>

    <!-- Visi & Misi Grid -->
    <div class="profile-grid-2" style="margin-bottom:32px;">
        <!-- Visi -->
        <section class="profile-card profile-visi" aria-label="Visi Instansi">
            <div class="profile-card__header">
                <span class="profile-card__icon profile-card__icon--gold">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m10 15 5-3-5-3v6z"/></svg>
                </span>
                <div>
                    <span class="profile-card__eyebrow">Arah Pembangunan</span>
                    <h2 class="profile-card__title">Visi Instansi</h2>
                </div>
            </div>
            <div class="profile-visi__content">
                <p class="profile-visi__quote">“{{ $tentang['visi'] ?? 'Terwujudnya Pelayanan Administrasi Kependudukan dan Pencatatan Sipil yang Prima, Akurat, dan Terpercaya.' }}”</p>
            </div>
        </section>

        <!-- Misi -->
        <section class="profile-card profile-misi" aria-label="Misi Instansi">
            <div class="profile-card__header">
                <span class="profile-card__icon profile-card__icon--blue">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                </span>
                <div>
                    <span class="profile-card__eyebrow">Strategi Pelaksanaan</span>
                    <h2 class="profile-card__title">Misi Instansi</h2>
                </div>
            </div>
            <ul class="profile-misi__list">
                @if(!empty($tentang['misi']) && is_array($tentang['misi']))
                    @foreach($tentang['misi'] as $idx => $misi)
                        <li class="profile-misi__item">
                            <span class="profile-misi__num">{{ $idx + 1 }}</span>
                            <span class="profile-misi__text">{{ $misi }}</span>
                        </li>
                    @endforeach
                @else
                    <li class="profile-misi__item">
                        <span class="profile-misi__num">1</span>
                        <span class="profile-misi__text">Meningkatkan kualitas dan aksesibilitas layanan administrasi kependudukan.</span>
                    </li>
                @endif
            </ul>
        </section>
    </div>

    <!-- Tugas Pokok dan Fungsi (Tupoksi) -->
    @if(!empty($tentang['tugas_fungsi']) && is_array($tentang['tugas_fungsi']))
    <section class="profile-card" style="margin-bottom:32px;" aria-label="Tugas Pokok dan Fungsi">
        <div class="profile-card__header">
            <span class="profile-card__icon profile-card__icon--green">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg>
            </span>
            <div>
                <span class="profile-card__eyebrow">Tugas Pokok &amp; Fungsi</span>
                <h2 class="profile-card__title">Tupoksi Disdukcapil</h2>
            </div>
        </div>
        <div class="profile-tupoksi__grid">
            @foreach($tentang['tugas_fungsi'] as $tIndex => $tupoksi)
                <div class="profile-tupoksi__item">
                    <span class="profile-tupoksi__check">✓</span>
                    <p class="profile-tupoksi__desc">{{ $tupoksi }}</p>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Maklumat Pelayanan Prima -->
    @if(!empty($tentang['maklumat_pelayanan']))
    <section class="profile-card profile-maklumat" style="margin-bottom:32px;" aria-label="Maklumat Pelayanan">
        <div class="profile-maklumat__inner">
            <div class="profile-maklumat__icon-seal">
                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="8" r="6"/>
                    <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
                </svg>
            </div>
            <div>
                <span class="profile-maklumat__tag">KOMITMEN INTEGRITAS PELAYANAN</span>
                <h2 class="profile-maklumat__title">Maklumat Pelayanan Disdukcapil</h2>
                <p class="profile-maklumat__body">{{ $tentang['maklumat_pelayanan'] }}</p>
            </div>
        </div>
    </section>
    @endif

    <!-- Sejarah Singkat & Landasan -->
    <section class="profile-card" style="margin-bottom:32px;" aria-label="Sejarah Singkat Instansi">
        <div class="profile-card__header">
            <span class="profile-card__icon profile-card__icon--blue">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            </span>
            <div>
                <span class="profile-card__eyebrow">Profil Lembaga</span>
                <h2 class="profile-card__title">Sejarah &amp; Transformasi Instansi</h2>
            </div>
        </div>
        <div class="profile-sejarah__text">
            {{ $tentang['sejarah'] ?? 'Dinas Kependudukan dan Pencatatan Sipil merupakan perangkat daerah yang dibentuk untuk menyelenggarakan urusan pemerintahan di bidang administrasi kependudukan dan pencatatan sipil.' }}
        </div>
    </section>

    <!-- Info Operasional, Kontak & Google Maps -->
    <section class="profile-card" style="margin-bottom:32px;" aria-label="Informasi Operasional dan Lokasi Kantor">
        <div class="profile-card__header">
            <span class="profile-card__icon profile-card__icon--green">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </span>
            <div>
                <span class="profile-card__eyebrow">Kunjungi Kantor Kami</span>
                <h2 class="profile-card__title">Informasi Operasional &amp; Lokasi Kantor</h2>
            </div>
        </div>

        <div class="profile-contact-grid">
            <div class="profile-contact-info">
                <div class="profile-info-row">
                    <div class="profile-info-row__icon">⏱️</div>
                    <div>
                        <div class="profile-info-row__label">Jam Pelayanan Kantor</div>
                        <div class="profile-info-row__val">{{ $tentang['jam_kerja'] ?? 'Senin – Kamis: 07.30 – 16.00 WIB | Jumat: 07.30 – 16.30 WIB' }}</div>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-row__icon">📍</div>
                    <div>
                        <div class="profile-info-row__label">Alamat Kantor Resmi</div>
                        <div class="profile-info-row__val">{{ $tentang['alamat'] ?? 'Jl. Sunan Muria Komplek Pemda No.84, Sumber, Kabupaten Cirebon, Jawa Barat 45611' }}</div>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-row__icon">📞</div>
                    <div>
                        <div class="profile-info-row__label">Telepon Kantor</div>
                        <div class="profile-info-row__val">{{ $tentang['telepon'] ?? '0231-321156' }}</div>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-row__icon">✉️</div>
                    <div>
                        <div class="profile-info-row__label">Email Resmi</div>
                        <div class="profile-info-row__val">{{ $tentang['email'] ?? 'disdukcapil@cirebonkab.go.id' }}</div>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-row__icon">🌐</div>
                    <div>
                        <div class="profile-info-row__label">Website Resmi</div>
                        <div class="profile-info-row__val">{{ $tentang['website'] ?? 'www.disdukcapil.cirebonkab.go.id' }}</div>
                    </div>
                </div>

                @if(!empty($tentang['maps_link']))
                    <div style="margin-top:16px;">
                        <a href="{{ $tentang['maps_link'] }}" target="_blank" class="btn-profile-maps">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                            <span>Buka Petunjuk Arah di Google Maps</span>
                        </a>
                    </div>
                @endif
            </div>

            <div class="profile-map-box">
                @if(!empty($tentang['maps_embed']))
                    <iframe src="{{ $tentang['maps_embed'] }}" class="profile-map-iframe" title="Peta Lokasi Disdukcapil" loading="lazy"></iframe>
                @else
                    <iframe src="https://maps.google.com/maps?q={{ urlencode(($tentang['nama_instansi'] ?? 'Dinas Kependudukan dan Pencatatan Sipil').' '.($tentang['nama_kabupaten'] ?? 'Kabupaten Cirebon')) }}&output=embed&z=16" class="profile-map-iframe" title="Peta Lokasi" loading="lazy"></iframe>
                @endif
            </div>
        </div>
    </section>

    <!-- Bottom Action CTA -->
    <div class="profile-cta">
        <div class="profile-cta__text">
            <h3>Butuh Pengurusan Dokumen Kependudukan?</h3>
            <p>Jelajahi seluruh persyaratan layanan kependudukan atau hubungi petugas layanan kami.</p>
        </div>
        <div class="profile-cta__buttons">
            <a href="{{ url('/pelayanan') }}" class="btn-profile-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                <span>Lihat Direktori Layanan</span>
            </a>
            <a href="{{ url('/Kontak') }}" class="btn-profile-secondary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.59 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                <span>Kontak Layanan Publik</span>
            </a>
        </div>
    </div>

</div>

@endsection

@section('styles')
<style>
.profile-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 32px 24px 80px;
}

/* Hero Section */
.profile-hero {
    background: linear-gradient(135deg, #0D2E5A 0%, #1565C0 60%, #1E88E5 100%);
    border-radius: 20px;
    padding: 44px 36px;
    margin-bottom: 28px;
    color: #ffffff;
    box-shadow: 0 12px 32px rgba(13, 46, 90, 0.22);
    position: relative;
    overflow: hidden;
}

.profile-hero::before {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 260px;
    height: 260px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(249, 168, 37, 0.25) 0%, rgba(255, 255, 255, 0) 70%);
    pointer-events: none;
}

.profile-hero__badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.08em;
    color: #F9A825;
    margin-bottom: 16px;
}

.profile-hero__title {
    font-size: 32px;
    font-weight: 800;
    color: #ffffff;
    line-height: 1.2;
    margin: 0 0 6px;
}

.profile-hero__subtitle {
    font-size: 18px;
    font-weight: 600;
    color: #ffd54f;
    margin-bottom: 12px;
    letter-spacing: 0.02em;
}

.profile-hero__slogan {
    font-size: 15px;
    font-style: italic;
    color: rgba(255, 255, 255, 0.9);
    max-width: 780px;
    line-height: 1.6;
    margin: 0 0 24px;
}

.profile-hero__pills {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.profile-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.22);
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12.5px;
    font-weight: 600;
    color: #ffffff;
}

/* Card General */
.profile-card {
    background: #ffffff;
    border: 1px solid #dce7f5;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 4px 16px rgba(13, 46, 90, 0.05);
}

.profile-card__header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 20px;
}

.profile-card__icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.profile-card__icon--blue {
    background: #eff6ff;
    color: #1d4ed8;
}

.profile-card__icon--gold {
    background: #fffbeb;
    color: #d97706;
}

.profile-card__icon--green {
    background: #f0fdf4;
    color: #16a34a;
}

.profile-card__eyebrow {
    display: block;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #64748b;
    margin-bottom: 2px;
}

.profile-card__title {
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
}

/* Leader Section */
.profile-leader {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 32px;
    align-items: center;
    margin-bottom: 32px;
    background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
    border-left: 5px solid #1565C0;
}

.profile-leader__avatar-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 16px;
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
}

.profile-leader__img {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #1565C0;
    box-shadow: 0 4px 12px rgba(21, 101, 192, 0.2);
    margin-bottom: 12px;
}

.profile-leader__avatar-fallback {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: #eff6ff;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px dashed #93c5fd;
    margin-bottom: 12px;
}

.profile-leader__badge {
    display: inline-block;
    padding: 3px 12px;
    background: #eff6ff;
    color: #1e40af;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    border-radius: 999px;
    margin-bottom: 6px;
}

.profile-leader__name {
    font-size: 17px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px;
    line-height: 1.3;
}

.profile-leader__nip {
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
}

.profile-leader__speech {
    padding-left: 12px;
}

.profile-leader__speech-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 14px;
}

.profile-leader__quote-icon {
    width: 44px;
    height: 44px;
    background: rgba(249, 168, 37, 0.15);
    color: #d97706;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.profile-leader__quote-text {
    margin: 0;
    font-size: 15px;
    line-height: 1.8;
    color: #334155;
    background: #ffffff;
    border-radius: 12px;
    padding: 20px 24px;
    border: 1px solid #e2e8f0;
    font-style: normal;
}

/* Grid 2 Column */
.profile-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}

/* Visi & Misi */
.profile-visi__content {
    background: linear-gradient(135deg, #eff6ff 0%, #f0fdf4 100%);
    border: 1px solid #bfdbfe;
    border-radius: 14px;
    padding: 28px 24px;
    height: calc(100% - 64px);
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.profile-visi__quote {
    font-size: 18px;
    font-weight: 700;
    color: #1e3a8a;
    line-height: 1.7;
    font-style: italic;
    margin: 0;
}

.profile-misi__list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.profile-misi__item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
}

.profile-misi__num {
    width: 28px;
    height: 28px;
    background: linear-gradient(135deg, #1565C0, #1E88E5);
    color: #ffffff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 800;
    flex-shrink: 0;
    margin-top: 2px;
}

.profile-misi__text {
    font-size: 14px;
    line-height: 1.7;
    color: #334155;
    margin: 0;
}

/* Tupoksi */
.profile-tupoksi__grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.profile-tupoksi__item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px;
    transition: transform 0.2s ease, border-color 0.2s ease;
}

.profile-tupoksi__item:hover {
    border-color: #93c5fd;
    transform: translateY(-2px);
}

.profile-tupoksi__check {
    width: 22px;
    height: 22px;
    background: #16a34a;
    color: #ffffff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 800;
    flex-shrink: 0;
    margin-top: 2px;
}

.profile-tupoksi__desc {
    margin: 0;
    font-size: 13.5px;
    line-height: 1.6;
    color: #334155;
}

/* Maklumat */
.profile-maklumat {
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    border: 2px solid #fcd34d;
}

.profile-maklumat__inner {
    display: flex;
    gap: 22px;
    align-items: flex-start;
}

.profile-maklumat__icon-seal {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #d97706;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 6px 16px rgba(217, 119, 6, 0.28);
}

.profile-maklumat__tag {
    display: inline-block;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.08em;
    color: #b45309;
    margin-bottom: 4px;
}

.profile-maklumat__title {
    font-size: 20px;
    font-weight: 800;
    color: #78350f;
    margin: 0 0 10px;
}

.profile-maklumat__body {
    font-size: 14px;
    line-height: 1.8;
    color: #92400e;
    margin: 0;
}

/* Sejarah */
.profile-sejarah__text {
    font-size: 14.5px;
    line-height: 1.85;
    color: #334155;
}

/* Kontak & Maps */
.profile-contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 28px;
    align-items: start;
}

.profile-contact-info {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.profile-info-row {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding-bottom: 12px;
    border-bottom: 1px dashed #e2e8f0;
}

.profile-info-row:last-of-type {
    border-bottom: none;
    padding-bottom: 0;
}

.profile-info-row__icon {
    font-size: 20px;
    flex-shrink: 0;
    margin-top: 2px;
}

.profile-info-row__label {
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: #64748b;
    margin-bottom: 2px;
}

.profile-info-row__val {
    font-size: 13.5px;
    font-weight: 600;
    color: #0f172a;
    line-height: 1.5;
}

.btn-profile-maps {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-profile-maps:hover {
    background: #1d4ed8;
    color: #ffffff;
}

.profile-map-box {
    height: 320px;
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid #cbd5e1;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
}

.profile-map-iframe {
    width: 100%;
    height: 100%;
    border: 0;
    display: block;
}

/* CTA */
.profile-cta {
    background: linear-gradient(135deg, #071B3A 0%, #0D2E5A 100%);
    border-radius: 16px;
    padding: 32px 36px;
    color: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 24px;
    flex-wrap: wrap;
    box-shadow: 0 10px 25px rgba(7, 27, 58, 0.25);
}

.profile-cta__text h3 {
    font-size: 20px;
    font-weight: 800;
    margin: 0 0 6px;
    color: #ffffff;
}

.profile-cta__text p {
    font-size: 14px;
    color: #cbd5e1;
    margin: 0;
}

.profile-cta__buttons {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.btn-profile-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 22px;
    background: #F9A825;
    color: #071B3A !important;
    font-size: 13.5px;
    font-weight: 800;
    border-radius: 999px;
    text-decoration: none;
    transition: transform 0.2s, box-shadow 0.2s;
    box-shadow: 0 4px 12px rgba(249, 168, 37, 0.35);
}

.btn-profile-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(249, 168, 37, 0.45);
}

.btn-profile-secondary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 22px;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.25);
    color: #ffffff !important;
    font-size: 13.5px;
    font-weight: 700;
    border-radius: 999px;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-profile-secondary:hover {
    background: rgba(255, 255, 255, 0.22);
}

/* Responsive */
@media (max-width: 900px) {
    .profile-leader {
        grid-template-columns: 1fr;
        text-align: center;
    }
    .profile-leader__speech {
        padding-left: 0;
    }
    .profile-leader__speech-header {
        justify-content: center;
    }
    .profile-grid-2 {
        grid-template-columns: 1fr;
    }
    .profile-tupoksi__grid {
        grid-template-columns: 1fr;
    }
    .profile-contact-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 600px) {
    .profile-hero {
        padding: 30px 20px;
    }
    .profile-hero__title {
        font-size: 24px;
    }
    .profile-card {
        padding: 22px 18px;
    }
    .profile-cta {
        padding: 24px 20px;
        flex-direction: column;
        align-items: stretch;
    }
    .profile-cta__buttons {
        flex-direction: column;
    }
    .profile-maklumat__inner {
        flex-direction: column;
    }
}
</style>
@endsection

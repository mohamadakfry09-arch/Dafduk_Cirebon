@extends('layouts.app')

@section('title', 'Jemput Bola - Dinas Kependudukan dan Pencatatan Sipil')

@section('styles')
<style>
/* Penegasan tulisan di bar pengisian agar kontras, tebal, dan berwarna hitam pekat */
#jemputBolaForm .admin-input,
#jemputBolaForm .admin-textarea,
#jemputBolaForm input,
#jemputBolaForm textarea,
#jemputBolaForm select,
.warga-auth-card .admin-input,
.warga-auth-card input {
    color: #000000 !important;
    font-size: 15px !important;
    font-weight: 600 !important;
    font-family: inherit !important;
    background-color: #ffffff !important;
    border: 1.5px solid #64748b !important;
    border-radius: 8px !important;
    padding: 10px 14px !important;
    line-height: 1.5 !important;
    box-sizing: border-box !important;
    -webkit-text-fill-color: #000000 !important;
}

#jemputBolaForm .admin-input:focus,
#jemputBolaForm .admin-textarea:focus,
#jemputBolaForm input:focus,
#jemputBolaForm textarea:focus,
.warga-auth-card .admin-input:focus,
.warga-auth-card input:focus {
    color: #000000 !important;
    border-color: #0284c7 !important;
    box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.25) !important;
    outline: none !important;
}

#jemputBolaForm label,
.warga-auth-card label {
    color: #000000 !important;
    font-weight: 700 !important;
    font-size: 13.5px !important;
}

/* Styling Lembar Surat Permohonan Resmi Sesuai Format Cetak */
.surat-permohonan-paper {
    background: #ffffff;
    color: #000000;
    font-family: 'Times New Roman', Times, serif;
    font-size: 15px;
    line-height: 1.55;
    padding: 45px 50px;
    border: 1px solid #cbd5e1;
    border-radius: 4px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    max-width: 820px;
    margin: 0 auto;
    box-sizing: border-box;
}

.surat-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 16px;
    font-size: 15px;
    font-family: 'Times New Roman', Times, serif;
}

.surat-table td {
    padding: 2px 0;
    vertical-align: top;
    color: #000000;
}

.surat-table td.surat-lbl {
    width: 160px;
}

.surat-table td.surat-col {
    width: 25px;
    text-align: center;
}

.surat-table td.surat-val {
    color: #000000;
}

/* @media print: Hanya cetak lembar surat secara bersih tanpa elemen navigasi web */
@media print {
    @page {
        size: A4 portrait;
        margin: 15mm 15mm 15mm 15mm;
    }

    body {
        background: #ffffff !important;
        margin: 0 !important;
        padding: 0 !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    /* Sembunyikan elemen antarmuka website */
    .navbar,
    .breadcrumb,
    .detail-sidebar,
    .page-back-link,
    .detail-tabs,
    .detail-section:not(#printSection),
    #jemputBolaForm,
    #jemputBolaNextBar,
    #jemputBolaStatusPanel,
    .btn-admin-primary,
    .btn-admin-secondary,
    footer,
    .admin-float-btn,
    .admin-drawer {
        display: none !important;
    }

    #jemputBolaOutputWrap {
        display: block !important;
        border: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    #jemputBolaOutputWrap > div:first-child,
    #jemputBolaOutputWrap > div:nth-child(3) {
        display: none !important;
    }

    #jemputBolaSummary {
        background: transparent !important;
        border: none !important;
        padding: 0 !important;
        margin: 0 !important;
        box-shadow: none !important;
    }

    .surat-permohonan-paper {
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        margin: 0 !important;
        max-width: 100% !important;
        width: 100% !important;
        font-size: 12pt !important;
        line-height: 1.5 !important;
    }

    .surat-table {
        font-size: 12pt !important;
    }
}

/* Smartphone & Mobile Responsive Styles */
@media (max-width: 768px) {
    .detail-page {
        padding: 14px 12px 60px !important;
    }
    .detail-tabs {
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
        display: flex !important;
        flex-wrap: nowrap !important;
        gap: 6px !important;
        padding-bottom: 6px !important;
        scrollbar-width: none !important;
    }
    .detail-tabs::-webkit-scrollbar {
        display: none !important;
    }
    .detail-tab {
        white-space: nowrap !important;
        flex-shrink: 0 !important;
        padding: 8px 16px !important;
        font-size: 13px !important;
    }
    .detail-section {
        padding: 16px 14px !important;
        border-radius: 14px !important;
    }
    .surat-permohonan-paper {
        padding: 18px 12px !important;
        font-size: 13.5px !important;
    }
    .surat-table td.surat-lbl {
        width: 105px !important;
        font-size: 13px !important;
    }
    .surat-table td.surat-col {
        width: 14px !important;
    }
    .surat-table td.surat-val {
        font-size: 13px !important;
    }
}
</style>
@endsection

@section('content')
<div class="breadcrumb">
    <div class="breadcrumb__container">
        <span class="breadcrumb__item"><a href="{{ url('/') }}">Beranda</a></span>
        <span class="breadcrumb__sep">›</span>
        <span class="breadcrumb__item"><a href="{{ url('/pelayanan') }}">Pelayanan</a></span>
        <span class="breadcrumb__sep">›</span>
        <span class="breadcrumb__item">{{ $service['title'] ?? 'Jemput Bola' }}</span>
    </div>
</div>

<div class="detail-page">
    <div class="detail-main">
        <a href="{{ url('/') }}" class="page-back-link" style="margin-bottom: 24px;">
            <span aria-hidden="true">←</span>
            <span>Kembali ke Beranda</span>
        </a>
        <div class="detail-tabs" aria-label="Tab detail layanan">
            <button type="button" id="tab-persyaratan" class="detail-tab active" onclick="switchTab('persyaratan')">Persyaratan</button>
            <button type="button" id="tab-prosedur" class="detail-tab" onclick="switchTab('prosedur')">Prosedur</button>
            <button type="button" id="tab-informasi" class="detail-tab" onclick="switchTab('informasi')">Informasi</button>
        </div>

        <div id="content-persyaratan" class="tab-content" style="display:block;">
            <div class="detail-section">
                <h2 class="detail-section__title">📋 Persyaratan Pengajuan</h2>
                <div class="detail-section__notice">
                    {{ $service['notice'] ?? 'Informasi persyaratan akan ditampilkan pada bagian ini. Pemohon diwajibkan melengkapi seluruh persyaratan administrasi sebelum melakukan pendaftaran.' }}
                </div>

                <div class="detail-req-list">
                    @forelse($service['requirements'] ?? [] as $index => $req)
                        <div class="detail-req-item">
                            <div class="detail-req-num">{{ $index + 1 }}</div>
                            <div class="detail-req-content">
                                <div class="detail-req-title">{{ $req['title'] ?? 'Persyaratan' }}</div>
                                @if(!empty($req['desc']))
                                    <div class="detail-req-desc">{{ $req['desc'] }}</div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="detail-req-desc">Belum ada persyaratan yang diatur untuk layanan ini.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div id="content-prosedur" class="tab-content" style="display:none;">
            <div class="detail-section">
                <h2 class="detail-section__title">🧭 Prosedur</h2>
                <div class="detail-req-list">
                    @forelse($service['procedures'] ?? [] as $index => $proc)
                        <div class="detail-req-item">
                            <div class="detail-req-num">{{ $index + 1 }}</div>
                            <div class="detail-req-content">
                                <div class="detail-req-title">{{ $proc['title'] ?? 'Tahap' }}</div>
                                @if(!empty($proc['desc']))
                                    <div class="detail-req-desc">{{ $proc['desc'] }}</div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="detail-req-desc">Belum ada prosedur yang diatur untuk layanan ini.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div id="content-informasi" class="tab-content" style="display:none;">
            <div class="detail-section">
                <h2 class="detail-section__title">ℹ️ Informasi Layanan</h2>
                <div class="detail-req-list">
                    @forelse($service['information'] ?? [] as $index => $info)
                        <div class="detail-req-item">
                            <div class="detail-req-num">{{ $index + 1 }}</div>
                            <div class="detail-req-content">
                                <div class="detail-req-title">{{ $info['title'] ?? 'Informasi' }}</div>
                                @if(!empty($info['desc']))
                                    <div class="detail-req-desc">{{ $info['desc'] }}</div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="detail-req-desc">Informasi layanan belum tersedia.</div>
                    @endforelse
                </div>
            </div>
        </div>

        @if(($service['slug'] ?? '') === 'jemput-bola')
        <div class="detail-section" id="printSection" style="margin-top: 20px;">
            <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:12px;">
                <h2 class="detail-section__title" style="margin:0;">📝 Formulir Pendaftaran Permohonan Jemput Bola</h2>
                <span style="font-size:12px; font-weight:700; background:#e0f2fe; color:#0369a1; padding:5px 12px; border-radius:999px;">
                    Format Surat Resmi Disdukcapil
                </span>
            </div>
            <p style="font-size:14px; color:#64748b; margin:0 0 20px; line-height:1.6;">
                Silakan lengkapi formulir permohonan perekaman KTP-el Jemput Bola di bawah ini. Dokumen permohonan akan secara otomatis disesuaikan dengan format surat resmi dan siap dicetak / diajukan.
            </p>

            @if(session('is_warga'))
                <!-- Banner Akun Email Terverifikasi -->
                <div style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border: 2px solid #86efac; border-radius: 14px; padding: 18px 22px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; box-shadow: 0 4px 14px rgba(34, 197, 94, 0.1);">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: #22c55e; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: bold; flex-shrink: 0; box-shadow: 0 2px 8px rgba(34, 197, 94, 0.3);">
                            ✓
                        </div>
                        <div>
                            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                <span style="font-size: 11px; font-weight: 800; color: #15803d; text-transform: uppercase; letter-spacing: 0.05em; background: #dcfce7; padding: 2px 8px; border-radius: 4px;">Akun Email Terverifikasi</span>
                                <span style="font-size: 15px; font-weight: 700; color: #14532d;">{{ session('warga_nama') }}</span>
                            </div>
                            <div style="font-size: 13.5px; color: #166534; margin-top: 3px;">
                                Email: <strong>{{ session('warga_email') }}</strong> &bull; Anda siap mengisi dan mengajukan permohonan Jemput Bola.
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('warga.logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-admin-secondary" style="padding: 8px 16px; font-size: 13px; font-weight: 600; background: #ffffff; color: #b91c1c; border: 1.5px solid #fca5a5; border-radius: 8px; cursor: pointer;">
                            Keluar (Ganti Akun)
                        </button>
                    </form>
                </div>
            @else
                <!-- Kartu Registrasi / Masuk Akun Email (Wajib untuk Mendaftar Jemput Bola) -->
                <div id="wargaAuthNoticeCard" class="warga-auth-card" style="background: #ffffff; border: 2.5px solid #0284c7; border-radius: 16px; padding: 24px; margin-bottom: 26px; box-shadow: 0 8px 30px rgba(2, 132, 199, 0.12); transition: all 0.3s ease;">
                    <div style="display: flex; align-items: flex-start; gap: 14px; margin-bottom: 18px;">
                        <div style="width: 46px; height: 46px; border-radius: 12px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0;">
                            ✉️
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; flex-wrap: wrap;">
                                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                    <h3 style="margin: 0; font-size: 18px; font-weight: 800; color: #0f172a;">
                                        Wajib Login / Registrasi Akun Email
                                    </h3>
                                    <span style="background: #fee2e2; color: #dc2626; font-size: 11px; font-weight: 800; padding: 3px 10px; border-radius: 999px; text-transform: uppercase;">
                                        Wajib Registrasi
                                    </span>
                                </div>
                                <a href="{{ url('/pelayanan/jemput-bola/login') }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 18px; background: #ef7d57; color: #ffffff; text-decoration: none; border-radius: 999px; font-size: 13px; font-weight: 700; box-shadow: 0 4px 12px rgba(239, 125, 87, 0.35); transition: all 0.2s;">
                                    <span style="width: 22px; height: 22px; background: #ffffff; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <svg viewBox="0 0 24 24" width="13" height="13">
                                            <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.8-2.4 3.65v3h3.86c2.26-2.09 3.685-5.17 3.685-9.09z"/>
                                            <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.86-3c-1.08.72-2.45 1.16-4.07 1.16-3.13 0-5.78-2.11-6.73-4.96H1.26v3.09C3.26 21.3 7.36 24 12 24z"/>
                                            <path fill="#FBBC05" d="M5.27 14.29c-.25-.72-.38-1.49-.38-2.29s.13-1.57.38-2.29V6.62H1.26C.46 8.23 0 10.06 0 12s.46 3.77 1.26 5.38l4.01-3.09z"/>
                                            <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.36 0 3.26 2.7 1.26 6.62l4.01 3.09c.95-2.85 3.6-4.96 6.73-4.96z"/>
                                        </svg>
                                    </span>
                                    <span>Login Akun Google (Pelayanan Adminduk)</span>
                                    <span>→</span>
                                </a>
                            </div>
                            <p style="margin: 6px 0 0; font-size: 14px; color: #475569; line-height: 1.55;">
                                Untuk mengajukan pendaftaran <strong>Pelayanan Jemput Bola</strong>, warga pemohon diwajibkan melakukan registrasi atau masuk menggunakan akun email aktif.
                            </p>
                        </div>
                    </div>

                    <div id="authAlertMessage" style="display: none; padding: 12px 16px; border-radius: 8px; font-size: 14px; font-weight: 600; margin-bottom: 16px;"></div>

                    @if(session('auth_error'))
                        <div style="background: #fef2f2; border: 1.5px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 8px; font-size: 14px; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                            <span>⚠️</span>
                            <span>{{ session('auth_error') }}</span>
                        </div>
                    @endif

                    @if(session('success'))
                        <div style="background: #f0fdf4; border: 1.5px solid #bbf7d0; color: #166534; padding: 12px 16px; border-radius: 8px; font-size: 14px; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                            <span>✓</span>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <div style="display: flex; gap: 10px; border-bottom: 2px solid #e2e8f0; margin-bottom: 20px;">
                        <button type="button" id="tabAuthRegister" onclick="switchAuthTab('register')" style="padding: 10px 20px; font-size: 14px; font-weight: 700; border: none; background: transparent; cursor: pointer; border-bottom: 3px solid #0284c7; color: #0284c7; margin-bottom: -2px; transition: all 0.2s;">
                            1. Registrasi Akun Email Baru
                        </button>
                        <button type="button" id="tabAuthLogin" onclick="switchAuthTab('login')" style="padding: 10px 20px; font-size: 14px; font-weight: 600; border: none; background: transparent; cursor: pointer; border-bottom: 3px solid transparent; color: #64748b; margin-bottom: -2px; transition: all 0.2s;">
                            2. Sudah Punya Akun? Masuk (Login)
                        </button>
                    </div>

                    <!-- 1. Form Registrasi Akun Email -->
                    <form id="wargaRegisterForm" action="{{ route('warga.register') }}" method="POST" style="display: block;">
                        @csrf
                        <input type="hidden" name="redirect" value="{{ url('/pelayanan/jemput-bola') }}">
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px; margin-bottom: 18px;">
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 13.5px; color: #000000; margin-bottom: 6px;">Nama Lengkap Pemohon <span style="color: #ef4444;">*</span></label>
                                <input type="text" name="nama" class="admin-input" required autocomplete="name">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 13.5px; color: #000000; margin-bottom: 6px;">Alamat Email Aktif <span style="color: #ef4444;">*</span></label>
                                <input type="email" name="email" class="admin-input" required autocomplete="email">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 13.5px; color: #000000; margin-bottom: 6px;">Kata Sandi (Password) <span style="color: #ef4444;">*</span></label>
                                <input type="password" name="password" class="admin-input" required minlength="4" autocomplete="new-password">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 13.5px; color: #000000; margin-bottom: 6px;">NIK Pemohon</label>
                                <input type="text" name="nik" class="admin-input" maxlength="16">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 13.5px; color: #000000; margin-bottom: 6px;">No. WhatsApp / HP</label>
                                <input type="tel" name="phone" class="admin-input">
                            </div>
                        </div>
                        <div style="display: flex; justify-content: flex-end; align-items: center; gap: 12px;">
                            <button type="submit" id="wargaRegisterSubmitBtn" class="btn-admin-primary" style="padding: 11px 24px; font-size: 14px; font-weight: 700; background: #0284c7; border-color: #0284c7; border-radius: 8px;">
                                Registrasi Akun Email & Lanjutkan Formulir →
                            </button>
                        </div>
                    </form>

                    <!-- 2. Form Masuk / Login Akun Email -->
                    <form id="wargaLoginForm" action="{{ route('warga.login') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="redirect" value="{{ url('/pelayanan/jemput-bola') }}">
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; margin-bottom: 18px;">
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 13.5px; color: #000000; margin-bottom: 6px;">Alamat Email atau NIK <span style="color: #ef4444;">*</span></label>
                                <input type="text" name="identity" class="admin-input" required autocomplete="username">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 700; font-size: 13.5px; color: #000000; margin-bottom: 6px;">Kata Sandi (Password) <span style="color: #ef4444;">*</span></label>
                                <input type="password" name="password" class="admin-input" required autocomplete="current-password">
                            </div>
                        </div>
                        <div style="display: flex; justify-content: flex-end; align-items: center; gap: 12px;">
                            <button type="submit" id="wargaLoginSubmitBtn" class="btn-admin-primary" style="padding: 11px 24px; font-size: 14px; font-weight: 700; background: #0f766e; border-color: #0f766e; border-radius: 8px;">
                                Masuk dengan Akun Email →
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <form id="jemputBolaForm" method="POST" enctype="multipart/form-data" class="print-form" style="display:grid; gap:20px;">
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 18px;">
                    
                    <!-- 1. Data Pemohon (Yang Bertanda Tangan) -->
                    <div style="border:1px solid #e2e8f0; border-radius:14px; padding:20px; background:#f8fafc;">
                        <div style="display:flex; align-items:center; gap:8px; margin-bottom:14px;">
                            <span style="display:inline-flex; align-items:center; justify-content:center; width:26px; height:26px; border-radius:50%; background:#2563eb; color:#fff; font-size:13px; font-weight:700;">1</span>
                            <h3 style="margin:0; font-size:17px; color:#0f172a;">Data Pemohon (Yang Bertanda Tangan)</h3>
                        </div>
                        <div style="display:grid; gap:13px;">
                            <div>
                                <label style="display:block; font-weight:600; font-size:13px; color:#1e293b; margin-bottom:6px;">Nama Lengkap Pemohon <span style="color:#ef4444;">*</span></label>
                                <input type="text" name="nama_pemohon" class="admin-input" value="{{ old('nama_pemohon', '') }}" required>
                            </div>
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                                <div>
                                    <label style="display:block; font-weight:600; font-size:13px; color:#1e293b; margin-bottom:6px;">NIK Pemohon <span style="color:#ef4444;">*</span></label>
                                    <input type="text" name="nik_pemohon" class="admin-input" maxlength="16" value="{{ old('nik_pemohon', '') }}" required>
                                </div>
                                <div>
                                    <label style="display:block; font-weight:600; font-size:13px; color:#1e293b; margin-bottom:6px;">No. Kartu Keluarga <span style="color:#ef4444;">*</span></label>
                                    <input type="text" name="no_kk" class="admin-input" maxlength="16" required>
                                </div>
                            </div>
                            <div>
                                <label style="display:block; font-weight:600; font-size:13px; color:#1e293b; margin-bottom:6px;">Hubungan dengan Yang Dimohonkan <span style="color:#ef4444;">*</span></label>
                                <input type="text" name="hubungan_pemohon" list="listHubungan" class="admin-input" required>
                                <datalist id="listHubungan">
                                    <option value="Anak Kandung">
                                     <option value="Suami">
                                    <option value="Istri">
                                    <option value="Orang Tua">
                                    <option value="Saudara Kandung">
                                    <option value="Diri Sendiri">
                                    <option value="Wali / Keluarga">
                                </datalist>
                            </div>
                            <div>
                                <label style="display:block; font-weight:600; font-size:13px; color:#1e293b; margin-bottom:6px;">Alamat Lengkap Pemohon <span style="color:#ef4444;">*</span></label>
                                <textarea name="alamat_pemohon" class="admin-textarea" rows="3" required></textarea>
                            </div>
                            <div>
                                <label style="display:block; font-weight:600; font-size:13px; color:#1e293b; margin-bottom:6px;">Kontak Pemohon (No. HP / WA) <span style="color:#ef4444;">*</span></label>
                                <input type="tel" name="kontak_pemohon" class="admin-input" value="{{ old('kontak_pemohon', '') }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Data Yang Dimohonkan (Perekaman KTP-el) -->
                    <div style="border:1px solid #e2e8f0; border-radius:14px; padding:20px; background:#f8fafc;">
                        <div style="display:flex; align-items:center; gap:8px; margin-bottom:14px;">
                            <span style="display:inline-flex; align-items:center; justify-content:center; width:26px; height:26px; border-radius:50%; background:#2563eb; color:#fff; font-size:13px; font-weight:700;">2</span>
                            <h3 style="margin:0; font-size:17px; color:#0f172a;">Data Yang Dimohonkan (Perekaman KTP-el)</h3>
                        </div>
                        <div style="display:grid; gap:13px;">
                            <div>
                                <label style="display:block; font-weight:600; font-size:13px; color:#1e293b; margin-bottom:6px;">Nama Yang Dimohonkan <span style="color:#ef4444;">*</span></label>
                                <input type="text" name="nama_dimohonkan" class="admin-input" required>
                            </div>
                            <div>
                                <label style="display:block; font-weight:600; font-size:13px; color:#1e293b; margin-bottom:6px;">NIK Yang Dimohonkan <span style="color:#ef4444;">*</span></label>
                                <input type="text" name="nik_dimohonkan" class="admin-input" maxlength="16" required>
                            </div>
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                                <div>
                                    <label style="display:block; font-weight:600; font-size:13px; color:#1e293b; margin-bottom:6px;">Tempat Lahir <span style="color:#ef4444;">*</span></label>
                                    <input type="text" name="tempat_lahir_dimohonkan" class="admin-input" required>
                                </div>
                                <div>
                                    <label style="display:block; font-weight:600; font-size:13px; color:#1e293b; margin-bottom:6px;">Tanggal Lahir <span style="color:#ef4444;">*</span></label>
                                    <input type="text" name="tgl_lahir_dimohonkan" class="admin-input" required>
                                </div>
                            </div>
                            <div>
                                <label style="display:block; font-weight:600; font-size:13px; color:#1e293b; margin-bottom:6px;">Alamat Perekaman (Lokasi Jemput Bola) <span style="color:#ef4444;">*</span></label>
                                <textarea name="alamat_dimohonkan" class="admin-textarea" rows="3" required></textarea>
                            </div>
                            <div>
                                <label style="display:block; font-weight:600; font-size:13px; color:#1e293b; margin-bottom:6px;">Alasan Permohonan Jemput Bola <span style="color:#ef4444;">*</span></label>
                                <input type="text" name="alasan_permohonan" list="listAlasan" class="admin-input" required>
                                <datalist id="listAlasan">
                                    <option value="Sakit">
                                    <option value="Lanjut Usia (Lansia)">
                                    <option value="Penyandang Disabilitas Fisik">
                                    <option value="ODGJ (Orang Dengan Gangguan Jiwa)">
                                    <option value="Sakit Menahun (Tirah Baring)">
                                </datalist>
                            </div>
                            <div>
                                <label style="display:block; font-weight:600; font-size:13px; color:#1e293b; margin-bottom:6px;">Keterangan Tambahan (Opsional)</label>
                                <input type="text" name="keterangan_permohonan" class="admin-input">
                            </div>
                        </div>
                    </div>

                    <!-- 3. Berkas Lampiran & Tanggal Surat -->
                    <div style="border:1px solid #e2e8f0; border-radius:14px; padding:20px; background:#f8fafc;">
                        <div style="display:flex; align-items:center; gap:8px; margin-bottom:14px;">
                            <span style="display:inline-flex; align-items:center; justify-content:center; width:26px; height:26px; border-radius:50%; background:#2563eb; color:#fff; font-size:13px; font-weight:700;">3</span>
                            <h3 style="margin:0; font-size:17px; color:#0f172a;">Lampiran & Tanggal Surat</h3>
                        </div>
                        <div style="display:grid; gap:13px;">
                            <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:12px; font-size:13px; color:#1e40af; line-height:1.5;">
                                <strong>Daftar Lampiran Surat:</strong>
                                <ol style="margin:6px 0 0 18px; padding:0;">
                                    <li>Photokopy Kartu Keluarga (KK) <em>(Otomatis)</em></li>
                                    <li>Lampiran 2 (opsional)</li>
                                    <li>Lampiran 3 (opsional)</li>
                                    <li>Lampiran 4 (opsional)</li>
                                </ol>
                            </div>
                            <div>
                                <label style="display:block; font-weight:600; font-size:13px; color:#1e293b; margin-bottom:6px;">Lampiran 2 (Opsional)</label>
                                <input type="text" name="lampiran_2" class="admin-input">
                            </div>
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                                <div>
                                    <label style="display:block; font-weight:600; font-size:13px; color:#1e293b; margin-bottom:6px;">Lampiran 3 (Opsional)</label>
                                    <input type="text" name="lampiran_3" class="admin-input">
                                </div>
                                <div>
                                    <label style="display:block; font-weight:600; font-size:13px; color:#1e293b; margin-bottom:6px;">Lampiran 4 (Opsional)</label>
                                    <input type="text" name="lampiran_4" class="admin-input">
                                </div>
                            </div>
                            <div>
                                <label style="display:block; font-weight:600; font-size:13px; color:#1e293b; margin-bottom:6px;">Unggah Berkas Lampiran (KK / Surat Dokter) <span style="color:#ef4444;">*</span></label>
                                <input type="file" name="lampiran_permohonan" class="admin-input" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>
                            </div>
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                                <div>
                                    <label style="display:block; font-weight:600; font-size:13px; color:#1e293b; margin-bottom:6px;">Kota Surat</label>
                                    <input type="text" name="kota_surat" class="admin-input" value="{{ old('kota_surat', '') }}" required>
                                </div>
                                <div>
                                    <label style="display:block; font-weight:600; font-size:13px; color:#1e293b; margin-bottom:6px;">Tanggal Surat</label>
                                    <input type="text" name="tanggal_surat" id="tanggalSuratInput" class="admin-input" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Tanda Tangan Pemohon -->
                    <div style="border:1px solid #e2e8f0; border-radius:14px; padding:20px; background:#f8fafc; grid-column: 1 / -1;">
                        <div style="display:flex; align-items:center; gap:8px; margin-bottom:14px;">
                            <span style="display:inline-flex; align-items:center; justify-content:center; width:26px; height:26px; border-radius:50%; background:#2563eb; color:#fff; font-size:13px; font-weight:700;">4</span>
                            <h3 style="margin:0; font-size:17px; color:#0f172a;">Tanda Tangan Pemohon</h3>
                        </div>
                        <div style="display:flex; flex-direction:column; gap:10px;">
                            <label style="display:block; font-weight:600; font-size:13px; color:#1e293b;">
                                Bubuhkan Tanda Tangan Digital Anda pada kotak berikut (menggunakan jari di layar sentuh HP atau mouse di PC):
                            </label>
                            <div style="border: 2px dashed #94a3b8; background: #ffffff; border-radius: 8px; overflow: hidden; width: 100%; max-width: 440px; touch-action: none; box-shadow: inset 0 2px 4px rgba(0,0,0,0.04);">
                                <canvas id="signatureCanvas" width="440" height="180" style="display:block; width:100%; height:auto; cursor:crosshair;"></canvas>
                            </div>
                            <div style="display:flex; gap: 10px; margin-top: 4px;">
                                <button type="button" id="clearSignatureBtn" class="btn-admin-secondary" style="padding: 6px 14px; font-size: 13px;">Hapus & Ulangi Tanda Tangan</button>
                            </div>
                            <input type="hidden" name="signature_data" id="signatureData">
                        </div>
                    </div>
                </div>
            </form>

            <div id="jemputBolaNextBar" style="display:flex; justify-content:flex-end; margin-top:20px;">
                <button type="button" id="showJemputDataBtn" class="btn-admin-primary" style="display:inline-flex; align-items:center; gap:8px; font-size:15px; padding:12px 24px;">
                    <span>Lihat Format Surat Permohonan</span>
                    <span>→</span>
                </button>
            </div>

            <div id="jemputBolaOutputWrap" style="display:none; margin-top: 26px; border-top: 2px solid #e2e8f0; padding-top: 24px;">
                <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap; margin-bottom:18px;">
                    <div>
                        <h3 style="margin:0 0 4px; font-size:20px; color:#0f172a;">📄 Pratinjau Surat Permohonan Resmi</h3>
                        <p style="margin:0; font-size:13px; color:#64748b;">Format di bawah ini telah disesuaikan dengan standar surat permohonan Jemput Bola Disdukcapil.</p>
                    </div>
                    <div style="display:flex; gap:10px; flex-wrap:wrap;">
                        <button type="button" id="backToJemputFormBtn" class="btn-admin-secondary">✏️ Ubah Data</button>
                        <button type="button" id="printJemputFormBtn" class="btn-admin-primary" style="background:#0f766e; border-color:#0f766e;">
                            🖨️ Cetak Surat Permohonan
                        </button>
                    </div>
                </div>

                <!-- Kontainer Dokumen Surat Fisik -->
                <div id="jemputBolaSummary" style="background:#f1f5f9; border-radius:12px; padding:24px 12px; min-height: 140px;">
                    Data surat akan tampil di sini setelah data diisi.
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap; margin-top:22px; margin-bottom:18px;">
                    <button type="button" id="backToJemputFormBtnSecondary" class="btn-admin-secondary">← Kembali ke Form</button>
                    <div style="display:flex; gap:10px;">
                        <button type="button" id="printJemputFormBtnBottom" class="btn-admin-secondary">🖨️ Cetak Surat</button>
                        <button type="button" id="submitJemputFormBtn" class="btn-admin-primary">Kirim Permohonan</button>
                    </div>
                </div>

                <div id="jemputBolaStatusPanel" style="display:none; margin-top:20px; border:1px solid #fbbf24; background:#fff7ed; color:#92400e; border-radius:12px; padding:20px;">
                    <div id="statusBadge" style="display:inline-flex; align-items:center; gap:8px; margin-bottom:12px; font-weight:700; font-size:12px; text-transform:uppercase; letter-spacing:0.06em;">
                        <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#f59e0b;"></span>
                        Monitoring Permohonan Warga
                    </div>

                    <div id="approvalFlow" style="display:flex; align-items:center; justify-content:flex-start; gap:12px; flex-wrap:wrap; margin-bottom:18px;">
                        <div class="approval-step" data-status="accepted" style="display:flex; align-items:center; gap:8px; padding:8px 14px; border-radius:999px; border:1px solid #bbf7d0; background:#f0fdf4; color:#166534; font-size:12px; font-weight:600;">
                            <span style="display:inline-flex; align-items:center; justify-content:center; width:18px; height:18px; border-radius:50%; background:#22c55e; color:#fff; font-size:11px; font-weight:700;">✓</span>
                            <span>Disetujui</span>
                        </div>
                        <div class="approval-step" data-status="pending" style="display:flex; align-items:center; gap:8px; padding:8px 14px; border-radius:999px; border:1px solid #fcd34d; background:#fffbeb; color:#92400e; font-size:12px; font-weight:600;">
                            <span style="display:inline-flex; align-items:center; justify-content:center; width:18px; height:18px; border-radius:50%; background:#f59e0b; color:#fff; font-size:11px; font-weight:700;">•</span>
                            <span>Dalam Proses Persetujuan</span>
                        </div>
                        <div class="approval-step" data-status="rejected" style="display:flex; align-items:center; gap:8px; padding:8px 14px; border-radius:999px; border:1px solid #fecaca; background:#fef2f2; color:#991b1b; font-size:12px; font-weight:600;">
                            <span style="display:inline-flex; align-items:center; justify-content:center; width:18px; height:18px; border-radius:50%; background:#ef4444; color:#fff; font-size:11px; font-weight:700;">✕</span>
                            <span>Tidak Disetujui</span>
                        </div>
                    </div>

                    <h3 id="statusTitle" style="margin:0 0 8px; font-size:20px;">Dalam Proses Persetujuan</h3>
                    <p id="statusMessage" style="margin:0; line-height:1.7;">Terima kasih sudah mendaftarkan permohonan jemput bola. Mohon tunggu proses persetujuan dari admin.</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    <aside class="detail-sidebar">
        <div class="related-services">
            <h3 class="related-services__title">Layanan Lainnya</h3>
            @forelse($relatedServices ?? [] as $related)
                @php
                    $relUrl = (($related['slug'] ?? '') === 'jemput-bola' && !session('is_warga'))
                        ? url('/pelayanan/jemput-bola/login')
                        : url('/pelayanan/' . ($related['slug'] ?? ''));
                @endphp
                <a href="{{ $relUrl }}" style="text-decoration:none; color:inherit; display:block;">
                    <div class="related-service-item">
                        <div class="related-service-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                @if(($related['icon'] ?? '') === 'credit-card')
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/>
                                @elseif(($related['icon'] ?? '') === 'map-pin')
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                                @else
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                                @endif
                            </svg>
                        </div>
                        <div class="related-service-content">
                            <div class="related-service-title">{{ $related['title'] ?? 'Layanan' }}</div>
                            <div class="related-service-sub">{{ $related['tag'] ?? 'KEPENDUDUKAN' }}</div>
                        </div>
                        <div class="related-service-arrow">›</div>
                    </div>
                </a>
            @empty
                <div class="detail-req-desc">Tidak ada layanan terkait.</div>
            @endforelse
        </div>
    </aside>
</div>
@endsection

@section('scripts')
<script>
    window.jemputBolaApproval = <?php echo json_encode($service['approval'] ?? [
        'default_status' => 'pending',
        'pending_title' => 'Dalam Proses Persetujuan',
        'pending_message' => 'Terima kasih sudah mendaftarkan permohonan jemput bola. Mohon tunggu proses persetujuan dari admin.',
        'accepted_title' => 'Persetujuan Diterima',
        'accepted_message' => 'Pengajuan Anda telah disetujui dan akan diproses lebih lanjut oleh admin.',
        'rejected_title' => 'Pengajuan Tidak Disetujui',
        'rejected_message' => 'Mohon maaf, pengajuan Anda belum dapat disetujui pada saat ini.'
    ]); ?>;

    function speakServiceRequirements() {
        const titleEl = document.querySelector('.hero__title');
        const title = titleEl ? titleEl.textContent.trim() : 'layanan';

        if (!('speechSynthesis' in window)) return;

        window.speechSynthesis.cancel();
        const utterance = new SpeechSynthesisUtterance('Persyaratan ' + title + '.');
        utterance.lang = 'id-ID';
        utterance.rate = 0.95;
        window.speechSynthesis.speak(utterance);
    }

    function switchTab(name) {
        document.querySelectorAll('.detail-tab').forEach(t => t.classList.remove('active'));
        const tabBtn = document.getElementById('tab-' + name);
        if (tabBtn) tabBtn.classList.add('active');

        document.querySelectorAll('.tab-content').forEach(c => c.style.display = 'none');
        const contentBox = document.getElementById('content-' + name);
        if (contentBox) contentBox.style.display = 'block';

        if (name === 'persyaratan') {
            setTimeout(speakServiceRequirements, 350);
        }
    }

    function switchAuthTab(tab) {
        const regTab = document.getElementById('tabAuthRegister');
        const loginTab = document.getElementById('tabAuthLogin');
        const regForm = document.getElementById('wargaRegisterForm');
        const loginForm = document.getElementById('wargaLoginForm');

        if (!regTab || !loginTab || !regForm || !loginForm) return;

        if (tab === 'register') {
            regTab.style.borderBottom = '3px solid #0284c7';
            regTab.style.color = '#0284c7';
            regTab.style.fontWeight = '700';

            loginTab.style.borderBottom = '3px solid transparent';
            loginTab.style.color = '#64748b';
            loginTab.style.fontWeight = '600';

            regForm.style.display = 'block';
            loginForm.style.display = 'none';
        } else {
            loginTab.style.borderBottom = '3px solid #0f766e';
            loginTab.style.color = '#0f766e';
            loginTab.style.fontWeight = '700';

            regTab.style.borderBottom = '3px solid transparent';
            regTab.style.color = '#64748b';
            regTab.style.fontWeight = '600';

            regForm.style.display = 'none';
            loginForm.style.display = 'block';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const isWargaAuth = @json((bool) session('is_warga'));

        window.promptWargaAuth = function() {
            const authCard = document.getElementById('wargaAuthNoticeCard');
            if (authCard) {
                authCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                authCard.style.boxShadow = '0 0 0 4px rgba(239, 68, 68, 0.4)';
                setTimeout(() => {
                    authCard.style.boxShadow = '0 8px 30px rgba(2, 132, 199, 0.12)';
                }, 2500);
            }
            if (confirm('Perhatian: Anda wajib masuk (login) menggunakan akun email terlebih dahulu sebelum mengisi formulir permohonan Jemput Bola.\n\nKlik OK untuk membuka Halaman Login Email.')) {
                window.location.href = "{{ url('/pelayanan/jemput-bola/login') }}";
            }
        };

        // AJAX handler untuk Registrasi & Login Akun Email
        function setupAuthFormAjax(formId, submitBtnId, loadingText) {
            const authForm = document.getElementById(formId);
            const submitBtn = document.getElementById(submitBtnId);
            const alertBox = document.getElementById('authAlertMessage');
            if (!authForm || !submitBtn) return;

            authForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(authForm);
                const originalText = submitBtn.textContent;
                submitBtn.disabled = true;
                submitBtn.textContent = loadingText;

                if (alertBox) alertBox.style.display = 'none';

                fetch(authForm.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(async res => {
                    const data = await res.json();
                    if (!res.ok) {
                        throw new Error(data.message || 'Terjadi kesalahan, silakan periksa data Anda.');
                    }
                    return data;
                })
                .then(data => {
                    if (alertBox) {
                        alertBox.style.display = 'block';
                        alertBox.style.background = '#f0fdf4';
                        alertBox.style.border = '1.5px solid #86efac';
                        alertBox.style.color = '#15803d';
                        alertBox.innerHTML = `✓ ${data.message || 'Berhasil! Mengalihkan...'}`;
                    }
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                })
                .catch(err => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                    if (alertBox) {
                        alertBox.style.display = 'block';
                        alertBox.style.background = '#fef2f2';
                        alertBox.style.border = '1.5px solid #fecaca';
                        alertBox.style.color = '#991b1b';
                        alertBox.innerHTML = `⚠️ ${err.message}`;
                        alertBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    } else {
                        alert(err.message);
                    }
                });
            });
        }

        setupAuthFormAjax('wargaRegisterForm', 'wargaRegisterSubmitBtn', 'Mendaftarkan akun email...');
        setupAuthFormAjax('wargaLoginForm', 'wargaLoginSubmitBtn', 'Sedang memproses masuk...');

        const defaultTab = document.getElementById('tab-persyaratan');
        if (defaultTab && defaultTab.classList.contains('active')) {
            setTimeout(speakServiceRequirements, 400);
        }

        const form = document.getElementById('jemputBolaForm');
        if (!form) return;

        if (!isWargaAuth) {
            form.querySelectorAll('input, textarea, select').forEach(el => {
                el.addEventListener('focus', function() {
                    if (!isWargaAuth) {
                        window.promptWargaAuth();
                    }
                }, { once: true });
            });
        }

        const summaryBox = document.getElementById('jemputBolaSummary');
        const statusPanel = document.getElementById('jemputBolaStatusPanel');
        const statusTitle = document.getElementById('statusTitle');
        const statusMessage = document.getElementById('statusMessage');
        const statusBadge = document.getElementById('statusBadge');
        const approvalSteps = document.querySelectorAll('.approval-step');
        const resetBtn = document.getElementById('resetJemputFormBtn');
        const printBtn = document.getElementById('printJemputFormBtn');
        const printBtnBottom = document.getElementById('printJemputFormBtnBottom');
        const showBtn = document.getElementById('showJemputDataBtn');
        const backFromOutputBtn = document.getElementById('backToJemputFormBtn');
        const secondaryBackBtn = document.getElementById('backToJemputFormBtnSecondary');
        const submitBtn = document.getElementById('submitJemputFormBtn');

        // Format tanggal hari ini
        const today = new Date();
        const dd = String(today.getDate()).padStart(2, '0');
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const yyyy = today.getFullYear();
        const defaultTanggalFormatted = `${dd} - ${mm} - ${yyyy}`;
        
        const tanggalInput = document.getElementById('tanggalSuratInput');

        const renderSummary = () => {
            const formData = new FormData(form);

            const namaPemohon = (formData.get('nama_pemohon') || '').trim();
            const nikPemohon = (formData.get('nik_pemohon') || '').trim();
            const alamatPemohon = (formData.get('alamat_pemohon') || '').trim();
            const hubunganPemohon = (formData.get('hubungan_pemohon') || '').trim();

            const namaDimohonkan = (formData.get('nama_dimohonkan') || '').trim();
            const nikDimohonkan = (formData.get('nik_dimohonkan') || '').trim();
            const tempatLahir = (formData.get('tempat_lahir_dimohonkan') || '').trim();
            const tglLahir = (formData.get('tgl_lahir_dimohonkan') || '').trim();

            let ttlDimohonkan = '';
            if (tempatLahir && tglLahir) {
                ttlDimohonkan = `${tempatLahir}, ${tglLahir}`;
            } else if (tempatLahir) {
                ttlDimohonkan = tempatLahir;
            } else if (tglLahir) {
                ttlDimohonkan = tglLahir;
            } else {
                ttlDimohonkan = '';
            }

            const alamatDimohonkan = (formData.get('alamat_dimohonkan') || '').trim();
            const alasanPermohonan = (formData.get('alasan_permohonan') || '').trim();
            const keteranganPermohonan = (formData.get('keterangan_permohonan') || '').trim();

            const lampiran2 = (formData.get('lampiran_2') || '').trim();
            const lampiran3 = (formData.get('lampiran_3') || '').trim();
            const lampiran4 = (formData.get('lampiran_4') || '').trim();

            const kotaSurat = (formData.get('kota_surat') || 'Cirebon').trim();
            const tanggalSurat = (formData.get('tanggal_surat') || '........................').trim();
            const sigData = formData.get('signature_data') || '';

            const htmlContent = `
                <div id="printLetterArea" class="surat-permohonan-paper">
                    <div style="font-family: 'Times New Roman', Times, serif; color: #000000; font-size: 15px; line-height: 1.55;">
                        <div style="margin-bottom: 22px;">
                            Kepada Yth.<br>
                            Kepala Dinas Kependudukan dan Pencatatan Sipil<br>
                            Kabupaten Cirebon<br>
                            di<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;Sumber
                        </div>

                        <div style="margin-bottom: 22px;">
                            Perihal : Permohonan Perekaman KTP-el
                        </div>

                        <div style="margin-bottom: 12px;">
                            Dengan Hormat,<br>
                            Saya yang bertanda tangan di bawah ini:
                        </div>

                        <table class="surat-table" style="width: 100%; border-collapse: collapse; margin-bottom: 16px; font-size: 15px;">
                            <tr>
                                <td class="surat-lbl" style="width: 160px; vertical-align: top; padding: 2px 0;">Nama</td>
                                <td class="surat-col" style="width: 25px; vertical-align: top; text-align: center; padding: 2px 0;">:</td>
                                <td class="surat-val" style="vertical-align: top; padding: 2px 0; font-weight: bold; text-transform: uppercase;">${namaPemohon || '...................................................'}</td>
                            </tr>
                            <tr>
                                <td class="surat-lbl" style="vertical-align: top; padding: 2px 0;">NIK</td>
                                <td class="surat-col" style="vertical-align: top; text-align: center; padding: 2px 0;">:</td>
                                <td class="surat-val" style="vertical-align: top; padding: 2px 0;">${nikPemohon || '...................................................'}</td>
                            </tr>
                            <tr>
                                <td class="surat-lbl" style="vertical-align: top; padding: 2px 0;">Alamat</td>
                                <td class="surat-col" style="vertical-align: top; text-align: center; padding: 2px 0;">:</td>
                                <td class="surat-val" style="vertical-align: top; padding: 2px 0;">${alamatPemohon || '...................................................'}</td>
                            </tr>
                            <tr>
                                <td class="surat-lbl" style="vertical-align: top; padding: 2px 0;">Hubungan</td>
                                <td class="surat-col" style="vertical-align: top; text-align: center; padding: 2px 0;">:</td>
                                <td class="surat-val" style="vertical-align: top; padding: 2px 0;">${hubunganPemohon || '...................................................'}</td>
                            </tr>
                        </table>

                        <div style="text-align: justify; text-justify: inter-word; line-height: 1.6; margin-bottom: 16px;">
                            Dengan ini bermaksud mengajukan permohonan perekaman KTP Elektronik (KTP-el) di ${alamatDimohonkan || '...................................................'} dikarenakan ${alasanPermohonan || '...................................................'} dan tidak memungkinkan untuk datang langsung ke Kantor Dinas Kependudukan dan Pencatatan Sipil. Adapun data yang akan dilakukan perekaman adalah sebagai berikut;
                        </div>

                        <table class="surat-table" style="width: 100%; border-collapse: collapse; margin-bottom: 16px; font-size: 15px;">
                            <tr>
                                <td class="surat-lbl" style="width: 160px; vertical-align: top; padding: 2px 0;">Nama</td>
                                <td class="surat-col" style="width: 25px; vertical-align: top; text-align: center; padding: 2px 0;">:</td>
                                <td class="surat-val" style="vertical-align: top; padding: 2px 0; font-weight: bold; text-transform: uppercase;">${namaDimohonkan || '...................................................'}</td>
                            </tr>
                            <tr>
                                <td class="surat-lbl" style="vertical-align: top; padding: 2px 0;">NIK</td>
                                <td class="surat-col" style="vertical-align: top; text-align: center; padding: 2px 0;">:</td>
                                <td class="surat-val" style="vertical-align: top; padding: 2px 0;">${nikDimohonkan || '...................................................'}</td>
                            </tr>
                            <tr>
                                <td class="surat-lbl" style="vertical-align: top; padding: 2px 0;">Tempat/ Tgl Lahir</td>
                                <td class="surat-col" style="vertical-align: top; text-align: center; padding: 2px 0;">:</td>
                                <td class="surat-val" style="vertical-align: top; padding: 2px 0;">${ttlDimohonkan || '...................................................'}</td>
                            </tr>
                            <tr>
                                <td class="surat-lbl" style="vertical-align: top; padding: 2px 0;">Alamat</td>
                                <td class="surat-col" style="vertical-align: top; text-align: center; padding: 2px 0;">:</td>
                                <td class="surat-val" style="vertical-align: top; padding: 2px 0;">${alamatDimohonkan || '...................................................'}</td>
                            </tr>
                            <tr>
                                <td class="surat-lbl" style="vertical-align: top; padding: 2px 0;">Keterangan</td>
                                <td class="surat-col" style="vertical-align: top; text-align: center; padding: 2px 0;">:</td>
                                <td class="surat-val" style="vertical-align: top; padding: 2px 0;">${keteranganPermohonan || ''}</td>
                            </tr>
                        </table>

                        <div style="margin-bottom: 4px;">
                            Bersamaan surat ini, saya lampirkan:
                        </div>
                        <div style="margin-left: 20px; margin-bottom: 18px; line-height: 1.6;">
                            <div>1. Photokopy Kartu Keluarga (KK)</div>
                            <div>2. ${lampiran2 || '.................................................'}</div>
                            <div>3. ${lampiran3 || '.................................................'}</div>
                            <div>4. ${lampiran4 || '.................................................'}</div>
                        </div>

                        <div style="text-align: justify; text-justify: inter-word; line-height: 1.6; margin-bottom: 30px;">
                            Demikian surat permohonan ini saya buat, besar harapan kami agar dapat dibantu dalam proses perekaman KTP-el, atas perhatian dan bantuan, kami ucapkan terima kasih.
                        </div>

                        <div style="display: flex; justify-content: flex-end; margin-top: 24px;">
                            <div style="text-align: center; width: 280px;">
                                <div>${kotaSurat}, ${tanggalSurat}</div>
                                <div style="margin-top: 4px; margin-bottom: 6px;">Hormat kami,</div>
                                <div style="height: 75px; display: flex; align-items: center; justify-content: center; margin-bottom: 6px;">
                                    ${sigData ? `<img src="${sigData}" style="max-height: 75px; max-width: 240px; display: block;" />` : `<div style="height: 75px;"></div>`}
                                </div>
                                <div style="font-weight: bold; text-transform: uppercase;">
                                    ${namaPemohon || '...........................................'}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            summaryBox.innerHTML = htmlContent;
        };

        const updateMonitoring = () => {
            const config = window.jemputBolaApproval || {};
            const status = config.default_status || 'pending';
            const isApproved = status === 'accepted';
            const isRejected = status === 'rejected';
            const isPending = !isApproved && !isRejected;

            const title = isPending
                ? (config.pending_title || 'Dalam Proses Persetujuan')
                : (isApproved ? (config.accepted_title || 'Persetujuan Diterima') : (config.rejected_title || 'Pengajuan Tidak Disetujui'));

            const message = isPending
                ? (config.pending_message || 'Terima kasih sudah mendaftarkan permohonan jemput bola. Mohon tunggu proses persetujuan dari admin.')
                : (isApproved ? (config.accepted_message || 'Pengajuan Anda telah disetujui dan akan diproses lebih lanjut oleh admin.') : (config.rejected_message || 'Mohon maaf, pengajuan Anda belum dapat disetujui pada saat ini.'));

            if (statusPanel) statusPanel.style.display = 'block';
            if (statusTitle) statusTitle.textContent = title;
            if (statusMessage) {
                statusMessage.textContent = message;
                if (isPending) {
                    statusMessage.style.background = '#fff7ed';
                    statusMessage.style.borderColor = '#fbbf24';
                    statusMessage.style.color = '#92400e';
                } else if (isApproved) {
                    statusMessage.style.background = '#f0fdf4';
                    statusMessage.style.borderColor = '#bbf7d0';
                    statusMessage.style.color = '#166534';
                } else {
                    statusMessage.style.background = '#fef2f2';
                    statusMessage.style.borderColor = '#fecaca';
                    statusMessage.style.color = '#991b1b';
                }
            }
            if (statusBadge) {
                const dot = statusBadge.querySelector('span');
                if (dot) {
                    dot.style.background = isPending ? '#f59e0b' : (isApproved ? '#22c55e' : '#ef4444');
                }
            }

            approvalSteps.forEach((step) => {
                const stepStatus = step.dataset.status;
                const isActive = stepStatus === status;
                const isInactive = !isActive;

                step.style.opacity = isInactive ? '0.55' : '1';
                step.style.transform = isActive ? 'scale(1.02)' : 'scale(1)';
                step.style.boxShadow = isActive ? '0 0 0 2px rgba(148, 163, 184, 0.2)' : 'none';

                const indicator = step.querySelector('span');
                if (indicator) {
                    if (stepStatus === 'accepted') {
                        indicator.style.background = isActive ? '#22c55e' : '#bbf7d0';
                        indicator.style.color = '#fff';
                    } else if (stepStatus === 'pending') {
                        indicator.style.background = isActive ? '#f59e0b' : '#fcd34d';
                        indicator.style.color = '#fff';
                    } else if (stepStatus === 'rejected') {
                        indicator.style.background = isActive ? '#ef4444' : '#fecaca';
                        indicator.style.color = '#fff';
                    }
                }
            });
        };

        const validateForm = () => {
            if (!isWargaAuth) {
                window.promptWargaAuth();
                return false;
            }
            const requiredFields = form.querySelectorAll('input[required], textarea[required]');
            for (const field of requiredFields) {
                if (!field.value.trim()) {
                    field.focus();
                    field.reportValidity();
                    return false;
                }
            }
            return true;
        };

        const handlePrint = function() {
            if (!validateForm()) return;
            if (window.jemputBolaApproval) {
                window.jemputBolaApproval.default_status = 'pending';
            }
            renderSummary();
            updateMonitoring();
            const outputWrap = document.getElementById('jemputBolaOutputWrap');
            if (outputWrap) outputWrap.style.display = 'block';
            window.print();
        };

        if (printBtn) {
            printBtn.addEventListener('click', handlePrint);
        }
        if (printBtnBottom) {
            printBtnBottom.addEventListener('click', handlePrint);
        }

        if (showBtn) {
            showBtn.addEventListener('click', function() {
                if (!validateForm()) return;
                renderSummary();
                if (statusPanel) statusPanel.style.display = 'none';
                const outputWrap = document.getElementById('jemputBolaOutputWrap');
                if (outputWrap) {
                    outputWrap.style.display = 'block';
                    outputWrap.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        }

        if (backFromOutputBtn || secondaryBackBtn) {
            const handleBack = function() {
                const outputWrap = document.getElementById('jemputBolaOutputWrap');
                const formBlock = document.getElementById('jemputBolaForm');
                if (outputWrap) outputWrap.style.display = 'none';
                if (formBlock) {
                    formBlock.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            };

            if (backFromOutputBtn) backFromOutputBtn.addEventListener('click', handleBack);
            if (secondaryBackBtn) secondaryBackBtn.addEventListener('click', handleBack);
        }

        if (submitBtn) {
            submitBtn.addEventListener('click', function() {
                if (!validateForm()) return;

                const originalText = submitBtn.textContent;
                submitBtn.disabled = true;
                submitBtn.textContent = 'Mengirim Permohonan...';

                const formData = new FormData(form);

                fetch("{{ route('jemput-bola.submit') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;

                    if (data.success) {
                        const sub = data.submission || {};
                        const regId = sub.id || '';

                        if (window.jemputBolaApproval) {
                            window.jemputBolaApproval.default_status = sub.status || 'pending';
                        }
                        renderSummary();
                        updateMonitoring();

                        if (statusTitle && regId) {
                            statusTitle.innerHTML = `Dalam Proses Persetujuan <span style="display:inline-block; font-size:14px; background:#0284c7; color:#fff; padding:3px 10px; border-radius:999px; margin-left:8px; vertical-align:middle;">No. Reg: ${regId}</span>`;
                        }

                        const outputWrap = document.getElementById('jemputBolaOutputWrap');
                        if (outputWrap) outputWrap.scrollIntoView({ behavior: 'smooth', block: 'start' });

                        alert(`✓ Permohonan Jemput Bola Berhasil Terkirim!\nNomor Registrasi Anda: ${regId}\n\nSilakan simpan atau cetak surat permohonan Anda.`);
                    } else {
                        alert(data.message || 'Gagal mengirim permohonan. Silakan periksa kembali data Anda.');
                    }
                })
                .catch(err => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                    renderSummary();
                    updateMonitoring();
                    const outputWrap = document.getElementById('jemputBolaOutputWrap');
                    if (outputWrap) outputWrap.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            });
        }

        if (resetBtn) {
            resetBtn.addEventListener('click', function() {
                form.reset();
                if (tanggalInput) tanggalInput.value = '';
                if (summaryBox) summaryBox.innerHTML = 'Data surat akan tampil di sini setelah data diisi.';
                if (statusPanel) statusPanel.style.display = 'none';
                const outputWrap = document.getElementById('jemputBolaOutputWrap');
                if (outputWrap) outputWrap.style.display = 'none';
            });
        }

        form.querySelectorAll('input, textarea').forEach(el => {
            el.addEventListener('input', renderSummary);
            el.addEventListener('change', renderSummary);
        });

        // Signature Canvas Logic
        const canvas = document.getElementById('signatureCanvas');
        const clearBtn = document.getElementById('clearSignatureBtn');
        const signatureData = document.getElementById('signatureData');
        
        if (canvas) {
            const ctx = canvas.getContext('2d');
            let isDrawing = false;
            
            // Set initial background
            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            
            function getCoordinates(e) {
                const rect = canvas.getBoundingClientRect();
                const scaleX = canvas.width / rect.width;
                const scaleY = canvas.height / rect.height;
                
                let clientX = e.clientX;
                let clientY = e.clientY;
                
                if (e.touches && e.touches.length > 0) {
                    clientX = e.touches[0].clientX;
                    clientY = e.touches[0].clientY;
                }
                
                return {
                    x: (clientX - rect.left) * scaleX,
                    y: (clientY - rect.top) * scaleY
                };
            }
            
            function startDrawing(e) {
                isDrawing = true;
                const coords = getCoordinates(e);
                ctx.beginPath();
                ctx.moveTo(coords.x, coords.y);
                if (e.cancelable) e.preventDefault();
            }
            
            function draw(e) {
                if (!isDrawing) return;
                const coords = getCoordinates(e);
                ctx.lineTo(coords.x, coords.y);
                ctx.strokeStyle = '#000000';
                ctx.lineWidth = 2.5;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';
                ctx.stroke();
                if (e.cancelable) e.preventDefault();
            }
            
            function stopDrawing() {
                if (isDrawing) {
                    isDrawing = false;
                    signatureData.value = canvas.toDataURL('image/png');
                    renderSummary(); // update summary with new signature
                }
            }
            
            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('mouseup', stopDrawing);
            canvas.addEventListener('mouseout', stopDrawing);
            
            canvas.addEventListener('touchstart', startDrawing, { passive: false });
            canvas.addEventListener('touchmove', draw, { passive: false });
            canvas.addEventListener('touchend', stopDrawing);
            
            if (clearBtn) {
                clearBtn.addEventListener('click', () => {
                    ctx.fillStyle = "#ffffff";
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                    signatureData.value = '';
                    renderSummary();
                });
            }
        }

        renderSummary();
    });
</script>
@endsection
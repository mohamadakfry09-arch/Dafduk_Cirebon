@extends('layouts.app')

@section('title', 'Login - Pelayanan Jemput Bola Dinas Kependudukan dan Pencatatan Sipil')

@section('styles')
<style>
    /* Styling khusus Pelayanan Adminduk Disdukcapil Kab. Cirebon */
    .adminduk-login-page-wrapper {
        min-height: calc(100vh - 120px);
        background-color: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px 14px;
        box-sizing: border-box;
    }

    .adminduk-login-app-container {
        width: 100%;
        max-width: 420px;
        background: #ffffff;
        border-radius: 32px;
        box-shadow: 0 16px 45px rgba(15, 23, 42, 0.12);
        border: 1px solid #e2e8f0;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        min-height: 660px;
    }

    .adminduk-login-header {
        padding: 20px 20px 10px 20px;
        display: flex;
        align-items: center;
        position: relative;
    }

    .adminduk-login-back-btn {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #ef7d57;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        cursor: pointer;
    }

    .adminduk-login-back-btn:hover {
        background: #f1f5f9;
        transform: scale(1.05);
    }

    .adminduk-login-title {
        position: absolute;
        left: 0;
        right: 0;
        text-align: center;
        margin: 0;
        font-size: 22px;
        font-weight: 600;
        color: #475569;
        pointer-events: none;
    }

    .adminduk-login-body {
        padding: 16px 22px 90px 22px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .adminduk-login-info-box {
        background: #e2f6f9;
        border-radius: 16px;
        padding: 20px 20px;
        margin-bottom: 22px;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.02);
    }

    .adminduk-login-info-list {
        margin: 0;
        padding-left: 20px;
        color: #334155;
        font-size: 13.5px;
        line-height: 1.62;
    }

    .adminduk-login-info-list li {
        margin-bottom: 12px;
    }

    .adminduk-login-info-list li:last-child {
        margin-bottom: 0;
    }

    .adminduk-login-info-list strong {
        color: #1e293b;
        font-weight: 700;
    }

    .adminduk-login-terms-wrap {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 24px;
        cursor: pointer;
        user-select: none;
    }

    .adminduk-login-checkbox {
        width: 20px;
        height: 20px;
        margin-top: 2px;
        accent-color: #ef7d57;
        cursor: pointer;
        flex-shrink: 0;
    }

    .adminduk-login-terms-label {
        font-size: 13.5px;
        color: #475569;
        line-height: 1.5;
    }

    .adminduk-login-terms-label a,
    .adminduk-login-subtext a {
        color: #0284c7;
        text-decoration: underline;
        font-weight: 600;
    }

    .adminduk-login-google-btn {
        width: 100%;
        background: #ef7d57;
        color: #ffffff;
        border: none;
        border-radius: 999px;
        padding: 14px 24px;
        font-size: 16px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 16px rgba(239, 125, 87, 0.35);
    }

    .adminduk-login-google-btn:not(:disabled):hover {
        background: #e66c44;
        box-shadow: 0 6px 20px rgba(239, 125, 87, 0.45);
        transform: translateY(-1px);
    }

    .adminduk-login-google-btn:disabled {
        opacity: 0.55;
        cursor: not-allowed;
        box-shadow: none;
    }

    .adminduk-login-google-icon-circle {
        width: 32px;
        height: 32px;
        background: #ffffff;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.12);
        flex-shrink: 0;
    }

    .adminduk-login-subtext {
        text-align: center;
        font-size: 12.5px;
        color: #64748b;
        margin-top: 14px;
        line-height: 1.5;
    }

    /* Bottom Navigation Bar persis seperti di screenshot */
    .adminduk-login-bottom-nav {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 68px;
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-around;
        padding: 0 8px;
        z-index: 20;
    }

    .adminduk-login-nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 3px;
        text-decoration: none;
        color: #64748b;
        font-size: 11px;
        font-weight: 600;
        flex: 1;
        transition: color 0.2s ease;
    }

    .adminduk-login-nav-item svg {
        stroke: currentColor;
    }

    .adminduk-login-nav-item.active {
        color: #ef7d57;
    }

    /* Modal Google Account Picker */
    .google-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(5px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 16px;
    }

    .google-modal-card {
        background: #ffffff;
        width: 100%;
        max-width: 440px;
        border-radius: 20px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
        border: 1px solid #e2e8f0;
        overflow: hidden;
        animation: modalScaleIn 0.22s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes modalScaleIn {
        from { transform: scale(0.92); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .google-account-picker-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 16px;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        background: #ffffff;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: left;
        width: 100%;
        margin-bottom: 10px;
        position: relative;
    }

    .google-account-picker-item:hover {
        background: #f8fafc;
        border-color: #3b82f6;
        box-shadow: 0 4px 14px rgba(59, 130, 246, 0.12);
        transform: translateY(-1px);
    }

    .google-account-picker-item.selected {
        border-color: #ef7d57;
        background: #fffaf8;
        box-shadow: 0 4px 14px rgba(239, 125, 87, 0.18);
    }

    .google-account-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 16px;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }
</style>
@endsection

@section('content')

@php
    $initialAccounts = $registeredAccounts ?? [];
    if (empty($initialAccounts)) {
        $initialAccounts = [
            [
                'nama' => 'Nova Fitriyanti',
                'email' => 'sinovacfty@gmail.com'
            ]
        ];
    }
@endphp

<div class="adminduk-login-page-wrapper">
    <div class="adminduk-login-app-container">

        <!-- Top Header: Back Button & Centered Title "Login" -->
        <div class="adminduk-login-header">
            <a href="{{ url('/') }}" class="adminduk-login-back-btn" title="Kembali ke Beranda" aria-label="Kembali ke Beranda">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <h1 class="adminduk-login-title">Login</h1>
        </div>

        <!-- Main Body -->
        <div class="adminduk-login-body">

            @if(session('auth_error'))
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 12px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 16px;">
                    {{ session('auth_error') }}
                </div>
            @endif

            @if(session('info'))
                <div style="background: #eff6ff; border-left: 4px solid #3b82f6; color: #1e40af; padding: 12px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 16px;">
                    {{ session('info') }}
                </div>
            @endif

            @if(session('success'))
                <div style="background: #f0fdf4; border-left: 4px solid #22c55e; color: #166534; padding: 12px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 16px;">
                    {{ session('success') }}
                </div>
            @endif

            <!-- 1. Kotak Informasi Biru Muda (Pelayanan Adminduk) -->
            <div class="adminduk-login-info-box">
                <ul class="adminduk-login-info-list">
                    <li>
                        Login hanya dapat menggunakan email akun <strong>Google</strong> yang valid dan aktif; kami <strong>tidak mengakses isi akun Google dan tidak menyimpan kata sandi</strong> Anda.
                    </li>
                    <li>
                        Satu akun Pelayanan Adminduk digunakan utk melakukan permohonan 1 Keluarga. Tidak dapat mengentri NIK yg telah digunakan Akun lain.
                    </li>
                    <li>
                        Data pribadi pada Pelayanan Adminduk hanya digunakan untuk <strong>layanan administrasi kependudukan dan tidak dibagikan kepada pihak manapun</strong>.
                    </li>
                </ul>
            </div>

            <!-- 2. Checkbox Persetujuan Syarat & Ketentuan -->
            <label class="adminduk-login-terms-wrap" for="agreeTermsCheckbox" id="termsWrapper">
                <input type="checkbox" id="agreeTermsCheckbox" class="adminduk-login-checkbox">
                <span class="adminduk-login-terms-label">
                    Saya telah membaca dan menyetujui <a href="javascript:void(0)" onclick="openTermsModal(event)">Syarat & Ketentuan Layanan</a>.
                </span>
            </label>

            <!-- 3. Tombol Login Google Coral/Orange -->
            <button type="button" id="googleLoginBtn" class="adminduk-login-google-btn" disabled onclick="handleGoogleLoginClick()">
                <div class="adminduk-login-google-icon-circle">
                    <!-- Google Authentic 'G' SVG Logo -->
                    <svg viewBox="0 0 24 24" width="18" height="18">
                        <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.8-2.4 3.65v3h3.86c2.26-2.09 3.685-5.17 3.685-9.09z"/>
                        <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.86-3c-1.08.72-2.45 1.16-4.07 1.16-3.13 0-5.78-2.11-6.73-4.96H1.26v3.09C3.26 21.3 7.36 24 12 24z"/>
                        <path fill="#FBBC05" d="M5.27 14.29c-.25-.72-.38-1.49-.38-2.29s.13-1.57.38-2.29V6.62H1.26C.46 8.23 0 10.06 0 12s.46 3.77 1.26 5.38l4.01-3.09z"/>
                        <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.36 0 3.26 2.7 1.26 6.62l4.01 3.09c.95-2.85 3.6-4.96 6.73-4.96z"/>
                    </svg>
                </div>
                <span id="googleLoginBtnLabel">Login Google</span>
            </button>

            <!-- 4. Catatan Kaki Tombol -->
            <p class="adminduk-login-subtext">
                *) Jika tombol tidak aktif, silahkan baca <a href="javascript:void(0)" onclick="openTermsModal(event)">Syarat & Ketentuan</a>
            </p>

        </div>

        <!-- 5. Bottom Navigation Bar (Home, Layanan, ChatBot, Akun) -->
        <nav class="adminduk-login-bottom-nav" aria-label="Navigasi bawah">
            <a href="{{ url('/') }}" class="adminduk-login-nav-item">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                <span>Home</span>
            </a>
            <a href="{{ url('/pelayanan') }}" class="adminduk-login-nav-item">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="16" x="2" y="4" rx="2"/>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                </svg>
                <span>Layanan</span>
            </a>
            <a href="{{ url('/Kontak') }}" class="adminduk-login-nav-item">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    <line x1="8" y1="9" x2="16" y2="9"/>
                    <line x1="8" y1="13" x2="14" y2="13"/>
                </svg>
                <span>ChatBot</span>
            </a>
            <a href="javascript:void(0)" class="adminduk-login-nav-item active">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <span>Akun</span>
            </a>
        </nav>

    </div>
</div>

<!-- Modal Dialog: Autentikasi Akun Google Pemohon (Pilih Akun Google) -->
<div id="googlePickerModal" class="google-modal-overlay" onclick="handleModalOverlayClick(event)">
    <div class="google-modal-card">
        
        <!-- Header Dialog Google -->
        <div style="padding: 22px 24px 16px 24px; border-bottom: 1px solid #f1f5f9;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <svg viewBox="0 0 24 24" width="24" height="24">
                        <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.8-2.4 3.65v3h3.86c2.26-2.09 3.685-5.17 3.685-9.09z"/>
                        <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.86-3c-1.08.72-2.45 1.16-4.07 1.16-3.13 0-5.78-2.11-6.73-4.96H1.26v3.09C3.26 21.3 7.36 24 12 24z"/>
                        <path fill="#FBBC05" d="M5.27 14.29c-.25-.72-.38-1.49-.38-2.29s.13-1.57.38-2.29V6.62H1.26C.46 8.23 0 10.06 0 12s.46 3.77 1.26 5.38l4.01-3.09z"/>
                        <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.36 0 3.26 2.7 1.26 6.62l4.01 3.09c.95-2.85 3.6-4.96 6.73-4.96z"/>
                    </svg>
                    <span style="font-weight: 700; color: #1e293b; font-size: 17px;">Login dengan Google</span>
                </div>
                <button type="button" onclick="closeGoogleModal()" style="border: none; background: transparent; font-size: 22px; color: #94a3b8; cursor: pointer; padding: 2px 6px;">✕</button>
            </div>
            <p style="margin: 0; font-size: 13px; color: #64748b; line-height: 1.5;">
                Pilih akun Google Anda untuk melanjutkan ke layanan <strong>Jemput Bola Disdukcapil Kab. Cirebon</strong>:
            </p>
        </div>

        <!-- Body: Daftar Akun Google Pengguna -->
        <div id="googleModalBody" style="padding: 20px 24px; max-height: 400px; overflow-y: auto;">
            
            <!-- Tempat daftar akun Google yang otomatis tampil -->
            <div id="googleAccountsContainer"></div>

            <!-- Tombol Toggle: Gunakan Akun Google Lain -->
            <div class="google-account-picker-item" onclick="toggleAddAccountForm()" style="border-style: dashed; background: #f8fafc;">
                <div class="google-account-avatar" style="background: #e2e8f0; color: #64748b; font-size: 20px;">
                    +
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-size: 14px; font-weight: 700; color: #334155;">Gunakan akun Google lain</div>
                    <div style="font-size: 12px; color: #94a3b8;">Masuk dengan alamat email pemohon lainnya</div>
                </div>
            </div>

            <!-- Formulir Tambah / Masuk dengan Akun Baru -->
            <div id="addAccountFormWrapper" style="display: none; background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 14px; padding: 16px; margin-top: 10px; margin-bottom: 12px; animation: modalScaleIn 0.2s ease;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="font-size: 13px; font-weight: 700; color: #0f172a;">Masukkan Akun Google Baru:</span>
                    <button type="button" onclick="toggleAddAccountForm()" style="background: none; border: none; font-size: 12px; color: #ef4444; font-weight: 700; cursor: pointer;">Batal</button>
                </div>
                <form onsubmit="handleAddNewAccountSubmit(event)">
                    <div style="margin-bottom: 10px;">
                        <label style="display: block; font-size: 11.5px; font-weight: 700; color: #475569; margin-bottom: 4px;">Nama Lengkap Pemohon (Sesuai KTP/KK) <span style="color: #ef4444;">*</span></label>
                        <input type="text" id="inputNewNama" placeholder="Nama lengkap pemohon" required style="width: 100%; height: 42px; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 0 12px; font-size: 14px; color: #000000 !important; font-weight: 600; box-sizing: border-box;">
                    </div>
                    <div style="margin-bottom: 14px;">
                        <label style="display: block; font-size: 11.5px; font-weight: 700; color: #475569; margin-bottom: 4px;">Email Google (@gmail.com) <span style="color: #ef4444;">*</span></label>
                        <input type="email" id="inputNewEmail" placeholder="nama@gmail.com" required style="width: 100%; height: 42px; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 0 12px; font-size: 14px; color: #000000 !important; font-weight: 600; box-sizing: border-box;">
                    </div>
                    <button type="submit" id="btnSubmitNewAccount" class="adminduk-login-google-btn" style="width: 100%; height: 44px; font-size: 14px; font-weight: 700; box-shadow: 0 4px 12px rgba(239, 125, 87, 0.35);">
                        <span id="btnSubmitNewAccountText">Lanjutkan Masuk dengan Email Google Ini &rarr;</span>
                    </button>
                </form>
            </div>

        </div>

        <!-- Footer Modal -->
        <div style="background: #f8fafc; padding: 12px 24px; border-top: 1px solid #f1f5f9; text-align: center; font-size: 11.5px; color: #94a3b8;">
            Disdukcapil Kabupaten Cirebon &bull; Layanan Jemput Bola
        </div>
    </div>
</div>

<!-- Modal Dialog: Syarat & Ketentuan Layanan -->
<div id="termsModal" class="google-modal-overlay">
    <div class="google-modal-card" style="max-width: 480px;">
        <div style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
            <h3 style="margin: 0; font-size: 17px; font-weight: 700; color: #0f172a;">Syarat & Ketentuan Layanan</h3>
            <button type="button" onclick="closeTermsModal()" style="border: none; background: transparent; font-size: 20px; color: #94a3b8; cursor: pointer;">✕</button>
        </div>
        <div style="padding: 20px 24px; font-size: 13.5px; color: #475569; line-height: 1.65; max-height: 360px; overflow-y: auto;">
            <p style="margin-top: 0;">Dengan menggunakan layanan pendaftaran Jemput Bola Administrasi Kependudukan, Anda menyetujui ketentuan berikut:</p>
            <ol style="padding-left: 20px; margin: 0 0 16px;">
                <li style="margin-bottom: 8px;"><strong>Autentikasi Akun Google:</strong> Login hanya menggunakan email Google aktif yang valid. Sistem kami tidak mengakses isi data pribadi maupun menyimpan kata sandi Google Anda.</li>
                <li style="margin-bottom: 8px;"><strong>1 Akun per 1 Keluarga:</strong> Satu akun pemohon diperuntukkan untuk permohonan dalam 1 Kartu Keluarga. Nomor Induk Kependudukan (NIK) yang telah terdaftar tidak dapat digunakan oleh akun pemohon lain.</li>
                <li style="margin-bottom: 8px;"><strong>Kerahasiaan Data:</strong> Seluruh data administrasi kependudukan yang diunggah dilindungi sesuai Undang-Undang Kependudukan dan tidak dibagikan kepada pihak mana pun.</li>
                <li><strong>Kebenaran Data:</strong> Pemohon bertanggung jawab penuh atas kebenaran seluruh dokumen dan data permohonan perekaman KTP-el Jemput Bola.</li>
            </ol>
        </div>
        <div style="padding: 16px 24px; background: #f8fafc; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; gap: 10px;">
            <button type="button" onclick="acceptTermsAndClose()" style="padding: 10px 20px; background: #ef7d57; color: #ffffff; border: none; border-radius: 8px; font-size: 13.5px; font-weight: 700; cursor: pointer;">
                Saya Mengerti & Setujui
            </button>
        </div>
    </div>
</div>

<!-- Hidden Form for Google Login POST -->
<form id="googlePostForm" action="{{ route('warga.google.login') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="email" id="googlePostEmail">
    <input type="hidden" name="nama" id="googlePostNama">
    <input type="hidden" name="redirect" value="{{ url('/pelayanan/jemput-bola') }}">
</form>

@endsection

@section('scripts')
<script>
    const checkbox = document.getElementById('agreeTermsCheckbox');
    const googleBtn = document.getElementById('googleLoginBtn');

    if (checkbox && googleBtn) {
        googleBtn.disabled = !checkbox.checked;
        checkbox.addEventListener('change', function() {
            googleBtn.disabled = !this.checked;
        });
    }
    
    // Akun terdaftar dari server
    const serverAccounts = @json($initialAccounts);
    
    // Palet warna Google Avatar
    const googleColors = ['#1a73e8', '#ea4335', '#34a853', '#f9ab00', '#8e24aa', '#ef7d57'];

    function getLocalAccounts() {
        try {
            const raw = localStorage.getItem('dafduk_user_google_accounts');
            if (raw) {
                const parsed = JSON.parse(raw);
                if (Array.isArray(parsed)) return parsed;
            }
        } catch (e) {
            console.error('Error reading localStorage accounts', e);
        }
        return [];
    }

    function saveAccountToLocal(email, nama) {
        let accounts = getLocalAccounts();
        accounts = accounts.filter(a => a.email.toLowerCase() !== email.toLowerCase());
        accounts.unshift({ nama: nama, email: email, lastUsed: new Date().toISOString() });
        localStorage.setItem('dafduk_user_google_accounts', JSON.stringify(accounts));
        localStorage.setItem('pemohon_google_email', email);
        localStorage.setItem('pemohon_google_nama', nama);
    }

    function getCombinedAccounts() {
        const localList = getLocalAccounts();
        const combined = [...localList];

        // Tambahkan akun dari server jika belum ada di list
        serverAccounts.forEach(sa => {
            const exists = combined.some(c => c.email.toLowerCase() === sa.email.toLowerCase());
            if (!exists) {
                combined.push({
                    nama: sa.nama,
                    email: sa.email,
                    lastUsed: null
                });
            }
        });

        // Default jika kosong sama sekali
        if (combined.length === 0) {
            combined.push({
                nama: 'Nova Fitriyanti',
                email: 'sinovacfty@gmail.com',
                lastUsed: null
            });
        }

        return combined;
    }

    // Render daftar akun Google pada modal
    function renderGoogleAccounts() {
        const container = document.getElementById('googleAccountsContainer');
        if (!container) return;

        const accounts = getCombinedAccounts();
        const activeEmail = (localStorage.getItem('pemohon_google_email') || accounts[0]?.email || '').toLowerCase();

        let html = '';
        accounts.forEach((acc, index) => {
            const initial = (acc.nama && acc.nama.trim().length > 0) ? acc.nama.trim().charAt(0).toUpperCase() : 'G';
            const color = googleColors[index % googleColors.length];
            const isSelected = (acc.email.toLowerCase() === activeEmail);

            html += `
                <div class="google-account-picker-item ${isSelected ? 'selected' : ''}" 
                     onclick="selectAndLoginGoogle('${escapeJs(acc.email)}', '${escapeJs(acc.nama)}')"
                     title="Klik untuk masuk sebagai ${escapeHtml(acc.nama)}">
                    <div class="google-account-avatar" style="background: ${color};">
                        ${initial}
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-size: 14.5px; font-weight: 700; color: #1e293b; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                ${escapeHtml(acc.nama)}
                            </span>
                            ${isSelected ? '<span style="font-size: 10px; font-weight: 800; background: #fed7aa; color: #c2410c; padding: 2px 7px; border-radius: 999px;">PILIHAN</span>' : ''}
                        </div>
                        <div style="font-size: 13px; color: #64748b; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; margin-top: 2px;">
                            ${escapeHtml(acc.email)}
                        </div>
                    </div>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </div>
            `;
        });

        container.innerHTML = html;

        // Update pratinjau utama di halaman depan
        const currentActive = accounts.find(a => a.email.toLowerCase() === activeEmail) || accounts[0];
        if (currentActive) {
            updateMainCardDisplay(currentActive.nama, currentActive.email);
        }
    }

    function updateMainCardDisplay(nama, email) {
        const nameText = document.getElementById('mainAccountNameText');
        const emailText = document.getElementById('mainAccountEmailText');
        const avatarInitial = document.getElementById('mainAvatarInitial');
        const avatarWrap = document.getElementById('mainAvatarWrap');

        const initial = (nama && nama.trim().length > 0) ? nama.trim().charAt(0).toUpperCase() : 'G';

        if (nameText) nameText.textContent = nama;
        if (emailText) emailText.textContent = email;
        if (avatarInitial) avatarInitial.textContent = initial;
    }

    function escapeHtml(str) {
        return (str || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    function escapeJs(str) {
        return (str || '').replace(/'/g, "\\'").replace(/"/g, '\\"');
    }

    // Klik tombol utama "Login Google": Buka modal pilihan akun Google
    function handleGoogleLoginClick() {
        if (!checkbox || !checkbox.checked) {
            const termsWrap = document.getElementById('termsWrapper');
            if (termsWrap) {
                termsWrap.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.4)';
                termsWrap.style.borderRadius = '8px';
                setTimeout(() => { termsWrap.style.boxShadow = 'none'; }, 2000);
            }
            alert('Silakan centang persetujuan Syarat & Ketentuan Layanan terlebih dahulu.');
            return;
        }

        openGoogleModal();
    }

    // Pengguna memilih salah satu akun dari daftar dan langsung login
    function selectAndLoginGoogle(email, nama) {
        if (!checkbox || !checkbox.checked) {
            checkbox.checked = true;
        }

        saveAccountToLocal(email, nama);
        updateMainCardDisplay(nama, email);

        // Tampilkan indikator loading penghubung akun
        const modalBody = document.getElementById('googleModalBody');
        if (modalBody) {
            modalBody.innerHTML = `
                <div style="padding: 36px 20px; text-align: center;">
                    <div style="width: 44px; height: 44px; border: 3.5px solid #fed7aa; border-top-color: #ef7d57; border-radius: 50%; margin: 0 auto 16px auto; animation: spin 0.8s linear infinite;"></div>
                    <div style="font-size: 16px; font-weight: 700; color: #0f172a;">Menghubungkan Akun Google...</div>
                    <div style="font-size: 13.5px; color: #64748b; margin-top: 4px;">${escapeHtml(email)}</div>
                    <div style="font-size: 12px; color: #94a3b8; margin-top: 14px;">Mengalihkan ke formulir pendaftaran Jemput Bola...</div>
                </div>
            `;
        }

        const label = document.getElementById('googleLoginBtnLabel');
        if (label) label.textContent = 'Menghubungkan...';

        setTimeout(() => {
            submitGoogleLogin(email, nama);
        }, 350);
    }

    function toggleAddAccountForm() {
        const formWrap = document.getElementById('addAccountFormWrapper');
        if (formWrap) {
            const isHidden = (formWrap.style.display === 'none' || formWrap.style.display === '');
            formWrap.style.display = isHidden ? 'block' : 'none';
            if (isHidden) {
                setTimeout(() => {
                    const input = document.getElementById('inputNewNama');
                    if (input) input.focus();
                }, 100);
            }
        }
    }

    function handleAddNewAccountSubmit(e) {
        e.preventDefault();
        const nama = (document.getElementById('inputNewNama').value || '').trim();
        const email = (document.getElementById('inputNewEmail').value || '').trim();

        if (!nama || !email) {
            alert('Mohon isi nama lengkap dan alamat email Google.');
            return;
        }

        const btnText = document.getElementById('btnSubmitNewAccountText');
        if (btnText) btnText.textContent = 'Menghubungkan...';

        selectAndLoginGoogle(email, nama);
    }

    function openGoogleModal() {
        renderGoogleAccounts();
        const modal = document.getElementById('googlePickerModal');
        if (modal) modal.style.display = 'flex';
    }

    function closeGoogleModal() {
        const modal = document.getElementById('googlePickerModal');
        if (modal) modal.style.display = 'none';
        const formWrap = document.getElementById('addAccountFormWrapper');
        if (formWrap) formWrap.style.display = 'none';
    }

    function handleModalOverlayClick(e) {
        if (e.target && e.target.id === 'googlePickerModal') {
            closeGoogleModal();
        }
    }

    function openTermsModal(e) {
        if (e) e.preventDefault();
        const modal = document.getElementById('termsModal');
        if (modal) modal.style.display = 'flex';
    }

    function closeTermsModal() {
        const modal = document.getElementById('termsModal');
        if (modal) modal.style.display = 'none';
    }

    function acceptTermsAndClose() {
        if (checkbox) {
            checkbox.checked = true;
            if (googleBtn) googleBtn.disabled = false;
        }
        closeTermsModal();
    }

    function submitGoogleLogin(email, nama) {
        const emailField = document.getElementById('googlePostEmail');
        const namaField = document.getElementById('googlePostNama');
        const form = document.getElementById('googlePostForm');

        if (emailField && namaField && form) {
            emailField.value = email;
            namaField.value = nama;
            form.submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        renderGoogleAccounts();
    });
</script>
@endsection

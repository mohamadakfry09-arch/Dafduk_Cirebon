<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="Portal resmi pelayanan administrasi kependudukan dan pencatatan sipil. Mempermudah warga dalam mengurus dokumen kependudukan secara digital dan transparan.">
    <title>@yield('title', 'Dinas Kependudukan Dan Pencatatan Sipil')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Lexend:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
    <!-- Fitur Aksesibilitas Disabilitas -->
    <link rel="stylesheet" href="{{ asset('css/accessibility.css') }}?v={{ filemtime(public_path('css/accessibility.css')) }}">

    @yield('styles')
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar" id="navbar" style="padding-left:0;">
        <div class="navbar__container" style="padding-left:0;">
            <div class="navbar__left-group" style="padding-left:0;margin-left:0;">
                <a href="{{ url('/') }}" class="navbar__brand"
                    style="display: flex; align-items: center; gap: 10px; text-decoration: none; margin-left: 0; padding-left: 0;">
                    <div class="navbar__logo" style="margin-left:0;padding-left:0;">
                        <img src="{{ asset('images/logopemkabcirebon.png') }}" alt="Logo Dinas"
                            style="height: 48px; width: auto; display: block;">
                    </div>
                </a>
                <div class="navbar__brand-text" style="margin-left: 0; padding-left: 0;">
                    <span class="navbar__brand-name">DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL</span>
                    <span class="navbar__brand-sub">PEMKAB CIREBON</span>
                </div>
            </div>

            <div class="navbar__admin-right" style="display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-left:auto; margin-right:0; padding-right:0;">
                <a href="{{ url('/') }}" aria-label="Ke Beranda"
                    style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:50%; background:rgba(30,95,168,0.08); border:1px solid rgba(30,95,168,0.18); color:var(--color-primary); text-decoration:none;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 10.5 12 3l9 7.5" />
                        <path d="M5 9.5V20h14V9.5" />
                        <path d="M10 20v-6h4v6" />
                    </svg>
                </a>


                @if(session('is_warga') && !session('is_admin'))
                    <div style="display:inline-flex; align-items:center; gap:8px; background:#eff6ff; border:1px solid #bfdbfe; border-radius:999px; padding:5px 12px; font-size:12px; color:#1e40af; font-weight:700;">
                        <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#2563eb;"></span>
                        <span>{{ Str::limit(session('warga_nama'), 18) }}</span>
                        <form action="{{ route('warga.logout') }}" method="POST" style="margin:0; display:inline;">
                            @csrf
                            <button type="submit" title="Keluar Akun Email" style="background:none; border:none; color:#dc2626; cursor:pointer; font-weight:700; padding:0 0 0 4px; font-size:12px;">(Keluar)</button>
                        </form>
                    </div>
                @endif

                @if(session('is_admin'))
                    <a href="{{ url('/admin/dashboard') }}" class="btn-admin-pill"
                        style="text-decoration:none; background:#0D2E5A; color:#ffffff; border-color:#0D2E5A; display:inline-flex; align-items:center; gap:7px; font-weight:700; box-shadow:0 3px 10px rgba(13,46,90,0.25);">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#F9A825" stroke-width="2.5">
                            <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                        </svg>
                        <span>Dashboard Admin</span>
                    </a>
                    <button type="button" class="btn-admin-logout" onclick="logoutAnyUser()" title="Logout Admin">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                    </button>
                @else
                    <a href="{{ route('admin.login') }}" class="btn-admin-pill"
                        style="text-decoration:none; background:#ffffff; color:#0D2E5A; border:1px solid #C2D8F0; font-weight:700; display:inline-flex; align-items:center; gap:7px; box-shadow:0 2px 6px rgba(13,46,90,0.06);">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1565C0" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                        <span>Login Admin</span>
                    </a>
                @endif
            </div>


        </div>
    </nav>

    <!-- Running Text (Hanya di Beranda) -->
    @if(request()->is('/'))
    <div class="running-text-bar" aria-label="Informasi pelayanan">
        <div class="running-text-bar__logo-wrap">
            <img src="{{ asset('images/logo capil.jpg') }}" alt="Logo Disdukcapil" class="running-text-bar__logo">
        </div>
        <div class="running-text-bar__scroll-area">
            <div class="running-text-bar__track">
                <span>SELAMAT DATANG DI KANAL PELAYANAN ADMINISTRASI KEPENDUDUKAN DISDUKCAPIL KABUPATEN CIREBON &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; SELAMAT DATANG DI KANAL PELAYANAN ADMINISTRASI KEPENDUDUKAN DISDUKCAPIL KABUPATEN CIREBON &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; SELAMAT DATANG DI KANAL PELAYANAN ADMINISTRASI KEPENDUDUKAN DISDUKCAPIL KABUPATEN CIREBON &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</span>
            </div>
        </div>
    </div>
    @endif

    <!-- Page Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer__container">
            <div class="footer__grid">
                <!-- Menu -->
                <div class="footer__col">
                    <h3 class="footer__heading">Menu</h3>
                    <ul class="footer__links">
                        <li><a href="{{ url('/') }}" class="footer__link">Beranda</a></li>
                        <li><a href="{{ url('/pelayanan') }}" class="footer__link">Pelayanan</a></li>
                        <li><a href="{{ url('/informasi') }}" class="footer__link">Informasi</a></li>
                        <li><a href="{{ url('/tentang') }}" class="footer__link">Tentang Kami</a></li>
                        <li><a href="{{ url('/syarat-ketentuan') }}" class="footer__link">Persyaratan</a></li>
                        <li><a href="{{ url('/kebijakan-privasi') }}" class="footer__link">Kebijakan</a></li>
                        <li><a href="{{ url('/faq') }}" class="footer__link">FAQ</a></li>
                        <li><a href="{{ url('/Kontak') }}" class="footer__link">Kontak Kami</a></li>
                    </ul>
                </div>

                <!-- Tentang -->
                <div class="footer__col">
                    <h3 class="footer__heading">Tentang Kami</h3>
                    <p class="footer__desc">Portal resmi Disdukcapil Pemkab Cirebon. Mempermudah warga dalam mengurus dokumen kependudukan secara digital, transparan, dan profesional.</p>
                </div>

                <!-- Lokasi -->
                <div class="footer__col">
                    <h3 class="footer__heading">Lokasi Kantor</h3>
                    <p class="footer__desc">Jl. Sunan Muria Komplek Pemda No.84, Sumber, Cirebon.</p>
                    <div class="footer__map">
                        <iframe src="https://maps.google.com/maps?q={{ urlencode('Dinas Kependudukan dan Pencatatan Sipil Kabupaten Cirebon') }}&output=embed&z=16" title="Peta lokasi Disdukcapil Kabupaten Cirebon" loading="lazy"></iframe>
                    </div>
                </div>
            </div>

            <div class="footer__bottom">
                <p>© 2026 Dinas Kependudukan dan Pencatatan Sipil Pemkab Cirebon.</p>
            </div>
        </div>
    </footer>

    <!-- ============================================================
         SMARTPHONE APP BOTTOM NAVIGATION BAR (Mobile Only <= 768px)
         ============================================================ -->
    @unless(request()->is('pelayanan/jemput-bola/login'))
        @php
            $isHome = request()->is('/');
            $isLayanan = request()->is('pelayanan*') && !request()->is('pelayanan/jemput-bola/login');
            $isChatBot = request()->is('Kontak*') || request()->is('kontak*');
            $isAkun = request()->is('*login*') || request()->is('*register*') || request()->is('admin/dashboard*') || (request()->is('pelayanan/jemput-bola*') && session('is_warga'));
            
            if (session('is_admin')) {
                $accountUrl = url('/admin/dashboard');
                $accountLabel = 'Admin';
            } elseif (session('is_warga')) {
                $accountUrl = url('/pelayanan/jemput-bola');
                $accountLabel = 'Pemohon';
            } else {
                $accountUrl = url('/pelayanan/jemput-bola/login');
                $accountLabel = 'Akun';
            }
        @endphp
        
        <nav class="mobile-app-bottom-nav" aria-label="Navigasi Smartphone">
            <a href="{{ url('/') }}" class="mobile-app-nav-item {{ $isHome ? 'active' : '' }}">
                <div class="mobile-app-nav-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                </div>
                <span>Home</span>
            </a>
            <a href="{{ url('/pelayanan') }}" class="mobile-app-nav-item {{ $isLayanan ? 'active' : '' }}">
                <div class="mobile-app-nav-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="20" height="16" x="2" y="4" rx="2"/>
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                    </svg>
                </div>
                <span>Layanan</span>
            </a>
            <a href="{{ url('/Kontak') }}" class="mobile-app-nav-item {{ $isChatBot ? 'active' : '' }}">
                <div class="mobile-app-nav-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        <line x1="8" y1="9" x2="16" y2="9"/>
                        <line x1="8" y1="13" x2="14" y2="13"/>
                    </svg>
                </div>
                <span>ChatBot</span>
            </a>
            <a href="{{ $accountUrl }}" class="mobile-app-nav-item {{ $isAkun ? 'active' : '' }}">
                <div class="mobile-app-nav-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <span>{{ $accountLabel }}</span>
            </a>
        </nav>
    @endunless

    <!-- MODAL 1: ADMIN LOGIN MODAL -->
    <div class="admin-modal-overlay" id="adminLoginModalOverlay" onclick="closeAdminLoginModalOnOverlay(event)">
        <div class="admin-modal" style="max-width: 440px;">
            <div class="admin-modal__header">
                <div class="admin-modal__title-group">
                    <div class="admin-modal__icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            <circle cx="12" cy="11" r="3" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="admin-modal__title">Otentikasi Admin</h3>
                        <p class="admin-modal__subtitle">Silakan login untuk membuka Fitur Admin</p>
                    </div>
                </div>
                <button type="button" class="admin-modal__close" onclick="closeAdminLoginModal()">&times;</button>
            </div>
            <div class="admin-modal__body">
                <form id="ajaxAdminLoginForm" onsubmit="submitAdminLoginAjax(event)">
                    <div id="adminLoginAlert"
                        style="display:none; padding:10px 12px; margin-bottom:14px; border-radius:6px; font-size:12px; font-weight:600;">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-label">Username / Email Admin:</label>
                        <input type="text" id="modalUsername" class="admin-input" value="admin"
                            placeholder="Masukkan username" required>
                    </div>
                    <div class="admin-form-group" style="margin-top:12px;">
                        <label class="admin-label">Password:</label>
                        <input type="password" id="modalPassword" class="admin-input" value="admin"
                            placeholder="Masukkan password" required>
                    </div>

                    <div
                        style="margin-top:14px; padding:10px; background:#f8fafc; border:1px dashed var(--color-border); border-radius:6px; font-size:11px; color:var(--color-text-secondary); text-align:center;">
                        🔑 Default: Username <strong>admin</strong> | Password <strong>admin</strong>
                    </div>

                    <div class="admin-modal__footer">
                        <button type="button" class="btn-admin-secondary"
                            onclick="closeAdminLoginModal()">Batal</button>
                        <button type="submit" class="btn-admin-primary">🔑 Masuk Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL 2: ADMIN PANEL MODAL (FITUR ADMIN) -->
    <div class="admin-modal-overlay" id="adminModalOverlay" onclick="closeAdminModalOnOverlay(event)">
        <div class="admin-modal">
            <div class="admin-modal__header">
                <div class="admin-modal__title-group">
                    <div class="admin-modal__icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            <path d="M12 8v4" />
                            <path d="M12 16h.01" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="admin-modal__title">Panel Fitur Admin</h3>
                        <p class="admin-modal__subtitle">Kelola persyaratan publik, layanan, dan informasi website
                            secara langsung</p>
                    </div>
                </div>
                <button type="button" class="admin-modal__close" onclick="closeAdminModal()">&times;</button>
            </div>

            <!-- Admin Tabs -->
            <div class="admin-tabs">
                <button type="button" class="admin-tab-btn active" id="tabAdminReq"
                    onclick="switchAdminTab('persyaratan')">
                    📝 Kelola Persyaratan Publik
                </button>
                <button type="button" class="admin-tab-btn" id="tabAdminService" onclick="switchAdminTab('service')">
                    ⚙️ Detail Layanan
                </button>
            </div>

            <div class="admin-modal__body">

                <!-- TAB 1: PERSYARATAN PUBLIK -->
                <div class="admin-tab-content active" id="adminTabContentReq">
                    <div class="admin-form-group">
                        <label class="admin-label">Pilih Layanan Publik:</label>
                        <select class="admin-select" id="adminServiceSelect"
                            onchange="loadServiceRequirementsToAdmin()">
                            <!-- Populated via JS -->
                        </select>
                    </div>

                    <div class="admin-form-group" style="margin-top:12px;">
                        <label class="admin-label">Catatan / Perhatian Persyaratan (Ditampilkan di Atas List):</label>
                        <textarea class="admin-textarea" id="adminNoticeInput" rows="2"
                            placeholder="Tuliskan catatan informasi persyaratan untuk warga..."></textarea>
                    </div>

                    <div class="admin-req-header">
                        <span style="font-weight:600;color:var(--color-primary);">Daftar Poin Persyaratan Publik:</span>
                        <button type="button" class="btn-admin-add" onclick="addRequirementRowAdmin()" title="Tambah poin persyaratan tanpa batas jumlah">
                            + Tambah Poin Persyaratan (Tanpa Batas)
                        </button>
                    </div>
                    <div style="margin-top:8px; font-size:12px; color:var(--color-text-muted);">
                        Catatan: Anda dapat menambahkan poin persyaratan sebanyak yang dibutuhkan untuk setiap layanan.
                    </div>

                    <div class="admin-req-rows" id="adminReqRowsContainer">
                        <!-- Rows rendered by JS -->
                    </div>

                    <div class="admin-modal__footer">
                        <button type="button" class="btn-admin-secondary" onclick="closeAdminModal()">Batal</button>
                        <button type="button" class="btn-admin-primary" onclick="saveAdminRequirements()">
                            💾 Simpan & Publikasikan ke Publik
                        </button>
                    </div>
                </div>

                <!-- TAB 2: DETAIL LAYANAN -->
                <div class="admin-tab-content" id="adminTabContentService">
                    <div class="admin-form-group">
                        <label class="admin-label">Pilih Layanan untuk Diubah:</label>
                        <select class="admin-select" id="adminServiceMetaSelect" onchange="loadServiceMetaToAdmin()">
                            <!-- Populated via JS -->
                        </select>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:12px;">
                        <div class="admin-form-group">
                            <label class="admin-label">Judul Layanan:</label>
                            <input type="text" class="admin-input" id="adminMetaTitle">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-label">Tag Badge (contoh: KEPENDUDUKAN):</label>
                            <input type="text" class="admin-input" id="adminMetaTag">
                        </div>
                    </div>
                    <div class="admin-form-group" style="margin-top:12px;">
                        <label class="admin-label">Deskripsi Ringkas Layanan:</label>
                        <textarea class="admin-textarea" id="adminMetaDesc" rows="3"></textarea>
                    </div>
                    <div class="admin-form-group" style="margin-top:12px;">
                        <label class="admin-label">Status Default Pengajuan Jemput Bola:</label>
                        <select class="admin-select" id="adminMetaApprovalStatus">
                            <option value="accepted">Diterima</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:12px;">
                        <div class="admin-form-group">
                            <label class="admin-label">Judul Status Diterima:</label>
                            <input type="text" class="admin-input" id="adminMetaAcceptedTitle">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-label">Judul Status Ditolak:</label>
                            <input type="text" class="admin-input" id="adminMetaRejectedTitle">
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:12px;">
                        <div class="admin-form-group">
                            <label class="admin-label">Pesan Setelah Diterima:</label>
                            <textarea class="admin-textarea" id="adminMetaAcceptedMessage" rows="3"></textarea>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-label">Pesan Setelah Ditolak:</label>
                            <textarea class="admin-textarea" id="adminMetaRejectedMessage" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="admin-modal__footer">
                        <button type="button" class="btn-admin-danger" onclick="resetAllAdminData()">🔄 Reset ke
                            Default</button>
                        <button type="button" class="btn-admin-primary" onclick="saveAdminServiceMeta()">
                            💾 Simpan Detail Layanan
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div class="admin-toast-container" id="adminToastContainer"></div>

    <!-- Main JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        // ============================================================
        // THEME TOGGLE — Default: Dark Mode
        // ============================================================
        (function () {
            // Ambil preferensi tersimpan, default = dark
            var saved = localStorage.getItem('theme') || 'dark';
            applyTheme(saved);
        })();

        function applyTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            var sunIcon  = document.getElementById('iconSun');
            var moonIcon = document.getElementById('iconMoon');
            var btn      = document.getElementById('themeToggleBtn');
            if (!sunIcon || !moonIcon) return;
            if (theme === 'dark') {
                // Dark aktif: tampilkan ikon matahari (klik = ke light)
                sunIcon.style.display  = 'block';
                moonIcon.style.display = 'none';
                if (btn) btn.title = 'Beralih ke Tema Terang';
            } else {
                // Light aktif: tampilkan ikon bulan (klik = ke dark)
                sunIcon.style.display  = 'none';
                moonIcon.style.display = 'block';
                if (btn) btn.title = 'Beralih ke Tema Gelap';
            }
        }

        function toggleTheme() {
            var current = document.documentElement.getAttribute('data-theme') || 'dark';
            applyTheme(current === 'dark' ? 'light' : 'dark');
        }
    </script>

    <!-- Fitur Aksesibilitas Disabilitas -->
    @include('partials.accessibility-widget')
    <script src="{{ asset('js/accessibility.js') }}?v={{ filemtime(public_path('js/accessibility.js')) }}"></script>
    @yield('scripts')
</body>

</html>
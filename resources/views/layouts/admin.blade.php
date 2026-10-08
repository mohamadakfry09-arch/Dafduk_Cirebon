<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Dashboard Administrator - Portal Pelayanan Administrasi Kependudukan dan Pencatatan Sipil">
    <title>@yield('title', 'Admin Dashboard - Disdukcapil Pemkab Cirebon')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Lexend:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS Base & Admin Styling Dedicated -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">

    <style>
        :root {
            --sidebar-width: 260px;
            --admin-header-height: 64px;
            --admin-bg: #EEF4FB;
            --admin-card-bg: #ffffff;
            --admin-sidebar-bg: #071B3A;
            --admin-sidebar-surface: #0D2E5A;
            --admin-sidebar-text: #C8DCFF;
            --admin-sidebar-hover: rgba(249, 168, 37, 0.12);
            --admin-gold: #F9A825;
            --admin-gold-hover: #FFC107;
            --admin-primary: #0D2E5A;
            --admin-primary-dark: #071B3A;
            --admin-accent: #1565C0;
            --admin-border: #C2D8F0;
            --admin-card-surface: #F7FAFE;
        }

        body.admin-body {
            background: #EEF4FB;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            color: #0D1B2A;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles - Nuansa Deep Navy & Gold Pemkab Cirebon */
        .admin-sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #071B3A 0%, #0D2E5A 60%, #05152D 100%);
            color: var(--admin-sidebar-text);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            box-shadow: 4px 0 20px rgba(7, 27, 58, 0.28);
            border-right: 2px solid rgba(249, 168, 37, 0.3);
        }

        .admin-sidebar__brand {
            height: var(--admin-header-height);
            display: flex;
            align-items: center;
            padding: 0 18px;
            gap: 12px;
            border-bottom: 2px solid #F9A825;
            background: linear-gradient(90deg, rgba(249, 168, 37, 0.14), rgba(13, 46, 90, 0.7));
        }

        .admin-sidebar__brand img {
            height: 38px;
            width: auto;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }

        .admin-sidebar__brand-text h2 {
            font-size: 14.5px;
            font-weight: 800;
            color: #ffffff;
            margin: 0;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }

        .admin-sidebar__brand-text span {
            font-size: 10.5px;
            color: #F9A825;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .admin-sidebar__menu {
            padding: 16px 12px;
            flex: 1;
            overflow-y: auto;
            list-style: none;
            margin: 0;
        }

        .admin-sidebar__menu-label {
            font-size: 10.5px;
            font-weight: 800;
            color: rgba(200, 220, 255, 0.45);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            padding: 12px 14px 6px;
        }

        .admin-sidebar__item {
            margin-bottom: 4px;
        }

        .admin-sidebar__link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 16px;
            color: rgba(200, 220, 255, 0.8);
            text-decoration: none;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .admin-sidebar__link:hover {
            background-color: rgba(249, 168, 37, 0.12);
            color: #F9A825;
            transform: translateX(2px);
        }

        .admin-sidebar__link.active {
            background: linear-gradient(90deg, rgba(249, 168, 37, 0.22) 0%, rgba(21, 101, 192, 0.45) 100%);
            color: #ffffff;
            font-weight: 800;
            box-shadow: 0 4px 14px rgba(249, 168, 37, 0.2);
            border-left: 4px solid #F9A825;
            padding-left: 12px;
        }

        .admin-sidebar__link.active svg {
            color: #F9A825;
            stroke: #F9A825;
        }

        .admin-sidebar__link svg {
            width: 18px;
            height: 18px;
            stroke-width: 2;
            flex-shrink: 0;
        }

        .admin-sidebar__footer {
            padding: 14px 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(7, 27, 58, 0.8);
        }

        /* Main Wrapper */
        .admin-wrapper {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Header Bar - Konsisten dengan Navbar Website Beraksen Emas */
        .admin-header {
            height: var(--admin-header-height);
            background: #ffffff;
            border-bottom: 3px solid #F9A825;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 90;
            box-shadow: 0 2px 10px rgba(13, 46, 90, 0.05);
        }

        .admin-header__title {
            font-size: 18px;
            font-weight: 800;
            color: #0D2E5A;
            margin: 0;
            letter-spacing: 0.02em;
        }

        .admin-header__actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .admin-user-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(13, 46, 90, 0.06);
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 700;
            color: #0D2E5A;
            border: 1px solid #C2D8F0;
        }

        .admin-user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #0D2E5A;
            color: #F9A825;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 12px;
        }

        .btn-view-site {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            background: #ffffff;
            border: 1px solid #C2D8F0;
            border-radius: 8px;
            color: #0D2E5A;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-view-site:hover {
            background: #EEF4FB;
            border-color: #1565C0;
            color: #1565C0;
        }

        .btn-logout-header {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            color: #dc2626;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-logout-header:hover {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* Content Area */
        .admin-content {
            padding: 28px;
            flex: 1;
        }

        /* Card Styles - Nuansa Website */
        .admin-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #C2D8F0;
            box-shadow: 0 4px 18px rgba(13, 46, 90, 0.06);
            margin-bottom: 24px;
            overflow: hidden;
        }

        .admin-card__header {
            padding: 18px 24px;
            border-bottom: 1px solid #C2D8F0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(90deg, #F0F6FD 0%, #ffffff 100%);
        }

        .admin-card__title {
            font-size: 16px;
            font-weight: 800;
            color: #0D2E5A;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-card__body {
            padding: 24px;
            background: #ffffff;
        }

        .admin-form-group {
            margin-bottom: 18px;
        }

        .admin-label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 700;
            color: #0D2E5A;
            letter-spacing: 0.02em;
        }

        .admin-input,
        .admin-textarea {
            width: 100%;
            background: #ffffff;
            color: #0D1B2A;
            border: 1px solid #C2D8F0;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 14px;
            line-height: 1.5;
            box-sizing: border-box;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .admin-input:focus,
        .admin-textarea:focus {
            border-color: #1565C0;
            outline: none;
            box-shadow: 0 0 0 3px rgba(21, 101, 192, 0.15);
        }

        .admin-input::placeholder,
        .admin-textarea::placeholder {
            color: #5B7FA6;
            opacity: 0.85;
        }

        .btn-admin-primary {
            background: #0D2E5A;
            color: #ffffff !important;
            border: 1px solid #0D2E5A;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(13, 46, 90, 0.2);
        }

        .btn-admin-primary:hover {
            background: #1565C0;
            border-color: #1565C0;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(21, 101, 192, 0.3);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-wrapper {
                margin-left: 0;
            }
            body.sidebar-open .admin-sidebar {
                transform: translateX(0);
            }
        }
    </style>

    @yield('styles')
</head>
<body class="admin-body">

    <!-- Admin Sidebar -->
    <aside class="admin-sidebar">
        <div class="admin-sidebar__brand">
            <img src="{{ asset('images/logopemkabcirebon.png') }}" alt="Logo Pemkab Cirebon">
            <div class="admin-sidebar__brand-text">
                <h2>DISDUKCAPIL</h2>
                <span>PANEL ADMINISTRATOR</span>
            </div>
        </div>

        <ul class="admin-sidebar__menu">
            <li class="admin-sidebar__menu-label">Navigasi Utama</li>
            
            <li class="admin-sidebar__item">
                <a href="{{ url('/admin/dashboard') }}" class="admin-sidebar__link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="admin-sidebar__item">
                <a href="{{ url('/admin/services') }}" class="admin-sidebar__link {{ request()->is('admin/services*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    <span>Kelola Seluruh Layanan</span>
                </a>
            </li>

            <li class="admin-sidebar__item">
                <a href="{{ url('/admin/jemput-bola') }}" class="admin-sidebar__link {{ request()->is('admin/jemput-bola*') ? 'active' : '' }}" style="position: relative;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span>Layanan Jemput Bola</span>
                    <span style="margin-left: auto; background: #F9A825; color: #071B3A; font-size: 10px; font-weight: 800; padding: 2px 7px; border-radius: 999px; letter-spacing: 0.5px;">KHUSUS</span>
                </a>
            </li>

            <li class="admin-sidebar__item">
                <a href="{{ url('/admin/berita') }}" class="admin-sidebar__link {{ request()->is('admin/berita*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10l4 4v12a2 2 0 0 1-2 2z"/><polyline points="17 20 17 13 7 13 7 20"/><polyline points="7 4 7 8 15 8"/></svg>
                    <span>Kelola Berita / Informasi</span>
                </a>
            </li>

            <li class="admin-sidebar__item">
                <a href="{{ url('/admin/tentang') }}" class="admin-sidebar__link {{ request()->is('admin/tentang*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    <span>Profil Instansi (Tentang)</span>
                </a>
            </li>

            <li class="admin-sidebar__item">
                <a href="{{ url('/admin/kontak') }}" class="admin-sidebar__link {{ request()->is('admin/kontak*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.59 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    <span>Kelola Halaman Kontak</span>
                </a>
            </li>

            <li class="admin-sidebar__menu-label" style="margin-top: 16px;">Sistem &amp; Pengaturan</li>

            <li class="admin-sidebar__item">
                <a href="{{ url('/admin/pengaturan-akun') }}" class="admin-sidebar__link {{ request()->is('admin/pengaturan-akun*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <span>Pengaturan Akun &amp; Password</span>
                </a>
            </li>

            <li class="admin-sidebar__item">
                <a href="{{ url('/') }}" target="_blank" class="admin-sidebar__link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    <span>Lihat Website Publik ↗</span>
                </a>
            </li>
        </ul>

        <div class="admin-sidebar__footer">
            <button onclick="logoutAdmin()" class="btn-logout-header" style="width: 100%; justify-content: center;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                <span>Keluar / Logout</span>
            </button>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="admin-wrapper">
        
        <!-- Header Bar -->
        <header class="admin-header">
            <h1 class="admin-header__title">@yield('page_title', 'Admin Dashboard')</h1>

            <div class="admin-header__actions">
                <a href="{{ url('/') }}" target="_blank" class="btn-view-site">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/></svg>
                    <span>Lihat Website Publik</span>
                </a>

                <a href="{{ url('/admin/pengaturan-akun') }}" class="admin-user-pill" title="Klik untuk ubah Username &amp; Password" style="text-decoration: none; cursor: pointer;">
                    <div class="admin-user-avatar">👤</div>
                    <span>{{ session('admin_username', 'Administrator') }}</span>
                    <span style="font-size: 11px; color: #1565C0; font-weight: 700; margin-left: 4px;">(Ubah)</span>
                </a>

                <button onclick="logoutAdmin()" class="btn-logout-header" title="Logout">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                </button>
            </div>
        </header>

        <!-- Main Content -->
        <main class="admin-content">
            @yield('content')
        </main>
    </div>

    <!-- Toast Notification Container -->
    <div class="admin-toast-container" id="adminToastContainer"></div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        function logoutAdmin() {
            if(confirm('Apakah Anda yakin ingin keluar dari Panel Admin?')) {
                fetch('/admin/logout', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    window.location.href = '/admin/login';
                })
                .catch(err => {
                    window.location.href = '/admin/login';
                });
            }
        }
    </script>

    @yield('scripts')
</body>
</html>

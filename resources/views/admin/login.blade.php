@extends('layouts.app')

@section('title', 'Login Administrator - Dinas Kependudukan dan Pencatatan Sipil')

@section('content')

<div style="min-height: calc(100vh - 180px); display: flex; align-items: center; justify-content: center; padding: 40px 20px; background: linear-gradient(135deg, #071B3A 0%, #0D2E5A 60%, #1565C0 100%); position: relative; overflow: hidden;">

    <!-- Background Decorative Glow -->
    <div style="position: absolute; top: -100px; right: -100px; width: 340px; height: 340px; border-radius: 50%; background: radial-gradient(circle, rgba(249, 168, 37, 0.22) 0%, rgba(255, 255, 255, 0) 70%); pointer-events: none;"></div>
    <div style="position: absolute; bottom: -80px; left: -80px; width: 300px; height: 300px; border-radius: 50%; background: radial-gradient(circle, rgba(21, 101, 192, 0.3) 0%, rgba(255, 255, 255, 0) 70%); pointer-events: none;"></div>

    <div style="width: 100%; max-width: 440px; background: #ffffff; border-radius: 20px; padding: 36px 32px; box-shadow: 0 20px 60px rgba(7, 27, 58, 0.4); border: 1px solid #C2D8F0; border-top: 5px solid #F9A825; position: relative; z-index: 10;">

        <!-- Header / Logo -->
        <div style="text-align: center; margin-bottom: 26px;">
            <div style="width: 68px; height: 68px; background: #EEF4FB; border-radius: 18px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 14px; border: 2px solid #C2D8F0; box-shadow: 0 4px 12px rgba(13, 46, 90, 0.1);">
                <img src="{{ asset('images/logopemkabcirebon.png') }}" alt="Logo Pemkab Cirebon" style="height: 48px; width: auto; display: block;">
            </div>

            <div style="display: inline-block; padding: 4px 12px; background: rgba(249, 168, 37, 0.14); border: 1px solid rgba(249, 168, 37, 0.4); border-radius: 999px; font-size: 11px; font-weight: 800; color: #b45309; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 8px;">
                PORTAL ADMINISTRATOR
            </div>

            <h1 style="font-size: 22px; font-weight: 800; color: #0D2E5A; margin: 0 0 6px;">Login Admin Disdukcapil</h1>
            <p style="font-size: 13px; color: #5B7FA6; margin: 0; line-height: 1.5;">Masukkan kredensial untuk mengelola layanan, persyaratan, berita, dan profil instansi</p>
        </div>

        @if($errors->has('login'))
            <div style="padding: 12px 14px; background: #fee2e2; border-left: 4px solid #dc2626; color: #991b1b; font-size: 13px; font-weight: 600; border-radius: 8px; margin-bottom: 20px;">
                {{ $errors->first('login') }}
            </div>
        @endif

        <form action="{{ url('/admin/login') }}" method="POST" id="adminLoginForm">
            @csrf

            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: #0D2E5A; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">
                    Username Admin
                </label>
                <div style="position: relative;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#5B7FA6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%);">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    <input type="text" name="username" class="admin-input" style="padding-left: 42px; height: 46px; border: 1px solid #C2D8F0; border-radius: 10px; font-size: 14px;" placeholder="Masukkan username" value="admin" required autofocus>
                </div>
            </div>

            <div style="margin-bottom: 22px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: #0D2E5A; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">
                    Password Admin
                </label>
                <div style="position: relative;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#5B7FA6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%);">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    <input type="password" id="adminPasswordInput" name="password" class="admin-input" style="padding-left: 42px; padding-right: 42px; height: 46px; border: 1px solid #C2D8F0; border-radius: 10px; font-size: 14px;" placeholder="Masukkan password" value="admin" required>
                    <button type="button" onclick="togglePasswordVisibility()" aria-label="Lihat password" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #5B7FA6;">
                        <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-admin-primary" style="width: 100%; height: 48px; font-size: 14.5px; font-weight: 800; justify-content: center; display: flex; align-items: center; gap: 8px; background: #0D2E5A; color: #ffffff; border: none; border-radius: 10px; box-shadow: 0 4px 14px rgba(13, 46, 90, 0.35); cursor: pointer; transition: all 0.2s;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                    <polyline points="10 17 15 12 10 7" />
                    <line x1="15" y1="12" x2="3" y2="12" />
                </svg>
                <span>Masuk ke Panel Admin</span>
            </button>
        </form>


        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ url('/') }}" style="font-size: 13px; color: #1565C0; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                <span>← Kembali ke Beranda Website</span>
            </a>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
function togglePasswordVisibility() {
    const input = document.getElementById('adminPasswordInput');
    if (input.type === 'password') {
        input.type = 'text';
    } else {
        input.type = 'password';
    }
}
</script>
@endsection
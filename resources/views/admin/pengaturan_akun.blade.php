@extends('layouts.admin')

@section('title', 'Pengaturan Akun Admin - Disdukcapil')
@section('page_title', 'Pengaturan Akun Administrator')

@section('content')

<div style="max-width: 680px; margin: 0 auto;">

    <!-- Banner Info -->
    <div style="background: linear-gradient(135deg, #071B3A 0%, #0D2E5A 60%, #1565C0 100%); border-radius: 16px; padding: 22px 26px; color: #ffffff; margin-bottom: 24px; box-shadow: 0 6px 20px rgba(7, 27, 58, 0.2); border-left: 5px solid #F9A825;">
        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(249, 168, 37, 0.25); border: 1px solid #F9A825; padding: 3px 10px; border-radius: 999px; margin-bottom: 8px; font-size: 11px; font-weight: 800; color: #ffd54f; letter-spacing: 0.5px;">
            KEAMANAN &amp; AKSES ADMIN
        </div>
        <h2 style="margin: 0 0 6px; font-size: 21px; font-weight: 800; color: #ffffff;">
            Ubah Username &amp; Kata Sandi Admin
        </h2>
        <p style="margin: 0; font-size: 13.5px; color: #C8DCFF; line-height: 1.5;">
            Anda dapat menyesuaikan Username login dan Kata Sandi baru untuk meningkatkan keamanan akses ke Panel Administrator.
        </p>
    </div>

    <!-- Alert Sukses / Gagal -->
    <div id="accountAlertMessage" style="display: none; padding: 14px 18px; border-radius: 10px; font-size: 14px; font-weight: 700; margin-bottom: 20px;"></div>

    @if(session('success'))
        <div style="background: #f0fdf4; border: 1.5px solid #86efac; color: #15803d; padding: 14px 18px; border-radius: 10px; font-size: 14px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
            <span>✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div style="background: #fef2f2; border: 1.5px solid #fecaca; color: #991b1b; padding: 14px 18px; border-radius: 10px; font-size: 14px; font-weight: 700; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="admin-card">
        <div class="admin-card__header">
            <h3 class="admin-card__title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <span>Formulir Perubahan Akun Administrator</span>
            </h3>
        </div>

        <div class="admin-card__body">
            <form id="adminAccountForm" action="{{ url('/admin/pengaturan-akun') }}" method="POST">
                @csrf

                <!-- 1. Username Admin -->
                <div class="admin-form-group">
                    <label class="admin-label">
                        Username Login Admin <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" name="username" class="admin-input" value="{{ old('username', $admin['username'] ?? 'admin') }}" required minlength="3" placeholder="Masukkan username baru...">
                    <div style="font-size: 12px; color: #64748b; margin-top: 5px;">
                        Username ini digunakan untuk masuk / login ke Panel Admin.
                    </div>
                </div>

                <!-- 2. Nama Tampilan Admin -->
                <div class="admin-form-group">
                    <label class="admin-label">
                        Nama Lengkap / Tampilan Administrator
                    </label>
                    <input type="text" name="name" class="admin-input" value="{{ old('name', $admin['name'] ?? 'Administrator Disdukcapil') }}" placeholder="Contoh: Administrator Disdukcapil">
                    <div style="font-size: 12px; color: #64748b; margin-top: 5px;">
                        Nama ini akan tampil di bagian atas header dashboard dan laporan.
                    </div>
                </div>

                <div style="border-top: 1px solid #e2e8f0; margin: 24px 0 20px; padding-top: 20px;">
                    <div style="font-size: 14.5px; font-weight: 800; color: #0D2E5A; margin-bottom: 4px; display: flex; align-items: center; gap: 8px;">
                        <span>🔒 Ganti Kata Sandi (Password)</span>
                    </div>
                    <p style="font-size: 12.5px; color: #64748b; margin: 0 0 16px;">
                        Biarkan kosong jika Anda <strong>tidak ingin</strong> mengubah kata sandi saat ini.
                    </p>
                </div>

                <!-- 3. Password Baru -->
                <div class="admin-form-group">
                    <label class="admin-label">Kata Sandi (Password) Baru</label>
                    <div style="position: relative;">
                        <input type="password" name="new_password" id="inputNewPassword" class="admin-input" placeholder="Minimal 4 karakter..." style="padding-right: 44px;">
                        <button type="button" onclick="togglePass('inputNewPassword', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #64748b; padding: 4px;">
                            👁️
                        </button>
                    </div>
                </div>

                <!-- 4. Konfirmasi Password Baru -->
                <div class="admin-form-group">
                    <label class="admin-label">Konfirmasi Kata Sandi Baru</label>
                    <div style="position: relative;">
                        <input type="password" name="confirm_password" id="inputConfirmPassword" class="admin-input" placeholder="Ulangi kata sandi baru..." style="padding-right: 44px;">
                        <button type="button" onclick="togglePass('inputConfirmPassword', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #64748b; padding: 4px;">
                            👁️
                        </button>
                    </div>
                </div>

                <!-- Tombol Aksi Simpan -->
                <div style="margin-top: 28px; display: flex; justify-content: flex-end; gap: 12px;">
                    <button type="submit" id="saveAccountBtn" class="btn-admin-primary" style="padding: 12px 28px; font-size: 14.5px; font-weight: 800; background: #0D2E5A; border-color: #0D2E5A; border-radius: 10px;">
                        💾 Simpan Perubahan Akun
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
    function togglePass(inputId, btn) {
        const input = document.getElementById(inputId);
        if (input.type === 'password') {
            input.type = 'text';
            btn.textContent = '🙈';
        } else {
            input.type = 'password';
            btn.textContent = '👁️';
        }
    }

    document.getElementById('adminAccountForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('saveAccountBtn');
        const alertBox = document.getElementById('accountAlertMessage');
        const originalText = btn.textContent;

        const newPass = document.getElementById('inputNewPassword').value;
        const confirmPass = document.getElementById('inputConfirmPassword').value;

        if (newPass && newPass !== confirmPass) {
            alert('Konfirmasi kata sandi baru tidak sesuai!');
            document.getElementById('inputConfirmPassword').focus();
            return;
        }

        btn.disabled = true;
        btn.textContent = 'Menyimpan perubahan...';
        if (alertBox) alertBox.style.display = 'none';

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.textContent = originalText;

            if (data.success) {
                if (alertBox) {
                    alertBox.style.display = 'block';
                    alertBox.style.background = '#f0fdf4';
                    alertBox.style.border = '1.5px solid #86efac';
                    alertBox.style.color = '#15803d';
                    alertBox.innerHTML = `✓ ${data.message || 'Username dan kata sandi berhasil diperbarui!'}`;
                    alertBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                } else {
                    alert('✓ ' + data.message);
                }

                // Clear password inputs
                document.getElementById('inputNewPassword').value = '';
                document.getElementById('inputConfirmPassword').value = '';

                // Reload after short delay to update session username on header
                setTimeout(() => {
                    window.location.reload();
                }, 1200);
            } else {
                if (alertBox) {
                    alertBox.style.display = 'block';
                    alertBox.style.background = '#fef2f2';
                    alertBox.style.border = '1.5px solid #fecaca';
                    alertBox.style.color = '#991b1b';
                    alertBox.innerHTML = `⚠️ ${data.message || 'Gagal memperbarui akun.'}`;
                } else {
                    alert(data.message || 'Gagal memperbarui akun.');
                }
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.textContent = originalText;
            alert('Terjadi kesalahan koneksi.');
        });
    });
</script>
@endsection

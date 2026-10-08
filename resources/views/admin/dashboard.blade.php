@extends('layouts.admin')

@section('title', 'Dashboard Admin - Dinas Kependudukan dan Pencatatan Sipil')
@section('page_title', 'Dashboard Ringkasan Administrator')

@section('content')

<div style="background: linear-gradient(135deg, #071B3A 0%, #0D2E5A 60%, #1565C0 100%); color: #ffffff; padding: 28px 32px; border-radius: 16px; margin-bottom: 28px; box-shadow: 0 12px 28px -8px rgba(7, 27, 58, 0.35); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; border-left: 5px solid #F9A825;">
    <div>
        <div style="display:inline-block; padding:3px 10px; background:rgba(249,168,37,0.2); border:1px solid rgba(249,168,37,0.4); border-radius:999px; font-size:11px; font-weight:800; color:#ffd54f; letter-spacing:0.06em; margin-bottom:8px;">
            PANEL ADMINISTRATOR DISDUKCAPIL
        </div>
        <h2 style="font-size: 24px; font-weight: 800; margin: 0 0 8px 0; color: #ffffff;">Selamat Datang, {{ session('admin_username', 'Administrator') }}! 👋</h2>
        <p style="margin: 0; font-size: 14px; opacity: 0.9; max-width: 720px; line-height: 1.6; color: #e2e8f0;">
            Anda memiliki akses penuh untuk mengelola seluruh konten dan fitur website portal, mulai dari direktori layanan, berita &amp; informasi, profil instansi, serta kontak.
        </p>
    </div>
    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
        <a href="{{ url('/admin/services') }}" class="btn-admin-primary" style="background: #F9A825; color: #071B3A !important; font-weight: 800; text-decoration: none; padding: 12px 22px; border-radius: 10px; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 5px 14px rgba(249, 168, 37, 0.35); border: none;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            <span>Kelola Seluruh Layanan</span>
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 28px;">
    <div class="admin-card" style="margin: 0; padding: 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 52px; height: 52px; border-radius: 14px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center;">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        </div>
        <div>
            <div style="font-size: 26px; font-weight: 800; color: #0f172a;">{{ count($services ?? []) }}</div>
            <div style="font-size: 13px; color: #64748b; font-weight: 500;">Total Layanan Aktif</div>
        </div>
    </div>

    <div class="admin-card" style="margin: 0; padding: 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 52px; height: 52px; border-radius: 14px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center;">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
        </div>
        <div>
            <div style="font-size: 26px; font-weight: 800; color: #0f172a;">
                @php
                    $reqCount = 0;
                    foreach($services ?? [] as $s) {
                        $reqCount += count($s['requirements'] ?? []);
                    }
                    echo $reqCount;
                @endphp
            </div>
            <div style="font-size: 13px; color: #64748b; font-weight: 500;">Total Poin Persyaratan</div>
        </div>
    </div>

    <a href="{{ url('/admin/jemput-bola') }}" style="text-decoration:none; color:inherit; background: linear-gradient(135deg, #fef3c7, #fde68a); border:1px solid #fbbf24; border-radius:14px; padding:20px; display:flex; align-items:center; gap:16px; min-height:120px; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        <div style="width:52px; height:52px; border-radius:14px; background:#0D2E5A; color:#F9A825; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        </div>
        <div>
            <div style="display:flex; align-items:center; gap:6px;">
                <span style="font-size: 18px; font-weight: 800; color: #0f172a;">Layanan Jemput Bola</span>
                <span style="background:#0D2E5A; color:#F9A825; font-size:10px; font-weight:800; padding:2px 7px; border-radius:999px;">KHUSUS</span>
            </div>
            <div style="font-size: 13px; color: #78350f; font-weight: 600; margin-top:4px;">Kelola semua fitur, riwayat pemohon warga, serta cetak formulir & dokumen</div>
        </div>
    </a>

</div>

<div class="admin-card">
    <div class="admin-card__header">
        <h3 class="admin-card__title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            Kelola Semua Fitur Website Publik
        </h3>
    </div>

    <div class="admin-card__body" style="padding: 24px;">
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px;">

            <a href="{{ url('/admin/services') }}" style="text-decoration:none; color:inherit; background: linear-gradient(135deg, #eff6ff, #dbeafe); border:1px solid #bfdbfe; border-radius:14px; padding:20px; display:flex; flex-direction:column; gap:10px; min-height:160px;">
                <div style="width:42px;height:42px;border-radius:12px;background:#2563eb;color:#fff;display:flex;align-items:center;justify-content:center;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                </div>
                <h4 style="margin:0; font-size:16px; font-weight:800; color:#0f172a;">Layanan</h4>
                <p style="margin:0; font-size:13px; line-height:1.6; color:#475569;">Edit judul, deskripsi, syarat, dan detail setiap layanan publik.</p>
            </a>

            <a href="{{ url('/admin/berita') }}" style="text-decoration:none; color:inherit; background: linear-gradient(135deg, #ecfeff, #cffafe); border:1px solid #67e8f9; border-radius:14px; padding:20px; display:flex; flex-direction:column; gap:10px; min-height:160px;">
                <div style="width:42px;height:42px;border-radius:12px;background:#0891b2;color:#fff;display:flex;align-items:center;justify-content:center;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10l4 4v12a2 2 0 0 1-2 2z"/><polyline points="17 20 17 13 7 13 7 20"/><polyline points="7 4 7 8 15 8"/></svg>
                </div>
                <h4 style="margin:0; font-size:16px; font-weight:800; color:#0f172a;">Berita & Informasi</h4>
                <p style="margin:0; font-size:13px; line-height:1.6; color:#475569;">Tambah, edit, hapus artikel, berita, foto, dan infografis yang muncul di halaman informasi.</p>
            </a>

            <a href="{{ url('/admin/tentang') }}" style="text-decoration:none; color:inherit; background: linear-gradient(135deg, #f0fdf4, #dcfce7); border:1px solid #86efac; border-radius:14px; padding:20px; display:flex; flex-direction:column; gap:10px; min-height:160px;">
                <div style="width:42px;height:42px;border-radius:12px;background:#16a34a;color:#fff;display:flex;align-items:center;justify-content:center;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </div>
                <h4 style="margin:0; font-size:16px; font-weight:800; color:#0f172a;">Profil Instansi (Tentang)</h4>
                <p style="margin:0; font-size:13px; line-height:1.6; color:#475569;">Edit profil instansi, slogan, pimpinan/kepala dinas, visi, misi, tupoksi, maklumat, dan lokasi.</p>
            </a>

            <a href="{{ url('/admin/kontak') }}" style="text-decoration:none; color:inherit; background: linear-gradient(135deg, #f5f3ff, #e9d5ff); border:1px solid #c4b5fd; border-radius:14px; padding:20px; display:flex; flex-direction:column; gap:10px; min-height:160px;">
                <div style="width:42px;height:42px;border-radius:12px;background:#8b5cf6;color:#fff;display:flex;align-items:center;justify-content:center;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.59 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                </div>
                <h4 style="margin:0; font-size:16px; font-weight:800; color:#0f172a;">Kontak</h4>
                <p style="margin:0; font-size:13px; line-height:1.6; color:#475569;">Ubah nomor WhatsApp, email, media sosial, alamat, dan jam kerja.</p>
            </a>

        </div>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card__header">
        <h3 class="admin-card__title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Daftar Layanan Website Publik
        </h3>
        <a href="{{ url('/admin/services') }}" style="font-size: 13px; font-weight: 600; color: #2563eb; text-decoration: none;">Kelola Detail & Tambah →</a>
    </div>

    <div class="admin-card__body" style="padding: 0;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px; text-align: left;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; color: #475569; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                        <th style="padding: 14px 20px;">No</th>
                        <th style="padding: 14px 20px;">Nama Layanan</th>
                        <th style="padding: 14px 20px;">Kategori / Tag</th>
                        <th style="padding: 14px 20px;">Jumlah Syarat</th>
                        <th style="padding: 14px 20px; text-align: right;">Aksi Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services ?? [] as $index => $srv)
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 16px 20px; font-weight: 600; color: #94a3b8;">{{ $index + 1 }}</td>
                            <td style="padding: 16px 20px;">
                                <div style="font-weight: 700; color: #0f172a;">{{ $srv['title'] }}</div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">/pelayanan/{{ $srv['slug'] }}</div>
                            </td>
                            <td style="padding: 16px 20px;">
                                <span style="display: inline-block; background: #e0f2fe; color: #0369a1; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase;">
                                    {{ $srv['tag'] ?? 'KEPENDUDUKAN' }}
                                </span>
                            </td>
                            <td style="padding: 16px 20px;">
                                <span style="font-weight: 600; color: #334155;">{{ count($srv['requirements'] ?? []) }} Poin</span>
                            </td>
                            <td style="padding: 16px 20px; text-align: right;">
                                <a href="{{ url('/admin/services/edit/' . $srv['slug']) }}" class="btn-admin-primary" style="text-decoration: none; padding: 6px 14px; font-size: 12px; display: inline-flex; align-items: center; gap: 6px;">
                                    ✏️ Edit Layanan
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

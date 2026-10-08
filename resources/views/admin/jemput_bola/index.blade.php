@extends('layouts.admin')

@section('title', 'Layanan Jemput Bola - Admin Panel Disdukcapil')
@section('page_title', 'Kelola & Riwayat Pelayanan Jemput Bola')

@section('styles')
<style>
    /* Styling Peringatan / Alert Belum Dicek */
    .unopened-alert-banner {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        border: 2px solid #ef4444;
        border-radius: 14px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 22px;
        color: #991b1b;
        box-shadow: 0 4px 14px rgba(239, 68, 68, 0.15);
        animation: pulseWarning 2.5s infinite;
    }
    @keyframes pulseWarning {
        0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
        70% { box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
        100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }

    /* Bar Permohonan Warga (List Bar Card) */
    .applicant-bar {
        background: #ffffff;
        border: 1.5px solid #C2D8F0;
        border-radius: 14px;
        padding: 18px 22px;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        flex-wrap: wrap;
        box-shadow: 0 2px 10px rgba(13, 46, 90, 0.05);
        transition: all 0.25s ease;
        position: relative;
    }
    .applicant-bar:hover {
        border-color: #0D2E5A;
        box-shadow: 0 6px 18px rgba(13, 46, 90, 0.12);
        transform: translateY(-1px);
    }
    .applicant-bar.bar-unopened {
        border-left: 6px solid #ef4444;
        background: #fffdfd;
    }
    .applicant-bar.bar-opened {
        border-left: 6px solid #10b981;
    }

    /* Badge Peringatan */
    .badge-alert-unopened {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #fee2e2;
        color: #dc2626;
        border: 1.5px solid #f87171;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        animation: blinkAlert 2s infinite;
    }
    @keyframes blinkAlert {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.65; }
    }
    .badge-alert-unprinted {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #fef3c7;
        color: #b45309;
        border: 1px solid #fcd34d;
        padding: 3px 9px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
    }
    .badge-success-printed {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #86efac;
        padding: 3px 9px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
    }
    .badge-success-opened {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 3px 9px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
    }

    /* Dropdown Status di Bar */
    .status-select-bar {
        font-family: inherit;
        font-size: 13.5px;
        font-weight: 700;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1.5px solid #C2D8F0;
        background: #ffffff;
        cursor: pointer;
        transition: all 0.2s;
    }
    .status-select-bar:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(13, 46, 90, 0.15);
    }
    .status-select-bar[data-status="menunggu"] {
        border-color: #f59e0b;
        color: #92400e;
        background: #fffbeb;
    }
    .status-select-bar[data-status="disetujui"] {
        border-color: #10b981;
        color: #065f46;
        background: #ecfdf5;
    }
    .status-select-bar[data-status="selesai"] {
        border-color: #0284c7;
        color: #075985;
        background: #f0f9ff;
    }
    .status-select-bar[data-status="ditolak"] {
        border-color: #ef4444;
        color: #991b1b;
        background: #fef2f2;
    }

    /* Tabs Styling */
    .jb-main-tabs {
        display: flex;
        gap: 8px;
        border-bottom: 2px solid #C2D8F0;
        margin-bottom: 24px;
    }
    .jb-main-tab {
        padding: 12px 24px;
        font-size: 14.5px;
        font-weight: 700;
        color: #5B7FA6;
        background: transparent;
        border: none;
        border-bottom: 3px solid transparent;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: -2px;
        transition: all 0.2s;
    }
    .jb-main-tab:hover {
        color: #0D2E5A;
        background: rgba(255, 255, 255, 0.6);
    }
    .jb-main-tab.active {
        color: #0D2E5A;
        border-bottom-color: #F9A825;
        background: #ffffff;
        border-radius: 8px 8px 0 0;
    }

    /* Item Box for Dynamic Features */
    .jb-item-box {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 14px;
        margin-bottom: 12px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }
    .jb-item-box__number {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #0D2E5A;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 800;
        flex-shrink: 0;
    }
    .jb-item-box__fields {
        flex: 1;
        display: grid;
        gap: 8px;
    }
    .jb-btn-delete-item {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }
    .jb-btn-delete-item:hover {
        background: #fee2e2;
        color: #b91c1c;
    }
</style>
@endsection

@section('content')

@php
    $unopenedCount = count(array_filter($submissions, fn($s) => empty($s['dibuka'])));
    $unprintedCount = count(array_filter($submissions, fn($s) => empty($s['dicetak'])));
@endphp

<!-- Header Banner Khusus Jemput Bola -->
<div style="background: linear-gradient(135deg, #071B3A 0%, #0D2E5A 60%, #1565C0 100%); border-radius: 16px; padding: 24px 28px; color: #ffffff; margin-bottom: 22px; position: relative; overflow: hidden; box-shadow: 0 6px 20px rgba(7, 27, 58, 0.2); border: 2px solid rgba(249, 168, 37, 0.35);">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; position: relative; z-index: 1;">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(249, 168, 37, 0.25); border: 1px solid #F9A825; padding: 4px 12px; border-radius: 999px; margin-bottom: 8px;">
                <span style="font-size: 13px;">⚡</span>
                <span style="font-size: 11px; font-weight: 800; color: #F9A825; letter-spacing: 1px; text-transform: uppercase;">Tempat Khusus Admin Jemput Bola</span>
            </div>
            <h2 style="margin: 0 0 6px; font-size: 23px; font-weight: 800; color: #ffffff;">
                Pusat Pelayanan Jemput Bola Disdukcapil
            </h2>
            <p style="margin: 0; font-size: 13.5px; color: #C8DCFF; max-width: 680px; line-height: 1.5;">
                Kelola status permohonan warga langsung dari bar masing-masing pemohon, cetak formulir resmi standar Disdukcapil, dan edit semua fitur Jemput Bola.
            </p>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ url('/pelayanan/jemput-bola') }}" target="_blank" class="btn-admin-primary" style="background: #F9A825; color: #071B3A !important; border-color: #F9A825; font-weight: 800; padding: 10px 18px;">
                <span>Lihat Tampilan Warga</span>
                <span>↗</span>
            </a>
        </div>
    </div>
</div>

<!-- Navigasi Tab Utama -->
<div class="jb-main-tabs">
    <button type="button" class="jb-main-tab active" onclick="switchJbTab('riwayat')" id="tabBtnRiwayat">
        <span>📜 Riwayat Permohonan Pemohon</span>
        <span style="background: #0D2E5A; color: #ffffff; padding: 2px 9px; border-radius: 999px; font-size: 11.5px; font-weight: 800;">{{ count($submissions) }}</span>
        @if($unopenedCount > 0)
            <span style="background: #ef4444; color: #ffffff; padding: 2px 7px; border-radius: 999px; font-size: 11px; font-weight: 800;" title="{{ $unopenedCount }} Belum Dibuka">!</span>
        @endif
    </button>
    <button type="button" class="jb-main-tab" onclick="switchJbTab('fitur')" id="tabBtnFitur">
        <span>⚙️ Edit Semua Fitur Layanan Jemput Bola</span>
    </button>
</div>

<!-- ======================================================== -->
<!-- TAB 1: RIWAYAT PERMOHONAN MASUK (BENTUK BAR PERMOHONAN)  -->
<!-- ======================================================== -->
<div id="jbTabRiwayat" class="jb-tab-pane" style="display: block;">

    <!-- Peringatan untuk Admin jika ada permohonan belum dibuka/dicek -->
    @if($unopenedCount > 0)
    <div class="unopened-alert-banner">
        <div style="font-size: 28px; line-height: 1;">⚠️</div>
        <div style="flex: 1;">
            <div style="font-size: 15px; font-weight: 800;">
                PERINGATAN: Terdapat {{ $unopenedCount }} Permohonan Jemput Bola Baru yang Belum Dibuka / Dicek oleh Admin!
            </div>
            <div style="font-size: 13px; margin-top: 3px; opacity: 0.9;">
                Harap periksa permohonan berlabel merah di bawah ini, verifikasi data pemohon, dan cetak surat permohonan.
            </div>
        </div>
    </div>
    @endif

    <!-- Toolbar Pencarian & Filter -->
    <div style="display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 18px; background: #ffffff; padding: 14px 18px; border-radius: 12px; border: 1px solid #C2D8F0;">
        <div style="display: flex; align-items: center; gap: 8px;">
            <strong style="color: #0D2E5A; font-size: 15px;">Daftar Bar Permohonan Warga</strong>
            <span style="font-size: 12px; color: #64748b;">(Status dapat langsung diubah di bar masing-masing pemohon)</span>
        </div>
        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <input type="text" id="jbSearchInput" onkeyup="filterBars()" placeholder="Cari nama pemohon, NIK, alamat..." style="padding: 8px 14px; font-size: 13px; border: 1px solid #C2D8F0; border-radius: 8px; min-width: 260px;">
            <select id="jbStatusFilter" onchange="filterBars()" style="padding: 8px 12px; font-size: 13px; border: 1px solid #C2D8F0; border-radius: 8px;">
                <option value="">Semua Status</option>
                <option value="menunggu">Menunggu</option>
                <option value="disetujui">Disetujui</option>
                <option value="selesai">Selesai</option>
                <option value="ditolak">Ditolak</option>
            </select>
        </div>
    </div>

    <!-- Container Bar Permohonan -->
    <div id="applicantBarsContainer">
        @forelse($submissions as $sub)
        @php
            $isOpened = !empty($sub['dibuka']);
            $isPrinted = !empty($sub['dicetak']);
            $currentStatus = strtolower($sub['status'] ?? 'menunggu');
        @endphp
        <div class="applicant-bar {{ $isOpened ? 'bar-opened' : 'bar-unopened' }}" id="bar-{{ $sub['id'] }}" data-status="{{ $currentStatus }}">
            
            <!-- 1. Bagian Info Utama: Nama Pemohon & Registrasi -->
            <div style="flex: 1; min-width: 280px;">
                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-bottom: 6px;">
                    <!-- Nomor Registrasi -->
                    <span style="font-size: 12px; font-weight: 800; background: #0D2E5A; color: #ffffff; padding: 2px 8px; border-radius: 6px;">
                        {{ $sub['id'] }}
                    </span>
                    <span style="font-size: 12px; color: #64748b;">
                        📅 {{ date('d/m/Y H:i', strtotime($sub['created_at'])) }}
                    </span>

                    <!-- Badge Peringatan Belum Dibuka / Dicek -->
                    @if(!$isOpened)
                        <span class="badge-alert-unopened" id="badge-unopened-{{ $sub['id'] }}">
                            ⚠️ BELUM DI CEK / DIBUKA ADMIN
                        </span>
                    @else
                        <span class="badge-success-opened" id="badge-opened-{{ $sub['id'] }}">
                            ✓ Sudah Dicek
                        </span>
                    @endif

                    <!-- Badge Belum Dicetak / Sudah Dicetak -->
                    @if(!$isPrinted)
                        <span class="badge-alert-unprinted" id="badge-unprinted-{{ $sub['id'] }}">
                            🖨️ Belum Dicetak
                        </span>
                    @else
                        <span class="badge-success-printed" id="badge-printed-{{ $sub['id'] }}">
                            ✓ Sudah Dicetak
                        </span>
                    @endif
                </div>

                <!-- NAMA PEMOHON (Sangat Jelas & Menonjol) -->
                <div style="font-size: 19px; font-weight: 800; color: #0f172a; margin-bottom: 4px; display: flex; align-items: center; gap: 8px;">
                    <span>👤 {{ $sub['nama_pemohon'] }}</span>
                    <span style="font-size: 12.5px; font-weight: 600; color: #64748b; background: #f1f5f9; padding: 2px 8px; border-radius: 4px;">
                        NIK: {{ $sub['nik_pemohon'] }}
                    </span>
                </div>

                <!-- Info Yang Dimohonkan & Alasan Jemput Bola -->
                <div style="font-size: 13.5px; color: #334155; line-height: 1.5;">
                    Permohonan untuk: <strong style="color: #0D2E5A;">{{ $sub['nama_dimohonkan'] }}</strong>
                    <span style="margin: 0 4px; color: #cbd5e1;">&bull;</span>
                    Alasan: <strong style="color: #b45309;">{{ $sub['alasan_permohonan'] }}</strong>
                    <span style="margin: 0 4px; color: #cbd5e1;">&bull;</span>
                    Alamat: <span>{{ $sub['alamat_dimohonkan'] }}</span>
                </div>
            </div>

            <!-- 2. Bagian Kontrol Status Langsung di Bar (Bisa Langsung Diedit oleh Admin) -->
            <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 4px; min-width: 190px;">
                <label style="font-size: 11.5px; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">
                    Status Permohonan:
                </label>
                <div style="display: flex; align-items: center; gap: 6px; width: 100%;">
                    <select class="status-select-bar" id="select-status-{{ $sub['id'] }}" data-status="{{ $currentStatus }}" onchange="quickUpdateStatus('{{ $sub['id'] }}', this.value)" style="width: 100%;">
                        <option value="menunggu" {{ $currentStatus === 'menunggu' ? 'selected' : '' }}>⏳ Menunggu Verifikasi</option>
                        <option value="disetujui" {{ $currentStatus === 'disetujui' ? 'selected' : '' }}>✓ Disetujui / Terjadwal</option>
                        <option value="selesai" {{ $currentStatus === 'selesai' ? 'selected' : '' }}>★ Selesai Perekaman</option>
                        <option value="ditolak" {{ $currentStatus === 'ditolak' ? 'selected' : '' }}>✕ Ditolak</option>
                    </select>
                </div>
                <div id="status-msg-{{ $sub['id'] }}" style="font-size: 11px; color: #15803d; font-weight: 600; min-height: 14px;"></div>
            </div>

            <!-- 3. Bagian Aksi Cetak Formulir & Dokumen -->
            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                <!-- Tombol Cetak Formulir & Dokumen Persyaratan -->
                <a href="{{ route('admin.jemput-bola.cetak', $sub['id']) }}" target="_blank" onclick="handlePrintClick('{{ $sub['id'] }}')" class="btn-admin-primary" style="padding: 9px 16px; font-size: 13px; font-weight: 700; background: #0f766e; border-color: #0f766e; border-radius: 8px; text-decoration: none;" title="Buka formulir permohonan beserta dokumen persyaratan siap cetak">
                    <span>🖨️ Cetak Formulir &amp; Dokumen</span>
                </a>

                <!-- Tombol Dokumen Persyaratan & Formulir -->
                <a href="{{ route('admin.jemput-bola.dokumen', $sub['id']) }}" target="_blank" onclick="handleDocClick('{{ $sub['id'] }}')" class="btn-admin-secondary" style="padding: 9px 14px; font-size: 13px; font-weight: 700; background: #f0f9ff; color: #0284c7; border: 1.5px solid #bae6fd; border-radius: 8px; text-decoration: none;" title="Lihat dokumen persyaratan dan formulir permohonan">
                    <span>📎 Dokumen &amp; Formulir</span>
                </a>

                <!-- Tombol Hapus Permohonan -->
                <button type="button" onclick="deleteSubmission('{{ $sub['id'] }}')" style="padding: 9px 12px; font-size: 13px; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; border-radius: 8px; cursor: pointer;" title="Hapus permohonan">
                    🗑️
                </button>
            </div>

        </div>
        @empty
        <div style="background: #ffffff; border-radius: 12px; border: 1px solid #C2D8F0; padding: 40px 20px; text-align: center; color: #64748b;">
            Belum ada permohonan Jemput Bola yang diajukan oleh masyarakat.
        </div>
        @endforelse
    </div>
</div>

<!-- ======================================================== -->
<!-- TAB 2: EDIT SEMUA FITUR YANG ADA DI JEMPUT BOLA          -->
<!-- ======================================================== -->
<div id="jbTabFitur" class="jb-tab-pane" style="display: none;">
    <form id="jbFeaturesForm">
        @csrf

        <!-- 1. INFORMASI DASAR LAYANAN -->
        <div class="admin-card">
            <div class="admin-card__header">
                <h3 class="admin-card__title">
                    <span>1. Informasi &amp; Deskripsi Layanan Jemput Bola</span>
                </h3>
            </div>
            <div class="admin-card__body">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
                    <div class="admin-form-group">
                        <label class="admin-label">Judul Layanan <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="title" class="admin-input" value="{{ $service['title'] ?? 'Jemput Bola' }}" required>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-label">Label Kategori / Tag</label>
                        <input type="text" name="tag" class="admin-input" value="{{ $service['tag'] ?? 'KEPENDUDUKAN' }}">
                    </div>
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Deskripsi Ringkas Layanan</label>
                    <textarea name="desc" class="admin-textarea" rows="2">{{ $service['desc'] ?? '' }}</textarea>
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Pemberitahuan Persyaratan (Notice Box di Halaman Depan)</label>
                    <textarea name="notice" class="admin-textarea" rows="3">{{ $service['notice'] ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <!-- 2. EDIT PERSYARATAN JEMPUT BOLA -->
        <div class="admin-card">
            <div class="admin-card__header">
                <h3 class="admin-card__title">
                    <span>2. Kelola Daftar Persyaratan Pengajuan</span>
                </h3>
                <button type="button" onclick="addRequirementItem()" class="btn-admin-secondary" style="padding: 7px 14px; font-size: 13px; font-weight: 700; background: #ffffff; border: 1.5px solid #0D2E5A; color: #0D2E5A; border-radius: 8px; cursor: pointer;">
                    + Tambah Poin Persyaratan
                </button>
            </div>
            <div class="admin-card__body">
                <div id="jbReqsContainer">
                    @forelse($service['requirements'] ?? [] as $index => $req)
                    <div class="jb-item-box req-item">
                        <div class="jb-item-box__number">{{ $index + 1 }}</div>
                        <div class="jb-item-box__fields">
                            <input type="text" name="requirements[{{ $index }}][title]" class="admin-input" placeholder="Judul Persyaratan" value="{{ $req['title'] ?? '' }}" required>
                            <textarea name="requirements[{{ $index }}][desc]" class="admin-textarea" rows="2" placeholder="Keterangan rincian persyaratan...">{{ $req['desc'] ?? '' }}</textarea>
                        </div>
                        <button type="button" onclick="this.closest('.req-item').remove(); renumberItems('req-item');" class="jb-btn-delete-item">Hapus</button>
                    </div>
                    @empty
                    <div class="jb-item-box req-item">
                        <div class="jb-item-box__number">1</div>
                        <div class="jb-item-box__fields">
                            <input type="text" name="requirements[0][title]" class="admin-input" placeholder="Judul Persyaratan" value="Surat Permohonan & KTP/KK" required>
                            <textarea name="requirements[0][desc]" class="admin-textarea" rows="2">Fotokopi Kartu Keluarga dan Surat Permohonan resmi.</textarea>
                        </div>
                        <button type="button" onclick="this.closest('.req-item').remove(); renumberItems('req-item');" class="jb-btn-delete-item">Hapus</button>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- 3. EDIT PROSEDUR / TAHAPAN JEMPUT BOLA -->
        <div class="admin-card">
            <div class="admin-card__header">
                <h3 class="admin-card__title">
                    <span>3. Kelola Tahapan Prosedur Layanan</span>
                </h3>
                <button type="button" onclick="addProcedureItem()" class="btn-admin-secondary" style="padding: 7px 14px; font-size: 13px; font-weight: 700; background: #ffffff; border: 1.5px solid #0D2E5A; color: #0D2E5A; border-radius: 8px; cursor: pointer;">
                    + Tambah Tahapan Prosedur
                </button>
            </div>
            <div class="admin-card__body">
                <div id="jbProcsContainer">
                    @forelse($service['procedures'] ?? [] as $index => $proc)
                    <div class="jb-item-box proc-item">
                        <div class="jb-item-box__number">{{ $index + 1 }}</div>
                        <div class="jb-item-box__fields">
                            <input type="text" name="procedures[{{ $index }}][title]" class="admin-input" placeholder="Nama Tahapan" value="{{ $proc['title'] ?? '' }}" required>
                            <textarea name="procedures[{{ $index }}][desc]" class="admin-textarea" rows="2">{{ $proc['desc'] ?? '' }}</textarea>
                        </div>
                        <button type="button" onclick="this.closest('.proc-item').remove(); renumberItems('proc-item');" class="jb-btn-delete-item">Hapus</button>
                    </div>
                    @empty
                    <div class="jb-item-box proc-item">
                        <div class="jb-item-box__number">1</div>
                        <div class="jb-item-box__fields">
                            <input type="text" name="procedures[0][title]" class="admin-input" placeholder="Nama Tahapan" value="Pengajuan Formulir" required>
                            <textarea name="procedures[0][desc]" class="admin-textarea" rows="2">Warga mengisi formulir permohonan secara lengkap.</textarea>
                        </div>
                        <button type="button" onclick="this.closest('.proc-item').remove(); renumberItems('proc-item');" class="jb-btn-delete-item">Hapus</button>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- 4. PENGATURAN STATUS APPROVAL & NOTIFIKASI WARGA -->
        <div class="admin-card">
            <div class="admin-card__header">
                <h3 class="admin-card__title">
                    <span>4. Pengaturan Status &amp; Pesan Respon Pengajuan Warga</span>
                </h3>
            </div>
            <div class="admin-card__body">
                <div class="admin-form-group">
                    <label class="admin-label">Status Default Saat Warga Mengirim Formulir</label>
                    <select name="approval_default_status" class="admin-input">
                        <option value="pending" {{ ($service['approval']['default_status'] ?? 'pending') === 'pending' ? 'selected' : '' }}>Dalam Proses Persetujuan (Pending)</option>
                        <option value="accepted" {{ ($service['approval']['default_status'] ?? '') === 'accepted' ? 'selected' : '' }}>Langsung Disetujui (Accepted)</option>
                        <option value="rejected" {{ ($service['approval']['default_status'] ?? '') === 'rejected' ? 'selected' : '' }}>Ditolak Sementara (Rejected)</option>
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; margin-top: 14px;">
                    <!-- Pending -->
                    <div style="background: #fffbeb; border: 1.5px solid #fcd34d; border-radius: 12px; padding: 16px;">
                        <h4 style="margin: 0 0 10px; color: #92400e; font-size: 14px;">• Pesan Ketika "Dalam Proses Persetujuan"</h4>
                        <div class="admin-form-group">
                            <label class="admin-label" style="font-size: 12px;">Judul Status</label>
                            <input type="text" name="approval_pending_title" class="admin-input" value="{{ $service['approval']['pending_title'] ?? 'Dalam Proses Persetujuan' }}">
                        </div>
                        <div class="admin-form-group" style="margin-bottom: 0;">
                            <label class="admin-label" style="font-size: 12px;">Pesan Keterangan</label>
                            <textarea name="approval_pending_message" class="admin-textarea" rows="3">{{ $service['approval']['pending_message'] ?? '' }}</textarea>
                        </div>
                    </div>

                    <!-- Accepted -->
                    <div style="background: #f0fdf4; border: 1.5px solid #86efac; border-radius: 12px; padding: 16px;">
                        <h4 style="margin: 0 0 10px; color: #166534; font-size: 14px;">✓ Pesan Ketika "Disetujui"</h4>
                        <div class="admin-form-group">
                            <label class="admin-label" style="font-size: 12px;">Judul Status</label>
                            <input type="text" name="approval_accepted_title" class="admin-input" value="{{ $service['approval']['accepted_title'] ?? 'Persetujuan Diterima' }}">
                        </div>
                        <div class="admin-form-group" style="margin-bottom: 0;">
                            <label class="admin-label" style="font-size: 12px;">Pesan Keterangan</label>
                            <textarea name="approval_accepted_message" class="admin-textarea" rows="3">{{ $service['approval']['accepted_message'] ?? '' }}</textarea>
                        </div>
                    </div>

                    <!-- Rejected -->
                    <div style="background: #fef2f2; border: 1.5px solid #fca5a5; border-radius: 12px; padding: 16px;">
                        <h4 style="margin: 0 0 10px; color: #991b1b; font-size: 14px;">✕ Pesan Ketika "Tidak Disetujui"</h4>
                        <div class="admin-form-group">
                            <label class="admin-label" style="font-size: 12px;">Judul Status</label>
                            <input type="text" name="approval_rejected_title" class="admin-input" value="{{ $service['approval']['rejected_title'] ?? 'Pengajuan Tidak Disetujui' }}">
                        </div>
                        <div class="admin-form-group" style="margin-bottom: 0;">
                            <label class="admin-label" style="font-size: 12px;">Pesan Keterangan</label>
                            <textarea name="approval_rejected_message" class="admin-textarea" rows="3">{{ $service['approval']['rejected_message'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi Simpan Perubahan -->
        <div style="position: sticky; bottom: 20px; z-index: 80; background: #ffffff; padding: 18px 24px; border-radius: 14px; border: 2px solid #F9A825; box-shadow: 0 8px 30px rgba(0,0,0,0.15); display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap;">
            <div>
                <strong style="color: #0D2E5A; font-size: 15px;">Simpan Seluruh Fitur Jemput Bola</strong>
                <div style="font-size: 12.5px; color: #64748b;">Perubahan akan langsung aktif di halaman Jemput Bola.</div>
            </div>
            <button type="submit" id="saveFeaturesBtn" class="btn-admin-primary" style="padding: 12px 28px; font-size: 15px; font-weight: 800; background: #0D2E5A; border-color: #0D2E5A;">
                💾 Simpan Semua Perubahan Fitur
            </button>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    // Tab Switcher
    function switchJbTab(tabName) {
        document.querySelectorAll('.jb-main-tab').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.jb-tab-pane').forEach(p => p.style.display = 'none');

        if (tabName === 'riwayat') {
            document.getElementById('tabBtnRiwayat').classList.add('active');
            document.getElementById('jbTabRiwayat').style.display = 'block';
        } else {
            document.getElementById('tabBtnFitur').classList.add('active');
            document.getElementById('jbTabFitur').style.display = 'block';
        }
    }

    // Quick Update Status Langsung di Bar
    function quickUpdateStatus(id, newStatus) {
        const selectEl = document.getElementById('select-status-'.concat(id));
        const msgEl = document.getElementById('status-msg-'.concat(id));
        const barEl = document.getElementById('bar-'.concat(id));
        
        if (selectEl) {
            selectEl.dataset.status = newStatus;
        }
        if (msgEl) {
            msgEl.textContent = 'Menyimpan...';
            msgEl.style.color = '#0284c7';
        }

        const formData = new FormData();
        formData.append('id', id);
        formData.append('status', newStatus);

        fetch("{{ route('admin.jemput-bola.update-status') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (msgEl) {
                    msgEl.textContent = '✓ Tersimpan!';
                    msgEl.style.color = '#15803d';
                    setTimeout(() => { msgEl.textContent = ''; }, 2500);
                }
                if (barEl) {
                    barEl.dataset.status = newStatus;
                    barEl.classList.remove('bar-unopened');
                    barEl.classList.add('bar-opened');
                }
                const badgeUnopened = document.getElementById('badge-unopened-'.concat(id));
                if (badgeUnopened) {
                    badgeUnopened.className = 'badge-success-opened';
                    badgeUnopened.id = 'badge-opened-'.concat(id);
                    badgeUnopened.textContent = '✓ Sudah Dicek';
                }
            } else {
                if (msgEl) {
                    msgEl.textContent = '⚠️ Gagal';
                    msgEl.style.color = '#dc2626';
                }
                alert(data.message || 'Gagal mengubah status.');
            }
        })
        .catch(err => {
            if (msgEl) {
                msgEl.textContent = '⚠️ Error koneksi';
                msgEl.style.color = '#dc2626';
            }
        });
    }

    // Mark as checked when Cetak or Dokumen is clicked
    function handlePrintClick(id) {
        const barEl = document.getElementById('bar-'.concat(id));
        if (barEl) {
            barEl.classList.remove('bar-unopened');
            barEl.classList.add('bar-opened');
        }
        const badgeUnopened = document.getElementById('badge-unopened-'.concat(id));
        if (badgeUnopened) {
            badgeUnopened.className = 'badge-success-opened';
            badgeUnopened.textContent = '✓ Sudah Dicek';
        }
        const badgeUnprinted = document.getElementById('badge-unprinted-'.concat(id));
        if (badgeUnprinted) {
            badgeUnprinted.className = 'badge-success-printed';
            badgeUnprinted.textContent = '✓ Sudah Dicetak';
        }
    }

    function handleDocClick(id) {
        const barEl = document.getElementById('bar-'.concat(id));
        if (barEl) {
            barEl.classList.remove('bar-unopened');
            barEl.classList.add('bar-opened');
        }
        const badgeUnopened = document.getElementById('badge-unopened-'.concat(id));
        if (badgeUnopened) {
            badgeUnopened.className = 'badge-success-opened';
            badgeUnopened.textContent = '✓ Sudah Dicek';
        }
    }

    // Filter Bar Permohonan
    function filterBars() {
        const query = (document.getElementById('jbSearchInput').value || '').toLowerCase();
        const status = (document.getElementById('jbStatusFilter').value || '').toLowerCase();
        const bars = document.querySelectorAll('#applicantBarsContainer .applicant-bar');

        bars.forEach(bar => {
            const barText = bar.innerText.toLowerCase();
            const barStatus = (bar.dataset.status || '').toLowerCase();

            const matchesQuery = !query || barText.includes(query);
            const matchesStatus = !status || barStatus === status;

            bar.style.display = (matchesQuery && matchesStatus) ? 'flex' : 'none';
        });
    }

    // Hapus Permohonan
    function deleteSubmission(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus data permohonan ' + id + ' dari riwayat? Tindakan ini tidak dapat dibatalkan.')) {
            return;
        }

        const formData = new FormData();
        formData.append('id', id);

        fetch("{{ route('admin.jemput-bola.delete-submission') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const el = document.getElementById('bar-'.concat(id));
                if (el) el.remove();
                alert(data.message);
            } else {
                alert(data.message || 'Gagal menghapus data.');
            }
        })
        .catch(err => {
            alert('Terjadi kesalahan koneksi.');
        });
    }

    // Dynamic Items Helpers
    function renumberItems(className) {
        document.querySelectorAll('.' + className).forEach((item, index) => {
            const numEl = item.querySelector('.jb-item-box__number');
            if (numEl) numEl.textContent = index + 1;
        });
    }

    function addRequirementItem() {
        const container = document.getElementById('jbReqsContainer');
        const count = container.querySelectorAll('.req-item').length;
        const box = document.createElement('div');
        box.className = 'jb-item-box req-item';
        box.innerHTML = `
            <div class="jb-item-box__number">${count + 1}</div>
            <div class="jb-item-box__fields">
                <input type="text" name="requirements[${count}][title]" class="admin-input" placeholder="Judul Persyaratan Baru" required>
                <textarea name="requirements[${count}][desc]" class="admin-textarea" rows="2" placeholder="Keterangan rincian persyaratan..."></textarea>
            </div>
            <button type="button" onclick="this.closest('.req-item').remove(); renumberItems('req-item');" class="jb-btn-delete-item">Hapus</button>
        `;
        container.appendChild(box);
    }

    function addProcedureItem() {
        const container = document.getElementById('jbProcsContainer');
        const count = container.querySelectorAll('.proc-item').length;
        const box = document.createElement('div');
        box.className = 'jb-item-box proc-item';
        box.innerHTML = `
            <div class="jb-item-box__number">${count + 1}</div>
            <div class="jb-item-box__fields">
                <input type="text" name="procedures[${count}][title]" class="admin-input" placeholder="Nama Tahapan Prosedur Baru" required>
                <textarea name="procedures[${count}][desc]" class="admin-textarea" rows="2" placeholder="Uraian langkah yang dilakukan..."></textarea>
            </div>
            <button type="button" onclick="this.closest('.proc-item').remove(); renumberItems('proc-item');" class="jb-btn-delete-item">Hapus</button>
        `;
        container.appendChild(box);
    }

    // Save Features Form via AJAX
    document.getElementById('jbFeaturesForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('saveFeaturesBtn');
        const originalText = btn.textContent;
        btn.disabled = true;
        btn.textContent = 'Menyimpan seluruh fitur...';

        const formData = new FormData(this);

        fetch("{{ route('admin.jemput-bola.update-features') }}", {
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
                alert('✓ ' + (data.message || 'Semua fitur Layanan Jemput Bola berhasil diperbarui!'));
                window.location.reload();
            } else {
                alert('⚠️ ' + (data.message || 'Gagal menyimpan perubahan.'));
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.textContent = originalText;
            alert('⚠️ Terjadi kesalahan koneksi saat menyimpan.');
        });
    });
</script>
@endsection

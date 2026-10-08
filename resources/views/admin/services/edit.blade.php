@extends('layouts.admin')

@section('title', 'Edit Layanan - Admin')
@section('page_title', 'Edit Layanan')

@section('content')
@php
    $approval = $service['approval'] ?? [
        'default_status' => 'pending',
        'pending_title' => 'Dalam Proses Pengajuan',
        'pending_message' => 'Terima kasih sudah mendaftarkan permohonan. Mohon tunggu proses persetujuan admin.',
        'accepted_title' => 'Permohonan Diterima',
        'accepted_message' => 'Pengajuan Anda telah diterima dan akan diproses.',
        'rejected_title' => 'Pengajuan Ditolak',
        'rejected_message' => 'Pengajuan Anda belum memenuhi persyaratan yang berlaku.'
    ];
@endphp
<div class="admin-card">
    <div class="admin-card__header" style="display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap;">
        <h3 class="admin-card__title" style="margin:0; display:flex; align-items:center; gap:10px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Edit Layanan: {{ $service['title'] ?? 'Layanan' }}
        </h3>
        <a href="{{ url('/admin/services') }}" class="btn-admin-secondary" style="text-decoration:none;">
            ← Kembali ke Daftar Layanan
        </a>
    </div>

    <div class="admin-card__body" style="padding:24px;">
        <form method="POST" action="{{ url('/admin/update-service') }}">
            @csrf
            <input type="hidden" name="slug" value="{{ $service['slug'] ?? '' }}">

            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:18px;">
                <div class="admin-form-group">
                    <label class="admin-label">Judul Layanan</label>
                    <input type="text" class="admin-input" name="title" value="{{ old('title', $service['title'] ?? '') }}" required>
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Kategori</label>
                    <input type="text" class="admin-input" name="category" value="{{ old('category', $service['category'] ?? 'kependudukan') }}">
                </div>

                <div class="admin-form-group">
                    <label class="admin-label">Tag</label>
                    <input type="text" class="admin-input" name="tag" value="{{ old('tag', $service['tag'] ?? 'KEPENDUDUKAN') }}">
                </div>
            </div>

            <div class="admin-form-group" style="margin-top:18px;">
                <label class="admin-label">Deskripsi Ringkas</label>
                <textarea class="admin-textarea" name="desc" rows="4">{{ old('desc', $service['desc'] ?? '') }}</textarea>
            </div>

            <div class="admin-form-group" style="margin-top:18px;">
                <label class="admin-label">Catatan Persyaratan</label>
                <textarea class="admin-textarea" name="notice" rows="3">{{ old('notice', $service['notice'] ?? '') }}</textarea>
            </div>

            <div class="admin-form-group" style="margin-top:18px;">
                <label class="admin-label">Status Default Persetujuan</label>
                <div style="display:flex; gap:20px; flex-wrap:wrap; margin-top:8px;">
                    <label style="display:flex; align-items:center; gap:10px; font-weight:600; color:#111827; cursor:pointer;">
                        <input type="radio" name="approval[default_status]" value="accepted" {{ old('approval.default_status', $approval['default_status'] ?? 'pending') === 'accepted' ? 'checked' : '' }} style="width:18px; height:18px; accent-color:#16a34a;">
                        <span style="display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; border-radius:50%; background:#dcfce7; color:#166534; font-weight:800; font-size:12px;">✓</span>
                        <span>Setujui</span>
                    </label>

                    <label style="display:flex; align-items:center; gap:10px; font-weight:600; color:#111827; cursor:pointer;">
                        <input type="radio" name="approval[default_status]" value="pending" {{ old('approval.default_status', $approval['default_status'] ?? 'pending') === 'pending' ? 'checked' : '' }} style="width:18px; height:18px; accent-color:#d97706;">
                        <span style="display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; border-radius:50%; background:#fef3c7; color:#92400e; font-weight:800; font-size:12px;">•</span>
                        <span>Dalam Proses Pengajuan</span>
                    </label>

                    <label style="display:flex; align-items:center; gap:10px; font-weight:600; color:#111827; cursor:pointer;">
                        <input type="radio" name="approval[default_status]" value="rejected" {{ old('approval.default_status', $approval['default_status'] ?? 'pending') === 'rejected' ? 'checked' : '' }} style="width:18px; height:18px; accent-color:#dc2626;">
                        <span style="display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; border-radius:50%; background:#fee2e2; color:#b91c1c; font-weight:800; font-size:12px;">✕</span>
                        <span>Tidak Disetujui</span>
                    </label>
                </div>
                <div style="font-size:12px; color:#64748b; margin-top:10px;">
                    Pilih salah satu: <strong>Setujui</strong> jika persyaratan sudah terpenuhi, <strong>Dalam Proses Pengajuan</strong> jika masih menunggu validasi, atau <strong>Tidak Disetujui</strong> jika masih belum lengkap.
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:18px; margin-top:18px;">
                <div class="admin-form-group">
                    <label class="admin-label">Judul Status Dalam Proses</label>
                    <input type="text" class="admin-input" name="approval[pending_title]" value="{{ old('approval.pending_title', $approval['pending_title'] ?? 'Dalam Proses Pengajuan') }}">
                </div>
                <div class="admin-form-group">
                    <label class="admin-label">Judul Status Diterima</label>
                    <input type="text" class="admin-input" name="approval[accepted_title]" value="{{ old('approval.accepted_title', $approval['accepted_title'] ?? 'Permohonan Diterima') }}">
                </div>
                <div class="admin-form-group">
                    <label class="admin-label">Judul Status Ditolak</label>
                    <input type="text" class="admin-input" name="approval[rejected_title]" value="{{ old('approval.rejected_title', $approval['rejected_title'] ?? 'Pengajuan Ditolak') }}">
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:18px; margin-top:18px;">
                <div class="admin-form-group">
                    <label class="admin-label">Pesan Saat Proses</label>
                    <textarea class="admin-textarea" name="approval[pending_message]" rows="4">{{ old('approval.pending_message', $approval['pending_message'] ?? 'Terima kasih sudah mendaftarkan permohonan. Mohon tunggu proses persetujuan admin.') }}</textarea>
                </div>
                <div class="admin-form-group">
                    <label class="admin-label">Pesan Setelah ACC</label>
                    <textarea class="admin-textarea" name="approval[accepted_message]" rows="4">{{ old('approval.accepted_message', $approval['accepted_message'] ?? 'Pengajuan Anda telah diterima dan akan diproses.') }}</textarea>
                </div>
                <div class="admin-form-group">
                    <label class="admin-label">Pesan Setelah Ditolak</label>
                    <textarea class="admin-textarea" name="approval[rejected_message]" rows="4">{{ old('approval.rejected_message', $approval['rejected_message'] ?? 'Pengajuan Anda belum memenuhi persyaratan yang berlaku.') }}</textarea>
                </div>
            </div>

            <div class="admin-form-group" style="margin-top:18px;">
                <label class="admin-label">Daftar Poin Persyaratan</label>
                <div style="font-size:12px; color:#64748b; margin-bottom:10px;">
                    Catatan: Anda dapat menambahkan poin persyaratan sebanyak yang dibutuhkan untuk layanan ini.
                </div>
                <div style="display:flex; flex-direction:column; gap:12px;">
                    @php $requirements = $service['requirements'] ?? []; @endphp
                    @if(count($requirements) > 0)
                        @foreach($requirements as $idx => $req)
                            <div style="border:1px solid #e2e8f0; border-radius:12px; padding:14px; background:#f8fafc;">
                                <div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">
                                    <span style="width:28px; height:28px; border-radius:50%; background:#dbeafe; color:#1d4ed8; display:inline-flex; align-items:center; justify-content:center; font-size:12px; font-weight:800;">{{ $idx + 1 }}</span>
                                    <input type="text" class="admin-input" name="requirements[{{ $idx }}][title]" value="{{ old('requirements.' . $idx . '.title', $req['title'] ?? '') }}" placeholder="Judul persyaratan" style="flex:1;">
                                </div>
                                <textarea class="admin-textarea" name="requirements[{{ $idx }}][desc]" rows="2" placeholder="Deskripsi persyaratan (opsional)">{{ old('requirements.' . $idx . '.desc', $req['desc'] ?? '') }}</textarea>
                            </div>
                        @endforeach
                    @else
                        <div style="border:1px dashed #cbd5e1; border-radius:12px; padding:18px; text-align:center; color:#64748b; background:#f8fafc;">
                            Belum ada poin persyaratan untuk layanan ini.
                        </div>
                    @endif
                </div>
            </div>

            <div style="margin-top:24px; display:flex; justify-content:flex-end; gap:12px; flex-wrap:wrap;">
                <a href="{{ url('/admin/services') }}" class="btn-admin-secondary" style="text-decoration:none;">Batal</a>
                <button type="submit" class="btn-admin-primary">💾 Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

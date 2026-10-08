@extends('layouts.admin')

@section('title', isset($artikel) ? 'Edit Artikel - Admin Panel' : 'Tambah Artikel - Admin Panel')
@section('page_title', isset($artikel) ? 'Edit Artikel / Berita' : 'Tambah Artikel / Berita')

@section('content')

@php
    $isEdit = !empty($artikel);
    $articleId = $artikel['id'] ?? '';
    $fotoUrl = $artikel['foto'] ?? '';
    $published = $artikel['published'] ?? true;
@endphp

<div style="margin-bottom:20px;">
    <a href="{{ url('/admin/berita') }}" style="font-size:13px; font-weight:600; color:#2563eb; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
        Kembali ke Daftar Artikel
    </a>
</div>

<div class="admin-card">
    <div class="admin-card__header">
        <h3 class="admin-card__title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            {{ $isEdit ? 'Edit Artikel' : 'Tambah Artikel Baru' }}
        </h3>
    </div>

    <div class="admin-card__body">
        <form id="articleForm">
            <input type="hidden" id="articleId" value="{{ $articleId }}">
            <input type="hidden" id="fotoUrl" value="{{ $fotoUrl }}">

            <div style="display:grid; grid-template-columns:1.4fr 1fr; gap:20px; margin-bottom:20px;">
                <div class="admin-form-group">
                    <label class="admin-label">Judul Artikel</label>
                    <input type="text" class="admin-input" id="judul" value="{{ $artikel['judul'] ?? '' }}" placeholder="Masukkan judul artikel" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-label">Kategori</label>
                    <input type="text" class="admin-input" id="kategori" value="{{ $artikel['kategori'] ?? 'Informasi' }}" placeholder="Contoh: Program Layanan" required>
                </div>
            </div>

            <div class="admin-form-group" style="margin-bottom:20px;">
                <label class="admin-label">Ringkasan Singkat</label>
                <textarea class="admin-textarea" id="ringkasan" rows="3" placeholder="Tuliskan ringkasan singkat artikel..." required>{{ $artikel['ringkasan'] ?? '' }}</textarea>
            </div>

            <div class="admin-form-group" style="margin-bottom:20px;">
                <label class="admin-label">Isi Artikel</label>
                <textarea class="admin-textarea" id="isi" rows="8" placeholder="Tulis isi artikel lengkap di sini..." required>{{ $artikel['isi'] ?? '' }}</textarea>
            </div>

            <div class="admin-form-group" style="margin-bottom:20px;">
                <label class="admin-label">Foto / Infografis Artikel</label>
                <input type="file" id="fotoInput" accept="image/*" class="admin-input" style="padding:10px;">
                <div style="margin-top:12px; color:#64748b; font-size:12px;">Ukuran maksimum 4MB. Format: JPG, PNG, GIF, WEBP.</div>

                <div id="fotoPreview" style="margin-top:16px; border:1px solid #e2e8f0; border-radius:10px; padding:16px; background:#f8fafc; display:{{ !empty($fotoUrl) ? 'block' : 'none' }};">
                    @if(!empty($fotoUrl))
                        <img src="{{ $fotoUrl }}" alt="Preview foto" style="max-width:100%; max-height:260px; border-radius:8px; object-fit:cover;">
                    @endif
                </div>
            </div>

            <div class="admin-form-group" style="margin-bottom:24px;">
                <label style="display:flex; align-items:center; gap:10px; font-size:14px; font-weight:600; color:#334155;">
                    <input type="checkbox" id="published" {{ $published ? 'checked' : '' }}>
                    <span>Publikasikan artikel ini ke halaman publik</span>
                </label>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px;">
                <a href="{{ url('/admin/berita') }}" class="btn-admin-secondary" style="text-decoration:none; display:inline-flex; align-items:center; justify-content:center;">Batal</a>
                <button type="submit" class="btn-admin-primary">{{ $isEdit ? 'Simpan Perubahan' : 'Publikasikan Artikel' }}</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
async function uploadFotoIfNeeded() {
    const fileInput = document.getElementById('fotoInput');
    const fotoUrlInput = document.getElementById('fotoUrl');

    if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
        return;
    }

    const formData = new FormData();
    formData.append('foto', fileInput.files[0]);

    const res = await fetch('/admin/api/berita/upload-foto', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    });

    const data = await res.json();

    if (!data.success) {
        throw new Error(data.message || 'Gagal mengunggah foto.');
    }

    fotoUrlInput.value = data.url;
}

async function submitArticle(e) {
    e.preventDefault();

    try {
        await uploadFotoIfNeeded();

        const payload = {
            id: document.getElementById('articleId').value || null,
            judul: document.getElementById('judul').value.trim(),
            kategori: document.getElementById('kategori').value.trim(),
            ringkasan: document.getElementById('ringkasan').value.trim(),
            isi: document.getElementById('isi').value.trim(),
            foto: document.getElementById('fotoUrl').value.trim(),
            published: document.getElementById('published').checked
        };

        const res = await fetch('/admin/api/berita/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(payload)
        });

        const data = await res.json();

        if (data.success) {
            alert(data.message || 'Artikel berhasil disimpan.');
            window.location.href = '/admin/berita';
            return;
        }

        alert(data.message || 'Gagal menyimpan artikel.');
    } catch (error) {
        alert(error.message || 'Terjadi kesalahan saat menyimpan artikel.');
    }
}

window.addEventListener('DOMContentLoaded', function () {
    document.getElementById('articleForm').addEventListener('submit', submitArticle);
});
</script>
@endsection

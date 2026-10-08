@extends('layouts.admin')

@section('title', 'Kelola Halaman Kontak - Admin Panel')
@section('page_title', 'Kelola Halaman Kontak')

@section('content')

<div class="admin-card">
    <div class="admin-card__header">
        <h3 class="admin-card__title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.59 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            Kelola Informasi Kontak Publik
        </h3>
    </div>

    <div class="admin-card__body">
        <div style="margin-bottom: 22px; padding: 16px 18px; border-left: 4px solid #8b5cf6; background: linear-gradient(90deg, #f5f3ff, #faf7ff); border-radius: 12px; color: #5b21b6; font-size: 14px; font-weight: 600; line-height: 1.6;">
            Ubah data kontak di bawah ini agar masyarakat dapat menghubungi instansi dengan mudah melalui website.
        </div>

        <form id="kontakForm">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
                <div class="admin-form-group">
                    <label class="admin-label">Nomor WhatsApp Resmi</label>
                    <input type="text" class="admin-input" id="whatsapp" value="{{ $kontak['whatsapp'] ?? '' }}" placeholder="Contoh: 6281234567890">
                </div>
                <div class="admin-form-group">
                    <label class="admin-label">Label WhatsApp</label>
                    <input type="text" class="admin-input" id="whatsapp_label" value="{{ $kontak['whatsapp_label'] ?? '' }}" placeholder="Contoh: Chat WhatsApp Admin">
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
                <div class="admin-form-group">
                    <label class="admin-label">Username Instagram</label>
                    <input type="text" class="admin-input" id="instagram" value="{{ $kontak['instagram'] ?? '' }}" placeholder="Contoh: disdukcapilkabcirebon">
                </div>
                <div class="admin-form-group">
                    <label class="admin-label">URL Instagram</label>
                    <input type="text" class="admin-input" id="instagram_url" value="{{ $kontak['instagram_url'] ?? '' }}" placeholder="Masukkan link akun Instagram">
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
                <div class="admin-form-group">
                    <label class="admin-label">Email Resmi</label>
                    <input type="email" class="admin-input" id="email" value="{{ $kontak['email'] ?? '' }}" placeholder="Contoh: informasi@instansi.go.id">
                </div>
                <div class="admin-form-group">
                    <label class="admin-label">Nomor Telepon</label>
                    <input type="text" class="admin-input" id="telepon" value="{{ $kontak['telepon'] ?? '' }}" placeholder="Contoh: 0231-123456">
                </div>
            </div>

            <div class="admin-form-group" style="margin-bottom:20px;">
                <label class="admin-label">Alamat Kantor</label>
                <textarea class="admin-textarea" id="alamat" rows="3" placeholder="Masukkan alamat lengkap kantor">{{ $kontak['alamat'] ?? '' }}</textarea>
            </div>

            <div class="admin-form-group" style="margin-bottom:20px;">
                <label class="admin-label">Jam Pelayanan</label>
                <input type="text" class="admin-input" id="jam_kerja" value="{{ $kontak['jam_kerja'] ?? '' }}" placeholder="Contoh: Senin - Jumat, 08.00 - 16.00 WIB">
            </div>

            <div class="admin-form-group" style="margin-bottom:20px;">
                <label class="admin-label">Pesan Default WhatsApp</label>
                <textarea class="admin-textarea" id="pesan_wa" rows="3" placeholder="Tuliskan kalimat pembuka saat masyarakat menghubungi via WhatsApp">{{ $kontak['pesan_wa'] ?? '' }}</textarea>
            </div>

            <div style="display:flex; justify-content:flex-end;">
                <button type="submit" class="btn-admin-primary">💾 Simpan Perubahan Kontak</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
async function saveKontak(e) {
    e.preventDefault();

    const payload = {
        kontak: {
            whatsapp: document.getElementById('whatsapp').value.trim(),
            whatsapp_label: document.getElementById('whatsapp_label').value.trim(),
            instagram: document.getElementById('instagram').value.trim(),
            instagram_url: document.getElementById('instagram_url').value.trim(),
            email: document.getElementById('email').value.trim(),
            telepon: document.getElementById('telepon').value.trim(),
            alamat: document.getElementById('alamat').value.trim(),
            jam_kerja: document.getElementById('jam_kerja').value.trim(),
            pesan_wa: document.getElementById('pesan_wa').value.trim()
        }
    };

    const res = await fetch('/admin/api/kontak/save', {
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
        alert('Data kontak berhasil diperbarui.');
        window.location.reload();
        return;
    }

    alert(data.message || 'Gagal menyimpan data kontak.');
}

window.addEventListener('DOMContentLoaded', function () {
    document.getElementById('kontakForm').addEventListener('submit', saveKontak);
});
</script>
@endsection

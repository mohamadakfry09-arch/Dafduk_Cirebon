@extends('layouts.admin')

@section('title', 'Kelola Halaman Tentang & Profil Instansi - Admin Panel')
@section('page_title', 'Kelola Profil Instansi (Tentang Kami)')

@section('content')

@php
    $misiText = is_array($tentang['misi'] ?? null) ? implode("\n", $tentang['misi']) : ($tentang['misi'] ?? '');
    $tupoksiText = is_array($tentang['tugas_fungsi'] ?? null) ? implode("\n", $tentang['tugas_fungsi']) : ($tentang['tugas_fungsi'] ?? '');
@endphp

<!-- Toast Notification -->
<div id="adminToast" style="display:none; position:fixed; top:24px; right:24px; z-index:9999; min-width:320px; padding:16px 20px; border-radius:12px; background:#10b981; color:#ffffff; font-weight:700; box-shadow:0 10px 25px rgba(0,0,0,0.2); align-items:center; gap:12px; animation:slideIn 0.3s ease;">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
    <span id="adminToastMsg">Perubahan berhasil disimpan!</span>
</div>

<div class="admin-card">
    <div class="admin-card__header" style="flex-wrap:wrap; gap:12px;">
        <h3 class="admin-card__title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <span>Pengaturan Profil Instansi &amp; Halaman Tentang</span>
        </h3>

        <div style="display:flex; align-items:center; gap:10px;">
            <a href="{{ url('/tentang') }}" target="_blank" class="btn-admin-pill" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px; background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; font-size:13px; font-weight:700; padding:6px 14px; border-radius:999px;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                <span>Lihat Halaman Publik ↗</span>
            </a>
            <button type="button" onclick="submitTentangForm()" class="btn-admin-primary" id="btnSaveTop" style="padding:8px 18px; font-size:13px; font-weight:700;">
                💾 Simpan Profil
            </button>
        </div>
    </div>

    <div class="admin-card__body">
        <div style="margin-bottom:24px; padding:16px 20px; border-left:4px solid #2563eb; background:linear-gradient(90deg, #eff6ff 0%, #f8fbff 100%); border-radius:12px; color:#1e3a8a; font-size:13.5px; line-height:1.6; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
            <div>
                <strong>Informasi:</strong> Data yang diubah pada formulir ini akan langsung diperbarui secara realtime pada halaman <strong>Tentang Kami (Profil Instansi)</strong> di website publik.
            </div>
        </div>

        <form id="tentangForm" onsubmit="saveTentang(event)">

            <!-- Bagian 1: Identitas Instansi -->
            <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:14px; padding:22px; margin-bottom:22px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:16px; border-bottom:1px solid #f1f5f9; padding-bottom:10px;">
                    <span style="width:28px; height:28px; border-radius:8px; background:#eff6ff; color:#2563eb; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:12px;">1</span>
                    <h4 style="font-size:15px; font-weight:800; color:#0f172a; margin:0;">Identitas &amp; Slogan Instansi</h4>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:16px;">
                    <div class="admin-form-group" style="margin-bottom:0;">
                        <label class="admin-label">Nama Instansi</label>
                        <input type="text" class="admin-input" id="nama_instansi" value="{{ $tentang['nama_instansi'] ?? 'Dinas Kependudukan dan Pencatatan Sipil' }}" required placeholder="Contoh: Dinas Kependudukan dan Pencatatan Sipil">
                    </div>
                    <div class="admin-form-group" style="margin-bottom:0;">
                        <label class="admin-label">Pemerintah Kabupaten / Kota</label>
                        <input type="text" class="admin-input" id="nama_kabupaten" value="{{ $tentang['nama_kabupaten'] ?? 'Kabupaten Cirebon' }}" required placeholder="Contoh: Kabupaten Cirebon">
                    </div>
                </div>

                <div class="admin-form-group" style="margin-bottom:0;">
                    <label class="admin-label">Slogan / Motto Pelayanan</label>
                    <input type="text" class="admin-input" id="slogan" value="{{ $tentang['slogan'] ?? 'Melayani dengan Cepat, Akurat, Nyaman, dan Membahagiakan Masyarakat' }}" placeholder="Tuliskan motto atau slogan dinas">
                    <span style="font-size:12px; color:#64748b; margin-top:4px; display:block;">Slogan akan ditampilkan di bawah judul utama halaman profil.</span>
                </div>
            </div>

            <!-- Bagian 2: Profil Pimpinan / Kepala Dinas -->
            <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:14px; padding:22px; margin-bottom:22px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:16px; border-bottom:1px solid #f1f5f9; padding-bottom:10px;">
                    <span style="width:28px; height:28px; border-radius:8px; background:#eff6ff; color:#2563eb; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:12px;">2</span>
                    <h4 style="font-size:15px; font-weight:800; color:#0f172a; margin:0;">Profil Kepala Dinas (Pimpinan)</h4>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:16px;">
                    <div class="admin-form-group" style="margin-bottom:0;">
                        <label class="admin-label">Nama Lengkap &amp; Gelar Kepala Dinas</label>
                        <input type="text" class="admin-input" id="kepala_dinas" value="{{ $tentang['kepala_dinas'] ?? '' }}" placeholder="Contoh: Drs. H. Iman Supriadi, M.Si.">
                    </div>
                    <div class="admin-form-group" style="margin-bottom:0;">
                        <label class="admin-label">NIP Kepala Dinas</label>
                        <input type="text" class="admin-input" id="nip_kepala" value="{{ $tentang['nip_kepala'] ?? '' }}" placeholder="Contoh: 19680101 199203 1 001">
                    </div>
                </div>

                <!-- Foto Kepala Dinas -->
                <div style="display:grid; grid-template-columns:120px 1fr; gap:20px; align-items:center; background:#f8fafc; padding:16px; border-radius:12px; margin-bottom:16px; border:1px solid #e2e8f0;">
                    <div style="text-align:center;">
                        <div style="width:100px; height:100px; border-radius:50%; overflow:hidden; border:3px solid #2563eb; margin:0 auto; background:#eff6ff; display:flex; align-items:center; justify-content:center;">
                            <img id="previewFotoKepala" src="{{ !empty($tentang['foto_kepala']) ? $tentang['foto_kepala'] : '' }}" alt="Foto Kepala Dinas" style="{{ !empty($tentang['foto_kepala']) ? '' : 'display:none;' }} width:100%; height:100%; object-fit:cover;">
                            <div id="placeholderFotoKepala" style="{{ !empty($tentang['foto_kepala']) ? 'display:none;' : '' }} color:#94a3b8; font-size:11px; font-weight:700; text-align:center; padding:6px;">
                                Belum Ada Foto
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="admin-label">Foto Resmi Kepala Dinas</label>
                        <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-bottom:8px;">
                            <input type="text" class="admin-input" id="foto_kepala" value="{{ $tentang['foto_kepala'] ?? '' }}" placeholder="URL foto atau unggah langsung melalui tombol di sebelah kanan" style="flex:1; min-width:240px;" oninput="updateFotoPreview(this.value)">
                            <label class="btn-admin-pill" style="cursor:pointer; display:inline-flex; align-items:center; gap:6px; background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; font-size:13px; font-weight:700; padding:10px 16px; border-radius:8px; margin:0;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                <span>Unggah Foto</span>
                                <input type="file" id="fileFotoKepala" accept="image/*" style="display:none;" onchange="uploadFotoKepala(this)">
                            </label>
                        </div>
                        <span style="font-size:12px; color:#64748b;">Format: JPG, PNG, WEBP (maks. 5MB). Rekomendasi rasio 1:1 atau foto resmi dinas.</span>
                    </div>
                </div>

                <div class="admin-form-group" style="margin-bottom:0;">
                    <label class="admin-label">Sambutan Kepala Dinas</label>
                    <textarea class="admin-textarea" id="sambutan_kepala" rows="4" placeholder="Tuliskan kata sambutan pimpinan kepada masyarakat">{{ $tentang['sambutan_kepala'] ?? '' }}</textarea>
                </div>
            </div>

            <!-- Bagian 3: Visi & Misi -->
            <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:14px; padding:22px; margin-bottom:22px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:16px; border-bottom:1px solid #f1f5f9; padding-bottom:10px;">
                    <span style="width:28px; height:28px; border-radius:8px; background:#eff6ff; color:#2563eb; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:12px;">3</span>
                    <h4 style="font-size:15px; font-weight:800; color:#0f172a; margin:0;">Visi &amp; Misi Instansi</h4>
                </div>

                <div class="admin-form-group" style="margin-bottom:18px;">
                    <label class="admin-label">Visi Lembaga</label>
                    <textarea class="admin-textarea" id="visi" rows="3" placeholder="Tuliskan visi instansi atau lembaga">{{ $tentang['visi'] ?? '' }}</textarea>
                </div>

                <div class="admin-form-group" style="margin-bottom:0;">
                    <label class="admin-label">Misi Lembaga (Tuliskan satu butir misi per baris)</label>
                    <textarea class="admin-textarea" id="misi" rows="6" placeholder="Satu misi per baris, contoh:&#10;Meningkatkan kualitas pelayanan administrasi kependudukan.&#10;Mewujudkan tertib administrasi bagi seluruh masyarakat.">{{ $misiText }}</textarea>
                    <span style="font-size:12px; color:#64748b; margin-top:4px; display:block;">💡 Setiap baris baru (tekan Enter) otomatis menjadi nomor butir misi tersendiri pada tampilan publik.</span>
                </div>
            </div>

            <!-- Bagian 4: Tugas Pokok & Fungsi (Tupoksi) -->
            <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:14px; padding:22px; margin-bottom:22px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:16px; border-bottom:1px solid #f1f5f9; padding-bottom:10px;">
                    <span style="width:28px; height:28px; border-radius:8px; background:#eff6ff; color:#2563eb; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:12px;">4</span>
                    <h4 style="font-size:15px; font-weight:800; color:#0f172a; margin:0;">Tugas Pokok &amp; Fungsi (Tupoksi)</h4>
                </div>

                <div class="admin-form-group" style="margin-bottom:0;">
                    <label class="admin-label">Rincian Tugas &amp; Fungsi Disdukcapil (Tuliskan satu butir per baris)</label>
                    <textarea class="admin-textarea" id="tugas_fungsi" rows="6" placeholder="Tuliskan satu butir tugas pokok dan fungsi per baris">{{ $tupoksiText }}</textarea>
                    <span style="font-size:12px; color:#64748b; margin-top:4px; display:block;">💡 Setiap baris baru akan ditampilkan sebagai kartu tugas dengan checklist hijau yang rapi.</span>
                </div>
            </div>

            <!-- Bagian 5: Maklumat Pelayanan & Sejarah -->
            <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:14px; padding:22px; margin-bottom:22px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:16px; border-bottom:1px solid #f1f5f9; padding-bottom:10px;">
                    <span style="width:28px; height:28px; border-radius:8px; background:#eff6ff; color:#2563eb; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:12px;">5</span>
                    <h4 style="font-size:15px; font-weight:800; color:#0f172a; margin:0;">Maklumat Pelayanan &amp; Sejarah</h4>
                </div>

                <div class="admin-form-group" style="margin-bottom:18px;">
                    <label class="admin-label">Maklumat Pelayanan Prima (Pernyataan Janji Layanan Bebas Pungli)</label>
                    <textarea class="admin-textarea" id="maklumat_pelayanan" rows="4" placeholder="Tuliskan maklumat pelayanan publik">{{ $tentang['maklumat_pelayanan'] ?? '' }}</textarea>
                </div>

                <div class="admin-form-group" style="margin-bottom:0;">
                    <label class="admin-label">Sejarah &amp; Transformasi Singkat Instansi</label>
                    <textarea class="admin-textarea" id="sejarah" rows="5" placeholder="Tuliskan sejarah singkat lembaga">{{ $tentang['sejarah'] ?? '' }}</textarea>
                </div>
            </div>

            <!-- Bagian 6: Jam Operasional & Kontak Kantor -->
            <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:14px; padding:22px; margin-bottom:22px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:16px; border-bottom:1px solid #f1f5f9; padding-bottom:10px;">
                    <span style="width:28px; height:28px; border-radius:8px; background:#eff6ff; color:#2563eb; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:12px;">6</span>
                    <h4 style="font-size:15px; font-weight:800; color:#0f172a; margin:0;">Jam Operasional &amp; Kontak Kantor</h4>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:18px;">
                    <div class="admin-form-group" style="margin-bottom:0;">
                        <label class="admin-label">Jam Layanan Pelayanan</label>
                        <input type="text" class="admin-input" id="jam_kerja" value="{{ $tentang['jam_kerja'] ?? '' }}" placeholder="Contoh: Senin – Kamis: 07.30 – 16.00 WIB | Jumat: 07.30 – 16.30 WIB">
                    </div>
                    <div class="admin-form-group" style="margin-bottom:0;">
                        <label class="admin-label">Nomor Telepon Kantor</label>
                        <input type="text" class="admin-input" id="telepon" value="{{ $tentang['telepon'] ?? '' }}" placeholder="Contoh: 0231-321156">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:18px;">
                    <div class="admin-form-group" style="margin-bottom:0;">
                        <label class="admin-label">Email Resmi Instansi</label>
                        <input type="email" class="admin-input" id="email" value="{{ $tentang['email'] ?? '' }}" placeholder="Contoh: disdukcapil@cirebonkab.go.id">
                    </div>
                    <div class="admin-form-group" style="margin-bottom:0;">
                        <label class="admin-label">Website Resmi</label>
                        <input type="text" class="admin-input" id="website" value="{{ $tentang['website'] ?? '' }}" placeholder="Contoh: www.disdukcapil.cirebonkab.go.id">
                    </div>
                </div>

                <div class="admin-form-group" style="margin-bottom:0;">
                    <label class="admin-label">Alamat Lengkap Kantor</label>
                    <textarea class="admin-textarea" id="alamat" rows="2" placeholder="Tuliskan alamat lengkap kantor">{{ $tentang['alamat'] ?? '' }}</textarea>
                </div>
            </div>

            <!-- Bagian 7: Peta Lokasi (Google Maps) -->
            <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:14px; padding:22px; margin-bottom:28px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:16px; border-bottom:1px solid #f1f5f9; padding-bottom:10px;">
                    <span style="width:28px; height:28px; border-radius:8px; background:#eff6ff; color:#2563eb; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:12px;">7</span>
                    <h4 style="font-size:15px; font-weight:800; color:#0f172a; margin:0;">Peta Lokasi Kantor (Google Maps)</h4>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:14px;">
                    <div class="admin-form-group" style="margin-bottom:0;">
                        <label class="admin-label">URL Embed Iframe Google Maps</label>
                        <input type="text" class="admin-input" id="maps_embed" value="{{ $tentang['maps_embed'] ?? '' }}" placeholder="https://www.google.com/maps/embed?pb=...">
                    </div>
                    <div class="admin-form-group" style="margin-bottom:0;">
                        <label class="admin-label">Tautan Link Langsung Google Maps</label>
                        <input type="text" class="admin-input" id="maps_link" value="{{ $tentang['maps_link'] ?? '' }}" placeholder="https://maps.google.com/?q=...">
                    </div>
                </div>
                <span style="font-size:12px; color:#64748b;">Gunakan URL embed Google Maps untuk menampilkan peta interaktif di halaman profil instansi.</span>
            </div>

            <!-- Tombol Submit Bawah -->
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:14px; padding:20px 24px; background:#f8fafc; border-radius:14px; border:1px solid #e2e8f0;">
                <div style="font-size:13px; color:#64748b;">
                    Pastikan seluruh data profil instansi sudah terisi dengan benar sebelum menekan tombol simpan.
                </div>
                <div style="display:flex; gap:12px; align-items:center;">
                    <a href="{{ url('/tentang') }}" target="_blank" class="btn-admin-pill" style="text-decoration:none; padding:10px 18px; font-size:13.5px; font-weight:700; background:#ffffff; border:1px solid #cbd5e1; color:#334155; border-radius:10px;">
                        Buka Halaman Tentang ↗
                    </a>
                    <button type="submit" class="btn-admin-primary" id="btnSaveBottom" style="padding:10px 24px; font-size:14px; font-weight:800; border-radius:10px;">
                        💾 Simpan Perubahan Profil
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
function showToast(message, isSuccess = true) {
    const toast = document.getElementById('adminToast');
    const msg = document.getElementById('adminToastMsg');
    msg.textContent = message;
    toast.style.background = isSuccess ? '#10b981' : '#ef4444';
    toast.style.display = 'flex';
    setTimeout(() => {
        toast.style.display = 'none';
    }, 4000);
}

function updateFotoPreview(url) {
    const img = document.getElementById('previewFotoKepala');
    const placeholder = document.getElementById('placeholderFotoKepala');
    if (url && url.trim() !== '') {
        img.src = url.trim();
        img.style.display = 'block';
        placeholder.style.display = 'none';
    } else {
        img.style.display = 'none';
        placeholder.style.display = 'block';
    }
}

async function uploadFotoKepala(input) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];

    const formData = new FormData();
    formData.append('foto', file);

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    try {
        const btn = input.parentElement;
        const origText = btn.innerHTML;
        btn.innerHTML = '<span>Mengunggah...</span>';

        const res = await fetch('/admin/api/tentang/upload-foto', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await res.json();
        btn.innerHTML = origText;

        if (data.success && data.url) {
            document.getElementById('foto_kepala').value = data.url;
            updateFotoPreview(data.url);
            showToast('Foto kepala dinas berhasil diunggah!');
        } else {
            showToast(data.message || 'Gagal mengunggah foto.', false);
        }
    } catch (err) {
        console.error(err);
        showToast('Terjadi kesalahan saat mengunggah foto.', false);
    }
}

function submitTentangForm() {
    document.getElementById('tentangForm').dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
}

async function saveTentang(e) {
    e.preventDefault();

    const btnTop = document.getElementById('btnSaveTop');
    const btnBottom = document.getElementById('btnSaveBottom');
    if (btnTop) btnTop.disabled = true;
    if (btnBottom) btnBottom.disabled = true;

    const payload = {
        tentang: {
            nama_instansi: document.getElementById('nama_instansi').value.trim(),
            nama_kabupaten: document.getElementById('nama_kabupaten').value.trim(),
            slogan: document.getElementById('slogan').value.trim(),
            kepala_dinas: document.getElementById('kepala_dinas').value.trim(),
            nip_kepala: document.getElementById('nip_kepala').value.trim(),
            foto_kepala: document.getElementById('foto_kepala').value.trim(),
            sambutan_kepala: document.getElementById('sambutan_kepala').value.trim(),
            visi: document.getElementById('visi').value.trim(),
            misi: document.getElementById('misi').value,
            tugas_fungsi: document.getElementById('tugas_fungsi').value,
            maklumat_pelayanan: document.getElementById('maklumat_pelayanan').value.trim(),
            sejarah: document.getElementById('sejarah').value.trim(),
            jam_kerja: document.getElementById('jam_kerja').value.trim(),
            telepon: document.getElementById('telepon').value.trim(),
            email: document.getElementById('email').value.trim(),
            website: document.getElementById('website').value.trim(),
            alamat: document.getElementById('alamat').value.trim(),
            maps_embed: document.getElementById('maps_embed').value.trim(),
            maps_link: document.getElementById('maps_link').value.trim()
        }
    };

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    try {
        const res = await fetch('/admin/api/tentang/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(payload)
        });

        const data = await res.json();
        if (data.success) {
            showToast(data.message || 'Profil instansi berhasil diperbarui!');
        } else {
            showToast(data.message || 'Gagal menyimpan profil instansi.', false);
        }
    } catch (err) {
        console.error(err);
        showToast('Terjadi kesalahan koneksi atau server.', false);
    } finally {
        if (btnTop) btnTop.disabled = false;
        if (btnBottom) btnBottom.disabled = false;
    }
}
</script>
<style>
@keyframes slideIn {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
</style>
@endsection

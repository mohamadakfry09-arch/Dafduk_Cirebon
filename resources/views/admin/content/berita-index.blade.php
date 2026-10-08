@extends('layouts.admin')

@section('title', 'Kelola Berita & Informasi - Admin Panel')
@section('page_title', 'Kelola Berita & Informasi')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px; margin-bottom:24px;">
    <div>
        <h2 style="font-size:20px; font-weight:800; color:#0f172a; margin:0 0 6px;">Daftar Artikel & Berita</h2>
        <p style="margin:0; font-size:13px; color:#64748b;">Kelola artikel, berita, foto/infografis, dan publikasi konten website masyarakat.</p>
    </div>

    <a href="{{ url('/admin/berita/tambah') }}" class="btn-admin-primary" style="text-decoration:none; padding:10px 18px; font-size:14px; font-weight:700; display:inline-flex; align-items:center; gap:8px; border-radius:8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Artikel Baru
    </a>
</div>

<div class="admin-card">
    <div class="admin-card__header">
        <h3 class="admin-card__title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10l4 4v12a2 2 0 0 1-2 2z"/><polyline points="17 20 17 13 7 13 7 20"/><polyline points="7 4 7 8 15 8"/></svg>
            Daftar Artikel yang Sudah Dibuat
        </h3>
    </div>

    <div class="admin-card__body" style="padding:0;">
        @if(count($berita) === 0)
            <div style="padding:60px 24px; text-align:center; color:#64748b;">
                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" style="margin:0 auto 16px; display:block; opacity:0.35;"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10l4 4v12a2 2 0 0 1-2 2z"/><polyline points="17 20 17 13 7 13 7 20"/><polyline points="7 4 7 8 15 8"/></svg>
                <p style="margin:0; font-size:16px;">Belum ada artikel yang dipublikasikan.</p>
            </div>
        @else
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:14px; text-align:left;">
                    <thead>
                        <tr style="background:#f8fafc; border-bottom:1px solid #e2e8f0; color:#475569; font-size:12px; text-transform:uppercase; letter-spacing:0.5px;">
                            <th style="padding:14px 18px;">Judul</th>
                            <th style="padding:14px 18px;">Kategori</th>
                            <th style="padding:14px 18px;">Status</th>
                            <th style="padding:14px 18px;">Tanggal</th>
                            <th style="padding:14px 18px; text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($berita as $item)
                            <tr style="border-bottom:1px solid #f1f5f9;">
                                <td style="padding:16px 18px; max-width:360px;">
                                    <div style="font-weight:700; color:#0f172a;">{{ $item['judul'] }}</div>
                                    <div style="font-size:12px; color:#64748b; margin-top:4px;">{{ Str::limit($item['ringkasan'], 90) }}</div>
                                </td>
                                <td style="padding:16px 18px;">
                                    <span style="display:inline-block; background:#e0f2fe; color:#0369a1; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:700;">
                                        {{ $item['kategori'] ?? 'Umum' }}
                                    </span>
                                </td>
                                <td style="padding:16px 18px;">
                                    @if(($item['published'] ?? true))
                                        <span style="display:inline-block; background:#dcfce7; color:#166534; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:700;">Dipublikasikan</span>
                                    @else
                                        <span style="display:inline-block; background:#fef3c7; color:#92400e; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:700;">Draft</span>
                                    @endif
                                </td>
                                <td style="padding:16px 18px; color:#475569; font-size:12px;">
                                    {{ \Carbon\Carbon::parse($item['created_at'])->isoFormat('D MMMM YYYY') }}
                                </td>
                                <td style="padding:16px 18px; text-align:right;">
                                    <div style="display:flex; justify-content:flex-end; gap:8px; flex-wrap:wrap;">
                                        <a href="{{ url('/admin/berita/edit/'.$item['id']) }}" class="btn-admin-primary" style="text-decoration:none; padding:7px 12px; font-size:12px; font-weight:700; border-radius:6px; display:inline-flex; align-items:center; gap:6px;">
                                            ✏️ Edit
                                        </a>
                                        <button type="button" class="btn-admin-secondary" style="padding:7px 12px; font-size:12px; font-weight:700; border-radius:6px;" onclick="deleteBerita({{ $item['id'] }})">
                                            🗑️ Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
<script>
function deleteBerita(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus artikel ini?')) return;

    fetch('/admin/api/berita/delete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ id })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Artikel berhasil dihapus.');
            window.location.reload();
        } else {
            alert(data.message || 'Gagal menghapus artikel.');
        }
    })
    .catch(() => alert('Terjadi kesalahan jaringan.'));
}
</script>
@endsection

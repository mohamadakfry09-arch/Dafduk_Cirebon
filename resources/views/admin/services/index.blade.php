@extends('layouts.admin')

@section('title', 'Kelola Layanan - Admin')
@section('page_title', 'Kelola Layanan')

@section('content')
<div class="admin-card">
    <div class="admin-card__header" style="display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap;">
        <h3 class="admin-card__title" style="margin:0; display:flex; align-items:center; gap:10px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            Daftar Layanan Publik
        </h3>
        <a href="{{ url('/admin/dashboard') }}" class="btn-admin-secondary" style="text-decoration:none;">
            ← Kembali ke Dashboard
        </a>
    </div>

    <div class="admin-card__body" style="padding:0;">
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; font-size:14px;">
                <thead>
                    <tr style="background:#f8fafc; color:#475569; text-transform:uppercase; font-size:12px; letter-spacing:0.5px;">
                        <th style="padding:14px 20px; text-align:left;">No</th>
                        <th style="padding:14px 20px; text-align:left;">Nama Layanan</th>
                        <th style="padding:14px 20px; text-align:left;">Kategori / Tag</th>
                        <th style="padding:14px 20px; text-align:left;">Jumlah Syarat</th>
                        <th style="padding:14px 20px; text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services ?? [] as $index => $service)
                        <tr style="border-bottom:1px solid #e2e8f0;">
                            <td style="padding:16px 20px; font-weight:700; color:#94a3b8;">{{ $index + 1 }}</td>
                            <td style="padding:16px 20px;">
                                <div style="font-weight:700; color:#0f172a;">{{ $service['title'] ?? '-' }}</div>
                                <div style="font-size:12px; color:#64748b; margin-top:2px;">/pelayanan/{{ $service['slug'] ?? '-' }}</div>
                            </td>
                            <td style="padding:16px 20px;">
                                <span style="display:inline-block; background:#e0f2fe; color:#0369a1; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:700; text-transform:uppercase;">
                                    {{ $service['tag'] ?? 'KEPENDUDUKAN' }}
                                </span>
                            </td>
                            <td style="padding:16px 20px; font-weight:600; color:#334155;">
                                {{ count($service['requirements'] ?? []) }} Poin
                            </td>
                            <td style="padding:16px 20px; text-align:right;">
                                @if(($service['slug'] ?? '') === 'jemput-bola')
                                    <a href="{{ url('/admin/jemput-bola') }}" class="btn-admin-primary" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-size:12px; padding:7px 14px; background:#F9A825; color:#071B3A !important; border-color:#F9A825; font-weight:800;">
                                        ⚡ Kelola Khusus
                                    </a>
                                @else
                                    <a href="{{ url('/admin/services/edit/' . ($service['slug'] ?? '')) }}" class="btn-admin-primary" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-size:12px; padding:7px 14px;">
                                        ✏️ Edit
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding:28px 20px; text-align:center; color:#64748b;">
                                Belum ada layanan yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

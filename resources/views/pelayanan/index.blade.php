@extends('layouts.app')

@section('title', 'Direktori Pelayanan - Dinas Kependudukan Dan Pencatatan Sipil')

@section('content')

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="breadcrumb__container">
        <span class="breadcrumb__item"><a href="{{ url('/') }}">Beranda</a></span>
        <span class="breadcrumb__sep">›</span>
        <span class="breadcrumb__item">Pelayanan</span>
    </div>
</div>

<!-- Services Directory -->
<div class="container" style="padding-top:28px;padding-bottom:60px;max-width:1280px;margin:0 auto;padding-left:24px;padding-right:24px;">

    <a href="{{ url('/') }}" class="page-back-link">
        <span aria-hidden="true">←</span>
        <span>Kembali ke Beranda</span>
    </a>

    <!-- Search Bar -->
    <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;margin-bottom:16px;">
        <div style="display:flex;align-items:center;gap:10px;flex:1;max-width:640px;">
            <div class="search-bar" style="flex:1;">
                <svg class="search-bar__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" class="search-bar__input" id="serviceSearch" placeholder="Cari layanan, contoh: KTP, Akta Kelahiran, Pindah..." oninput="filterServices(this.value)">
                <button type="button" class="search-bar__btn">Cari</button>
            </div>
            <!-- Voice Search Button -->
            <button type="button" id="voiceSearchBtn" title="Cari dengan suara" aria-label="Cari layanan dengan suara" onclick="startVoiceSearch()" style="flex-shrink:0;display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:0 16px;height:44px;border-radius:var(--radius-full,999px);border:2px solid var(--color-primary,#1e5fa8);background:var(--color-white,#fff);color:var(--color-primary,#1e5fa8);font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;white-space:nowrap;">
                <svg id="voiceSearchIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3a3 3 0 0 1 3 3v6a3 3 0 0 1-6 0V6a3 3 0 0 1 3-3Z"/>
                    <path d="M19 10a7 7 0 0 1-14 0"/>
                    <path d="M12 17v4"/>
                    <path d="M8 21h8"/>
                </svg>
                <span id="voiceSearchLabel">Ucapkan</span>
            </button>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs" id="filterTabs">
        <button class="filter-tab active" onclick="filterByCategory('semua', this)">Semua Layanan</button>
        <button class="filter-tab" onclick="filterByCategory('ktp-el', this)">KTP-el</button>
        <button class="filter-tab" onclick="filterByCategory('kartu-keluarga', this)">Kartu Keluarga</button>
        <button class="filter-tab" onclick="filterByCategory('kependudukan', this)">Kependudukan</button>
        <button class="filter-tab" onclick="filterByCategory('lainnya', this)">Lainnya</button>
    </div>

    <!-- Section: Menampilkan -->
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
        <h2 style="font-size:14px;font-weight:600;color:var(--color-text-secondary);">Menampilkan {{ count($services) }} Layanan Adminduk</h2>
        <span style="font-size:12px;color:var(--color-text-muted);">Pilih filter untuk melihat kategori tertentu</span>
    </div>

    @if(!empty($permohonan))
        <div style="margin-bottom:24px; padding:20px 24px; border:2px solid #F9A825; border-left:6px solid #F9A825; background:linear-gradient(135deg, #0c2340 0%, #143760 100%); border-radius:16px; box-shadow:0 8px 24px rgba(12, 35, 64, 0.25); color:#ffffff;">
            <div style="display:flex; justify-content:space-between; gap:12px; align-items:center; flex-wrap:wrap; margin-bottom:14px;">
                <div>
                    <div style="font-size:11px; font-weight:800; letter-spacing:.08em; color:#F9A825; text-transform:uppercase;">Layanan Khusus Pemohon</div>
                    <h3 style="margin:6px 0 0; font-size:20px; font-weight:800; color:#ffffff;">Jemput Bola</h3>
                </div>
                <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; padding:5px 14px; border-radius:999px; background:#F9A825; color:#0c2340; font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:.06em; box-shadow:0 2px 8px rgba(249,168,37,0.3);">Prioritas</span>
                    <span style="display:inline-flex; align-items:center; justify-content:center; padding:5px 14px; border-radius:999px; background:rgba(239, 125, 87, 0.4); border:1px solid #fed7aa; color:#ffffff; font-size:11px; font-weight:700;">✉️ Login Google (Pelayanan Adminduk)</span>
                </div>
            </div>
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap:14px;">
                @foreach($permohonan as $service)
                    @php
                        $targetUrl = session('is_warga') ? url('/pelayanan/'.$service['slug']) : url('/pelayanan/jemput-bola/login');
                    @endphp
                    <a href="{{ $targetUrl }}" style="display:block; text-decoration:none; color:inherit; background:rgba(255, 255, 255, 0.06); border:1px solid rgba(249, 168, 37, 0.3); border-radius:14px; padding:18px; box-shadow:0 4px 12px rgba(0,0,0,0.15); transition:all .2s ease;">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:12px;">
                            <div style="width:36px; height:36px; border-radius:10px; background:rgba(249, 168, 37, 0.15); border:1px solid rgba(249, 168, 37, 0.35); color:#F9A825; display:flex; align-items:center; justify-content:center;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            </div>
                            <span style="font-size:10px; font-weight:800; letter-spacing:.08em; color:#F9A825; text-transform:uppercase;">{{ $service['tag'] ?? 'PERMOHONAN' }}</span>
                        </div>
                        <h4 style="margin:0 0 8px; font-size:16px; font-weight:800; color:#ffffff;">{{ $service['title'] }}</h4>
                        <p style="margin:0 0 12px; font-size:13px; line-height:1.6; color:#94a3b8;">{{ $service['desc'] }}</p>
                        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
                            <span style="display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:700; color:#F9A825;">
                                Ajukan Permohonan
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                            </span>
                            <span style="font-size:11px; color:#fed7aa; font-weight:600;">* Login akun Google (Pelayanan Adminduk)</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Service List Grid -->
    <div class="service-list" id="serviceList">

        @foreach($services as $service)
        <a href="{{ url('/pelayanan/'.$service['slug']) }}" class="service-item" data-category="{{ $service['category'] ?? 'kependudukan' }}" data-title="{{ strtolower($service['title']) }}" data-speech-title="{{ $service['title'] }}">
            <div style="display:flex;align-items:center;gap:10px;">
                <div class="service-item__icon service-item__icon--blue">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        @if(($service['icon'] ?? '') === 'user')
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        @elseif(($service['icon'] ?? '') === 'users')
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        @elseif(($service['icon'] ?? '') === 'credit-card')
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/>
                        @elseif(($service['icon'] ?? '') === 'smartphone')
                            <rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/>
                        @elseif(($service['icon'] ?? '') === 'map-pin')
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                        @elseif(($service['icon'] ?? '') === 'globe')
                            <circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                        @else
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                        @endif
                    </svg>
                </div>
                <span class="service-item__tag">{{ $service['tag'] ?? 'KEPENDUDUKAN' }}</span>
            </div>
            <h3 class="service-item__title">{{ $service['title'] }}</h3>
            <p class="service-item__desc">{{ $service['desc'] }}</p>
            <span class="service-item__link">
                Lihat Detail & Persyaratan
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
            </span>
        </a>
        @endforeach

    </div>
</div>

@endsection

@section('scripts')
<script>
function filterServices(query) {
    const items = document.querySelectorAll('.service-item');
    const q = query.toLowerCase();
    items.forEach(item => {
        const title = item.getAttribute('data-title') || '';
        item.style.display = title.includes(q) ? '' : 'none';
    });
}

function filterByCategory(cat, btn) {
    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
    if(btn) btn.classList.add('active');
    const items = document.querySelectorAll('.service-item');
    items.forEach(item => {
        if (cat === 'semua' || item.getAttribute('data-category') === cat) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}

const serviceLinks = document.querySelectorAll('.service-item');
serviceLinks.forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault();
        const destination = link.href;
        window.setTimeout(() => {
            window.location.href = destination;
        }, 150);
    });
});

// ---- Voice Search for Service Search Bar ----
let voiceSearchRecognition = null;

function startVoiceSearch() {
    const btn = document.getElementById('voiceSearchBtn');
    const label = document.getElementById('voiceSearchLabel');
    const icon = document.getElementById('voiceSearchIcon');
    const input = document.getElementById('serviceSearch');

    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    if (!SpeechRecognition) {
        alert('Browser Anda tidak mendukung fitur pencarian suara. Silakan gunakan Chrome terbaru.');
        return;
    }

    if (voiceSearchRecognition) {
        voiceSearchRecognition.stop();
        voiceSearchRecognition = null;
        resetVoiceSearchBtn();
        return;
    }

    voiceSearchRecognition = new SpeechRecognition();
    voiceSearchRecognition.lang = 'id-ID';
    voiceSearchRecognition.interimResults = true;
    voiceSearchRecognition.maxAlternatives = 1;

    // Active state
    btn.style.background = '#ef4444';
    btn.style.borderColor = '#ef4444';
    btn.style.color = '#fff';
    label.textContent = 'Mendengarkan...';
    icon.innerHTML = '<circle cx="12" cy="12" r="4" fill="currentColor"/><path d="M12 3a3 3 0 0 1 3 3v6a3 3 0 0 1-6 0V6a3 3 0 0 1 3-3Z" stroke="currentColor" fill="none"/>';

    voiceSearchRecognition.onresult = function(event) {
        const transcript = event.results[0][0].transcript;
        input.value = transcript;
        filterServices(transcript);
    };

    voiceSearchRecognition.onend = function() {
        voiceSearchRecognition = null;
        resetVoiceSearchBtn();
    };

    voiceSearchRecognition.onerror = function(e) {
        voiceSearchRecognition = null;
        resetVoiceSearchBtn();
        if (e.error !== 'no-speech' && e.error !== 'aborted') {
            alert('Gagal mendengarkan suara. Pastikan mikrofon diizinkan.');
        }
    };

    voiceSearchRecognition.start();
}

function resetVoiceSearchBtn() {
    const btn = document.getElementById('voiceSearchBtn');
    const label = document.getElementById('voiceSearchLabel');
    const icon = document.getElementById('voiceSearchIcon');
    if (!btn) return;
    btn.style.background = '';
    btn.style.borderColor = '';
    btn.style.color = '';
    label.textContent = 'Ucapkan';
    icon.innerHTML = '<path d="M12 3a3 3 0 0 1 3 3v6a3 3 0 0 1-6 0V6a3 3 0 0 1 3-3Z"/><path d="M19 10a7 7 0 0 1-14 0"/><path d="M12 17v4"/><path d="M8 21h8"/>';
}
</script>
@endsection

@extends('layouts.app')

@section('title', 'Kontak Kami - Dinas Kependudukan dan Pencatatan Sipil')

@section('content')

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="breadcrumb__container">
        <span class="breadcrumb__item"><a href="{{ url('/') }}">Beranda</a></span>
        <span class="breadcrumb__sep">›</span>
        <span class="breadcrumb__item">Kontak</span>
    </div>
</div>

<div class="contact-container-wrap" style="max-width:1200px;margin:0 auto;padding:40px 24px 80px;">

    <!-- Contact Cards Grid -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:20px;margin-bottom:40px;">

        <!-- WhatsApp -->
        <a href="https://wa.me/{{ $kontak['whatsapp'] }}?text={{ urlencode($kontak['pesan_wa'] ?? 'Halo Admin Disdukcapil') }}" target="_blank" class="contact-method-card contact-method-card--wa">
            <div class="contact-method-card__icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                    <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.555 4.116 1.524 5.845L.057 24l6.305-1.654A11.954 11.954 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.851 0-3.587-.5-5.088-1.373l-.362-.214-3.742.981.999-3.648-.235-.374A9.94 9.94 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                </svg>
            </div>
            <div class="contact-method-card__body">
                <div class="contact-method-card__label">WhatsApp</div>
                <div class="contact-method-card__value">{{ $kontak['whatsapp_label'] }}</div>
                <div class="contact-method-card__action">Chat Sekarang →</div>
            </div>
        </a>

        <!-- Instagram -->
        <a href="{{ $kontak['instagram_url'] }}" target="_blank" class="contact-method-card contact-method-card--ig">
            <div class="contact-method-card__icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                </svg>
            </div>
            <div class="contact-method-card__body">
                <div class="contact-method-card__label">Instagram</div>
                <div class="contact-method-card__value">@{{ $kontak['instagram'] }}</div>
                <div class="contact-method-card__action">Lihat Profil →</div>
            </div>
        </a>
    </div>

</div>

@endsection

@section('styles')
<style>
.contact-method-card {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 24px;
    border-radius: 12px;
    text-decoration: none;
    color: #fff;
    transition: transform .25s, box-shadow .25s;
    cursor: pointer;
}
.contact-method-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,.2); }
.contact-method-card--web { background: linear-gradient(135deg, #1e293b, #334155); }
.contact-method-card--wa { background: linear-gradient(135deg, #25d366, #1ebe5a); }
.contact-method-card--ig { background: linear-gradient(135deg, #f58529, #dd2a7b, #8134af); }
.contact-method-card__icon { width: 56px; height: 56px; background: rgba(255,255,255,.2); border-radius: 12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }

.contact-method-card__label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; opacity: .75; margin-bottom: 4px; }
.contact-method-card__value { font-size: 16px; font-weight: 700; margin-bottom: 6px; }
.contact-method-card__action { font-size: 12px; opacity: .8; font-weight: 600; }

@media (max-width: 768px) {
    .contact-container-wrap {
        padding: 20px 14px 80px !important;
    }
    .contact-method-card {
        padding: 16px !important;
        gap: 14px !important;
        border-radius: 14px !important;
    }
    .contact-method-card__icon {
        width: 44px !important;
        height: 44px !important;
    }
}
</style>
@endsection

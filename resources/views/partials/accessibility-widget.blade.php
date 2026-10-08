{{-- 
  PUSAT AKSESIBILITAS WEB INKLUSIF
  Dinas Kependudukan dan Pencatatan Sipil Kab. Cirebon
  Standar WCAG 2.1 Level AA
--}}

<!-- Floating Trigger Pill (Tombol Aksesibilitas Modern) -->
<button type="button" class="a11y-trigger-btn" id="a11yTriggerBtn" title="Pusat Aksesibilitas Inklusif (Tekan CTRL + U)" aria-label="Buka Menu Aksesibilitas Inklusif (Tekan CTRL + U)">
    <div class="a11y-trigger-pulse"></div>
    <span class="a11y-trigger-icon-wrap">
        <svg class="a11y-trigger-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="12" cy="4.5" r="2.3" fill="currentColor"/>
            <path d="M12 7.5v8"/>
            <path d="M6.5 10.5h11"/>
            <path d="M8.5 19.5l3.5-4 3.5 4"/>
        </svg>
    </span>
    <span class="a11y-trigger-text">Aksesibilitas</span>
    <span class="a11y-trigger-counter" id="a11yTriggerCounter" style="display:none;" aria-label="Jumlah fitur aktif">0</span>
</button>

<!-- Background Overlay -->
<div class="a11y-overlay" id="a11yOverlay" aria-hidden="true"></div>

<!-- Accessibility Modal Panel -->
<aside class="a11y-panel" id="a11yPanel" role="dialog" aria-labelledby="a11yTitle" aria-modal="true" aria-hidden="true">
    
    <!-- Top Header -->
    <div class="a11y-header">
        <div class="a11y-header-top">
            <span class="a11y-header-badge">
                <span class="a11y-badge-dot"></span>
                LAYANAN INKLUSIF DISDUKCAPIL
            </span>
            <span class="a11y-header-wcag">WCAG 2.1 AA</span>
        </div>
        <div class="a11y-header-main">
            <div class="a11y-header-title-box">
                <h2 class="a11y-header-title" id="a11yTitle">
                    Pusat Aksesibilitas
                </h2>
                <span class="a11y-kbd-hint"><kbd>Ctrl</kbd> + <kbd>U</kbd></span>
            </div>
            <button type="button" class="a11y-btn-close" id="a11yBtnClose" title="Tutup Menu Aksesibilitas (Esc)" aria-label="Tutup Menu Aksesibilitas">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <p class="a11y-header-desc">
            Sesuaikan kenyamanan tampilan, ukuran teks, dan alat bantu navigasi sesuai kebutuhan Anda.
        </p>
    </div>

    <!-- Quick Utility Bar -->
    <div class="a11y-subbar">
        <div class="a11y-active-indicator" id="a11yActiveIndicator">
            <span class="a11y-active-dot"></span>
            <span id="a11yActiveCount">0 Fitur Aktif</span>
        </div>
        <div class="a11y-oversized-wrap">
            <span class="a11y-subbar-label">Panel Besar</span>
            <label class="a11y-switch" title="Perbesar Tampilan Panel Aksesibilitas">
                <input type="checkbox" id="a11yOversizedToggle" aria-label="Perbesar Ukuran Menu Aksesibilitas">
                <span class="a11y-switch-slider"></span>
            </label>
        </div>
    </div>

    <!-- Category Filter Tabs -->
    <div class="a11y-tabs-nav" role="tablist" aria-label="Kategori Fitur Aksesibilitas">
        <button type="button" class="a11y-tab is-active" data-a11y-filter="all" role="tab" aria-selected="true">
            Semua
        </button>
        <button type="button" class="a11y-tab" data-a11y-filter="visual" role="tab" aria-selected="false">
            👁️ Tampilan
        </button>
        <button type="button" class="a11y-tab" data-a11y-filter="text" role="tab" aria-selected="false">
            🔤 Keterbacaan
        </button>
        <button type="button" class="a11y-tab" data-a11y-filter="nav" role="tab" aria-selected="false">
            🎯 Navigasi
        </button>
    </div>

    <!-- Panel Content Grid (12 Feature Action Tiles) -->
    <div class="a11y-body">
        <div class="a11y-grid" id="a11yGrid">
            
            <!-- 1. Kontras Layar -->
            <button type="button" class="a11y-card" data-a11y-action="contrast" data-category="visual" aria-label="Ubah Kontras Tampilan Layar">
                <div class="a11y-card-icon-wrap a11y-theme-indigo">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 3a9 9 0 0 1 0 18z" fill="currentColor"/>
                    </svg>
                </div>
                <div class="a11y-card-content">
                    <span class="a11y-card-title">Kontras Layar</span>
                    <span class="a11y-card-hint">Terbalik / Gelap / Terang</span>
                </div>
                <span class="a11y-card-pill">Normal</span>
            </button>

            <!-- 2. Kejenuhan Warna -->
            <button type="button" class="a11y-card" data-a11y-action="saturation" data-category="visual" aria-label="Atur Kejenuhan Warna Halaman">
                <div class="a11y-card-icon-wrap a11y-theme-purple">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
                        <path d="M12 2.69v17.31a8 8 0 0 0 5.66-13.65z" fill="currentColor"/>
                    </svg>
                </div>
                <div class="a11y-card-content">
                    <span class="a11y-card-title">Kejenuhan Warna</span>
                    <span class="a11y-card-hint">Monokrom / Redup / Tajam</span>
                </div>
                <span class="a11y-card-pill">Normal</span>
            </button>

            <!-- 3. Sembunyikan Gambar -->
            <button type="button" class="a11y-card" data-a11y-action="hideImages" data-category="visual" aria-label="Sembunyikan Gambar untuk Mengurangi Gangguan Visual">
                <div class="a11y-card-icon-wrap a11y-theme-rose">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="15" rx="3"/>
                        <circle cx="8" cy="9" r="1.5" fill="currentColor"/>
                        <path d="M4 16l4-4 3 3 4-4 4 4"/>
                        <line x1="2" y1="2" x2="22" y2="22" stroke-width="2.2" stroke="currentColor"/>
                    </svg>
                </div>
                <div class="a11y-card-content">
                    <span class="a11y-card-title">Sembunyikan Gambar</span>
                    <span class="a11y-card-hint">Reduksi beban sensorik</span>
                </div>
                <span class="a11y-card-pill">Standar</span>
            </button>

            <!-- 4. Animasi Dijeda -->
            <button type="button" class="a11y-card" data-a11y-action="pauseAnimation" data-category="visual" aria-label="Jeda Animasi dan Gerakan Halaman">
                <div class="a11y-card-icon-wrap a11y-theme-amber">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9"/>
                        <rect x="9" y="8" width="2" height="8" rx="0.5" fill="currentColor"/>
                        <rect x="13" y="8" width="2" height="8" rx="0.5" fill="currentColor"/>
                    </svg>
                </div>
                <div class="a11y-card-content">
                    <span class="a11y-card-title">Jeda Animasi</span>
                    <span class="a11y-card-hint">Hentikan efek bergerak</span>
                </div>
                <span class="a11y-card-pill">Aktif Gerak</span>
            </button>

            <!-- 5. Ukuran Huruf / Teks Lebih Besar -->
            <button type="button" class="a11y-card" data-a11y-action="textScale" data-category="text" aria-label="Perbesar Ukuran Font Tulisan">
                <div class="a11y-card-icon-wrap a11y-theme-blue">
                    <span class="a11y-icon-typography">A<sup>+</sup></span>
                </div>
                <div class="a11y-card-content">
                    <span class="a11y-card-title">Ukuran Huruf</span>
                    <span class="a11y-card-hint">Skala teks hingga 150%</span>
                </div>
                <span class="a11y-card-pill">100%</span>
            </button>

            <!-- 6. Spasi Tulisan -->
            <button type="button" class="a11y-card" data-a11y-action="textSpacing" data-category="text" aria-label="Atur Spasi dan Jarak Huruf">
                <div class="a11y-card-icon-wrap a11y-theme-cyan">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 12h16"/>
                        <path d="M7 8l-3 4 3 4"/>
                        <path d="M17 8l3 4-3 4"/>
                        <line x1="10" y1="6" x2="10" y2="18" stroke-dasharray="2 2"/>
                        <line x1="14" y1="6" x2="14" y2="18" stroke-dasharray="2 2"/>
                    </svg>
                </div>
                <div class="a11y-card-content">
                    <span class="a11y-card-title">Spasi Huruf</span>
                    <span class="a11y-card-hint">Renggangkan jarak teks</span>
                </div>
                <span class="a11y-card-pill">Normal</span>
            </button>

            <!-- 7. Ramah Disleksia -->
            <button type="button" class="a11y-card" data-a11y-action="dyslexiaFont" data-category="text" aria-label="Aktifkan Tipografi Ramah Disleksia">
                <div class="a11y-card-icon-wrap a11y-theme-teal">
                    <span class="a11y-icon-dyslexia">Lex</span>
                </div>
                <div class="a11y-card-content">
                    <span class="a11y-card-title">Font Disleksia</span>
                    <span class="a11y-card-hint">Bentuk huruf mudah dibedakan</span>
                </div>
                <span class="a11y-card-pill">Standar</span>
            </button>

            <!-- 8. Tinggi Baris -->
            <button type="button" class="a11y-card" data-a11y-action="lineHeight" data-category="text" aria-label="Perlebar Jarak Antar Baris Tulisan">
                <div class="a11y-card-icon-wrap a11y-theme-indigo">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 6l2-3 2 3"/>
                        <path d="M6 3v18"/>
                        <path d="M4 18l2 3 2-3"/>
                        <line x1="12" y1="6" x2="21" y2="6"/>
                        <line x1="12" y1="12" x2="21" y2="12"/>
                        <line x1="12" y1="18" x2="21" y2="18"/>
                    </svg>
                </div>
                <div class="a11y-card-content">
                    <span class="a11y-card-title">Tinggi Baris</span>
                    <span class="a11y-card-hint">Perlebar jarak antar paragraf</span>
                </div>
                <span class="a11y-card-pill">Normal</span>
            </button>

            <!-- 9. Perataan Teks -->
            <button type="button" class="a11y-card" data-a11y-action="textAlign" data-category="text" aria-label="Ubah Perataan Teks Halaman">
                <div class="a11y-card-icon-wrap a11y-theme-blue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <line x1="3" y1="11" x2="15" y2="11"/>
                        <line x1="3" y1="16" x2="21" y2="16"/>
                        <line x1="3" y1="21" x2="13" y2="21"/>
                    </svg>
                </div>
                <div class="a11y-card-content">
                    <span class="a11y-card-title">Perataan Teks</span>
                    <span class="a11y-card-hint">Kiri / Tengah / Rata Kanan</span>
                </div>
                <span class="a11y-card-pill">Default</span>
            </button>

            <!-- 10. Sorot Tautan Link -->
            <button type="button" class="a11y-card" data-a11y-action="highlightLinks" data-category="nav" aria-label="Sorot dan Tandai Semua Link / Tautan">
                <div class="a11y-card-icon-wrap a11y-theme-amber">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                    </svg>
                </div>
                <div class="a11y-card-content">
                    <span class="a11y-card-title">Sorot Tautan</span>
                    <span class="a11y-card-hint">Kuning kontras pada setiap link</span>
                </div>
                <span class="a11y-card-pill">Standar</span>
            </button>

            <!-- 11. Kursor & Garis Panduan -->
            <button type="button" class="a11y-card" data-a11y-action="cursorMode" data-category="nav" aria-label="Ubah Ukuran Kursor atau Tampilkan Garis Panduan Membaca">
                <div class="a11y-card-icon-wrap a11y-theme-purple">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="3 3 3 19 8 14 13 21 16 19 11 12 18 12 3 3"/>
                    </svg>
                </div>
                <div class="a11y-card-content">
                    <span class="a11y-card-title">Kursor & Panduan</span>
                    <span class="a11y-card-hint">Kursor besar / Penggaris baca</span>
                </div>
                <span class="a11y-card-pill">Standar</span>
            </button>

            <!-- 12. Keterangan Petunjuk (Tooltips) -->
            <button type="button" class="a11y-card" data-a11y-action="tooltips" data-category="nav" aria-label="Aktifkan Keterangan Petunjuk pada Elemen Interaktif">
                <div class="a11y-card-icon-wrap a11y-theme-emerald">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                        <line x1="12" y1="8" x2="12" y2="12" stroke-width="2.2"/>
                        <circle cx="12" cy="16" r="0.8" fill="currentColor"/>
                    </svg>
                </div>
                <div class="a11y-card-content">
                    <span class="a11y-card-title">Petunjuk Elemen</span>
                    <span class="a11y-card-hint">Panduan teks setiap tombol</span>
                </div>
                <span class="a11y-card-pill">Nonaktif</span>
            </button>

        </div>
    </div>

    <!-- Panel Footer -->
    <div class="a11y-footer">
        <div class="a11y-footer-actions">
            <button type="button" class="a11y-btn-reset" id="a11yBtnReset" aria-label="Atur Ulang Semua Pengaturan Aksesibilitas">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 12a9 9 0 1 0 2.5-6.14L2 9"/>
                    <path d="M2 3v6h6"/>
                </svg>
                <span>Atur Ulang Default</span>
            </button>
            <button type="button" class="a11y-btn-done" id="a11yBtnDone" aria-label="Simpan dan Tutup Menu Aksesibilitas">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                <span>Terapkan & Tutup</span>
            </button>
        </div>
        <div class="a11y-footer-note">
            <span>Dinas Kependudukan dan Pencatatan Sipil Kab. Cirebon</span>
        </div>
    </div>
</aside>

<!-- Reading Guide Bar (Garis Panduan Membaca) -->
<div class="a11y-reading-bar" id="a11yReadingBar" aria-hidden="true"></div>

<!-- Accessible Tooltip Container -->
<div class="a11y-tooltip-box" id="a11yTooltipBox" role="tooltip" aria-hidden="true"></div>

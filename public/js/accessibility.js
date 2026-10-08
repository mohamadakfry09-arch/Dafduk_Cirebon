/**
 * PUSAT AKSESIBILITAS WEB INKLUSIF (WCAG 2.1 AA)
 * Dinas Kependudukan dan Pencatatan Sipil Kab. Cirebon
 * Mendukung Navigasi Inklusif & Ramah Disabilitas
 */

(function () {
    'use strict';

    const STORAGE_KEY = 'disdukcapil_a11y_prefs';

    // Default configuration state
    const defaultState = {
        contrast: 0,       // 0: normal, 1: dark/invert, 2: high yellow/black, 3: high light
        highlightLinks: false,
        textScale: 0,      // 0: normal, 1: +12%, 2: +25%, 3: +38%, 4: +50%
        textSpacing: 0,    // 0: normal, 1: ringan, 2: sedang, 3: lebar
        pauseAnimation: false,
        hideImages: false,
        dyslexiaFont: false,
        cursorMode: 0,     // 0: normal, 1: kursor hitam besar, 2: kursor putih besar, 3: garis panduan baca
        tooltips: false,
        lineHeight: 0,     // 0: normal, 1: 1.8x, 2: 2.2x
        textAlign: 0,      // 0: default, 1: left, 2: center, 3: right, 4: justify
        saturation: 0,     // 0: normal, 1: low sat, 2: mono, 3: high sat
        oversized: false   // Widget kebesaran (Panel Besar)
    };

    let state = Object.assign({}, defaultState);

    // DOM Elements
    let triggerBtn, triggerCounter, overlay, panel, closeBtn, resetBtn, doneBtn, oversizedToggle;
    let readingBar, tooltipBox, srToast, activeCountEl, activeIndicatorEl;

    // Load from localStorage
    function loadSavedState() {
        try {
            const saved = localStorage.getItem(STORAGE_KEY);
            if (saved) {
                const parsed = JSON.parse(saved);
                state = Object.assign({}, defaultState, parsed);
            }
        } catch (e) {
            console.warn('Gagal memuat pengaturan aksesibilitas:', e);
        }
    }

    function saveState() {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
        } catch (e) {
            console.warn('Gagal menyimpan preferensi aksesibilitas:', e);
        }
    }

    // Apply all settings to the <html> and body element
    function applyAllSettings() {
        const root = document.documentElement;

        // 1. Kontras
        root.classList.remove('a11y-contrast-dark', 'a11y-contrast-high', 'a11y-contrast-light');
        if (state.contrast === 1) root.classList.add('a11y-contrast-dark');
        else if (state.contrast === 2) root.classList.add('a11y-contrast-high');
        else if (state.contrast === 3) root.classList.add('a11y-contrast-light');

        // 2. Sorot Tautan
        root.classList.toggle('a11y-highlight-links', !!state.highlightLinks);

        // 3. Teks Lebih Besar
        root.classList.remove('a11y-text-scale-1', 'a11y-text-scale-2', 'a11y-text-scale-3', 'a11y-text-scale-4');
        if (state.textScale > 0) root.classList.add(`a11y-text-scale-${state.textScale}`);

        // 4. Spasi Teks
        root.classList.remove('a11y-spacing-1', 'a11y-spacing-2', 'a11y-spacing-3');
        if (state.textSpacing > 0) root.classList.add(`a11y-spacing-${state.textSpacing}`);

        // 5. Animasi Dijeda
        root.classList.toggle('a11y-pause-animations', !!state.pauseAnimation);

        // 6. Sembunyikan Gambar
        root.classList.toggle('a11y-hide-images', !!state.hideImages);

        // 7. Ramah Disleksia
        root.classList.toggle('a11y-dyslexia', !!state.dyslexiaFont);

        // 8. Kursor & Garis Panduan
        root.classList.remove('a11y-cursor-black', 'a11y-cursor-white', 'a11y-reading-guide');
        if (state.cursorMode === 1) root.classList.add('a11y-cursor-black');
        else if (state.cursorMode === 2) root.classList.add('a11y-cursor-white');
        else if (state.cursorMode === 3) root.classList.add('a11y-reading-guide');

        // 9. Keterangan Alat (Tooltips)
        root.classList.toggle('a11y-tooltips-active', !!state.tooltips);

        // 10. Tinggi Garis
        root.classList.remove('a11y-line-height-1', 'a11y-line-height-2');
        if (state.lineHeight > 0) root.classList.add(`a11y-line-height-${state.lineHeight}`);

        // 11. Perataan Teks
        root.classList.remove('a11y-align-left', 'a11y-align-center', 'a11y-align-right', 'a11y-align-justify');
        if (state.textAlign === 1) root.classList.add('a11y-align-left');
        else if (state.textAlign === 2) root.classList.add('a11y-align-center');
        else if (state.textAlign === 3) root.classList.add('a11y-align-right');
        else if (state.textAlign === 4) root.classList.add('a11y-align-justify');

        // 12. Kejenuhan
        root.classList.remove('a11y-sat-low', 'a11y-sat-mono', 'a11y-sat-high');
        if (state.saturation === 1) root.classList.add('a11y-sat-low');
        else if (state.saturation === 2) root.classList.add('a11y-sat-mono');
        else if (state.saturation === 3) root.classList.add('a11y-sat-high');

        // 13. Panel Besar (Oversized)
        if (panel) {
            panel.classList.toggle('is-oversized', !!state.oversized);
            if (oversizedToggle) oversizedToggle.checked = !!state.oversized;
        }

        updateUIButtons();
    }

    // Update active badges and indicators on the modal cards
    function updateUIButtons() {
        if (!panel) return;

        // Kontras
        updateCard('contrast', state.contrast > 0, [
            'Normal', 'Terbalik', 'Tinggi (Kuning)', 'Terang'
        ][state.contrast], 'Normal');

        // Kejenuhan
        updateCard('saturation', state.saturation > 0, [
            'Normal', 'Redup (40%)', 'Monokrom', 'Tajam (200%)'
        ][state.saturation], 'Normal');

        // Sembunyikan Gambar
        updateCard('hideImages', state.hideImages, 'Sembunyi', 'Standar');

        // Animasi Dijeda
        updateCard('pauseAnimation', state.pauseAnimation, 'Dijeda', 'Aktif Gerak');

        // Teks Lebih Besar
        updateCard('textScale', state.textScale > 0, [
            '100%', '+12%', '+25%', '+38%', '+50%'
        ][state.textScale], '100%');

        // Spasi Teks
        updateCard('textSpacing', state.textSpacing > 0, [
            'Normal', 'Ringan', 'Sedang', 'Lebar'
        ][state.textSpacing], 'Normal');

        // Ramah Disleksia
        updateCard('dyslexiaFont', state.dyslexiaFont, 'Aktif (Lexend)', 'Standar');

        // Tinggi Garis
        updateCard('lineHeight', state.lineHeight > 0, [
            'Normal', '1.8x', '2.2x'
        ][state.lineHeight], 'Normal');

        // Perataan Teks
        updateCard('textAlign', state.textAlign > 0, [
            'Default', 'Rata Kiri', 'Rata Tengah', 'Rata Kanan', 'Rata Kanan-Kiri'
        ][state.textAlign], 'Default');

        // Sorot Tautan
        updateCard('highlightLinks', state.highlightLinks, 'Disorot Kuning', 'Standar');

        // Kursor
        updateCard('cursorMode', state.cursorMode > 0, [
            'Standar', 'Hitam Besar', 'Putih Besar', 'Garis Panduan'
        ][state.cursorMode], 'Standar');

        // Keterangan Alat
        updateCard('tooltips', state.tooltips, 'Aktif', 'Nonaktif');

        // Hitung total fitur aktif
        let activeCount = 0;
        if (state.contrast > 0) activeCount++;
        if (state.highlightLinks) activeCount++;
        if (state.textScale > 0) activeCount++;
        if (state.textSpacing > 0) activeCount++;
        if (state.pauseAnimation) activeCount++;
        if (state.hideImages) activeCount++;
        if (state.dyslexiaFont) activeCount++;
        if (state.cursorMode > 0) activeCount++;
        if (state.tooltips) activeCount++;
        if (state.lineHeight > 0) activeCount++;
        if (state.textAlign > 0) activeCount++;
        if (state.saturation > 0) activeCount++;

        // Update indicator text & badge
        if (activeCountEl) {
            activeCountEl.textContent = `${activeCount} Fitur Aktif`;
        }
        if (activeIndicatorEl) {
            activeIndicatorEl.classList.toggle('has-active', activeCount > 0);
        }

        // Update trigger capsule counter
        if (triggerCounter) {
            if (activeCount > 0) {
                triggerCounter.textContent = activeCount;
                triggerCounter.style.display = 'inline-block';
            } else {
                triggerCounter.style.display = 'none';
            }
        }
    }

    function updateCard(key, isActive, badgeText, defaultText) {
        const card = panel.querySelector(`[data-a11y-action="${key}"]`);
        if (!card) return;

        const pill = card.querySelector('.a11y-card-pill');
        if (isActive) {
            card.classList.add('is-active');
            if (pill) pill.textContent = badgeText;
        } else {
            card.classList.remove('is-active');
            if (pill) pill.textContent = defaultText || 'Normal';
        }
    }

    // Announce action for screen readers and show subtle feedback
    function notify(message) {
        if (!srToast) {
            srToast = document.createElement('div');
            srToast.className = 'a11y-sr-toast';
            srToast.setAttribute('role', 'status');
            srToast.setAttribute('aria-live', 'polite');
            document.body.appendChild(srToast);
        }
        srToast.textContent = message;
        srToast.classList.remove('is-show');
        void srToast.offsetWidth; // reflow
        srToast.classList.add('is-show');
    }

    // Toggle Modal Drawer
    function openPanel() {
        if (!panel || !overlay) return;
        overlay.classList.add('is-open');
        panel.classList.add('is-open');
        panel.setAttribute('aria-hidden', 'false');
        if (closeBtn) closeBtn.focus();
    }

    function closePanel() {
        if (!panel || !overlay) return;
        overlay.classList.remove('is-open');
        panel.classList.remove('is-open');
        panel.setAttribute('aria-hidden', 'true');
        if (triggerBtn) triggerBtn.focus();
    }

    function togglePanel() {
        if (panel && panel.classList.contains('is-open')) {
            closePanel();
        } else {
            openPanel();
        }
    }

    // Reset All Settings
    function resetAll() {
        state = Object.assign({}, defaultState);
        saveState();
        applyAllSettings();
        notify('Semua pengaturan aksesibilitas telah diatur ulang ke default.');
    }

    // Setup interactive handlers
    function initHandlers() {
        // Trigger Button & Counter
        triggerBtn = document.getElementById('a11yTriggerBtn');
        triggerCounter = document.getElementById('a11yTriggerCounter');
        overlay = document.getElementById('a11yOverlay');
        panel = document.getElementById('a11yPanel');
        closeBtn = document.getElementById('a11yBtnClose');
        resetBtn = document.getElementById('a11yBtnReset');
        doneBtn = document.getElementById('a11yBtnDone');
        oversizedToggle = document.getElementById('a11yOversizedToggle');
        readingBar = document.getElementById('a11yReadingBar');
        tooltipBox = document.getElementById('a11yTooltipBox');
        activeCountEl = document.getElementById('a11yActiveCount');
        activeIndicatorEl = document.getElementById('a11yActiveIndicator');

        if (triggerBtn) {
            triggerBtn.addEventListener('click', togglePanel);
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', closePanel);
        }

        if (doneBtn) {
            doneBtn.addEventListener('click', closePanel);
        }

        if (overlay) {
            overlay.addEventListener('click', closePanel);
        }

        if (resetBtn) {
            resetBtn.addEventListener('click', resetAll);
        }

        // Oversized widget switch
        if (oversizedToggle) {
            oversizedToggle.addEventListener('change', function () {
                state.oversized = this.checked;
                saveState();
                applyAllSettings();
                notify(state.oversized ? 'Ukuran panel diperbesar.' : 'Ukuran panel normal.');
            });
        }

        // Category Tab Filter
        if (panel) {
            const tabs = panel.querySelectorAll('[data-a11y-filter]');
            tabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    tabs.forEach(t => {
                        t.classList.remove('is-active');
                        t.setAttribute('aria-selected', 'false');
                    });
                    this.classList.add('is-active');
                    this.setAttribute('aria-selected', 'true');

                    const filter = this.getAttribute('data-a11y-filter');
                    const cards = panel.querySelectorAll('.a11y-card');
                    cards.forEach(card => {
                        const cat = card.getAttribute('data-category');
                        if (filter === 'all' || cat === filter) {
                            card.classList.remove('is-hidden');
                        } else {
                            card.classList.add('is-hidden');
                        }
                    });
                });
            });
        }

        // Card Clicks
        if (panel) {
            panel.addEventListener('click', function (e) {
                const card = e.target.closest('[data-a11y-action]');
                if (!card) return;

                const action = card.getAttribute('data-a11y-action');
                handleCardAction(action);
            });
        }

        // Keyboard Shortcuts (CTRL+U to toggle menu, ESC to close)
        document.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && (e.key === 'u' || e.key === 'U')) {
                e.preventDefault();
                togglePanel();
            } else if (e.key === 'Escape' && panel && panel.classList.contains('is-open')) {
                closePanel();
            }
        });

        // Reading Guide Mouse Tracking
        document.addEventListener('mousemove', function (e) {
            if (state.cursorMode === 3 && readingBar) {
                readingBar.style.top = e.clientY + 'px';
            }
        });

        // Accessible Tooltips on Hover/Focus
        document.addEventListener('mouseover', handleTooltipHover);
        document.addEventListener('focusin', handleTooltipHover);
        document.addEventListener('mouseout', hideTooltip);
        document.addEventListener('focusout', hideTooltip);
    }

    function handleCardAction(action) {
        switch (action) {
            case 'contrast':
                state.contrast = (state.contrast + 1) % 4;
                const contrastNames = ['Normal', 'Kontras Terbalik (Gelap)', 'Kontras Tinggi (Kuning-Hitam)', 'Kontras Terang'];
                notify(`Kontras: ${contrastNames[state.contrast]}`);
                break;

            case 'highlightLinks':
                state.highlightLinks = !state.highlightLinks;
                notify(state.highlightLinks ? 'Sorot tautan diaktifkan.' : 'Sorot tautan dinonaktifkan.');
                break;

            case 'textScale':
                state.textScale = (state.textScale + 1) % 5;
                const scales = ['100% (Normal)', '+12%', '+25%', '+38%', '+50%'];
                notify(`Ukuran teks: ${scales[state.textScale]}`);
                break;

            case 'textSpacing':
                state.textSpacing = (state.textSpacing + 1) % 4;
                const spacings = ['Normal', 'Spasi Ringan', 'Spasi Sedang', 'Spasi Lebar'];
                notify(`Spasi teks: ${spacings[state.textSpacing]}`);
                break;

            case 'pauseAnimation':
                state.pauseAnimation = !state.pauseAnimation;
                notify(state.pauseAnimation ? 'Semua animasi dijeda.' : 'Animasi diaktifkan kembali.');
                break;

            case 'hideImages':
                state.hideImages = !state.hideImages;
                notify(state.hideImages ? 'Gambar disembunyikan.' : 'Gambar ditampilkan kembali.');
                break;

            case 'dyslexiaFont':
                state.dyslexiaFont = !state.dyslexiaFont;
                notify(state.dyslexiaFont ? 'Font ramah disleksia diaktifkan.' : 'Font standar dikembalikan.');
                break;

            case 'cursorMode':
                state.cursorMode = (state.cursorMode + 1) % 4;
                const cursors = ['Kursor Standar', 'Kursor Besar Hitam', 'Kursor Besar Putih', 'Garis Panduan Membaca'];
                notify(`Kursor: ${cursors[state.cursorMode]}`);
                break;

            case 'tooltips':
                state.tooltips = !state.tooltips;
                notify(state.tooltips ? 'Petunjuk elemen diaktifkan.' : 'Petunjuk elemen dinonaktifkan.');
                break;

            case 'lineHeight':
                state.lineHeight = (state.lineHeight + 1) % 3;
                const lineHeights = ['Standar (1.5x)', 'Sedang (1.8x)', 'Tinggi (2.2x)'];
                notify(`Tinggi baris: ${lineHeights[state.lineHeight]}`);
                break;

            case 'textAlign':
                state.textAlign = (state.textAlign + 1) % 5;
                const aligns = ['Standar', 'Rata Kiri', 'Rata Tengah', 'Rata Kanan', 'Rata Kanan-Kiri'];
                notify(`Perataan teks: ${aligns[state.textAlign]}`);
                break;

            case 'saturation':
                state.saturation = (state.saturation + 1) % 4;
                const sats = ['Normal', 'Desaturasi Rendah', 'Monokrom (Hitam-Putih)', 'Kejenuhan Tinggi'];
                notify(`Kejenuhan warna: ${sats[state.saturation]}`);
                break;
        }

        saveState();
        applyAllSettings();
    }

    function handleTooltipHover(e) {
        if (!state.tooltips || !tooltipBox) return;

        // Skip inside accessibility panel
        if (e.target.closest('#a11yPanel') || e.target.closest('#a11yTriggerBtn')) return;

        const target = e.target.closest('a, button, input, select, textarea, img, [role="button"], [title], [aria-label]');
        if (!target) {
            hideTooltip();
            return;
        }

        let tipText = target.getAttribute('aria-label') ||
                      target.getAttribute('title') ||
                      target.getAttribute('alt') ||
                      (target.tagName.toLowerCase() === 'a' ? (target.innerText.trim() || target.href) : '') ||
                      target.innerText.trim();

        if (!tipText) {
            hideTooltip();
            return;
        }

        if (tipText.length > 100) tipText = tipText.substring(0, 97) + '...';

        tooltipBox.textContent = tipText;
        const rect = target.getBoundingClientRect();

        let top = rect.bottom + 8;
        let left = rect.left;

        if (top + 40 > window.innerHeight) {
            top = Math.max(10, rect.top - 40);
        }
        if (left + 220 > window.innerWidth) {
            left = Math.max(10, window.innerWidth - 240);
        }

        tooltipBox.style.top = top + 'px';
        tooltipBox.style.left = left + 'px';
        tooltipBox.classList.add('is-visible');
    }

    function hideTooltip() {
        if (tooltipBox) {
            tooltipBox.classList.remove('is-visible');
        }
    }

    // Auto initialize once DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            loadSavedState();
            initHandlers();
            applyAllSettings();
        });
    } else {
        loadSavedState();
        initHandlers();
        applyAllSettings();
    }
})();

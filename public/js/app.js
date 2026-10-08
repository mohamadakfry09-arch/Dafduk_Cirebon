// Theme mode management
const themeToggle = document.getElementById('themeToggle');
const applyTheme = (mode) => {
    const resolvedMode = mode === 'dark' ? 'dark' : 'light';
    document.documentElement.setAttribute('data-theme', resolvedMode);
    if (themeToggle) {
        const isDark = resolvedMode === 'dark';
        themeToggle.classList.toggle('is-dark', isDark);
        themeToggle.setAttribute('aria-pressed', String(isDark));
    }
    localStorage.setItem('themeMode', resolvedMode);
};

const storedTheme = localStorage.getItem('themeMode');
if (storedTheme) {
    applyTheme(storedTheme);
} else {
    applyTheme('light');
}

if (themeToggle) {
    themeToggle.addEventListener('click', () => {
        const currentTheme = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
        applyTheme(currentTheme === 'dark' ? 'light' : 'dark');
    });
}

// Navbar scroll effect
const navbar = document.getElementById('navbar');
if (navbar) {
    window.addEventListener('scroll', () => {
        if (window.scrollY > 20) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
}

function initializeHomeIntroReveal() {
    const intro = document.getElementById('homeIntroReveal');
    if (!intro || !window.location.pathname.match(/^\/(?:index\.php)?$/)) {
        return;
    }

    const hasSkippedIntro = sessionStorage.getItem('disdukcapil_intro_skipped') === '1';
    if (hasSkippedIntro) {
        intro.classList.add('home-intro-reveal--hidden');
        document.body.classList.remove('intro-active');
        return;
    }

    document.body.classList.add('intro-active');

    const revealIntro = () => {
        intro.classList.add('home-intro-reveal--hidden');
        document.body.classList.remove('intro-active');
        sessionStorage.setItem('disdukcapil_intro_skipped', '1');
    };

    const introArrow = document.querySelector('.home-intro-reveal__arrow');
    introArrow?.addEventListener('click', (event) => {
        event.preventDefault();
        revealIntro();
        setTimeout(() => {
            const target = document.getElementById('services-home');
            target?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 200);
    });

    const handleScrollReveal = () => {
        if (window.scrollY > 24) {
            revealIntro();
            window.removeEventListener('scroll', handleScrollReveal);
        }
    };

    window.addEventListener('scroll', handleScrollReveal, { passive: true });
    window.addEventListener('wheel', () => {
        if (window.scrollY > 0 && !intro.classList.contains('home-intro-reveal--hidden')) {
            revealIntro();
        }
    }, { passive: true });
}

initializeHomeIntroReveal();

// Mobile navbar toggle
const navToggle = document.getElementById('navToggle');
const navMenu = document.getElementById('navMenu');
if (navToggle && navMenu) {
    navToggle.addEventListener('click', () => {
        navMenu.classList.toggle('open');
        const spans = navToggle.querySelectorAll('span');
        navMenu.classList.contains('open')
            ? (spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)',
               spans[1].style.opacity = '0',
               spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)')
            : (spans[0].style.transform = '',
               spans[1].style.opacity = '',
               spans[2].style.transform = '');
    });

    document.addEventListener('click', (e) => {
        if (!navbar.contains(e.target) && navMenu.classList.contains('open')) {
            navMenu.classList.remove('open');
        }
    });
}

function speakPelayananMessage() {
    if (!('speechSynthesis' in window)) {
        return;
    }

    window.speechSynthesis.cancel();
    const message = new SpeechSynthesisUtterance('Disdukcapil Kabupaten Cirebon menyediakan dua puluh dua layanan administrasi kependudukan, pilih layanan yang anda butuhkan.');
    message.lang = 'id-ID';
    message.rate = 1;
    window.speechSynthesis.speak(message);
}

function speakWelcomeMessage() {
    if (!('speechSynthesis' in window)) {
        return;
    }

    const hasWelcomed = sessionStorage.getItem('disdukcapil_welcome_spoken');
    if (hasWelcomed === '1') {
        return;
    }

    window.speechSynthesis.cancel();
    const message = new SpeechSynthesisUtterance('Selamat datang di kanal informasi pelayanan administrasi kependudukan disdukcapil kabupaten cirebon.');
    message.lang = 'id-ID';
    message.rate = 1;
    window.speechSynthesis.speak(message);
    sessionStorage.setItem('disdukcapil_welcome_spoken', '1');
}

function getVoiceCommandRoute(commandText) {
    const normalized = (commandText || '')
        .toLowerCase()
        .replace(/[^a-z0-9\s]/g, ' ')
        .replace(/\s+/g, ' ')
        .trim();

    if (!normalized) return null;

    const routeMap = [
        { keys: ['beranda', 'home', 'menu utama', 'halaman utama'], path: '/' },
        { keys: ['pelayanan', 'layanan', 'menu pelayanan', 'halaman layanan'], path: '/pelayanan' },
        { keys: ['informasi', 'berita', 'berita dan informasi', 'menu informasi'], path: '/informasi' },
        { keys: ['tentang', 'tentang kami'], path: '/tentang' },
        { keys: ['kontak', 'hubungi', 'kontak admin', 'wa admin'], path: '/Kontak' },
        { keys: ['login', 'masuk', 'halaman login'], path: '/login' }
    ];

    const match = routeMap.find(({ keys }) => keys.some((key) => normalized.includes(key)));
    return match ? match.path : null;
}

function handleVoiceNavigationCommand(commandText) {
    const route = getVoiceCommandRoute(commandText);
    if (!route) {
        if ('speechSynthesis' in window) {
            const message = new SpeechSynthesisUtterance('Perintah tidak dikenali. Coba kata kunci seperti pelayanan, informasi, kontak, atau beranda.');
            message.lang = 'id-ID';
            message.rate = 1;
            window.speechSynthesis.cancel();
            window.speechSynthesis.speak(message);
        }
        return;
    }

    if ('speechSynthesis' in window) {
        const message = new SpeechSynthesisUtterance('Membuka halaman ' + route.replace('/', '').replace('Kontak', 'Kontak') + '.');
        message.lang = 'id-ID';
        message.rate = 1;
        window.speechSynthesis.cancel();
        window.speechSynthesis.speak(message);
    }

    window.location.href = route;
}

function initializeVoiceNavigation() {
    const toggleButton = document.getElementById('voiceNavToggle');
    if (!toggleButton) return;

    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    if (!SpeechRecognition) {
        toggleButton.title = 'Navigasi suara tidak didukung di browser ini.';
        toggleButton.disabled = true;
        return;
    }

    const recognition = new SpeechRecognition();
    recognition.lang = 'id-ID';
    recognition.interimResults = false;
    recognition.maxAlternatives = 1;

    let listening = false;

    recognition.onstart = () => {
        listening = true;
        toggleButton.classList.add('is-listening');
        toggleButton.setAttribute('aria-pressed', 'true');
    };

    recognition.onresult = (event) => {
        const transcript = event.results[0][0].transcript;
        handleVoiceNavigationCommand(transcript);
    };

    recognition.onerror = () => {
        toggleButton.classList.remove('is-listening');
        toggleButton.setAttribute('aria-pressed', 'false');
    };

    recognition.onend = () => {
        listening = false;
        toggleButton.classList.remove('is-listening');
        toggleButton.setAttribute('aria-pressed', 'false');
    };

    toggleButton.addEventListener('click', () => {
        if (listening) {
            recognition.stop();
            return;
        }

        recognition.start();
    });
}

initializeVoiceNavigation();

// Read the service message while preserving the navigation action.
document.querySelectorAll('[data-pelayanan-link], a[href="/pelayanan"], a[href="/pelayanan/"]').forEach(link => {
    link.addEventListener('click', (event) => {
        event.preventDefault();
        const destination = link.href;
        window.setTimeout(() => { window.location.href = destination; }, 150);
    });
});

if (window.location.pathname === '/' || window.location.pathname === '/index.php') {
    window.addEventListener('load', () => {
        setTimeout(speakWelcomeMessage, 700);
    });
}

if (window.location.pathname === '/pelayanan' || window.location.pathname === '/pelayanan/') {
    window.addEventListener('load', () => {
        setTimeout(speakPelayananMessage, 350);
    });
}

/* ============================================================
   FITUR ADMIN & LOGIN AUTH MANAGEMENT ENGINE
   ============================================================ */

let globalAdminData = null;

// Get CSRF Token safely
function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

// Admin Login Modal Controls
function openAdminLoginModal() {
    const overlay = document.getElementById('adminLoginModalOverlay');
    if (overlay) {
        overlay.classList.add('active');
        const userIn = document.getElementById('modalUsername');
        if (userIn) userIn.focus();
    }
}

function closeAdminLoginModal() {
    const overlay = document.getElementById('adminLoginModalOverlay');
    if (overlay) overlay.classList.remove('active');
}

function closeAdminLoginModalOnOverlay(e) {
    if (e.target.id === 'adminLoginModalOverlay') {
        closeAdminLoginModal();
    }
}

// Submit Admin Login via AJAX
async function submitAdminLoginAjax(e) {
    e.preventDefault();
    const username = document.getElementById('modalUsername').value;
    const password = document.getElementById('modalPassword').value;
    const alertBox = document.getElementById('adminLoginAlert');

    try {
        const res = await fetch('/admin/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ username, password })
        });

        const data = await res.json();
        if (res.ok && data.success) {
            showAdminToast('🔑 ' + data.message);
            closeAdminLoginModal();
            setTimeout(() => window.location.reload(), 500);
        } else {
            if (alertBox) {
                alertBox.style.display = 'block';
                alertBox.style.background = '#fee2e2';
                alertBox.style.color = '#991b1b';
                alertBox.textContent = data.message || 'Login Admin gagal. Silakan periksa username & password.';
            }
        }
    } catch (err) {
        if (alertBox) {
            alertBox.style.display = 'block';
            alertBox.style.background = '#fee2e2';
            alertBox.style.color = '#991b1b';
            alertBox.textContent = 'Gagal menghubungkan ke server login.';
        }
    }
}

// Logout Admin or Warga via AJAX
async function logoutAdmin() {
    return logoutAnyUser();
}

async function logoutAnyUser() {
    if (!confirm('Apakah Anda yakin ingin keluar (logout)?')) return;

    try {
        const res = await fetch('/auth/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            }
        });

        const data = await res.json();
        if (data.success) {
            showAdminToast('👋 ' + data.message);
            setTimeout(() => window.location.reload(), 500);
        }
    } catch (e) {
        showAdminToast('❌ Gagal melakukan logout', 'error');
    }
}

// Open Admin Modal (Checks Auth Status First)
async function openAdminModal(targetSlug = null) {
    // Check auth status first
    try {
        const authRes = await fetch('/admin/check-auth');
        const authData = await authRes.json();
        if (!authData.logged_in) {
            openAdminLoginModal();
            return;
        }
    } catch (e) {
        console.warn('Auth check failed, opening login modal');
        openAdminLoginModal();
        return;
    }

    const overlay = document.getElementById('adminModalOverlay');
    if (!overlay) return;

    overlay.classList.add('active');

    // Fetch fresh data from backend
    try {
        const response = await fetch('/admin/api/data');
        if (response.ok) {
            globalAdminData = await response.json();
            populateAdminServiceSelects(targetSlug);
        }
    } catch (e) {
        console.error('Failed to load admin services data:', e);
    }
}

function openAdminModalForService(slug) {
    openAdminModal(slug);
    switchAdminTab('persyaratan');
}

function closeAdminModal() {
    const overlay = document.getElementById('adminModalOverlay');
    if (overlay) overlay.classList.remove('active');
}

function closeAdminModalOnOverlay(e) {
    if (e.target.id === 'adminModalOverlay') {
        closeAdminModal();
    }
}

function switchAdminTab(tabName) {
    document.querySelectorAll('.admin-tab-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.admin-tab-content').forEach(c => c.classList.remove('active'));

    if (tabName === 'persyaratan') {
        document.getElementById('tabAdminReq')?.classList.add('active');
        document.getElementById('adminTabContentReq')?.classList.add('active');
    } else if (tabName === 'service') {
        document.getElementById('tabAdminService')?.classList.add('active');
        document.getElementById('adminTabContentService')?.classList.add('active');
    }
}

// Populate service options dropdowns
function populateAdminServiceSelects(targetSlug = null) {
    if (!globalAdminData || !globalAdminData.services) return;

    const reqSelect = document.getElementById('adminServiceSelect');
    const metaSelect = document.getElementById('adminServiceMetaSelect');

    if (!reqSelect || !metaSelect) return;

    reqSelect.innerHTML = '';
    metaSelect.innerHTML = '';

    const pageDetail = document.querySelector('.detail-page');
    const activeSlug = targetSlug || (pageDetail ? pageDetail.getAttribute('data-service-slug') : null);

    globalAdminData.services.forEach(service => {
        const isSelected = activeSlug && activeSlug === service.slug ? 'selected' : '';

        const optReq = document.createElement('option');
        optReq.value = service.slug;
        optReq.textContent = `${service.title} (${service.slug})`;
        if (isSelected) optReq.selected = true;
        reqSelect.appendChild(optReq);

        const optMeta = document.createElement('option');
        optMeta.value = service.slug;
        optMeta.textContent = `${service.title} (${service.slug})`;
        if (isSelected) optMeta.selected = true;
        metaSelect.appendChild(optMeta);
    });

    loadServiceRequirementsToAdmin();
    loadServiceMetaToAdmin();
}

// Load requirements for selected service into Admin Editor
function loadServiceRequirementsToAdmin() {
    const select = document.getElementById('adminServiceSelect');
    const rowsContainer = document.getElementById('adminReqRowsContainer');
    const noticeInput = document.getElementById('adminNoticeInput');

    if (!select || !rowsContainer || !globalAdminData) return;

    const slug = select.value;
    const service = globalAdminData.services.find(s => s.slug === slug);

    rowsContainer.innerHTML = '';

    if (service) {
        if (noticeInput) {
            noticeInput.value = service.notice || '';
        }

        const reqs = service.requirements || [];
        if (reqs.length === 0) {
            addRequirementRowAdmin();
        } else {
            reqs.forEach((r) => {
                addRequirementRowAdmin(r.title, r.desc);
            });
        }
    } else {
        addRequirementRowAdmin();
    }
}

// Add row to requirement editor
function addRequirementRowAdmin(title = '', desc = '') {
    const container = document.getElementById('adminReqRowsContainer');
    if (!container) return;

    const count = container.children.length + 1;

    const row = document.createElement('div');
    row.className = 'admin-req-row';
    row.innerHTML = `
        <div class="admin-req-row-top">
            <span class="admin-req-row-num">${count}</span>
            <input type="text" class="admin-input req-item-title" placeholder="Judul Persyaratan (contoh: Kartu Keluarga)" value="${escapeHtml(title)}">
            <button type="button" class="btn-admin-delete-row" title="Hapus Poin" onclick="removeRequirementRowAdmin(this)">&times;</button>
        </div>
        <textarea class="admin-textarea req-item-desc" rows="2" placeholder="Deskripsi/penjelasan persyaratan (opsional)...">${escapeHtml(desc)}</textarea>
    `;

    container.appendChild(row);
    reindexReqRows();
}

function removeRequirementRowAdmin(btn) {
    const row = btn.closest('.admin-req-row');
    if (row) {
        row.remove();
        reindexReqRows();
    }
}

function reindexReqRows() {
    const rows = document.querySelectorAll('#adminReqRowsContainer .admin-req-row');
    rows.forEach((row, i) => {
        const numSpan = row.querySelector('.admin-req-row-num');
        if (numSpan) numSpan.textContent = i + 1;
    });
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

// Save & Publish Requirements to Public View
async function saveAdminRequirements() {
    const select = document.getElementById('adminServiceSelect');
    const noticeInput = document.getElementById('adminNoticeInput');
    const rows = document.querySelectorAll('#adminReqRowsContainer .admin-req-row');

    if (!select) return;

    const slug = select.value;
    const notice = noticeInput ? noticeInput.value : '';

    const requirements = [];
    rows.forEach(r => {
        const titleInput = r.querySelector('.req-item-title');
        const descInput = r.querySelector('.req-item-desc');
        const title = titleInput ? titleInput.value.trim() : '';
        const desc = descInput ? descInput.value.trim() : '';

        if (title) {
            requirements.push({ title, desc });
        }
    });

    try {
        const res = await fetch('/admin/update-persyaratan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ slug, requirements, notice })
        });

        const data = await res.json();
        if (res.ok && data.success) {
            showAdminToast('✅ ' + data.message);

            if (globalAdminData && globalAdminData.services) {
                const sIndex = globalAdminData.services.findIndex(s => s.slug === slug);
                if (sIndex !== -1) {
                    globalAdminData.services[sIndex] = data.data;
                }
            }

            updatePublicDetailPageDOM(data.data);
            closeAdminModal();
        } else if (data.require_login) {
            showAdminToast('⚠️ ' + data.message, 'error');
            closeAdminModal();
            openAdminLoginModal();
        } else {
            showAdminToast('❌ Gagal memperbarui persyaratan: ' + (data.message || ''), 'error');
        }
    } catch (err) {
        console.error('Error saving requirements:', err);
        showAdminToast('❌ Terjadi kesalahan jaringan', 'error');
    }
}

// Dynamically update public detail page if active
function updatePublicDetailPageDOM(serviceData) {
    const pageDetail = document.querySelector('.detail-page');
    if (!pageDetail) return;

    const pageSlug = pageDetail.getAttribute('data-service-slug');
    if (pageSlug !== serviceData.slug) return;

    const noticeBox = document.getElementById('publicNoticeContainer');
    if (noticeBox) {
        if (serviceData.notice) {
            noticeBox.textContent = serviceData.notice;
            noticeBox.style.display = 'block';
        } else {
            noticeBox.style.display = 'none';
        }
    }

    const reqList = document.getElementById('publicReqList');
    if (reqList) {
        reqList.innerHTML = '';
        if (serviceData.requirements && serviceData.requirements.length > 0) {
            serviceData.requirements.forEach((req, idx) => {
                const item = document.createElement('div');
                item.className = 'detail-req-item';
                item.innerHTML = `
                    <div class="detail-req-num">${idx + 1}</div>
                    <div class="detail-req-content">
                        <div class="detail-req-title">${escapeHtml(req.title)}</div>
                        ${req.desc ? `<div class="detail-req-desc">${escapeHtml(req.desc)}</div>` : ''}
                    </div>
                `;
                reqList.appendChild(item);
            });
        } else {
            reqList.innerHTML = `<div style="padding:24px;text-align:center;color:var(--color-text-muted);">Belum ada persyaratan.</div>`;
        }
    }
}

// Load service metadata to Admin form
function loadServiceMetaToAdmin() {
    const select = document.getElementById('adminServiceMetaSelect');
    if (!select || !globalAdminData) return;

    const service = globalAdminData.services.find(s => s.slug === select.value);
    if (!service) return;

    const titleIn = document.getElementById('adminMetaTitle');
    const tagIn = document.getElementById('adminMetaTag');
    const descIn = document.getElementById('adminMetaDesc');
    const statusIn = document.getElementById('adminMetaApprovalStatus');
    const acceptedTitleIn = document.getElementById('adminMetaAcceptedTitle');
    const acceptedMessageIn = document.getElementById('adminMetaAcceptedMessage');
    const rejectedTitleIn = document.getElementById('adminMetaRejectedTitle');
    const rejectedMessageIn = document.getElementById('adminMetaRejectedMessage');

    if (titleIn) titleIn.value = service.title || '';
    if (tagIn) tagIn.value = service.tag || '';
    if (descIn) descIn.value = service.desc || '';
    if (statusIn) statusIn.value = service.approval?.default_status || 'accepted';
    if (acceptedTitleIn) acceptedTitleIn.value = service.approval?.accepted_title || 'Permohonan Diterima';
    if (acceptedMessageIn) acceptedMessageIn.value = service.approval?.accepted_message || 'Terima kasih sudah mendaftarkan pengajuan permohonan jemput bola. Permohonan di terima. Team kelingan adminduk akan segera ke tempat anda.';
    if (rejectedTitleIn) rejectedTitleIn.value = service.approval?.rejected_title || 'Mohon Maaf Pengajuan Ditolak';
    if (rejectedMessageIn) rejectedMessageIn.value = service.approval?.rejected_message || 'Mohon maaf pengajuan di tolak.';
}

// Save Service Metadata
async function saveAdminServiceMeta() {
    const select = document.getElementById('adminServiceMetaSelect');
    if (!select) return;

    const slug = select.value;
    const title = document.getElementById('adminMetaTitle').value;
    const tag = document.getElementById('adminMetaTag').value;
    const desc = document.getElementById('adminMetaDesc').value;
    const approval = {
        default_status: document.getElementById('adminMetaApprovalStatus').value,
        accepted_title: document.getElementById('adminMetaAcceptedTitle').value,
        accepted_message: document.getElementById('adminMetaAcceptedMessage').value,
        rejected_title: document.getElementById('adminMetaRejectedTitle').value,
        rejected_message: document.getElementById('adminMetaRejectedMessage').value
    };

    try {
        const res = await fetch('/admin/update-service', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ slug, title, tag, desc, approval })
        });

        const data = await res.json();
        if (res.ok && data.success) {
            showAdminToast('⚙️ ' + data.message);
            closeAdminModal();
            setTimeout(() => window.location.reload(), 600);
        } else if (data.require_login) {
            showAdminToast('⚠️ ' + data.message, 'error');
            closeAdminModal();
            openAdminLoginModal();
        }
    } catch (e) {
        showAdminToast('❌ Gagal memperbarui metadata layanan', 'error');
    }
}

// Reset All Data
async function resetAllAdminData() {
    if (!confirm('Apakah Anda yakin ingin mengembalikan seluruh data persyaratan & layanan ke versi awal?')) return;

    try {
        const res = await fetch('/admin/reset-data', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            }
        });

        const data = await res.json();
        if (res.ok && data.success) {
            showAdminToast('🔄 Data berhasil direset!');
            closeAdminModal();
            setTimeout(() => window.location.reload(), 600);
        } else if (data.require_login) {
            showAdminToast('⚠️ ' + data.message, 'error');
            closeAdminModal();
            openAdminLoginModal();
        }
    } catch (e) {
        showAdminToast('❌ Gagal mereset data', 'error');
    }
}

// Toast Notification
function showAdminToast(message, type = 'success') {
    const container = document.getElementById('adminToastContainer');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = 'admin-toast';
    toast.textContent = message;

    if (type === 'error') {
        toast.style.borderLeftColor = '#dc2626';
    }

    container.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(10px)';
        toast.style.transition = 'all 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3500);
}

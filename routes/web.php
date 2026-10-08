<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelayananController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentController;

// Beranda
Route::get('/', [PelayananController::class, 'welcome']);

// Pelayanan
Route::get('/pelayanan', [PelayananController::class, 'index']);
Route::get('/pelayanan/{slug}', [PelayananController::class, 'detail']);

// Halaman Konten Publik
Route::get('/informasi', [ContentController::class, 'informasi']);
Route::get('/berita/{id}', [ContentController::class, 'beritaDetail'])->name('berita.detail');
Route::get('/tentang', [ContentController::class, 'tentang']);
Route::get('/Kontak', [ContentController::class, 'Kontak']);

// Placeholder halaman lain
Route::get('/syarat-ketentuan', [PelayananController::class, 'welcome']);
Route::get('/kebijakan-privasi', [PelayananController::class, 'welcome']);
Route::get('/faq', [PelayananController::class, 'welcome']);

// Auth Routes Warga (Registrasi & Login Akun Email untuk Pelayanan Jemput Bola - Bentuk Seperti Login Admin)
Route::get('/pelayanan/jemput-bola/login', [AuthController::class, 'showWargaLoginPage'])->name('warga.login.page');
Route::get('/pelayanan/jemput-bola/register', [AuthController::class, 'showWargaLoginPage'])->name('warga.register.page');
Route::post('/pelayanan/jemput-bola/login', [AuthController::class, 'loginWarga']);
Route::post('/pelayanan/jemput-bola/register', [AuthController::class, 'registerWarga']);
Route::get('/warga/login', [AuthController::class, 'showWargaLoginPage']);
Route::post('/pelayanan/jemput-bola/google-login', [AuthController::class, 'loginGoogle'])->name('warga.google.login');
Route::post('/auth/warga/register', [AuthController::class, 'registerWarga'])->name('warga.register');
Route::post('/auth/warga/login', [AuthController::class, 'loginWarga'])->name('warga.login');
Route::post('/auth/warga/logout', [AuthController::class, 'logoutWarga'])->name('warga.logout');

// Auth Routes - Hanya Login Admin (Login Masyarakat Ditiadakan)
Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
Route::get('/register', fn() => redirect('/login'))->name('register');
Route::post('/auth/logout', [AdminController::class, 'logout']);
Route::get('/auth/check', [AdminController::class, 'checkAuth']);

// Admin Auth Routes
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::get('/admin/check-auth', [AdminController::class, 'checkAuth']);

// Admin Dashboard & Panel Dedicated Views
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/services', [AdminController::class, 'servicesIndex'])->name('admin.services');
Route::get('/admin/services/edit/{slug}', [AdminController::class, 'editService'])->name('admin.services.edit');
Route::get('/admin/pengaturan-akun', [AdminController::class, 'pengaturanAkun'])->name('admin.pengaturan-akun');
Route::post('/admin/pengaturan-akun', [AdminController::class, 'updatePengaturanAkun'])->name('admin.pengaturan-akun.update');

// Admin Content Management (Berita, Tentang, Kontak)
Route::get('/admin/berita', [ContentController::class, 'adminBeritaIndex'])->name('admin.berita');
Route::get('/admin/berita/tambah', [ContentController::class, 'adminBeritaCreate'])->name('admin.berita.create');
Route::get('/admin/berita/edit/{id}', [ContentController::class, 'adminBeritaEdit'])->name('admin.berita.edit');
Route::get('/admin/tentang', [ContentController::class, 'adminTentang'])->name('admin.tentang');
Route::get('/admin/kontak', [ContentController::class, 'adminKontak'])->name('admin.kontak');

// Admin Content API
Route::post('/admin/api/berita/save', [ContentController::class, 'apiSaveBerita']);
Route::post('/admin/api/berita/upload-foto', [ContentController::class, 'apiUploadFoto']);
Route::post('/admin/api/berita/delete', [ContentController::class, 'apiDeleteBerita']);
Route::post('/admin/api/tentang/save', [ContentController::class, 'apiSaveTentang']);
Route::post('/admin/api/tentang/upload-foto', [ContentController::class, 'apiUploadFotoTentang']);
Route::post('/admin/api/kontak/save', [ContentController::class, 'apiSaveKontak']);

// Admin Service API & Management Routes
Route::get('/admin/api/data', [AdminController::class, 'getServicesData']);
Route::post('/admin/update-persyaratan', [AdminController::class, 'updatePersyaratan']);
Route::post('/admin/add-persyaratan', [AdminController::class, 'addPersyaratan']);
Route::post('/admin/delete-persyaratan', [AdminController::class, 'deletePersyaratan']);
Route::post('/admin/update-service', [AdminController::class, 'updateService']);
Route::post('/admin/reset-data', [AdminController::class, 'resetData']);

// Submission Pelayanan Jemput Bola (Warga)
Route::post('/pelayanan/jemput-bola/submit', [PelayananController::class, 'submitJemputBola'])->name('jemput-bola.submit');

// Admin Khusus Jemput Bola (Edit Semua Fitur, Riwayat Permohonan, Cetak Formulir & Dokumen)
Route::get('/admin/jemput-bola', [AdminController::class, 'jemputBolaIndex'])->name('admin.jemput-bola');
Route::post('/admin/jemput-bola/update-features', [AdminController::class, 'updateJemputBolaFeatures'])->name('admin.jemput-bola.update-features');
Route::post('/admin/jemput-bola/update-status', [AdminController::class, 'updateSubmissionStatus'])->name('admin.jemput-bola.update-status');
Route::post('/admin/jemput-bola/delete-submission', [AdminController::class, 'deleteSubmission'])->name('admin.jemput-bola.delete-submission');
Route::post('/admin/jemput-bola/mark-checked', [AdminController::class, 'markSubmissionChecked'])->name('admin.jemput-bola.mark-checked');
Route::post('/admin/jemput-bola/mark-printed', [AdminController::class, 'markSubmissionPrinted'])->name('admin.jemput-bola.mark-printed');
Route::get('/admin/jemput-bola/cetak/{id}', [AdminController::class, 'cetakFormulirJemputBola'])->name('admin.jemput-bola.cetak');
Route::get('/admin/jemput-bola/dokumen/{id}', [AdminController::class, 'dokumenPersyaratanJemputBola'])->name('admin.jemput-bola.dokumen');


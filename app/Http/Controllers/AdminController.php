<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Services\ServiceRepository;
use App\Services\JemputBolaRepository;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        if (session('is_admin')) {
            return redirect('/admin/dashboard');
        }
        return view('admin.login');
    }

    public function dashboard()
    {
        if (!session('is_admin')) {
            return redirect('/admin/login');
        }
        $data = ServiceRepository::getAllData();
        return view('admin.dashboard', [
            'services' => $data['services'] ?? [],
            'announcement' => $data['announcement'] ?? ''
        ]);
    }

    public function servicesIndex()
    {
        if (!session('is_admin')) {
            return redirect('/admin/login');
        }
        $data = ServiceRepository::getAllData();
        return view('admin.services.index', [
            'services' => $data['services'] ?? []
        ]);
    }

    public function editService($slug)
    {
        if (!session('is_admin')) {
            return redirect('/admin/login');
        }
        $service = ServiceRepository::getServiceBySlug($slug);
        return view('admin.services.edit', [
            'service' => $service
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = trim($request->input('username'));
        $password = trim($request->input('password'));

        $admin = self::getAdminAccount();

        // Cek username (mendukung username yang telah diedit admin atau username default)
        $isUsernameMatch = (strtolower($username) === strtolower($admin['username']))
            || in_array(strtolower($username), ['admin', 'admin@disdukcapil.go.id', 'disdukcapil']);

        // Cek password (mendukung password baru yang di-hash atau password default untuk tes)
        $isPasswordMatch = Hash::check($password, $admin['password'])
            || in_array($password, ['admin', 'admin123', 'disdukcapil2026']);

        if ($isUsernameMatch && $isPasswordMatch) {
            session([
                'is_admin' => true,
                'admin_username' => $admin['name'] ?? 'Administrator Disdukcapil',
                'admin_user_login' => $admin['username'],
                'admin_login_at' => now()->format('Y-m-d H:i:s')
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login Admin berhasil! Selamat datang, ' . ($admin['name'] ?? 'Administrator') . '.',
                    'redirect' => '/admin/dashboard'
                ]);
            }

            return redirect('/admin/dashboard')->with('success', 'Selamat datang di Panel Admin Disdukcapil!');
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password Admin salah.'
            ], 401);
        }

        return back()->withErrors(['login' => 'Username atau password Admin salah.']);
    }

    public function logout(Request $request)
    {
        session()->forget(['is_admin', 'admin_username', 'admin_login_at']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Anda telah berhasil keluar dari akun Admin.'
            ]);
        }

        return redirect('/')->with('info', 'Anda telah logout.');
    }

    public function checkAuth()
    {
        return response()->json([
            'logged_in' => (bool) session('is_admin'),
            'username' => session('admin_username', 'Administrator'),
            'login_at' => session('admin_login_at', '')
        ]);
    }

    public function getServicesData()
    {
        return response()->json(ServiceRepository::getAllData());
    }

    public function updatePersyaratan(Request $request)
    {
        if (!session('is_admin')) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak. Anda harus login sebagai Admin terlebih dahulu.', 'require_login' => true], 401);
        }

        $request->validate([
            'slug' => 'required|string',
            'requirements' => 'required|array',
            'notice' => 'nullable|string',
        ]);

        $slug = $request->input('slug');
        $requirements = $request->input('requirements');
        $notice = $request->input('notice');

        // Re-index requirement IDs cleanly
        $cleanReqs = [];
        $id = 1;
        foreach ($requirements as $req) {
            if (!empty($req['title'])) {
                $cleanReqs[] = [
                    'id' => $id++,
                    'title' => trim($req['title']),
                    'desc' => trim($req['desc'] ?? '')
                ];
            }
        }

        ServiceRepository::updatePersyaratan($slug, $cleanReqs, $notice);

        return response()->json([
            'success' => true,
            'message' => 'Persyaratan berhasil diperbarui dan dipublikasikan!',
            'data' => ServiceRepository::getServiceBySlug($slug)
        ]);
    }

    public function addPersyaratan(Request $request)
    {
        if (!session('is_admin')) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak. Silakan login sebagai Admin terlebih dahulu.', 'require_login' => true], 401);
        }

        $request->validate([
            'slug' => 'required|string',
            'title' => 'required|string',
            'desc' => 'nullable|string',
        ]);

        $slug = $request->input('slug');
        $service = ServiceRepository::getServiceBySlug($slug);

        $reqs = $service['requirements'] ?? [];
        $nextId = count($reqs) + 1;

        $reqs[] = [
            'id' => $nextId,
            'title' => trim($request->input('title')),
            'desc' => trim($request->input('desc', ''))
        ];

        ServiceRepository::updatePersyaratan($slug, $reqs);

        return response()->json([
            'success' => true,
            'message' => 'Persyaratan baru berhasil ditambahkan!',
            'data' => ServiceRepository::getServiceBySlug($slug)
        ]);
    }

    public function deletePersyaratan(Request $request)
    {
        if (!session('is_admin')) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak. Silakan login sebagai Admin terlebih dahulu.', 'require_login' => true], 401);
        }

        $request->validate([
            'slug' => 'required|string',
            'index' => 'required|integer',
        ]);

        $slug = $request->input('slug');
        $index = $request->input('index');
        $service = ServiceRepository::getServiceBySlug($slug);

        $reqs = $service['requirements'] ?? [];
        if (isset($reqs[$index])) {
            array_splice($reqs, $index, 1);
            
            foreach ($reqs as $k => &$r) {
                $r['id'] = $k + 1;
            }

            ServiceRepository::updatePersyaratan($slug, $reqs);
        }

        return response()->json([
            'success' => true,
            'message' => 'Persyaratan berhasil dihapus!',
            'data' => ServiceRepository::getServiceBySlug($slug)
        ]);
    }

    public function updateService(Request $request)
    {
        if (!session('is_admin')) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak. Silakan login sebagai Admin terlebih dahulu.', 'require_login' => true], 401);
        }

        $request->validate([
            'slug' => 'required|string',
            'title' => 'required|string',
            'category' => 'nullable|string',
            'tag' => 'nullable|string',
            'desc' => 'nullable|string',
            'notice' => 'nullable|string',
            'approval' => 'nullable|array',
        ]);

        $slug = $request->input('slug');
        $existing = ServiceRepository::getServiceBySlug($slug);
        $approval = $request->input('approval', $existing['approval'] ?? []);

        $updated = array_merge($existing, [
            'title' => $request->input('title'),
            'category' => $request->input('category', $existing['category'] ?? 'kependudukan'),
            'tag' => strtoupper($request->input('tag', $existing['tag'] ?? 'KEPENDUDUKAN')),
            'desc' => $request->input('desc', $existing['desc'] ?? ''),
            'notice' => $request->input('notice', $existing['notice'] ?? ''),
            'approval' => is_array($approval) ? $approval : ($existing['approval'] ?? [])
        ]);

        ServiceRepository::updateServiceFull($slug, $updated);

        return response()->json([
            'success' => true,
            'message' => 'Layanan berhasil diperbarui!',
            'data' => $updated
        ]);
    }

    public function resetData()
    {
        if (!session('is_admin')) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak. Silakan login sebagai Admin terlebih dahulu.', 'require_login' => true], 401);
        }

        $default = ServiceRepository::getDefaultData();
        ServiceRepository::saveData($default);

        return response()->json([
            'success' => true,
            'message' => 'Semua data telah dikembalikan ke pengaturan awal pabrik!'
        ]);
    }

    // ==========================================
    // KHUSUS ADMIN JEMPUT BOLA (FITUR & RIWAYAT)
    // ==========================================

    public function jemputBolaIndex(Request $request)
    {
        if (!session('is_admin')) {
            return redirect('/admin/login');
        }

        $service = ServiceRepository::getServiceBySlug('jemput-bola');
        $submissions = JemputBolaRepository::getAllSubmissions();

        // Calculate statistics
        $stats = [
            'total' => count($submissions),
            'menunggu' => count(array_filter($submissions, fn($s) => ($s['status'] ?? '') === 'menunggu')),
            'disetujui' => count(array_filter($submissions, fn($s) => ($s['status'] ?? '') === 'disetujui')),
            'ditolak' => count(array_filter($submissions, fn($s) => ($s['status'] ?? '') === 'ditolak')),
            'selesai' => count(array_filter($submissions, fn($s) => ($s['status'] ?? '') === 'selesai')),
        ];

        return view('admin.jemput_bola.index', compact('service', 'submissions', 'stats'));
    }

    public function updateJemputBolaFeatures(Request $request)
    {
        if (!session('is_admin')) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak. Silakan login sebagai Admin terlebih dahulu.'], 401);
        }

        $existing = ServiceRepository::getServiceBySlug('jemput-bola');

        $requirements = $request->input('requirements', []);
        $cleanReqs = [];
        $idReq = 1;
        if (is_array($requirements)) {
            foreach ($requirements as $r) {
                if (!empty($r['title'])) {
                    $cleanReqs[] = [
                        'id' => $idReq++,
                        'title' => trim($r['title']),
                        'desc' => trim($r['desc'] ?? '')
                    ];
                }
            }
        }

        $procedures = $request->input('procedures', []);
        $cleanProcs = [];
        $idProc = 1;
        if (is_array($procedures)) {
            foreach ($procedures as $p) {
                if (!empty($p['title'])) {
                    $cleanProcs[] = [
                        'id' => $idProc++,
                        'title' => trim($p['title']),
                        'desc' => trim($p['desc'] ?? '')
                    ];
                }
            }
        }

        $information = $request->input('information', []);
        $cleanInfos = [];
        $idInfo = 1;
        if (is_array($information)) {
            foreach ($information as $info) {
                if (!empty($info['title'])) {
                    $cleanInfos[] = [
                        'id' => $idInfo++,
                        'title' => trim($info['title']),
                        'desc' => trim($info['desc'] ?? '')
                    ];
                }
            }
        }

        $approval = [
            'default_status' => $request->input('approval_default_status', 'pending'),
            'pending_title' => $request->input('approval_pending_title', 'Dalam Proses Persetujuan'),
            'pending_message' => $request->input('approval_pending_message', 'Terima kasih sudah mendaftarkan permohonan jemput bola. Mohon tunggu proses persetujuan dari admin.'),
            'accepted_title' => $request->input('approval_accepted_title', 'Persetujuan Diterima'),
            'accepted_message' => $request->input('approval_accepted_message', 'Pengajuan Anda telah disetujui dan akan diproses lebih lanjut oleh admin.'),
            'rejected_title' => $request->input('approval_rejected_title', 'Pengajuan Tidak Disetujui'),
            'rejected_message' => $request->input('approval_rejected_message', 'Mohon maaf, pengajuan Anda belum dapat disetujui pada saat ini.'),
        ];

        $updated = array_merge($existing, [
            'title' => $request->input('title', $existing['title'] ?? 'Jemput Bola'),
            'category' => $request->input('category', $existing['category'] ?? 'kependudukan'),
            'tag' => strtoupper($request->input('tag', $existing['tag'] ?? 'KEPENDUDUKAN')),
            'desc' => $request->input('desc', $existing['desc'] ?? ''),
            'notice' => $request->input('notice', $existing['notice'] ?? ''),
            'requirements' => count($cleanReqs) > 0 ? $cleanReqs : ($existing['requirements'] ?? []),
            'procedures' => count($cleanProcs) > 0 ? $cleanProcs : ($existing['procedures'] ?? []),
            'information' => count($cleanInfos) > 0 ? $cleanInfos : ($existing['information'] ?? []),
            'approval' => $approval
        ]);

        ServiceRepository::updateServiceFull('jemput-bola', $updated);

        return response()->json([
            'success' => true,
            'message' => 'Seluruh fitur Layanan Jemput Bola berhasil diperbarui!',
            'data' => $updated
        ]);
    }

    public function updateSubmissionStatus(Request $request)
    {
        if (!session('is_admin')) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 401);
        }

        $request->validate([
            'id' => 'required|string',
            'status' => 'required|in:menunggu,disetujui,ditolak,selesai',
            'catatan_admin' => 'nullable|string'
        ]);

        $id = $request->input('id');
        $status = $request->input('status');
        $catatan = $request->input('catatan_admin', '');

        $updated = JemputBolaRepository::updateStatus($id, $status, $catatan);

        if (!$updated) {
            return response()->json(['success' => false, 'message' => 'Permohonan tidak ditemukan.'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => "Status permohonan {$id} berhasil diubah menjadi: " . strtoupper($status),
            'submission' => JemputBolaRepository::getSubmissionById($id)
        ]);
    }

    public function deleteSubmission(Request $request)
    {
        if (!session('is_admin')) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 401);
        }

        $id = $request->input('id');
        JemputBolaRepository::deleteSubmission($id);

        return response()->json([
            'success' => true,
            'message' => "Data permohonan {$id} berhasil dihapus dari riwayat."
        ]);
    }

    public function markSubmissionChecked(Request $request)
    {
        if (!session('is_admin')) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 401);
        }

        $id = $request->input('id');
        JemputBolaRepository::markAsOpened($id);

        return response()->json([
            'success' => true,
            'message' => "Permohonan {$id} ditandai sudah dibuka dan dicek.",
            'submission' => JemputBolaRepository::getSubmissionById($id)
        ]);
    }

    public function markSubmissionPrinted(Request $request)
    {
        if (!session('is_admin')) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 401);
        }

        $id = $request->input('id');
        JemputBolaRepository::markAsPrinted($id);

        return response()->json([
            'success' => true,
            'message' => "Permohonan {$id} ditandai sudah dicetak.",
            'submission' => JemputBolaRepository::getSubmissionById($id)
        ]);
    }

    public function cetakFormulirJemputBola($id)
    {
        if (!session('is_admin')) {
            return redirect('/admin/login');
        }

        // Tandai permohonan sudah dibuka & dicetak oleh admin
        JemputBolaRepository::markAsPrinted($id);
        $submission = JemputBolaRepository::getSubmissionById($id);

        if (!$submission) {
            return abort(404, 'Data permohonan tidak ditemukan.');
        }

        return view('admin.jemput_bola.cetak_formulir', compact('submission'));
    }

    public function dokumenPersyaratanJemputBola($id)
    {
        if (!session('is_admin')) {
            return redirect('/admin/login');
        }

        // Tandai permohonan sudah dibuka oleh admin
        JemputBolaRepository::markAsOpened($id);
        $submission = JemputBolaRepository::getSubmissionById($id);

        if (!$submission) {
            return abort(404, 'Data permohonan tidak ditemukan.');
        }

        return view('admin.jemput_bola.dokumen_persyaratan', compact('submission'));
    }

    // ==========================================
    // PENGATURAN AKUN ADMIN (EDIT USERNAME & PASSWORD)
    // ==========================================

    public static function getAdminAccount()
    {
        $path = storage_path('app/admin_account.json');
        if (!File::exists($path)) {
            $default = [
                'username' => 'admin',
                'name' => 'Administrator Disdukcapil',
                'password' => bcrypt('admin'),
                'updated_at' => now()->format('Y-m-d H:i:s')
            ];
            File::ensureDirectoryExists(dirname($path));
            File::put($path, json_encode($default, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            return $default;
        }

        $content = File::get($path);
        $data = json_decode($content, true);
        if (!is_array($data) || empty($data['username'])) {
            $default = [
                'username' => 'admin',
                'name' => 'Administrator Disdukcapil',
                'password' => bcrypt('admin'),
                'updated_at' => now()->format('Y-m-d H:i:s')
            ];
            File::put($path, json_encode($default, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            return $default;
        }

        return $data;
    }

    public static function saveAdminAccount($data)
    {
        $path = storage_path('app/admin_account.json');
        File::ensureDirectoryExists(dirname($path));
        File::put($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function pengaturanAkun()
    {
        if (!session('is_admin')) {
            return redirect('/admin/login');
        }

        $admin = self::getAdminAccount();
        return view('admin.pengaturan_akun', compact('admin'));
    }

    public function updatePengaturanAkun(Request $request)
    {
        if (!session('is_admin')) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 401);
        }

        $request->validate([
            'username' => 'required|string|min:3|max:50',
            'name' => 'nullable|string|max:100',
            'new_password' => 'nullable|string|min:4',
            'confirm_password' => 'nullable|same:new_password',
        ]);

        $admin = self::getAdminAccount();
        $newUsername = trim($request->input('username'));
        $newName = trim($request->input('name', $admin['name'] ?? 'Administrator Disdukcapil'));
        $newPassword = $request->input('new_password');

        $admin['username'] = $newUsername;
        $admin['name'] = $newName ?: 'Administrator Disdukcapil';

        if (!empty($newPassword)) {
            $admin['password'] = Hash::make($newPassword);
        }

        $admin['updated_at'] = now()->format('Y-m-d H:i:s');
        self::saveAdminAccount($admin);

        // Update active session
        session([
            'admin_username' => $admin['name'],
            'admin_user_login' => $admin['username'],
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Username dan password Admin berhasil diperbarui!',
                'admin' => [
                    'username' => $admin['username'],
                    'name' => $admin['name']
                ]
            ]);
        }

        return back()->with('success', 'Username dan password Admin berhasil diperbarui!');
    }
}

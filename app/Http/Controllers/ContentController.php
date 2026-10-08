<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ContentRepository;
use App\Services\ServiceRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    // ===========================
    // HALAMAN PUBLIK
    // ===========================

    public function informasi()
    {
        $announcement = ServiceRepository::getAnnouncement();
        $berita = ContentRepository::getBerita();
        // Hanya tampilkan yang published
        $berita = array_values(array_filter($berita, fn($b) => $b['published'] ?? true));
        // Urutkan terbaru dulu
        usort($berita, fn($a, $b) => strcmp($b['created_at'], $a['created_at']));
        return view('informasi', compact('announcement', 'berita'));
    }

    public function beritaDetail($id)
    {
        $announcement = ServiceRepository::getAnnouncement();
        $artikel = ContentRepository::getBeritaById($id);
        if (!$artikel) abort(404);
        $semuaBerita = ContentRepository::getBerita();
        $beritaLain = array_values(array_filter($semuaBerita, fn($b) => $b['id'] != $id && ($b['published'] ?? true)));
        $beritaLain = array_slice($beritaLain, 0, 3);
        return view('berita-detail', compact('announcement', 'artikel', 'beritaLain'));
    }

    public function tentang()
    {
        $announcement = ServiceRepository::getAnnouncement();
        $tentang = ContentRepository::getTentang();
        return view('tentang', compact('announcement', 'tentang'));
    }

    public function kontak()
    {
        $announcement = ServiceRepository::getAnnouncement();
        $kontak = ContentRepository::getKontak();
        return view('kontak', compact('announcement', 'kontak'));
    }

    // ===========================
    // ADMIN PANEL VIEWS
    // ===========================

    public function adminBeritaIndex()
    {
        if (!session('is_admin')) return redirect('/admin/login');
        $berita = ContentRepository::getBerita();
        usort($berita, fn($a, $b) => strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''));
        return view('admin.content.berita-index', compact('berita'));
    }

    public function adminBeritaCreate()
    {
        if (!session('is_admin')) return redirect('/admin/login');
        return view('admin.content.berita-form', ['artikel' => null, 'mode' => 'create']);
    }

    public function adminBeritaEdit($id)
    {
        if (!session('is_admin')) return redirect('/admin/login');
        $artikel = ContentRepository::getBeritaById($id);
        if (!$artikel) abort(404);
        return view('admin.content.berita-form', ['artikel' => $artikel, 'mode' => 'edit']);
    }

    public function adminTentang()
    {
        if (!session('is_admin')) return redirect('/admin/login');
        $tentang = ContentRepository::getTentang();
        return view('admin.content.tentang', compact('tentang'));
    }

    public function adminKontak()
    {
        if (!session('is_admin')) return redirect('/admin/login');
        $kontak = ContentRepository::getKontak();
        return view('admin.content.kontak', compact('kontak'));
    }

    // ===========================
    // ADMIN API / POST HANDLERS
    // ===========================

    public function apiSaveBerita(Request $request)
    {
        if (!session('is_admin')) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 401);
        }

        $request->validate([
            'judul' => 'required|string|max:300',
            'kategori' => 'required|string',
            'ringkasan' => 'required|string',
            'isi' => 'required|string',
        ]);

        $data = [
            'judul' => $request->input('judul'),
            'kategori' => $request->input('kategori'),
            'ringkasan' => $request->input('ringkasan'),
            'isi' => $request->input('isi'),
            'penulis' => session('admin_username', 'Admin Disdukcapil'),
            'published' => (bool) $request->input('published', true),
            'foto' => $request->input('foto', ''),
        ];

        $id = $request->input('id');
        if ($id) {
            ContentRepository::updateBerita($id, $data);
            return response()->json(['success' => true, 'message' => 'Artikel berhasil diperbarui!']);
        } else {
            $artikel = ContentRepository::addBerita($data);
            return response()->json(['success' => true, 'message' => 'Artikel berhasil diterbitkan!', 'id' => $artikel['id']]);
        }
    }

    public function apiUploadFoto(Request $request)
    {
        if (!session('is_admin')) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 401);
        }

        $request->validate(['foto' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096']);

        $file = $request->file('foto');
        $filename = 'berita_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/berita'), $filename);

        return response()->json([
            'success' => true,
            'url' => '/images/berita/' . $filename
        ]);
    }

    public function apiDeleteBerita(Request $request)
    {
        if (!session('is_admin')) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 401);
        }
        $id = $request->input('id');
        ContentRepository::deleteBerita($id);
        return response()->json(['success' => true, 'message' => 'Artikel berhasil dihapus.']);
    }

    public function apiSaveTentang(Request $request)
    {
        if (!session('is_admin')) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 401);
        }
        $tentang = $request->input('tentang');
        if (!is_array($tentang)) {
            return response()->json(['success' => false, 'message' => 'Format data tidak valid.'], 422);
        }

        // Handle misi as array
        if (isset($tentang['misi']) && is_string($tentang['misi'])) {
            $tentang['misi'] = array_values(array_filter(array_map('trim', explode("\n", $tentang['misi']))));
        }

        // Handle tugas_fungsi as array
        if (isset($tentang['tugas_fungsi']) && is_string($tentang['tugas_fungsi'])) {
            $tentang['tugas_fungsi'] = array_values(array_filter(array_map('trim', explode("\n", $tentang['tugas_fungsi']))));
        }

        ContentRepository::updateTentang($tentang);
        return response()->json(['success' => true, 'message' => 'Profil instansi berhasil diperbarui!']);
    }

    public function apiUploadFotoTentang(Request $request)
    {
        if (!session('is_admin')) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 401);
        }

        $request->validate(['foto' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120']);

        $file = $request->file('foto');
        $filename = 'profil_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
        $targetDir = public_path('images/profil');
        File::ensureDirectoryExists($targetDir);
        $file->move($targetDir, $filename);

        return response()->json([
            'success' => true,
            'url' => '/images/profil/' . $filename,
            'message' => 'Foto profil berhasil diunggah!'
        ]);
    }

    public function apiSaveKontak(Request $request)
    {
        if (!session('is_admin')) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 401);
        }
        $kontak = $request->input('kontak');
        ContentRepository::updateKontak($kontak);
        return response()->json(['success' => true, 'message' => 'Data kontak berhasil diperbarui!']);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ContentRepository;
use App\Services\ServiceRepository;
use App\Services\JemputBolaRepository;

class PelayananController extends Controller
{
    public function welcome()
    {
        $announcement = ServiceRepository::getAnnouncement();
        $allServices = ServiceRepository::getServices();
        $services = array_values(array_filter($allServices, fn($service) => ($service['slug'] ?? '') !== 'jemput-bola'));
        $permohonan = array_values(array_filter($allServices, fn($service) => ($service['slug'] ?? '') === 'jemput-bola'));
        $berita = ContentRepository::getBerita();
        $berita = array_values(array_filter($berita, fn($b) => $b['published'] ?? true));
        usort($berita, fn($a, $b) => strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''));
        $berita = array_slice($berita, 0, 3);

        return view('welcome', compact('announcement', 'services', 'permohonan', 'berita'));
    }

    public function index()
    {
        $announcement = ServiceRepository::getAnnouncement();
        $allServices = ServiceRepository::getServices();
        $services = array_values(array_filter($allServices, fn($service) => ($service['slug'] ?? '') !== 'jemput-bola'));
        $permohonan = array_values(array_filter($allServices, fn($service) => ($service['slug'] ?? '') === 'jemput-bola'));
        return view('pelayanan.index', compact('announcement', 'services', 'permohonan'));
    }

    public function detail($slug)
    {
        $announcement = ServiceRepository::getAnnouncement();
        $service = ServiceRepository::getServiceBySlug($slug);
        $allServices = ServiceRepository::getServices();
        
        // Filter 3 related services
        $relatedServices = array_filter($allServices, function($s) use ($slug) {
            return $s['slug'] !== $slug;
        });
        $relatedServices = array_slice($relatedServices, 0, 3);

        return view('pelayanan.detail', compact('announcement', 'service', 'relatedServices'));
    }

    public function submitJemputBola(Request $request)
    {
        $request->validate([
            'nama_pemohon' => 'required|string',
            'nik_pemohon' => 'required|string',
            'no_kk' => 'required|string',
            'hubungan_pemohon' => 'required|string',
            'alamat_pemohon' => 'required|string',
            'kontak_pemohon' => 'required|string',
            'nama_dimohonkan' => 'required|string',
            'nik_dimohonkan' => 'required|string',
            'tempat_lahir_dimohonkan' => 'required|string',
            'tgl_lahir_dimohonkan' => 'required|string',
            'alamat_dimohonkan' => 'required|string',
            'alasan_permohonan' => 'required|string',
            'lampiran_permohonan' => 'nullable|file|max:10240',
        ]);

        $submission = JemputBolaRepository::addSubmission(
            $request->all(),
            $request->file('lampiran_permohonan')
        );

        return response()->json([
            'success' => true,
            'message' => 'Permohonan Jemput Bola berhasil dikirimkan ke Tim Dukcapil!',
            'submission' => $submission
        ]);
    }
}

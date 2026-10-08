<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class JemputBolaRepository
{
    protected static $filePath;

    public static function getFilePath()
    {
        if (!self::$filePath) {
            self::$filePath = storage_path('app/jemput_bola_submissions.json');
        }
        return self::$filePath;
    }

    public static function getAllSubmissions()
    {
        $path = self::getFilePath();
        if (!File::exists($path)) {
            $default = self::getDefaultSubmissions();
            File::ensureDirectoryExists(dirname($path));
            File::put($path, json_encode($default, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            return $default;
        }

        $content = File::get($path);
        $data = json_decode($content, true);

        if (!is_array($data)) {
            $default = self::getDefaultSubmissions();
            File::put($path, json_encode($default, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            return $default;
        }

        return $data;
    }

    public static function saveAllSubmissions(array $submissions)
    {
        $path = self::getFilePath();
        File::ensureDirectoryExists(dirname($path));
        File::put($path, json_encode($submissions, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public static function getSubmissionById($id)
    {
        $submissions = self::getAllSubmissions();
        foreach ($submissions as $sub) {
            if (($sub['id'] ?? '') === $id) {
                return $sub;
            }
        }
        return null;
    }

    public static function addSubmission(array $data, $file = null)
    {
        $submissions = self::getAllSubmissions();
        
        $nextNumber = count($submissions) + 1;
        $year = date('Y');
        $id = sprintf("JB-%s-%03d", $year, $nextNumber);

        // Handle uploaded file if present
        $filePath = '';
        $fileNameOriginal = '';
        if ($file && $file->isValid()) {
            $dir = public_path('uploads/jemput_bola');
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $ext = $file->getClientOriginalExtension();
            $fileNameOriginal = $file->getClientOriginalName();
            $newFileName = 'dokumen_' . strtolower(Str::slug($id)) . '_' . time() . '.' . $ext;
            $file->move($dir, $newFileName);
            $filePath = '/uploads/jemput_bola/' . $newFileName;
        }

        $newSubmission = [
            'id' => $id,
            'created_at' => now()->format('Y-m-d H:i:s'),
            'status' => 'menunggu', // menunggu, disetujui, ditolak, selesai
            'catatan_admin' => 'Permohonan baru masuk, menunggu verifikasi kelengkapan berkas oleh petugas.',
            
            // Data Pemohon
            'nama_pemohon' => trim($data['nama_pemohon'] ?? ''),
            'nik_pemohon' => trim($data['nik_pemohon'] ?? ''),
            'no_kk' => trim($data['no_kk'] ?? ''),
            'hubungan_pemohon' => trim($data['hubungan_pemohon'] ?? ''),
            'alamat_pemohon' => trim($data['alamat_pemohon'] ?? ''),
            'kontak_pemohon' => trim($data['kontak_pemohon'] ?? ''),
            
            // Data Yang Dimohonkan
            'nama_dimohonkan' => trim($data['nama_dimohonkan'] ?? ''),
            'nik_dimohonkan' => trim($data['nik_dimohonkan'] ?? ''),
            'tempat_lahir_dimohonkan' => trim($data['tempat_lahir_dimohonkan'] ?? ''),
            'tgl_lahir_dimohonkan' => trim($data['tgl_lahir_dimohonkan'] ?? ''),
            'alamat_dimohonkan' => trim($data['alamat_dimohonkan'] ?? ''),
            'alasan_permohonan' => trim($data['alasan_permohonan'] ?? ''),
            'keterangan_permohonan' => trim($data['keterangan_permohonan'] ?? ''),
            
            // Lampiran & Lokasi Surat
            'lampiran_file' => $filePath,
            'lampiran_nama_asli' => $fileNameOriginal,
            'lampiran_2' => trim($data['lampiran_2'] ?? ''),
            'lampiran_3' => trim($data['lampiran_3'] ?? ''),
            'lampiran_4' => trim($data['lampiran_4'] ?? ''),
            'kota_surat' => trim($data['kota_surat'] ?? 'Cirebon'),
            'tanggal_surat' => trim($data['tanggal_surat'] ?? now()->translatedFormat('d F Y')),
            
            // Tanda Tangan Digital Pemohon
            'signature_data' => $data['signature_data'] ?? '',
            'dibuka' => false,
            'dicetak' => false,
        ];

        array_unshift($submissions, $newSubmission);
        self::saveAllSubmissions($submissions);

        return $newSubmission;
    }

    public static function markAsOpened($id)
    {
        $submissions = self::getAllSubmissions();
        $updated = false;

        foreach ($submissions as &$sub) {
            if (($sub['id'] ?? '') === $id) {
                $sub['dibuka'] = true;
                $sub['opened_at'] = now()->format('Y-m-d H:i:s');
                $updated = true;
                break;
            }
        }

        if ($updated) {
            self::saveAllSubmissions($submissions);
        }

        return $updated;
    }

    public static function markAsPrinted($id)
    {
        $submissions = self::getAllSubmissions();
        $updated = false;

        foreach ($submissions as &$sub) {
            if (($sub['id'] ?? '') === $id) {
                $sub['dibuka'] = true;
                $sub['dicetak'] = true;
                $sub['printed_at'] = now()->format('Y-m-d H:i:s');
                $updated = true;
                break;
            }
        }

        if ($updated) {
            self::saveAllSubmissions($submissions);
        }

        return $updated;
    }

    public static function updateStatus($id, $status, $catatan = '')
    {
        $submissions = self::getAllSubmissions();
        $updated = false;

        foreach ($submissions as &$sub) {
            if (($sub['id'] ?? '') === $id) {
                $sub['status'] = $status;
                $sub['dibuka'] = true; // Updating status means admin has opened/checked it
                if ($catatan !== null && $catatan !== '') {
                    $sub['catatan_admin'] = $catatan;
                }
                $sub['updated_at'] = now()->format('Y-m-d H:i:s');
                $updated = true;
                break;
            }
        }

        if ($updated) {
            self::saveAllSubmissions($submissions);
        }

        return $updated;
    }

    public static function deleteSubmission($id)
    {
        $submissions = self::getAllSubmissions();
        $filtered = array_values(array_filter($submissions, fn($s) => ($s['id'] ?? '') !== $id));
        self::saveAllSubmissions($filtered);
        return true;
    }

    public static function getDefaultSubmissions()
    {
        return [
            [
                'id' => 'JB-2026-001',
                'created_at' => '2026-09-28 09:15:30',
                'status' => 'disetujui',
                'catatan_admin' => 'Data berkas persyaratan lengkap. Dijadwalkan kunjungan perekaman biometrik Jemput Bola oleh Tim Petugas Dukcapil Wilayah Timur.',
                'nama_pemohon' => 'Sugiono',
                'nik_pemohon' => '3209121504780002',
                'no_kk' => '3209122301050001',
                'hubungan_pemohon' => 'Anak Kandung',
                'alamat_pemohon' => 'Dusun Kliwon RT 003 RW 002, Desa Mertapada Wetan, Kec. Astanajapura, Kab. Cirebon',
                'kontak_pemohon' => '081223456789',
                'nama_dimohonkan' => 'Kasminah',
                'nik_dimohonkan' => '3209125508500003',
                'tempat_lahir_dimohonkan' => 'Cirebon',
                'tgl_lahir_dimohonkan' => '15-08-1950',
                'alamat_dimohonkan' => 'Dusun Kliwon RT 003 RW 002, Desa Mertapada Wetan, Kec. Astanajapura, Kab. Cirebon',
                'alasan_permohonan' => 'Lanjut Usia (Lansia) & Sakit Menahun (Tirah Baring)',
                'keterangan_permohonan' => 'Kondisi lansia usia 76 tahun, kondisi tirah baring (stroke ringan) tidak memungkinkan datang ke kantor kecamatan/Disdukcapil.',
                'lampiran_file' => '',
                'lampiran_nama_asli' => 'Surat_Keterangan_Puskesmas_dan_KK.pdf',
                'lampiran_2' => 'Surat Keterangan Sakit dari Puskesmas Astanajapura',
                'lampiran_3' => 'Foto Kondisi Fisik Yang Dimohonkan',
                'lampiran_4' => '',
                'kota_surat' => 'Cirebon',
                'tanggal_surat' => '28 September 2026',
                'signature_data' => '',
            ],
            [
                'id' => 'JB-2026-002',
                'created_at' => '2026-09-30 14:20:10',
                'status' => 'menunggu',
                'catatan_admin' => 'Permohonan baru masuk, menunggu verifikasi kelengkapan berkas oleh petugas.',
                'nama_pemohon' => 'Rahmat Hidayat',
                'nik_pemohon' => '3209172206850004',
                'no_kk' => '3209171008080005',
                'hubungan_pemohon' => 'Saudara Kandung',
                'alamat_pemohon' => 'Blok Manis RT 001 RW 004, Desa Weru Kidul, Kec. Weru, Kab. Cirebon',
                'kontak_pemohon' => '085219876543',
                'nama_dimohonkan' => 'Dewi Lestari',
                'nik_dimohonkan' => '3209176009980006',
                'tempat_lahir_dimohonkan' => 'Cirebon',
                'tgl_lahir_dimohonkan' => '20-09-1998',
                'alamat_dimohonkan' => 'Blok Manis RT 001 RW 004, Desa Weru Kidul, Kec. Weru, Kab. Cirebon',
                'alasan_permohonan' => 'Penyandang Disabilitas Fisik',
                'keterangan_permohonan' => 'Penyandang disabilitas tuna daksa sejak lahir, membutuhkan perekaman KTP-el perdana untuk keperluan BPJS.',
                'lampiran_file' => '',
                'lampiran_nama_asli' => 'Fotokopi_KK_dan_Surat_Kades.jpg',
                'lampiran_2' => 'Surat Keterangan Disabilitas Puskesmas Weru',
                'lampiran_3' => 'Surat Pengantar Pemerintah Desa Weru Kidul',
                'lampiran_4' => '',
                'kota_surat' => 'Cirebon',
                'tanggal_surat' => '30 September 2026',
                'signature_data' => '',
            ],
            [
                'id' => 'JB-2026-003',
                'created_at' => '2026-10-01 10:05:45',
                'status' => 'menunggu',
                'catatan_admin' => 'Permohonan baru masuk, menunggu verifikasi kelengkapan berkas oleh petugas.',
                'nama_pemohon' => 'Siti Fatimah',
                'nik_pemohon' => '3209214407900007',
                'no_kk' => '3209211202110008',
                'hubungan_pemohon' => 'Orang Tua',
                'alamat_pemohon' => 'RT 002 RW 001 Desa Palimanan Barat, Kec. Gempol, Kab. Cirebon',
                'kontak_pemohon' => '087723456781',
                'nama_dimohonkan' => 'Ahmad Fauzi',
                'nik_dimohonkan' => '3209211501060009',
                'tempat_lahir_dimohonkan' => 'Cirebon',
                'tgl_lahir_dimohonkan' => '15-01-2006',
                'alamat_dimohonkan' => 'RT 002 RW 001 Desa Palimanan Barat, Kec. Gempol, Kab. Cirebon',
                'alasan_permohonan' => 'ODGJ (Orang Dengan Gangguan Jiwa)',
                'keterangan_permohonan' => 'Memerlukan pendekatan persuasif dan pendampingan keluarga pada saat perekaman biometrik mata dan sidik jari.',
                'lampiran_file' => '',
                'lampiran_nama_asli' => 'Berkas_Persyaratan_ODGJ.pdf',
                'lampiran_2' => 'Surat Keterangan Riwayat Pengobatan Jiwa RSUD Arjawinangun',
                'lampiran_3' => '',
                'lampiran_4' => '',
                'kota_surat' => 'Cirebon',
                'tanggal_surat' => '01 Oktober 2026',
                'signature_data' => '',
            ]
        ];
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class ContentRepository
{
    protected static $filePath;

    public static function getFilePath()
    {
        if (!self::$filePath) {
            self::$filePath = storage_path('app/content_data.json');
        }
        return self::$filePath;
    }

    public static function getAllData()
    {
        $path = self::getFilePath();
        if (!File::exists($path)) {
            $initialData = self::getDefaultData();
            File::ensureDirectoryExists(dirname($path));
            File::put($path, json_encode($initialData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            return $initialData;
        }
        $content = File::get($path);
        $data = json_decode($content, true);
        if (!is_array($data)) {
            $initialData = self::getDefaultData();
            File::put($path, json_encode($initialData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            return $initialData;
        }
        return $data;
    }

    public static function saveData($data)
    {
        $path = self::getFilePath();
        File::ensureDirectoryExists(dirname($path));
        File::put($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    // ========== BERITA (Informasi) ==========
    public static function getBerita()
    {
        $data = self::getAllData();
        return $data['berita'] ?? [];
    }

    public static function getBeritaById($id)
    {
        $berita = self::getBerita();
        foreach ($berita as $item) {
            if ($item['id'] == $id) return $item;
        }
        return null;
    }

    public static function addBerita($article)
    {
        $data = self::getAllData();
        $berita = $data['berita'] ?? [];
        $maxId = 0;
        foreach ($berita as $b) { if ($b['id'] > $maxId) $maxId = $b['id']; }
        $article['id'] = $maxId + 1;
        $article['created_at'] = now()->format('Y-m-d H:i:s');
        $berita[] = $article;
        $data['berita'] = $berita;
        self::saveData($data);
        return $article;
    }

    public static function updateBerita($id, $article)
    {
        $data = self::getAllData();
        foreach ($data['berita'] as &$b) {
            if ($b['id'] == $id) {
                $article['id'] = $id;
                $article['created_at'] = $b['created_at'] ?? now()->format('Y-m-d H:i:s');
                $article['updated_at'] = now()->format('Y-m-d H:i:s');
                $b = $article;
                break;
            }
        }
        self::saveData($data);
    }

    public static function deleteBerita($id)
    {
        $data = self::getAllData();
        $data['berita'] = array_values(array_filter($data['berita'] ?? [], fn($b) => $b['id'] != $id));
        self::saveData($data);
    }

    // ========== TENTANG ==========
    public static function getTentang()
    {
        $data = self::getAllData();
        $defaults = self::getDefaultData()['tentang'];
        $stored = $data['tentang'] ?? [];

        if (!is_array($stored)) {
            $stored = [];
        }

        // Merge defaults for any missing, null, or empty string values
        foreach ($defaults as $key => $defaultVal) {
            if (!isset($stored[$key]) || $stored[$key] === null || $stored[$key] === '') {
                $stored[$key] = $defaultVal;
            }
        }

        // Ensure array types
        if (!isset($stored['misi']) || !is_array($stored['misi']) || empty($stored['misi'])) {
            $stored['misi'] = $defaults['misi'];
        }

        if (!isset($stored['tugas_fungsi']) || !is_array($stored['tugas_fungsi']) || empty($stored['tugas_fungsi'])) {
            $stored['tugas_fungsi'] = $defaults['tugas_fungsi'] ?? [];
        }

        return $stored;
    }

    public static function updateTentang($tentang)
    {
        $data = self::getAllData();
        $current = self::getTentang();
        $data['tentang'] = array_merge($current, $tentang);
        self::saveData($data);
        return $data['tentang'];
    }

    // ========== KONTAK ==========
    public static function getKontak()
    {
        $data = self::getAllData();
        return $data['kontak'] ?? self::getDefaultData()['kontak'];
    }

    public static function updateKontak($kontak)
    {
        $data = self::getAllData();
        $data['kontak'] = $kontak;
        self::saveData($data);
    }

    public static function getDefaultData()
    {
        return [
            'berita' => [
                [
                    'id' => 1,
                    'judul' => 'Program Jemput Bola Perekaman KTP-el Kecamatan Sumber',
                    'kategori' => 'Program Layanan',
                    'ringkasan' => 'Dinas Kependudukan dan Pencatatan Sipil Kabupaten Cirebon menggelar program jemput bola perekaman KTP-el di Kecamatan Sumber guna mempercepat pelayanan kepada masyarakat yang belum melakukan perekaman.',
                    'isi' => 'Program jemput bola perekaman KTP-el ini merupakan salah satu upaya Disdukcapil Kabupaten Cirebon untuk mempercepat cakupan perekaman KTP-el bagi seluruh warga yang belum melakukannya. Kegiatan dilaksanakan di balai desa dan kecamatan, sehingga masyarakat tidak perlu jauh-jauh datang ke kantor Disdukcapil. Tim petugas membawa peralatan lengkap termasuk alat perekaman biometrik langsung ke lapangan. Warga cukup membawa fotokopi KK dan hadir langsung pada jadwal yang telah ditentukan.',
                    'foto' => '',
                    'penulis' => 'Admin Disdukcapil',
                    'created_at' => '2026-09-01 08:00:00',
                    'published' => true
                ],
                [
                    'id' => 2,
                    'judul' => 'Pengumuman: Perpanjangan Layanan Akta Kelahiran Online via IKD',
                    'kategori' => 'Pengumuman Resmi',
                    'ringkasan' => 'Dalam rangka meningkatkan kemudahan layanan bagi masyarakat, Disdukcapil Kabupaten Cirebon kini memperpanjang periode layanan penerbitan akta kelahiran secara online melalui aplikasi Identitas Kependudukan Digital (IKD).',
                    'isi' => 'Disdukcapil Kabupaten Cirebon mengumumkan perpanjangan program layanan Akta Kelahiran Online melalui aplikasi Identitas Kependudukan Digital (IKD). Program ini memungkinkan warga untuk mengurus akta kelahiran tanpa harus datang langsung ke kantor. Masyarakat hanya perlu mengunduh aplikasi IKD, mengaktifkan identitas digital, kemudian mengajukan permohonan secara online. Dokumen akan dikirimkan ke alamat atau dapat diunduh melalui aplikasi.',
                    'foto' => '',
                    'penulis' => 'Admin Disdukcapil',
                    'created_at' => '2026-09-05 09:30:00',
                    'published' => true
                ],
                [
                    'id' => 3,
                    'judul' => 'Sosialisasi Administrasi Kependudukan bagi Pelajar SMA Se-Kabupaten Cirebon',
                    'kategori' => 'Kegiatan',
                    'ringkasan' => 'Disdukcapil Kabupaten Cirebon mengadakan kegiatan sosialisasi administrasi kependudukan kepada para pelajar SMA sederajat, mengenalkan pentingnya dokumen kependudukan sedini mungkin bagi generasi muda.',
                    'isi' => 'Sosialisasi Administrasi Kependudukan bagi pelajar SMA dilaksanakan di aula kantor bupati Cirebon dengan dihadiri lebih dari 200 siswa dari berbagai sekolah. Kegiatan ini bertujuan untuk mengenalkan kepada generasi muda tentang pentingnya dokumen kependudukan seperti KTP-el, KK, akta kelahiran, dan KIA. Pelajar juga mendapatkan edukasi tentang cara mengaktifkan Identitas Kependudukan Digital (IKD) untuk mempermudah akses layanan publik digital.',
                    'foto' => '',
                    'penulis' => 'Admin Disdukcapil',
                    'created_at' => '2026-09-08 10:00:00',
                    'published' => true
                ]
            ],
            'tentang' => [
                'nama_instansi' => 'Dinas Kependudukan dan Pencatatan Sipil',
                'nama_kabupaten' => 'Kabupaten Cirebon',
                'slogan' => 'Melayani dengan Cepat, Akurat, Nyaman, dan Membahagiakan Masyarakat',
                'visi' => 'Terwujudnya Pelayanan Administrasi Kependudukan dan Pencatatan Sipil yang Prima, Akurat, dan Terpercaya untuk Mendukung Tata Kelola Pemerintahan yang Baik Menuju Kabupaten Cirebon yang Berbudaya, Sejahtera, Agamis, Maju, dan Aman.',
                'misi' => [
                    'Meningkatkan kualitas dan jangkauan pelayanan administrasi kependudukan yang mudah, cepat, tepat, dan transparan.',
                    'Mewujudkan tertib administrasi kependudukan dan kepemilikan dokumen kependudukan bagi seluruh masyarakat.',
                    'Mengembangkan sistem informasi administrasi kependudukan (SIAK) berbasis teknologi digital yang terintegrasi dan andal.',
                    'Meningkatkan profesionalisme, integritas, dan kompetensi aparatur dalam memberikan pelayanan publik prima.',
                    'Mengoptimalkan pemanfaatan data kependudukan untuk perencanaan pembangunan dan pelayanan publik lainnya.'
                ],
                'tugas_fungsi' => [
                    'Perumusan kebijakan teknis di bidang pendaftaran penduduk, pencatatan sipil, dan pengelolaan informasi kependudukan.',
                    'Pelaksanaan pelayanan pendaftaran penduduk (Penerbitan Biodata, KK, KTP-el, KIA, dan Surat Pindah Datang).',
                    'Pelaksanaan pelayanan pencatatan sipil (Penerbitan Akta Kelahiran, Kematian, Perkawinan, Perceraian, dan Pengakuan/Pengesahan Anak).',
                    'Pengelolaan data base kependudukan, pemanfaatan data, serta penyajian data profil kependudukan.',
                    'Pelaksanaan inovasi pelayanan jemput bola (Mobile Service) ke desa-desa, sekolah, dan kelompok rentan adminduk.'
                ],
                'maklumat_pelayanan' => 'Dengan ini, segenap pimpinan dan pegawai Dinas Kependudukan dan Pencatatan Sipil Kabupaten Cirebon menyatakan sanggup menyelenggarakan pelayanan administrasi kependudukan sesuai dengan standar pelayanan yang telah ditetapkan, memberikan pelayanan dengan sepenuh hati, cepat, ramah, dan 100% BEBAS PUNGUTAN BIAYA (GRATIS), serta siap menerima sanksi sesuai ketentuan yang berlaku apabila pelayanan tidak sesuai standar.',
                'sejarah' => 'Dinas Kependudukan dan Pencatatan Sipil (Disdukcapil) Kabupaten Cirebon merupakan unsur pelaksana urusan pemerintahan daerah di bidang administrasi kependudukan dan pencatatan sipil. Berkedudukan di ibukota Kabupaten Cirebon di Kecamatan Sumber, dinas ini terus bertransformasi seiring perkembangan regulasi nasional (UU No. 23/2006 jo UU No. 24/2013). Dari era pencatatan dokumen manual hingga era transformasi digital terintegrasi (SIAK Terpusat dan Identitas Kependudukan Digital/IKD), Disdukcapil Kabupaten Cirebon berkomitmen menghadirkan layanan publik yang inklusif, modern, dan menjangkau seluruh lapisan masyarakat hingga ke pelosok pedesaan.',
                'kepala_dinas' => 'Drs. H. Iman Supriadi, M.Si.',
                'nip_kepala' => '19680101 199203 1 001',
                'foto_kepala' => '',
                'sambutan_kepala' => 'Selamat datang di portal resmi Dinas Kependudukan dan Pencatatan Sipil Kabupaten Cirebon. Sebagai wujud komitmen reformasi birokrasi dan peningkatan kualitas pelayanan publik, portal ini kami sediakan untuk memudahkan seluruh warga masyarakat dalam mengakses informasi persyaratan, panduan pelayanan, serta perkembangan program kependudukan secara transparan dan akuntabel. Kami mengajak seluruh warga Kabupaten Cirebon untuk bersama-sama mewujudkan tertib administrasi kependudukan karena dokumen kependudukan merupakan hak dasar setiap warga negara untuk mengakses seluruh layanan publik lainnya.',
                'alamat' => 'Jl. Sunan Muria Komplek Perkantoran Pemda No. 84, Sumber, Kec. Sumber, Kabupaten Cirebon, Jawa Barat 45611',
                'telepon' => '0231-321156',
                'email' => 'disdukcapil@cirebonkab.go.id',
                'website' => 'www.disdukcapil.cirebonkab.go.id',
                'jam_kerja' => 'Senin – Kamis: 07.30 – 16.00 WIB | Jumat: 07.30 – 16.30 WIB',
                'maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.0620803525283!2d108.4812328!3d-6.7622839!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f1f457ffec789%3A0x89dc004523bb6eb4!2sDisdukcapil%20Kabupaten%20Cirebon!5e0!3m2!1sid!2sid!4v1710000000000!5m2!1sid!2sid',
                'maps_link' => 'https://maps.google.com/?q=Disdukcapil+Kabupaten+Cirebon'
            ],
            'kontak' => [
                'whatsapp' => '6281234567890',
                'whatsapp_label' => '+62 812-3456-7890',
                'instagram' => 'disdukcapil_cirebonkab',
                'instagram_url' => 'https://www.instagram.com/disdukcapil_cirebonkab',
                'email' => 'disdukcapil@cirebonkab.go.id',
                'telepon' => '069 8522 1888',
                'alamat' => 'Jl. Sunan Muria Komplek Pemda No.84, Sumber, Kec. Sumber, Kabupaten Cirebon, Jawa Barat 45611',
                'jam_kerja' => 'Senin – Kamis: 07.30 – 16.00 WIB | Jumat: 07.30 – 16.30 WIB',
                'pesan_wa' => 'Halo Admin Disdukcapil, saya ingin menanyakan informasi layanan kependudukan.'
            ]
        ];
    }
}

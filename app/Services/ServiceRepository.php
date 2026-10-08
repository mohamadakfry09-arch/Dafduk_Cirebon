<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class ServiceRepository
{
    protected static $filePath;

    public static function getFilePath()
    {
        if (!self::$filePath) {
            self::$filePath = storage_path('app/services_data.json');
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

        if (!is_array($data) || !isset($data['services'])) {
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

    public static function getAnnouncement()
    {
        $data = self::getAllData();
        return $data['announcement'] ?? 'Informasi pelayanan pada website ini mengacu pada sumber resmi Direktorat Jenderal Kependudukan dan Pencatatan Sipil Kementerian Dalam Negeri Republik Indonesia.';
    }

    public static function updateAnnouncement($text)
    {
        $data = self::getAllData();
        $data['announcement'] = $text;
        self::saveData($data);
    }

    public static function getServices()
    {
        $data = self::getAllData();
        return $data['services'] ?? [];
    }

    public static function getServiceBySlug($slug)
    {
        $services = self::getServices();
        foreach ($services as $s) {
            if ($s['slug'] === $slug) {
                return $s;
            }
        }
        
        // Fallback default structure if slug matches generic list
        return [
            'slug' => $slug,
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'category' => 'kependudukan',
            'tag' => 'KEPENDUDUKAN',
            'desc' => 'Informasi dan pelayanan administrasi kependudukan.',
            'notice' => 'Informasi persyaratan akan ditampilkan pada bagian ini. Pemohon diwajibkan melengkapi seluruh persyaratan administrasi sebelum melakukan pendaftaran.',
            'requirements' => [
                [
                    'id' => 1,
                    'title' => 'Dokumen Identitas Diri (KTP / KK)',
                    'desc' => 'Membawa dokumen identitas diri atau Kartu Keluarga yang berlaku.'
                ],
                [
                    'id' => 2,
                    'title' => 'Formulir Permohonan',
                    'desc' => 'Mengisi formulir permohonan pelayanan kependudukan yang telah disediakan.'
                ]
            ],
            'procedures' => [
                ['id' => 1, 'title' => 'Pengajuan Dokumen', 'desc' => 'Pemohon datang ke loket pelayanan dengan membawa persyaratan.'],
                ['id' => 2, 'title' => 'Verifikasi & Pengolahan', 'desc' => 'Petugas memverifikasi kelengkapan dan keabsahan dokumen.'],
                ['id' => 3, 'title' => 'Penerbitan Dokumen', 'desc' => 'Dokumen resmi diterbitkan dan dapat diambil oleh pemohon.']
            ],
            'documents' => [],
            'information' => [
                ['id' => 1, 'title' => 'Gratis Tanpa Biaya', 'desc' => 'Seluruh pelayanan kependudukan tidak dikenakan biaya (gratis).'],
                ['id' => 2, 'title' => 'Jam Operasional', 'desc' => 'Senin – Jumat pukul 07.30 – 15.30 WIB.']
            ],
            'hukum' => [
                ['id' => 1, 'title' => 'UU No. 24 Tahun 2013', 'desc' => 'Perubahan atas UU No. 23 Tahun 2006 tentang Administrasi Kependudukan.']
            ]
        ];
    }

    public static function updatePersyaratan($slug, $requirements, $notice = null)
    {
        $data = self::getAllData();
        $found = false;

        foreach ($data['services'] as &$service) {
            if ($service['slug'] === $slug) {
                $service['requirements'] = $requirements;
                if ($notice !== null) {
                    $service['notice'] = $notice;
                }
                $found = true;
                break;
            }
        }

        if (!$found) {
            // Add service dynamically if not exists
            $newService = self::getServiceBySlug($slug);
            $newService['requirements'] = $requirements;
            if ($notice !== null) {
                $newService['notice'] = $notice;
            }
            $data['services'][] = $newService;
        }

        self::saveData($data);
    }

    public static function updateServiceFull($slug, $serviceData)
    {
        $data = self::getAllData();
        $found = false;

        foreach ($data['services'] as &$service) {
            if ($service['slug'] === $slug) {
                $service = array_merge($service, $serviceData);
                $found = true;
                break;
            }
        }

        if (!$found) {
            $data['services'][] = $serviceData;
        }

        self::saveData($data);
    }

    public static function getDefaultData()
    {
        return [
            'announcement' => 'Informasi pelayanan pada website ini mengacu pada sumber resmi Direktorat Jenderal Kependudukan dan Pencatatan Sipil Kementerian Dalam Negeri Republik Indonesia.',
            'services' => [
                [
                    'slug' => 'penerbitan-ktp-el-baru',
                    'icon' => 'credit-card',
                    'category' => 'ktp-el',
                    'tag' => 'KEPENDUDUKAN',
                    'title' => 'Penerbitan KTP-el Baru',
                    'desc' => 'Layanan penerbitan Kartu Tanda Penduduk Elektronik (KTP-el) bagi Warga Negara Indonesia (WNI) yang telah memenuhi syarat usia (17 tahun) atau sudah pernah menikah.',
                    'notice' => 'Informasi persyaratan akan ditampilkan pada bagian ini. Pemohon diwajibkan melengkapi seluruh persyaratan administrasi sebelum melakukan pendaftaran.',
                    'requirements' => [
                        [
                            'id' => 1,
                            'title' => 'Telah Berusia 17 Tahun',
                            'desc' => 'Pemohon wajib telah menginjak usia 17 tahun, atau sudah/pernah kawin meskipun belum berusia 17 tahun.'
                        ],
                        [
                            'id' => 2,
                            'title' => 'Kartu Keluarga (KK)',
                            'desc' => 'Fotokopi Kartu Keluarga (KK) terbaru yang mencantumkan nama pemohon.'
                        ],
                        [
                            'id' => 3,
                            'title' => 'Surat Pengantar (Opsional)',
                            'desc' => 'Surat pengantar dari RT/RW setempat (kebijakan menyesuaikan daerah masing-masing, saat ini sebagian besar daerah sudah tidak mewajibkan).'
                        ]
                    ],
                    'procedures' => [
                        ['id' => 1, 'title' => 'Datang ke Disdukcapil', 'desc' => 'Pemohon datang langsung ke kantor Dinas Kependudukan dan Pencatatan Sipil dengan membawa dokumen persyaratan.'],
                        ['id' => 2, 'title' => 'Perekaman Biometrik', 'desc' => 'Perekaman sidik jari, iris mata, tanda tangan, dan foto dilakukan oleh petugas.'],
                        ['id' => 3, 'title' => 'Verifikasi Data', 'desc' => 'Petugas melakukan verifikasi data pemohon berdasarkan dokumen yang diserahkan.'],
                        ['id' => 4, 'title' => 'Pengambilan KTP-el', 'desc' => 'KTP-el akan siap diambil sesuai jadwal yang ditentukan oleh petugas, atau dikirim ke alamat pemohon.']
                    ],
                    'documents' => [],
                    'information' => [
                        ['id' => 1, 'title' => 'Gratis Tanpa Biaya', 'desc' => 'Seluruh layanan penerbitan KTP-el tidak dikenakan biaya (gratis).'],
                        ['id' => 2, 'title' => 'Waktu Layanan', 'desc' => 'Senin – Jumat pukul 07.30 – 15.30 WIB. Hari Sabtu & Minggu libur.']
                    ],
                    'hukum' => [
                        ['id' => 1, 'title' => 'UU No. 23 Tahun 2006', 'desc' => 'Undang-undang tentang Administrasi Kependudukan sebagaimana telah diubah dengan UU No. 24 Tahun 2013.'],
                        ['id' => 2, 'title' => 'Perpres No. 26 Tahun 2009', 'desc' => 'Peraturan Presiden tentang Penerapan Kartu Tanda Penduduk Berbasis Nomor Induk Kependudukan Secara Nasional.']
                    ]
                ],
                [
                    'slug' => 'jemput-bola',
                    'icon' => 'map-pin',
                    'category' => 'kependudukan',
                    'tag' => 'KEPENDUDUKAN',
                    'title' => 'Jemput Bola',
                    'desc' => 'Pelayanan jemput bola untuk permohonan administrasi kependudukan bagi penyandang disabilitas, lansia, dan ODGJ.',
                    'notice' => 'Untuk syarat permohonan, siapkan berkas yang dibutuhkan dan lengkapi formulir digital dengan data yang benar.',
                    'requirements' => [
                        [
                            'id' => 1,
                            'title' => 'Untuk syarat permohonan',
                            'desc' => 'Siapkan berkas berupa 1. Kartu Keluarga, 2. Surat Permohonan Jemput Bola, 3. Surat Keterangan Dokter/Puskesmas bahwa pemohon penyandang disabilitas atau lansia atau ODGJ.'
                        ],
                        [
                            'id' => 2,
                            'title' => 'Formulir digital pendaftaran jemput bola',
                            'desc' => 'Pemohon mengisi formulir digital pendaftaran jemput bola berupa nama pemohon, nomor KK pemohon, tempat dan tanggal lahir pemohon, serta alamat pemohon.'
                        ],
                        [
                            'id' => 3,
                            'title' => 'Lampiran dokumen',
                            'desc' => 'Lampiran berupa foto KK, surat permohonan jemput bola, dan surat keterangan puskesmas/dokter bahwa pemohon penyandang disabilitas atau lansia atau ODGJ.'
                        ]
                    ],
                    'procedures' => [
                        ['id' => 1, 'title' => 'Pendaftaran', 'desc' => 'Pemohon mengisi formulir digital pendaftaran jemput bola sesuai data diri dan alamat domisili.'],
                        ['id' => 2, 'title' => 'Lampiran', 'desc' => 'Pemohon melampirkan foto KK, surat permohonan jemput bola, dan surat keterangan dokter/puskesmas.'],
                        ['id' => 3, 'title' => 'Ajukan', 'desc' => 'Pemohon menekan tombol ajukan agar pengajuan dikirim ke tim administrasi untuk diverifikasi.'],
                        ['id' => 4, 'title' => 'Selesai', 'desc' => 'Setelah hasil verifikasi, sistem menampilkan status penerimaan atau penolakan pengajuan.']
                    ],
                    'documents' => [],
                    'information' => [
                        ['id' => 1, 'title' => 'Layanan prioritas', 'desc' => 'Layanan ini ditujukan untuk warga yang memiliki keterbatasan mobilitas agar dapat menerima pelayanan di rumah.'],
                        ['id' => 2, 'title' => 'Waktu verifikasi', 'desc' => 'Tim adminduk dapat melakukan verifikasi dalam waktu yang ditentukan setelah pengajuan diterima.']
                    ],
                    'hukum' => [
                        ['id' => 1, 'title' => 'Peraturan daerah', 'desc' => 'Pelayanan administrasi kependudukan diatur sesuai peraturan perundang-undangan terkait pelayanan publik dan administrasi kependudukan.']
                    ],
                    'approval' => [
                        'default_status' => 'pending',
                        'pending_title' => 'Dalam Proses Persetujuan',
                        'pending_message' => 'Terima kasih sudah mendaftarkan permohonan jemput bola. Mohon tunggu proses persetujuan dari admin.',
                        'accepted_title' => 'Persetujuan Diterima',
                        'accepted_message' => 'Pengajuan Anda telah disetujui dan akan diproses lebih lanjut oleh admin.',
                        'rejected_title' => 'Pengajuan Tidak Disetujui',
                        'rejected_message' => 'Mohon maaf, pengajuan Anda belum dapat disetujui pada saat ini.'
                    ]
                ],
                [
                    'slug' => 'pencatatan-biodata-wni',
                    'icon' => 'user',
                    'category' => 'kependudukan',
                    'tag' => 'KEPENDUDUKAN',
                    'title' => 'Pencatatan Biodata WNI',
                    'desc' => 'Proses pencatatan identitas data Warga Negara Indonesia yang baru lahir atau pindah domisili.',
                    'notice' => 'Lengkapi berkas biodata kependudukan secara cermat untuk validasi sistem SIAK.',
                    'requirements' => [
                        ['id' => 1, 'title' => 'Formulir F-1.01', 'desc' => 'Formulir isian biodata penduduk warga negara Indonesia.'],
                        ['id' => 2, 'title' => 'Surat Pengantar RT/RW', 'desc' => 'Surat keterangan domisili atau pengantar RT/RW.'],
                        ['id' => 3, 'title' => 'Dokumen Pendukung', 'desc' => 'Kutipan akta kelahiran, ijazah, atau surat nikah jika ada.']
                    ]
                ],
                [
                    'slug' => 'penerbitan-kk-baru',
                    'icon' => 'users',
                    'category' => 'kartu-keluarga',
                    'tag' => 'KEPENDUDUKAN',
                    'title' => 'Penerbitan KK Baru',
                    'desc' => 'Penerbitan Kartu Keluarga baru akibat pernikahan, kelahiran, maupun perpindahan dari daerah lain.',
                    'notice' => 'Penerbitan KK Baru gratis tanpa dipungut biaya apapun.',
                    'requirements' => [
                        ['id' => 1, 'title' => 'Buku Nikah / Kutipan Akta Perkawinan', 'desc' => 'Fotokopi akta nikah atau buku nikah resmi.'],
                        ['id' => 2, 'title' => 'KK Asli Orang Tua', 'desc' => 'KK asal suami dan istri untuk pemisahan KK.'],
                        ['id' => 3, 'title' => 'Formulir F-1.02', 'desc' => 'Formulir permohonan Kartu Keluarga baru.']
                    ]
                ],
                [
                    'slug' => 'penambahan-anggota-kk',
                    'icon' => 'user-plus',
                    'category' => 'kartu-keluarga',
                    'tag' => 'KEPENDUDUKAN',
                    'title' => 'Penambahan Anggota KK',
                    'desc' => 'Penambahan anggota pada Kartu Keluarga karena kelahiran anak, menikah, maupun kedatangan dari luar.',
                    'notice' => 'Pastikan anak yang baru lahir menyertakan Surat Keterangan Lahir.',
                    'requirements' => [
                        ['id' => 1, 'title' => 'KK Asli', 'desc' => 'Kartu Keluarga asli yang hendak ditambah anggotanya.'],
                        ['id' => 2, 'title' => 'Surat Keterangan Lahir', 'desc' => 'Dari dokter/bidan/faskes bagi penambahan anggota karena kelahiran.'],
                        ['id' => 3, 'title' => 'Surat Keterangan Pindah (SKPWNI)', 'desc' => 'Bagi anggota keluarga yang pindah masuk.']
                    ]
                ],
                [
                    'slug' => 'pengurangan-anggota-kk',
                    'icon' => 'user-minus',
                    'category' => 'kartu-keluarga',
                    'tag' => 'KEPENDUDUKAN',
                    'title' => 'Pengurangan Anggota KK',
                    'desc' => 'Pengurangan anggota KK akibat kematian, pindah domisili, atau alasan lain yang sah.',
                    'notice' => 'Persyaratan kematian melampirkan Surat Keterangan Kematian.',
                    'requirements' => [
                        ['id' => 1, 'title' => 'KK Asli', 'desc' => 'Kartu Keluarga asli saat ini.'],
                        ['id' => 2, 'title' => 'Surat Kematian / SKPWNI', 'desc' => 'Kutipan Akta Kematian atau Surat Pindah Penduduk.']
                    ]
                ],
                [
                    'slug' => 'perubahan-data-kk',
                    'icon' => 'edit',
                    'category' => 'kartu-keluarga',
                    'tag' => 'KEPENDUDUKAN',
                    'title' => 'Perubahan Data KK',
                    'desc' => 'Layanan memperbarui data anggota keluarga, seperti perubahan nama, status dll.',
                    'notice' => 'Melampirkan dokumen bukti perubahan data pendukung.',
                    'requirements' => [
                        ['id' => 1, 'title' => 'KK Asli', 'desc' => 'Kartu Keluarga lama yang akan diubah.'],
                        ['id' => 2, 'title' => 'Dokumen Bukti Perubahan', 'desc' => 'Ijazah, Akta Kelahiran, Surat Nikah, atau penetapan pengadilan.']
                    ]
                ],
                [
                    'slug' => 'cetak-rusak-hilang',
                    'icon' => 'printer',
                    'category' => 'ktp-el',
                    'tag' => 'KEPENDUDUKAN',
                    'title' => 'Cetak KTP-el Rusak/Hilang',
                    'desc' => 'Penerbitan ulang KTP-el yang rusak atau hilang dengan melampirkan dokumen yang sah.',
                    'notice' => 'Untuk KTP-el hilang wajib menyertakan Surat Kehilangan dari Kepolisian.',
                    'requirements' => [
                        ['id' => 1, 'title' => 'Surat Keterangan Kehilangan', 'desc' => 'Surat tanda penerimaan laporan kehilangan dari kepolisian setempat (jika hilang).'],
                        ['id' => 2, 'title' => 'KTP-el Lama (Jika Rusak)', 'desc' => 'Fisik KTP-el asli yang mengalami kerusakan (jika rusak).'],
                        ['id' => 3, 'title' => 'Fotokopi Kartu Keluarga', 'desc' => 'Kartu Keluarga terbaru yang masih berlaku.']
                    ]
                ],
                [
                    'slug' => 'ktp-el-hilang',
                    'icon' => 'search',
                    'category' => 'ktp-el',
                    'tag' => 'KEPENDUDUKAN',
                    'title' => 'KTP-el Hilang',
                    'desc' => 'Penggantian KTP-el yang dilaporkan hilang. Proses cepat dan mudah.',
                    'notice' => 'Syarat utama menyertakan surat kehilangan polisi dan KK.',
                    'requirements' => [
                        ['id' => 1, 'title' => 'Surat Kehilangan Polsek/Polres', 'desc' => 'Surat laporan kehilangan KTP dari kepolisian.'],
                        ['id' => 2, 'title' => 'Fotokopi Kartu Keluarga', 'desc' => 'Kartu Keluarga sesuai domisili pemohon.']
                    ]
                ],
                [
                    'slug' => 'ktp-el-rusak',
                    'icon' => 'alert-triangle',
                    'category' => 'ktp-el',
                    'tag' => 'KEPENDUDUKAN',
                    'title' => 'KTP-el Rusak',
                    'desc' => 'Penggantian KTP yang rusak atau tidak terbaca dengan menyerahkan KTP lama yang rusak.',
                    'notice' => 'KTP lama wajib diserahkan kepada petugas loket.',
                    'requirements' => [
                        ['id' => 1, 'title' => 'Fisik KTP-el Rusak', 'desc' => 'KTP lama yang patah, terkelupas, atau chip tidak terbaca.'],
                        ['id' => 2, 'title' => 'Fotokopi KK', 'desc' => 'Kartu Keluarga aktif.']
                    ]
                ],
                [
                    'slug' => 'perubahan-data-ktp-el',
                    'icon' => 'edit-2',
                    'category' => 'ktp-el',
                    'tag' => 'KEPENDUDUKAN',
                    'title' => 'Perubahan Data KTP-el',
                    'desc' => 'Ubah status, alamat, dll. pada dokumen KTP-el.',
                    'notice' => 'Perubahan data KTP harus selaras dengan Kartu Keluarga.',
                    'requirements' => [
                        ['id' => 1, 'title' => 'KK Terbaru Hasil Perubahan', 'desc' => 'Kartu Keluarga yang sudah diperbarui datanya.'],
                        ['id' => 2, 'title' => 'KTP-el Lama', 'desc' => 'Fisik KTP lama untuk ditarik petugas.']
                    ]
                ],
                [
                    'slug' => 'perekaman-ktp-el',
                    'icon' => 'camera',
                    'category' => 'ktp-el',
                    'tag' => 'KEPENDUDUKAN',
                    'title' => 'Perekaman KTP-el',
                    'desc' => 'Perekaman biometrik untuk WNI yang telah berusia 17 tahun atau lebih. Wajib dilakukan.',
                    'notice' => 'Perekaman mencakup foto, retina, dan 10 sidik jari.',
                    'requirements' => [
                        ['id' => 1, 'title' => 'Fotokopi KK', 'desc' => 'Membawa fotokopi Kartu Keluarga.'],
                        ['id' => 2, 'title' => 'Kehadiran Fisik Pemohon', 'desc' => 'Wajib hadir secara langsung untuk perekaman biometrik.']
                    ]
                ],
                [
                    'slug' => 'penerbitan-kia',
                    'icon' => 'id-card',
                    'category' => 'kependudukan',
                    'tag' => 'KEPENDUDUKAN',
                    'title' => 'Penerbitan KIA',
                    'desc' => 'Penerbitan Kartu Identitas Anak bagi anak di bawah usia 17 tahun.',
                    'notice' => 'Untuk anak usia 5-17 tahun melampirkan pas foto 2x3.',
                    'requirements' => [
                        ['id' => 1, 'title' => 'Fotokopi Akta Kelahiran', 'desc' => 'Akta kelahiran anak.'],
                        ['id' => 2, 'title' => 'Fotokopi KK Orang Tua', 'desc' => 'KK orang tua di mana anak terdaftar.'],
                        ['id' => 3, 'title' => 'Pas Foto 2x3 (2 Lembar)', 'desc' => 'Bagi anak usia 5 s.d 17 tahun kurang 1 hari.']
                    ]
                ],
                [
                    'slug' => 'penggantian-kia',
                    'icon' => 'refresh-cw',
                    'category' => 'kependudukan',
                    'tag' => 'KEPENDUDUKAN',
                    'title' => 'Penggantian KIA',
                    'desc' => 'Penggantian Kartu Identitas Anak yang hilang atau rusak.',
                    'notice' => 'Membawa KIA fisik lama jika rusak atau surat kehilangan jika hilang.',
                    'requirements' => [
                        ['id' => 1, 'title' => 'KIA Lama / Surat Kehilangan', 'desc' => 'Kartu fisik KIA rusak atau surat kehilangan polisi.'],
                        ['id' => 2, 'title' => 'Fotokopi KK', 'desc' => 'KK orang tua yang berlaku.']
                    ]
                ],
                [
                    'slug' => 'pindah-dalam-kabupaten',
                    'icon' => 'map-pin',
                    'category' => 'lainnya',
                    'tag' => 'PEMBATASAN SOSIAL',
                    'title' => 'Pindah Dalam Kabupaten',
                    'desc' => 'Layanan pengurusan surat pindah domisili yang masih dalam satu wilayah kabupaten.',
                    'notice' => 'Memastikan alamat tujuan sudah jelas.',
                    'requirements' => [
                        ['id' => 1, 'title' => 'KK Asli', 'desc' => 'Kartu Keluarga asli pemohon.'],
                        ['id' => 2, 'title' => 'Formulir Pindah F-1.03', 'desc' => 'Formulir permohonan pindah WNI.']
                    ]
                ],
                [
                    'slug' => 'pindah-antar-kabupaten',
                    'icon' => 'map',
                    'category' => 'lainnya',
                    'tag' => 'PINDAH',
                    'title' => 'Pindah Antar Kabupaten',
                    'desc' => 'Layanan pengurusan surat pindah domisili yang berpindah ke kabupaten lain.',
                    'notice' => 'SKPWNI akan diterbitkan untuk dibawa ke daerah tujuan.',
                    'requirements' => [
                        ['id' => 1, 'title' => 'KK Asli', 'desc' => 'Kartu Keluarga asal.'],
                        ['id' => 2, 'title' => 'KTP-el Asli', 'desc' => 'KTP-el pemohon yang akan ditarik/diperbarui.'],
                        ['id' => 3, 'title' => 'Formulir F-1.03', 'desc' => 'Form pendaftaran perpindahan penduduk.']
                    ]
                ],
                [
                    'slug' => 'pindah-antar-provinsi',
                    'icon' => 'navigation',
                    'category' => 'lainnya',
                    'tag' => 'PINDAH',
                    'title' => 'Pindah Antar Provinsi',
                    'desc' => 'Layanan pengurusan surat pindah domisili yang berpindah ke provinsi lain.',
                    'notice' => 'Proses menerbitkan Surat Keterangan Pindah WNI (SKPWNI).',
                    'requirements' => [
                        ['id' => 1, 'title' => 'KK Asli', 'desc' => 'KK asal pemohon.'],
                        ['id' => 2, 'title' => 'KTP-el Asli', 'desc' => 'KTP-el pemohon.'],
                        ['id' => 3, 'title' => 'Alamat Tujuan Lengkap', 'desc' => 'RT/RW, Desa/Kelurahan, Kecamatan, Kabupaten/Kota, Provinsi tujuan.']
                    ]
                ],
                [
                    'slug' => 'pindah-ke-luar-negeri',
                    'icon' => 'globe',
                    'category' => 'lainnya',
                    'tag' => 'PINDAH',
                    'title' => 'Pindah ke Luar Negeri',
                    'desc' => 'Layanan administrasi pindah bagi penduduk yang akan menetap di luar negeri.',
                    'notice' => 'Menyerahkan paspor dan KTP-el.',
                    'requirements' => [
                        ['id' => 1, 'title' => 'KK & KTP-el Asli', 'desc' => 'Dokumen identitas kependudukan Indonesia.'],
                        ['id' => 2, 'title' => 'Paspor & Visa', 'desc' => 'Fotokopi paspor dan izin tinggal/visa negara tujuan.'],
                        ['id' => 3, 'title' => 'Formulir Pindah LN', 'desc' => 'Formulir pendaftaran perpindahan ke luar negeri.']
                    ]
                ],
                [
                    'slug' => 'kedatangan-dari-luar-kabupaten',
                    'icon' => 'arrow-down-circle',
                    'category' => 'lainnya',
                    'tag' => 'SOSIAL KHUSUS',
                    'title' => 'Kedatangan dari Luar Kabupaten',
                    'desc' => 'Layanan bagi penduduk yang baru datang dari luar kabupaten dan mendaftar domisili.',
                    'notice' => 'Membawa SKPWNI dari daerah asal.',
                    'requirements' => [
                        ['id' => 1, 'title' => 'SKPWNI Asli', 'desc' => 'Surat Keterangan Pindah dari daerah asal.'],
                        ['id' => 2, 'title' => 'KK Tujuan / Pengantar RT/RW', 'desc' => 'KK tempat tujuan bergabung atau pengantar jika buat KK baru.']
                    ]
                ],
                [
                    'slug' => 'kedatangan-dari-luar-negeri',
                    'icon' => 'arrow-down-left',
                    'category' => 'lainnya',
                    'tag' => 'SOSIAL KHUSUS',
                    'title' => 'Kedatangan dari Luar Negeri',
                    'desc' => 'Layanan bagi WNI yang kembali dari luar negeri dan mendaftar kembali domisili.',
                    'notice' => 'Membawa paspor dengan stempel kedatangan imigrasi.',
                    'requirements' => [
                        ['id' => 1, 'title' => 'Paspor RI', 'desc' => 'Paspor asli dengan stempel kedatangan dari imigrasi.'],
                        ['id' => 2, 'title' => 'Surat Keterangan Pindah LN', 'desc' => 'SKP dari perwakilan RI di luar negeri (Perwakilan KBRI/KJRI).']
                    ]
                ],
                [
                    'slug' => 'pendataan-penduduk-rentan',
                    'icon' => 'shield',
                    'category' => 'kependudukan',
                    'tag' => 'DATA KEPENDUDUKAN',
                    'title' => 'Pendataan Penduduk Rentan',
                    'desc' => 'Pendataan khusus bagi kelompok rentan sosial yang membutuhkan layanan administrasi.',
                    'notice' => 'Petugas dapat melakukan pendataan secara jemput bola.',
                    'requirements' => [
                        ['id' => 1, 'title' => 'Surat Keterangan dari Dinas Sosial / Lembaga', 'desc' => 'Surat pengantar atau rekomendasi dari instansi sosial.'],
                        ['id' => 2, 'title' => 'Data Diri / Biometrik', 'desc' => 'Pencatatan fisik atau data biometrik yang ada.']
                    ]
                ],
                [
                    'slug' => 'pendataan-orang-asing',
                    'icon' => 'user-x',
                    'category' => 'kependudukan',
                    'tag' => 'DATA KEPENDUDUKAN',
                    'title' => 'Pendataan Orang Asing',
                    'desc' => 'Layanan pencatatan dan pengelolaan data warga negara asing yang tinggal di wilayah ini.',
                    'notice' => 'Melampirkan ITAS / ITAP dari Imigrasi.',
                    'requirements' => [
                        ['id' => 1, 'title' => 'Paspor & ITAS/ITAP', 'desc' => 'Paspor serta Izin Tinggal Terbatas / Tetap yang sah.'],
                        ['id' => 2, 'title' => 'Surat Keterangan Tempat Tinggal (SKTT)', 'desc' => 'Dokumen pendaftaran tempat tinggal WNA.']
                    ]
                ],
                [
                    'slug' => 'aktivasi-ikd',
                    'icon' => 'smartphone',
                    'category' => 'kependudukan',
                    'tag' => 'LAYANAN DIGITAL',
                    'title' => 'Aktivasi IKD',
                    'desc' => 'Aktivasi Identitas Kependudukan Digital untuk memudahkan akses layanan publik secara online.',
                    'notice' => 'Petugas akan memindai QR Code melalui aplikasi IKD di HP pemohon.',
                    'requirements' => [
                        ['id' => 1, 'title' => 'Sudah Memiliki KTP-el', 'desc' => 'Pemohon sudah pernah melakukan perekaman KTP-el.'],
                        ['id' => 2, 'title' => 'Smartphone Android / iOS', 'desc' => 'Memiliki HP dengan akses internet aktif.'],
                        ['id' => 3, 'title' => 'Email Aktif', 'desc' => 'Alamat email aktif untuk verifikasi akun IKD.']
                    ]
                ]
            ]
        ];
    }
}

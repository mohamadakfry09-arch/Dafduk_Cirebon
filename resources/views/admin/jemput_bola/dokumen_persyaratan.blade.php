<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir & Dokumen Persyaratan Jemput Bola - {{ $submission['nama_pemohon'] }} ({{ $submission['id'] }})</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f1f5f9;
            margin: 0;
            padding: 24px 16px;
            font-family: 'Times New Roman', Times, serif;
            color: #000000;
        }

        /* Top Action Bar (Hanya tampil di monitor layar) */
        .doc-toolbar {
            max-width: 820px;
            margin: 0 auto 20px auto;
            background: #ffffff;
            border-radius: 12px;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
            border: 1px solid #cbd5e1;
            font-family: 'Inter', sans-serif;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.2s;
        }
        .btn-print {
            background: #0f766e;
            color: #ffffff;
        }
        .btn-print:hover {
            background: #115e59;
        }
        .btn-back {
            background: #f8fafc;
            color: #334155;
            border-color: #cbd5e1;
        }
        .btn-back:hover {
            background: #f1f5f9;
        }
        .btn-doc {
            background: #0284c7;
            color: #ffffff;
        }
        .btn-doc:hover {
            background: #0369a1;
        }

        /* Kertas Dokumen Surat & Lampiran */
        .surat-permohonan-paper {
            background: #ffffff;
            color: #000000;
            font-family: 'Times New Roman', Times, serif;
            font-size: 15px;
            line-height: 1.55;
            padding: 50px 55px;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            max-width: 820px;
            margin: 0 auto 30px auto;
            box-sizing: border-box;
        }

        .surat-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            font-size: 15px;
            font-family: 'Times New Roman', Times, serif;
        }

        .surat-table td {
            padding: 2px 0;
            vertical-align: top;
            color: #000000;
        }

        .surat-table td.surat-lbl {
            width: 160px;
        }

        .surat-table td.surat-col {
            width: 25px;
            text-align: center;
        }

        .surat-table td.surat-val {
            color: #000000;
        }

        .page-break {
            page-break-before: always;
            break-before: page;
        }

        /* Preview Lampiran Dokumen */
        .lampiran-box {
            border: 1.5px dashed #64748b;
            border-radius: 8px;
            padding: 16px;
            background: #fafafa;
            margin-top: 14px;
            text-align: center;
        }

        .lampiran-box img {
            max-width: 100%;
            height: auto;
            border: 1px solid #cbd5e1;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            border-radius: 4px;
        }

        /* Aturan Cetak (Print View) */
        @media print {
            @page {
                size: A4 portrait;
                margin: 15mm 15mm 15mm 15mm;
            }
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .doc-toolbar {
                display: none !important;
            }
            .surat-permohonan-paper {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
                width: 100% !important;
                font-size: 12pt !important;
                line-height: 1.5 !important;
            }
            .surat-table {
                font-size: 12pt !important;
            }
            .page-break {
                page-break-before: always !important;
                break-before: page !important;
                margin-top: 0 !important;
                padding-top: 15mm !important;
            }
        }
    </style>
</head>
<body>

    <!-- Bar Navigasi Aksi Admin -->
    <div class="doc-toolbar">
        <div>
            <span style="font-size: 12px; color: #64748b; font-weight: 600;">Paket Formulir & Dokumen:</span>
            <strong style="color: #0D2E5A; font-size: 15px; margin-left: 6px;">{{ $submission['nama_pemohon'] }}</strong>
            <span style="margin-left: 8px; font-size: 11px; padding: 2px 8px; border-radius: 999px; background: #e0f2fe; color: #0369a1; font-weight: 700; text-transform: uppercase;">
                {{ $submission['id'] }}
            </span>
        </div>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('admin.jemput-bola') }}" class="btn btn-back">
                <span>← Kembali</span>
            </a>
            <button type="button" onclick="window.print()" class="btn btn-print">
                <span>🖨️ Cetak Formulir & Dokumen (Print)</span>
            </button>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- LEMBAR 1: FORMULIR SURAT PERMOHONAN RESMI (SESUAI GAMBAR) -->
    <!-- ======================================================== -->
    <div class="surat-permohonan-paper">
        <div style="margin-bottom: 22px;">
            Kepada Yth.<br>
            Kepala Dinas Kependudukan dan Pencatatan Sipil<br>
            Kabupaten Cirebon<br>
            di<br>
            &nbsp;&nbsp;&nbsp;&nbsp;Sumber
        </div>

        <div style="margin-bottom: 22px;">
            Perihal : Permohonan Perekaman KTP-el
        </div>

        <div style="margin-bottom: 12px;">
            Dengan Hormat,<br>
            Saya yang bertanda tangan di bawah ini:
        </div>

        <!-- Tabel 1: Identitas Pemohon -->
        <table class="surat-table">
            <tr>
                <td class="surat-lbl">Nama</td>
                <td class="surat-col">:</td>
                <td class="surat-val" style="font-weight: bold; text-transform: uppercase;">{{ $submission['nama_pemohon'] }}</td>
            </tr>
            <tr>
                <td class="surat-lbl">NIK</td>
                <td class="surat-col">:</td>
                <td class="surat-val" style="font-weight: bold;">{{ $submission['nik_pemohon'] }}</td>
            </tr>
            <tr>
                <td class="surat-lbl">Alamat</td>
                <td class="surat-col">:</td>
                <td class="surat-val" style="font-weight: bold;">{{ $submission['alamat_pemohon'] }}</td>
            </tr>
            <tr>
                <td class="surat-lbl">Hubungan</td>
                <td class="surat-col">:</td>
                <td class="surat-val" style="font-weight: bold;">{{ $submission['hubungan_pemohon'] }}</td>
            </tr>
        </table>

        <!-- Paragraf Isi Permohonan -->
        <div style="text-align: justify; text-justify: inter-word; line-height: 1.6; margin-bottom: 16px;">
            Dengan ini bermaksud mengajukan permohonan perekaman KTP Elektronik (KTP-el) di {{ $submission['alamat_dimohonkan'] }} dikarenakan {{ $submission['alasan_permohonan'] }} dan tidak memungkinkan untuk datang langsung ke Kantor Dinas Kependudukan dan Pencatatan Sipil. Adapun data yang akan dilakukan perekaman adalah sebagai berikut;
        </div>

        <!-- Tabel 2: Identitas Yang Dimohonkan -->
        <table class="surat-table">
            <tr>
                <td class="surat-lbl">Nama</td>
                <td class="surat-col">:</td>
                <td class="surat-val" style="font-weight: bold; text-transform: uppercase;">{{ $submission['nama_dimohonkan'] }}</td>
            </tr>
            <tr>
                <td class="surat-lbl">NIK</td>
                <td class="surat-col">:</td>
                <td class="surat-val" style="font-weight: bold;">{{ $submission['nik_dimohonkan'] }}</td>
            </tr>
            <tr>
                <td class="surat-lbl">Tempat/ Tgl Lahir</td>
                <td class="surat-col">:</td>
                <td class="surat-val" style="font-weight: bold;">{{ $submission['tempat_lahir_dimohonkan'] }}, {{ $submission['tgl_lahir_dimohonkan'] }}</td>
            </tr>
            <tr>
                <td class="surat-lbl">Alamat</td>
                <td class="surat-col">:</td>
                <td class="surat-val" style="font-weight: bold;">{{ $submission['alamat_dimohonkan'] }}</td>
            </tr>
            <tr>
                <td class="surat-lbl">Keterangan</td>
                <td class="surat-col">:</td>
                <td class="surat-val" style="font-weight: bold;">{{ $submission['keterangan_permohonan'] ?? '' }}</td>
            </tr>
        </table>

        <!-- Daftar Lampiran Surat -->
        <div style="margin-bottom: 4px;">
            Bersamaan surat ini, saya lampirkan:
        </div>
        <div style="margin-left: 20px; margin-bottom: 18px; line-height: 1.6;">
            <div>1. Photokopy Kartu Keluarga (KK)</div>
            <div>2. {{ !empty($submission['lampiran_2']) ? $submission['lampiran_2'] : 'Surat Keterangan Dokter / Puskesmas' }}</div>
            <div>3. {{ !empty($submission['lampiran_3']) ? $submission['lampiran_3'] : 'Surat Pengantar RT/RW / Desa' }}</div>
            <div>4. {{ !empty($submission['lampiran_4']) ? $submission['lampiran_4'] : 'Foto Kondisi Fisik Pemohon' }}</div>
        </div>

        <!-- Penutup Surat -->
        <div style="text-align: justify; text-justify: inter-word; line-height: 1.6; margin-bottom: 30px;">
            Demikian surat permohonan ini saya buat, besar harapan kami agar dapat dibantu dalam proses perekaman KTP-el, atas perhatian dan bantuan, kami ucapkan terima kasih.
        </div>

        <!-- Tanda Tangan Pemohon -->
        <div style="display: flex; justify-content: flex-end; margin-top: 24px;">
            <div style="text-align: center; width: 280px;">
                <div>{{ strtoupper($submission['kota_surat'] ?? 'CIREBON') }}, {{ $submission['tanggal_surat'] ?? date('d') }}</div>
                <div style="margin-top: 4px; margin-bottom: 6px;">Hormat kami,</div>
                <div style="height: 75px; display: flex; align-items: center; justify-content: center; margin-bottom: 6px;">
                    @if(!empty($submission['signature_data']))
                        <img src="{{ $submission['signature_data'] }}" alt="Tanda Tangan" style="max-height: 75px; max-width: 240px; display: block;" />
                    @else
                        <div style="height: 75px;"></div>
                    @endif
                </div>
                <div style="font-weight: bold; text-transform: uppercase;">
                    {{ $submission['nama_pemohon'] }}
                </div>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- LEMBAR 2: DOKUMEN PERSYARATAN & BERKAS LAMPIRAN          -->
    <!-- ======================================================== -->
    <div class="surat-permohonan-paper page-break">
        <div style="border-bottom: 2px solid #000000; padding-bottom: 12px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: flex-end;">
            <div>
                <h3 style="margin: 0; font-size: 16.5px; font-weight: bold; text-transform: uppercase;">
                    LAMPIRAN DOKUMEN PERSYARATAN JEMPUT BOLA
                </h3>
                <div style="font-size: 13px; color: #334155; margin-top: 4px;">
                    Pemerintah Kabupaten Cirebon &bull; Dinas Kependudukan dan Pencatatan Sipil
                </div>
            </div>
            <div style="text-align: right; font-size: 13px;">
                No. Registrasi: <strong>{{ $submission['id'] }}</strong>
            </div>
        </div>

        <!-- Ringkasan Keterangan Lampiran -->
        <table class="surat-table" style="margin-bottom: 18px;">
            <tr>
                <td class="surat-lbl" style="width: 180px;">Nama Pemohon</td>
                <td class="surat-col">:</td>
                <td class="surat-val" style="font-weight: bold; text-transform: uppercase;">{{ $submission['nama_pemohon'] }}</td>
            </tr>
            <tr>
                <td class="surat-lbl">NIK / No. Kartu Keluarga</td>
                <td class="surat-col">:</td>
                <td class="surat-val">{{ $submission['nik_pemohon'] }} / KK: {{ $submission['no_kk'] }}</td>
            </tr>
            <tr>
                <td class="surat-lbl">Yang Dimohonkan</td>
                <td class="surat-col">:</td>
                <td class="surat-val" style="font-weight: bold; text-transform: uppercase;">{{ $submission['nama_dimohonkan'] }}</td>
            </tr>
            <tr>
                <td class="surat-lbl">Alasan Jemput Bola</td>
                <td class="surat-col">:</td>
                <td class="surat-val" style="font-weight: bold; color: #000000;">{{ $submission['alasan_permohonan'] }}</td>
            </tr>
            @if(!empty($submission['lampiran_nama_asli']))
            <tr>
                <td class="surat-lbl">Nama File Berkas</td>
                <td class="surat-col">:</td>
                <td class="surat-val">{{ $submission['lampiran_nama_asli'] }}</td>
            </tr>
            @endif
        </table>

        <!-- Berkas Dokumen Fisik yang Diunggah Pemohon -->
        @if(!empty($submission['lampiran_file']) && file_exists(public_path(ltrim($submission['lampiran_file'], '/'))))
            @php
                $ext = strtolower(pathinfo($submission['lampiran_file'], PATHINFO_EXTENSION));
            @endphp

            @if(in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif']))
                <div class="lampiran-box">
                    <div style="font-size: 13px; font-weight: bold; margin-bottom: 10px; text-transform: uppercase;">
                        Foto Berkas Persyaratan (Kartu Keluarga / Surat Keterangan):
                    </div>
                    <img src="{{ asset($submission['lampiran_file']) }}" alt="Berkas Lampiran Persyaratan">
                </div>
            @elseif($ext === 'pdf')
                <div style="height: 720px; width: 100%; border: 1px solid #cbd5e1; border-radius: 4px; overflow: hidden; margin-top: 14px;">
                    <iframe src="{{ asset($submission['lampiran_file']) }}" style="width: 100%; height: 100%; border: none;"></iframe>
                </div>
            @else
                <div class="lampiran-box" style="padding: 30px;">
                    <div style="font-size: 36px; margin-bottom: 8px;">📎</div>
                    <div style="font-size: 15px; font-weight: bold;">{{ $submission['lampiran_nama_asli'] ?? basename($submission['lampiran_file']) }}</div>
                    <div style="font-size: 13px; color: #64748b; margin-top: 4px;">Berkas terlampir dalam sistem pendaftaran.</div>
                </div>
            @endif
        @else
            <!-- Lembar Verifikasi Dokumen Terdaftar -->
            <div style="border: 1px solid #000000; padding: 20px; border-radius: 4px; margin-top: 14px;">
                <div style="font-weight: bold; font-size: 14px; text-transform: uppercase; margin-bottom: 12px; border-bottom: 1px solid #000000; padding-bottom: 6px;">
                    Daftar Dokumen Persyaratan Yang Dilampirkan:
                </div>
                <ol style="margin: 0 0 16px 20px; padding: 0; line-height: 1.8;">
                    <li><strong>Fotokopi Kartu Keluarga (KK)</strong> — No. KK: {{ $submission['no_kk'] }}</li>
                    <li><strong>{{ !empty($submission['lampiran_2']) ? $submission['lampiran_2'] : 'Surat Keterangan Dokter Puskesmas / Medis' }}</strong> (Kondisi: {{ $submission['alasan_permohonan'] }})</li>
                    @if(!empty($submission['lampiran_3']))
                    <li><strong>{{ $submission['lampiran_3'] }}</strong></li>
                    @endif
                    @if(!empty($submission['lampiran_4']))
                    <li><strong>{{ $submission['lampiran_4'] }}</strong></li>
                    @endif
                </ol>

                <div style="font-size: 13.5px; line-height: 1.6; text-align: justify; margin-top: 16px;">
                    Dokumen persyaratan di atas telah diverifikasi kelengkapannya dalam sistem pendaftaran pelayanan Jemput Bola Disdukcapil Kabupaten Cirebon untuk permohonan perekaman KTP-el atas nama <strong>{{ $submission['nama_dimohonkan'] }}</strong>.
                </div>
            </div>
        @endif

        <!-- Lembar Paraf Verifikator Dokumen -->
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 36px;">
            <div style="font-size: 12px; color: #334155;">
                Dicetak pada: {{ date('d F Y') }}<br>
                Sistem Pelayanan Administrasi Kependudukan (Jemput Bola)
            </div>
            <div style="text-align: center; width: 260px;">
                <div>Petugas Verifikator Berkas,</div>
                <div style="height: 60px;"></div>
                <div style="font-weight: bold; text-decoration: underline; text-transform: uppercase;">
                    ( Tim Adminduk Jemput Bola )
                </div>
                <div style="font-size: 12px;">Disdukcapil Kab. Cirebon</div>
            </div>
        </div>
    </div>

</body>
</html>

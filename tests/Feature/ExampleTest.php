<?php

namespace Tests\Feature;

use App\Services\ServiceRepository;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_jemput_bola_service_exists_with_requirement_flow(): void
    {
        $data = ServiceRepository::getAllData();
        $service = collect($data['services'] ?? [])->firstWhere('slug', 'jemput-bola');

        $this->assertNotNull($service, 'Layanan Jemput Bola harus tersedia di katalog layanan.');
        $this->assertSame('Jemput Bola', $service['title']);
        $this->assertNotEmpty($service['requirements'] ?? []);
        $this->assertStringContainsString('syarat permohonan', strtolower($service['requirements'][0]['title'] ?? ''));
    }

    public function test_jemput_bola_public_page_contains_requirements_and_registration_form(): void
    {
        $response = $this->get('/pelayanan/jemput-bola');

        $response->assertStatus(200);
        $response->assertSee('Persyaratan Pengajuan');
        $response->assertSee('Formulir Pendaftaran Permohonan Jemput Bola');
        $response->assertSee('nama_pemohon');
        $response->assertSee('no_kk');
    }

    public function test_admin_dashboard_does_not_expose_running_bar_management(): void
    {
        $this->withSession(['is_admin' => true, 'admin_username' => 'Administrator'])
            ->get('/admin/dashboard')
            ->assertStatus(200)
            ->assertDontSee('Running Bar Active')
            ->assertDontSee('Pengumuman Running Bar')
            ->assertDontSee('Info Bar');

        $this->get('/admin/announcement')->assertStatus(404);
    }

    public function test_admin_jemput_bola_page_and_letter_print_format(): void
    {
        $response = $this->withSession(['is_admin' => true, 'admin_username' => 'Administrator'])
            ->get('/admin/jemput-bola');

        $response->assertStatus(200);
        $response->assertSee('Riwayat Permohonan Pemohon');
        $response->assertSee('Edit Semua Fitur Layanan Jemput Bola');

        // Test Cetak View matches requested screenshot format
        $cetakResponse = $this->withSession(['is_admin' => true, 'admin_username' => 'Administrator'])
            ->get('/admin/jemput-bola/cetak/JB-2026-001');

        $cetakResponse->assertStatus(200);
        $cetakResponse->assertSee('Kepada Yth.');
        $cetakResponse->assertSee('Perihal : Permohonan Perekaman KTP-el');
        $cetakResponse->assertSee('Saya yang bertanda tangan di bawah ini:');
        $cetakResponse->assertSee('Bersamaan surat ini, saya lampirkan:');

        // Test Dokumen View includes both Formulir and Dokumen Persyaratan
        $dokumenResponse = $this->withSession(['is_admin' => true, 'admin_username' => 'Administrator'])
            ->get('/admin/jemput-bola/dokumen/JB-2026-001');

        $dokumenResponse->assertStatus(200);
        $dokumenResponse->assertSee('Kepada Yth.');
        $dokumenResponse->assertSee('LAMPIRAN DOKUMEN PERSYARATAN JEMPUT BOLA');

        // Test Admin Login does not expose default credentials box
        $loginResponse = $this->get('/admin/login');
        $loginResponse->assertStatus(200);
        $loginResponse->assertDontSee('Akun Admin Default');
    }
}

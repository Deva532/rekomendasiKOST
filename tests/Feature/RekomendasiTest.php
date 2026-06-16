<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\FasilitasSeeder;
use Database\Seeders\KostSeeder;
use App\Models\Kost;

class RekomendasiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed database untuk test
        $this->seed(FasilitasSeeder::class);
        $this->seed(KostSeeder::class);
    }

    public function test_halaman_home_dapat_diakses()
    {
        $response = $this->get('/rekomendasi');
        $response->assertStatus(200);
        $response->assertViewHas('fasilitas');
    }

    public function test_proses_rekomendasi_menyimpan_session()
    {
        $response = $this->post('/proses', [
            'harga_max' => 500000,
            'jarak_max' => 1000,
            'jenis_kost' => 'putra',
            'fasilitas' => [1, 2]
        ]);

        $response->assertStatus(200);
        $response->assertSessionHas('preferensi_rekomendasi');
        $response->assertViewHas(['utama', 'alternatif']);

        $preferensi = session('preferensi_rekomendasi');
        $this->assertEquals(500000, $preferensi['harga_max']);
        $this->assertEquals(1000, $preferensi['jarak_max']);
        $this->assertEquals('putra', $preferensi['jenis_kost']);
    }

    public function test_proses_perhitungan_memerlukan_session()
    {
        // Tanpa session, harus redirect
        $response = $this->get('/rekomendasi/proses-perhitungan');
        $response->assertRedirect('/rekomendasi');

        // Dengan session
        $responseWithSession = $this->withSession([
            'preferensi_rekomendasi' => [
                'harga_max' => 500000,
                'jarak_max' => 1000,
                'jenis_kost' => 'putra',
                'fasilitas' => []
            ]
        ])->get('/rekomendasi/proses-perhitungan');

        $responseWithSession->assertStatus(200);
        $responseWithSession->assertViewHas(['semuaKost', 'preferensi']);
    }

    public function test_detail_perhitungan_memerlukan_session_dan_id_valid()
    {
        $kost = Kost::first();

        // Tanpa session
        $response = $this->get("/rekomendasi/detail/{$kost->id}");
        $response->assertRedirect('/rekomendasi');

        // Dengan session dan id valid
        $responseWithSession = $this->withSession([
            'preferensi_rekomendasi' => [
                'harga_max' => 500000,
                'jarak_max' => 1000,
                'jenis_kost' => 'putra',
                'fasilitas' => []
            ]
        ])->get("/rekomendasi/detail/{$kost->id}");

        $responseWithSession->assertStatus(200);
        $responseWithSession->assertViewHas(['kost', 'preferensi', 'rank']);
    }
}

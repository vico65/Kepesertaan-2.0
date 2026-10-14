<?php

namespace Tests\Feature;

use App\Models\MasterBu;
use App\Models\RiwayatBulananBu;
use App\Models\Staff;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BadanUsahaViewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test halaman view badan usaha dapat diakses dan mengembalikan status 200.
     */
    public function test_badan_usaha_view_returns_successful_response(): void
    {
        $response = $this->get('/badan-usaha');

        $response->assertStatus(200);
        $response->assertSee('Data Badan Usaha');
    }

    /**
     * Test data badan usaha beserta nama RO muncul pada tabel.
     */
    public function test_badan_usaha_view_displays_badan_usaha_and_ro(): void
    {
        $staff = Staff::create([
            'name'    => 'Budi Santoso',
            'email'   => 'budi@example.com',
            'passkey' => bcrypt('password123'),
            'status'  => 'active',
        ]);

        $bu = MasterBu::create([
            'kode_entitas' => 'ENT-999',
            'kode_bu'      => 'BU-999',
            'nama_bu'      => 'PT Maju Terus Pantang Mundur',
            'tmt_bu'       => '2026-01-01',
        ]);

        RiwayatBulananBu::create([
            'kode_entitas'        => $bu->kode_entitas,
            'npp_staff'           => $staff->npp,
            'periode'             => '2026-10',
            'jumlah_tenaga_kerja' => 50,
            'jumlah_angkel'       => 2,
            'jenis_bu'            => 'Menengah',
        ]);

        $response = $this->get('/badan-usaha');

        $response->assertStatus(200);
        $response->assertSee('ENT-999');
        $response->assertSee('BU-999');
        $response->assertSee('PT Maju Terus Pantang Mundur');
        $response->assertSee('Budi Santoso');
        $response->assertSee('Menengah');
    }

    /**
     * Test pesan kosong tampil saat belum ada data badan usaha.
     */
    public function test_badan_usaha_view_shows_empty_message_when_no_data(): void
    {
        $response = $this->get('/badan-usaha');

        $response->assertStatus(200);
        $response->assertSee('Belum ada data badan usaha.');
    }
}

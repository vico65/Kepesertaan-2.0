<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\MasterBu;
use App\Models\RiwayatBulananBu;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;

class BadanUsahaRegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test registrasi master badan usaha baru berhasil sesuai spesifikasi issue.
     */
    public function test_badan_usaha_registration_success(): void
    {
        // Payload sesuai contoh pada deskripsi issue
        $payload = [
            'kode_entitas'  => '000123456',
            'kode_bu'       => 'BU-9988',
            'nama_bu'       => 'PT Bina Maju Palembang',
            'nama_dati_2'   => 'Palembang',
            'alamat_bu'     => 'Jl. Jend. Sudirman No. 123',
            'jenis_usaha'   => 'Perdagangan',
            'nama_pimpinan' => 'Ahmad Santoso',
            'email_bu'      => 'info@binamaju.co.id',
        ];

        $response = $this->postJson('/api/badan-usaha', $payload);

        // Memastikan status code 201 Created
        $response->assertStatus(201);

        // Memastikan response body sesuai spesifikasi
        $response->assertExactJson([
            'message' => 'Badan Usaha berhasil ditambahkan',
        ]);

        // Memastikan record tersimpan di tabel master_bu
        $this->assertDatabaseHas('master_bu', [
            'kode_entitas'  => '000123456',
            'kode_bu'       => 'BU-9988',
            'nama_bu'       => 'PT Bina Maju Palembang',
            'nama_dati_2'   => 'Palembang',
            'alamat_bu'     => 'Jl. Jend. Sudirman No. 123',
            'jenis_usaha'   => 'Perdagangan',
            'nama_pimpinan' => 'Ahmad Santoso',
            'email_bu'      => 'info@binamaju.co.id',
        ]);

        // Memastikan tmt_bu otomatis terisi jika tidak dikirimkan di payload
        $bu = MasterBu::find('000123456');
        $this->assertNotNull($bu);
        $this->assertEquals(now()->toDateString(), $bu->tmt_bu);
    }

    /**
     * Test registrasi badan usaha dengan seluruh field lengkap termasuk tmt_bu dan data PIC.
     */
    public function test_badan_usaha_registration_with_all_fields(): void
    {
        $payload = [
            'kode_entitas'        => '000999888',
            'kode_bu'             => 'BU-1234',
            'nama_bu'             => 'PT Sukses Makmur Abadi',
            'nama_dati_2'         => 'Palembang',
            'kecamatan_bu'        => 'Ilir Timur I',
            'kelurahan_bu'        => '16 Ilir',
            'alamat_bu'           => 'Jl. Sudirman KM 3.5',
            'jenis_usaha'         => 'Manufaktur',
            'detail_jenis_usaha'  => 'Pabrik Tekstil',
            'tmt_bu'              => '2026-01-15',
            'nama_pimpinan'       => 'Budi Hartono',
            'telp_bu'             => '0711-123456',
            'email_bu'            => 'hrd@suksesmakmur.com',
            'nama_pic'            => 'Siti Rahma',
            'jabatan_pic'         => 'Manager HRD',
            'telp_pic'            => '0711-654321',
            'hp_pic'              => '081234567890',
            'email_pic'           => 'siti.rahma@suksesmakmur.com',
        ];

        $response = $this->postJson('/api/badan-usaha', $payload);

        $response->assertStatus(201);
        $response->assertExactJson([
            'message' => 'Badan Usaha berhasil ditambahkan',
        ]);

        $this->assertDatabaseHas('master_bu', [
            'kode_entitas' => '000999888',
            'kode_bu'      => 'BU-1234',
            'tmt_bu'       => '2026-01-15',
            'nama_pic'     => 'Siti Rahma',
            'email_pic'    => 'siti.rahma@suksesmakmur.com',
        ]);
    }

    /**
     * Test registrasi badan usaha gagal jika validasi tidak terpenuhi (field required kosong).
     */
    public function test_badan_usaha_registration_fails_on_validation_error(): void
    {
        // Payload tanpa kode_entitas, kode_bu, dan nama_bu
        $payload = [
            'nama_dati_2' => 'Palembang',
        ];

        $response = $this->postJson('/api/badan-usaha', $payload);

        // Memastikan status code 400 Bad Request
        $response->assertStatus(400);

        // Memastikan response body error sesuai spesifikasi
        $response->assertExactJson([
            'message' => 'Badan Usaha gagal ditambahkan',
        ]);
    }

    /**
     * Test registrasi badan usaha gagal jika kode_entitas duplikat.
     */
    public function test_badan_usaha_registration_fails_on_duplicate_kode_entitas(): void
    {
        // Buat record badan usaha pertama
        MasterBu::create([
            'kode_entitas' => '000123456',
            'kode_bu'      => 'BU-1111',
            'nama_bu'      => 'PT Pertama',
        ]);

        // Coba registrasi badan usaha baru dengan kode_entitas yang sama
        $payload = [
            'kode_entitas' => '000123456',
            'kode_bu'      => 'BU-2222',
            'nama_bu'      => 'PT Kedua',
        ];

        $response = $this->postJson('/api/badan-usaha', $payload);

        $response->assertStatus(400);
        $response->assertExactJson([
            'message' => 'Badan Usaha gagal ditambahkan',
        ]);
    }

    /**
     * Test registrasi badan usaha gagal jika kode_bu duplikat.
     */
    public function test_badan_usaha_registration_fails_on_duplicate_kode_bu(): void
    {
        // Buat record badan usaha pertama
        MasterBu::create([
            'kode_entitas' => '000111111',
            'kode_bu'      => 'BU-DUPLICATE',
            'nama_bu'      => 'PT Pertama',
        ]);

        // Coba registrasi badan usaha baru dengan kode_bu yang sama
        $payload = [
            'kode_entitas' => '000222222',
            'kode_bu'      => 'BU-DUPLICATE',
            'nama_bu'      => 'PT Kedua',
        ];

        $response = $this->postJson('/api/badan-usaha', $payload);

        $response->assertStatus(400);
        $response->assertExactJson([
            'message' => 'Badan Usaha gagal ditambahkan',
        ]);
    }

    /**
     * Test relasi antara MasterBu, RiwayatBulananBu, dan Staff berjalan dengan baik.
     */
    public function test_master_bu_and_riwayat_bulanan_relationships(): void
    {
        // Buat staff
        $staff = Staff::create([
            'name'    => 'Pembina Staff',
            'email'   => 'pembina@bpjs.go.id',
            'passkey' => Hash::make('password123'),
        ]);

        // Buat master badan usaha
        $bu = MasterBu::create([
            'kode_entitas' => '000555666',
            'kode_bu'      => 'BU-5566',
            'nama_bu'      => 'PT Relasi Mandiri',
        ]);

        // Buat riwayat bulanan yang menunjuk ke badan usaha dan staff
        $riwayat = RiwayatBulananBu::create([
            'kode_entitas'        => $bu->kode_entitas,
            'npp_staff'           => $staff->npp,
            'periode'             => '2026-10',
            'jumlah_tenaga_kerja' => 50,
            'jumlah_angkel'       => 120,
            'jenis_bu'            => 'Menengah',
        ]);

        // Verifikasi relasi dari MasterBu ke RiwayatBulananBu
        $this->assertCount(1, $bu->riwayatBulanan);
        $this->assertEquals('2026-10', $bu->riwayatBulanan->first()->periode);

        // Verifikasi relasi dari RiwayatBulananBu ke MasterBu
        $this->assertEquals($bu->kode_entitas, $riwayat->masterBu->kode_entitas);
        $this->assertEquals('PT Relasi Mandiri', $riwayat->masterBu->nama_bu);

        // Verifikasi relasi dari RiwayatBulananBu ke Staff
        $this->assertEquals($staff->npp, $riwayat->staff->npp);
        $this->assertEquals('Pembina Staff', $riwayat->staff->name);

        // Verifikasi relasi dari Staff ke RiwayatBulananBu
        $this->assertCount(1, $staff->riwayatBulanan);
        $this->assertEquals($riwayat->id, $staff->riwayatBulanan->first()->id);
    }
}

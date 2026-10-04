<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\Staff;

class StaffRegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test registrasi staff baru berhasil sesuai spesifikasi.
     */
    public function test_staff_registration_success(): void
    {
        $payload = [
            'name' => 'staff',
            'email' => 'staff@gmail.com',
            'passkey' => 'rahasia',
        ];

        $response = $this->postJson('/api/staff', $payload);

        // Memastikan status code 201 Created
        $response->assertStatus(201);

        // Memastikan response body sesuai spesifikasi
        $response->assertExactJson([
            'message' => 'User berhasil ditambahkan',
        ]);

        // Memastikan record tersimpan di database
        $this->assertDatabaseHas('staff', [
            'name' => 'staff',
            'email' => 'staff@gmail.com',
            'status' => 'active',
        ]);

        // Memastikan passkey ter-hash dengan algoritma Bcrypt
        $staff = Staff::where('email', 'staff@gmail.com')->first();
        $this->assertNotNull($staff);
        $this->assertNotEquals('rahasia', $staff->passkey);
        $this->assertTrue(Hash::check('rahasia', $staff->passkey));
    }

    /**
     * Test registrasi staff gagal jika validasi tidak terpenuhi.
     */
    public function test_staff_registration_fails_on_validation_error(): void
    {
        // Payload tanpa field name dan email tidak valid
        $payload = [
            'email' => 'bukan-email',
            'passkey' => '',
        ];

        $response = $this->postJson('/api/staff', $payload);

        // Memastikan status code 400 Bad Request
        $response->assertStatus(400);

        // Memastikan response body error sesuai spesifikasi
        $response->assertExactJson([
            'message' => 'User gagal ditambahkan',
        ]);
    }

    /**
     * Test registrasi staff gagal jika email sudah terdaftar (duplikat).
     */
    public function test_staff_registration_fails_on_duplicate_email(): void
    {
        // Buat staff pertama
        Staff::create([
            'name' => 'Existing Staff',
            'email' => 'staff@gmail.com',
            'passkey' => Hash::make('password123'),
        ]);

        // Coba mendaftarkan staff dengan email yang sama
        $payload = [
            'name' => 'staff duplikat',
            'email' => 'staff@gmail.com',
            'passkey' => 'rahasia',
        ];

        $response = $this->postJson('/api/staff', $payload);

        // Response harus 400
        $response->assertStatus(400);

        // Memastikan response body error
        $response->assertExactJson([
            'message' => 'User gagal ditambahkan',
        ]);
    }
}

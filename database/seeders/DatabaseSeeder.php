<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => 'password',
            ]
        );

        // Jalankan seeder data dummy secara berurutan
        // PENTING: Urutan harus Staff -> MasterBu -> RiwayatBulananBu
        // karena riwayat_bulanan_bu memiliki foreign key ke staff dan master_bu
        $this->call([
            StaffSeeder::class,
            MasterBuSeeder::class,
            RiwayatBulananBuSeeder::class,
        ]);
    }
}


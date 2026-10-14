<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RiwayatBulananBu;
use App\Models\Staff;

class RiwayatBulananBuSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil staff yang aktif untuk dijadikan RO
        $activeStaffs = Staff::where('status', 'active')->orderBy('npp')->pluck('npp')->toArray();

        // Fallback jika belum ada data staff, gunakan index 1..4
        $npp1 = $activeStaffs[0] ?? 1;
        $npp2 = $activeStaffs[1] ?? 2;
        $npp3 = $activeStaffs[2] ?? 3;
        $npp4 = $activeStaffs[3] ?? 4;

        $riwayatList = [
            [
                'kode_entitas'        => 'ENT-001',
                'npp_staff'           => $npp1,
                'periode'             => '2026-10',
                'jumlah_tenaga_kerja' => 150,
                'jumlah_angkel'       => 5,
                'jenis_bu'            => 'Besar',
            ],
            [
                'kode_entitas'        => 'ENT-002',
                'npp_staff'           => $npp2,
                'periode'             => '2026-10',
                'jumlah_tenaga_kerja' => 45,
                'jumlah_angkel'       => 2,
                'jenis_bu'            => 'Kecil',
            ],
            [
                'kode_entitas'        => 'ENT-003',
                'npp_staff'           => $npp1,
                'periode'             => '2026-10',
                'jumlah_tenaga_kerja' => 80,
                'jumlah_angkel'       => 3,
                'jenis_bu'            => 'Menengah',
            ],
            [
                'kode_entitas'        => 'ENT-004',
                'npp_staff'           => $npp3,
                'periode'             => '2026-10',
                'jumlah_tenaga_kerja' => 20,
                'jumlah_angkel'       => 1,
                'jenis_bu'            => 'Kecil',
            ],
            [
                'kode_entitas'        => 'ENT-005',
                'npp_staff'           => $npp4,
                'periode'             => '2026-10',
                'jumlah_tenaga_kerja' => 200,
                'jumlah_angkel'       => 8,
                'jenis_bu'            => 'Besar',
            ],
            [
                'kode_entitas'        => 'ENT-006',
                'npp_staff'           => $npp2,
                'periode'             => '2026-10',
                'jumlah_tenaga_kerja' => 35,
                'jumlah_angkel'       => 1,
                'jenis_bu'            => 'Kecil',
            ],
            [
                'kode_entitas'        => 'ENT-007',
                'npp_staff'           => $npp3,
                'periode'             => '2026-10',
                'jumlah_tenaga_kerja' => 15,
                'jumlah_angkel'       => 1,
                'jenis_bu'            => 'Mikro',
            ],
            [
                'kode_entitas'        => 'ENT-008',
                'npp_staff'           => $npp1,
                'periode'             => '2026-10',
                'jumlah_tenaga_kerja' => 60,
                'jumlah_angkel'       => 3,
                'jenis_bu'            => 'Menengah',
            ],
            [
                'kode_entitas'        => 'ENT-009',
                'npp_staff'           => $npp4,
                'periode'             => '2026-10',
                'jumlah_tenaga_kerja' => 10,
                'jumlah_angkel'       => 0,
                'jenis_bu'            => 'Mikro',
            ],
            [
                'kode_entitas'        => 'ENT-010',
                'npp_staff'           => $npp2,
                'periode'             => '2026-10',
                'jumlah_tenaga_kerja' => 120,
                'jumlah_angkel'       => 4,
                'jenis_bu'            => 'Besar',
            ],
        ];

        foreach ($riwayatList as $riwayat) {
            RiwayatBulananBu::updateOrCreate(
                [
                    'kode_entitas' => $riwayat['kode_entitas'],
                    'periode'      => $riwayat['periode'],
                ],
                $riwayat
            );
        }
    }
}

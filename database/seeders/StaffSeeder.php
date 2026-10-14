<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $staffs = [
            [
                'name'    => 'Andi Pratama',
                'email'   => 'andi.pratama@kepesertaan.co.id',
                'passkey' => Hash::make('password123'),
                'status'  => 'active',
            ],
            [
                'name'    => 'Budi Santoso',
                'email'   => 'budi.santoso@kepesertaan.co.id',
                'passkey' => Hash::make('password123'),
                'status'  => 'active',
            ],
            [
                'name'    => 'Citra Dewi',
                'email'   => 'citra.dewi@kepesertaan.co.id',
                'passkey' => Hash::make('password123'),
                'status'  => 'active',
            ],
            [
                'name'    => 'Dimas Nugroho',
                'email'   => 'dimas.nugroho@kepesertaan.co.id',
                'passkey' => Hash::make('password123'),
                'status'  => 'active',
            ],
            [
                'name'    => 'Eka Putri',
                'email'   => 'eka.putri@kepesertaan.co.id',
                'passkey' => Hash::make('password123'),
                'status'  => 'inactive',
            ],
        ];

        foreach ($staffs as $staff) {
            Staff::updateOrCreate(
                ['email' => $staff['email']],
                $staff
            );
        }
    }
}

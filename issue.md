# 📋 Issue: Implementasi View Data Badan Usaha

> **Priority**: Medium  
> **Type**: Feature  
> **Assignee**: Junior Programmer / AI Model  
> **Estimasi**: 2–4 jam  
> **Tanggal**: 14 Oktober 2026

---

## 🎯 Tujuan

Membuat halaman web (view) untuk menampilkan **seluruh data badan usaha** beserta **nama RO (Relationship Officer / Staff)** yang memegang masing-masing badan usaha. Data ditampilkan dalam bentuk **tabel HTML** dengan UI modern bernuansa **hijau dan biru**.

Sebelum membuat view, kita perlu menyiapkan **data dummy** terlebih dahulu agar halaman tidak kosong saat development.

---

## 📌 Ringkasan Pekerjaan

| No | Task | File yang Dibuat/Diubah |
|----|------|------------------------|
| 1 | Buat Seeder data dummy Staff | `database/seeders/StaffSeeder.php` |
| 2 | Buat Seeder data dummy Master BU | `database/seeders/MasterBuSeeder.php` |
| 3 | Buat Seeder data dummy Riwayat Bulanan BU | `database/seeders/RiwayatBulananBuSeeder.php` |
| 4 | Daftarkan semua seeder ke DatabaseSeeder | `database/seeders/DatabaseSeeder.php` |
| 5 | Jalankan seeder | Terminal (artisan command) |
| 6 | Buat Controller untuk view BU | `app/Http/Controllers/BadanUsahaViewController.php` |
| 7 | Buat Blade view halaman tabel BU | `resources/views/badan-usaha/index.blade.php` |
| 8 | Daftarkan route web | `routes/web.php` |

---

## 📦 TAHAP 1: Buat Data Dummy (Seeder)

### 1.1 — Seeder Staff (`database/seeders/StaffSeeder.php`)

Buat file baru `database/seeders/StaffSeeder.php` dengan isi sebagai berikut:

```php
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
            Staff::create($staff);
        }
    }
}
```

> **Penjelasan:**  
> - Membuat 5 data staff dengan nama Indonesia yang realistis.  
> - Password semuanya `password123` (hanya untuk dummy, jangan dipakai di production).  
> - 4 staff berstatus `active`, 1 staff `inactive`.  
> - Primary key `npp` akan auto-increment otomatis (1–5).

---

### 1.2 — Seeder Master Badan Usaha (`database/seeders/MasterBuSeeder.php`)

Buat file baru `database/seeders/MasterBuSeeder.php` dengan isi sebagai berikut:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterBu;

class MasterBuSeeder extends Seeder
{
    public function run(): void
    {
        $badanUsahaList = [
            [
                'kode_entitas'       => 'ENT-001',
                'kode_bu'            => 'BU-001',
                'nama_bu'            => 'PT Maju Bersama Sejahtera',
                'nama_dati_2'        => 'Kota Bandung',
                'kecamatan_bu'       => 'Coblong',
                'kelurahan_bu'       => 'Dago',
                'alamat_bu'          => 'Jl. Ir. H. Juanda No. 100, Bandung',
                'jenis_usaha'        => 'Manufaktur',
                'detail_jenis_usaha' => 'Pabrik Tekstil',
                'tmt_bu'             => '2020-01-15',
                'nama_pimpinan'      => 'Hendra Wijaya',
                'telp_bu'            => '022-1234567',
                'email_bu'           => 'info@majubersama.co.id',
                'nama_pic'           => 'Rina Marlina',
                'jabatan_pic'        => 'HRD Manager',
                'telp_pic'           => '022-1234568',
                'hp_pic'             => '081234567890',
                'email_pic'          => 'rina@majubersama.co.id',
            ],
            [
                'kode_entitas'       => 'ENT-002',
                'kode_bu'            => 'BU-002',
                'nama_bu'            => 'CV Teknologi Nusantara',
                'nama_dati_2'        => 'Kota Jakarta Selatan',
                'kecamatan_bu'       => 'Kebayoran Baru',
                'kelurahan_bu'       => 'Senayan',
                'alamat_bu'          => 'Jl. Sudirman Kav. 52-53, Jakarta',
                'jenis_usaha'        => 'Teknologi Informasi',
                'detail_jenis_usaha' => 'Software Development',
                'tmt_bu'             => '2019-06-20',
                'nama_pimpinan'      => 'Agus Setiawan',
                'telp_bu'            => '021-5551234',
                'email_bu'           => 'hello@teknusa.id',
                'nama_pic'           => 'Dewi Anggraini',
                'jabatan_pic'        => 'Finance Manager',
                'telp_pic'           => '021-5551235',
                'hp_pic'             => '081298765432',
                'email_pic'          => 'dewi@teknusa.id',
            ],
            [
                'kode_entitas'       => 'ENT-003',
                'kode_bu'            => 'BU-003',
                'nama_bu'            => 'PT Sinar Abadi Perkasa',
                'nama_dati_2'        => 'Kota Surabaya',
                'kecamatan_bu'       => 'Gubeng',
                'kelurahan_bu'       => 'Airlangga',
                'alamat_bu'          => 'Jl. Dharmahusada No. 45, Surabaya',
                'jenis_usaha'        => 'Perdagangan',
                'detail_jenis_usaha' => 'Distribusi Bahan Bangunan',
                'tmt_bu'             => '2021-03-10',
                'nama_pimpinan'      => 'Bambang Suryono',
                'telp_bu'            => '031-7891234',
                'email_bu'           => 'admin@sinarabadi.com',
                'nama_pic'           => 'Lina Hartati',
                'jabatan_pic'        => 'Admin Staff',
                'telp_pic'           => '031-7891235',
                'hp_pic'             => '085612345678',
                'email_pic'          => 'lina@sinarabadi.com',
            ],
            [
                'kode_entitas'       => 'ENT-004',
                'kode_bu'            => 'BU-004',
                'nama_bu'            => 'UD Karya Mandiri',
                'nama_dati_2'        => 'Kabupaten Sleman',
                'kecamatan_bu'       => 'Depok',
                'kelurahan_bu'       => 'Caturtunggal',
                'alamat_bu'          => 'Jl. Kaliurang KM 7, Sleman, Yogyakarta',
                'jenis_usaha'        => 'Jasa',
                'detail_jenis_usaha' => 'Jasa Konstruksi',
                'tmt_bu'             => '2022-08-01',
                'nama_pimpinan'      => 'Suharto',
                'telp_bu'            => '0274-551234',
                'email_bu'           => 'info@karyamandiri.co.id',
                'nama_pic'           => 'Yuni Astuti',
                'jabatan_pic'        => 'Kepala Operasional',
                'telp_pic'           => '0274-551235',
                'hp_pic'             => '087712345678',
                'email_pic'          => 'yuni@karyamandiri.co.id',
            ],
            [
                'kode_entitas'       => 'ENT-005',
                'kode_bu'            => 'BU-005',
                'nama_bu'            => 'PT Global Makmur Indonesia',
                'nama_dati_2'        => 'Kota Medan',
                'kecamatan_bu'       => 'Medan Baru',
                'kelurahan_bu'       => 'Darat',
                'alamat_bu'          => 'Jl. Gatot Subroto No. 88, Medan',
                'jenis_usaha'        => 'Perdagangan',
                'detail_jenis_usaha' => 'Ekspor Kelapa Sawit',
                'tmt_bu'             => '2018-11-25',
                'nama_pimpinan'      => 'Taufik Hidayat',
                'telp_bu'            => '061-4561234',
                'email_bu'           => 'export@globalmakmur.co.id',
                'nama_pic'           => 'Sari Indah',
                'jabatan_pic'        => 'Manajer Keuangan',
                'telp_pic'           => '061-4561235',
                'hp_pic'             => '082198765432',
                'email_pic'          => 'sari@globalmakmur.co.id',
            ],
            [
                'kode_entitas'       => 'ENT-006',
                'kode_bu'            => 'BU-006',
                'nama_bu'            => 'CV Berkah Sentosa',
                'nama_dati_2'        => 'Kota Semarang',
                'kecamatan_bu'       => 'Banyumanik',
                'kelurahan_bu'       => 'Tembalang',
                'alamat_bu'          => 'Jl. Prof. Sudarto No. 10, Semarang',
                'jenis_usaha'        => 'Manufaktur',
                'detail_jenis_usaha' => 'Pabrik Makanan Ringan',
                'tmt_bu'             => '2023-02-14',
                'nama_pimpinan'      => 'Wahyu Prasetyo',
                'telp_bu'            => '024-7651234',
                'email_bu'           => 'cs@berkahsentosa.com',
                'nama_pic'           => 'Mega Putri',
                'jabatan_pic'        => 'Staf HRD',
                'telp_pic'           => '024-7651235',
                'hp_pic'             => '089876543210',
                'email_pic'          => 'mega@berkahsentosa.com',
            ],
            [
                'kode_entitas'       => 'ENT-007',
                'kode_bu'            => 'BU-007',
                'nama_bu'            => 'PT Pelita Harapan Bangsa',
                'nama_dati_2'        => 'Kota Makassar',
                'kecamatan_bu'       => 'Panakkukang',
                'kelurahan_bu'       => 'Masale',
                'alamat_bu'          => 'Jl. A.P. Pettarani No. 55, Makassar',
                'jenis_usaha'        => 'Jasa',
                'detail_jenis_usaha' => 'Jasa Konsultan Manajemen',
                'tmt_bu'             => '2021-07-19',
                'nama_pimpinan'      => 'Rahmat Saleh',
                'telp_bu'            => '0411-8901234',
                'email_bu'           => 'contact@pelitaharapan.co.id',
                'nama_pic'           => 'Aisyah Nurdin',
                'jabatan_pic'        => 'Sekretaris Direksi',
                'telp_pic'           => '0411-8901235',
                'hp_pic'             => '081356789012',
                'email_pic'          => 'aisyah@pelitaharapan.co.id',
            ],
            [
                'kode_entitas'       => 'ENT-008',
                'kode_bu'            => 'BU-008',
                'nama_bu'            => 'PT Cipta Karya Digital',
                'nama_dati_2'        => 'Kota Tangerang Selatan',
                'kecamatan_bu'       => 'Serpong',
                'kelurahan_bu'       => 'Lengkong Karya',
                'alamat_bu'          => 'BSD Green Office Park, Tangerang Selatan',
                'jenis_usaha'        => 'Teknologi Informasi',
                'detail_jenis_usaha' => 'Digital Marketing Agency',
                'tmt_bu'             => '2023-09-05',
                'nama_pimpinan'      => 'Reza Firmansyah',
                'telp_bu'            => '021-29001234',
                'email_bu'           => 'info@ciptakarya.digital',
                'nama_pic'           => 'Fitri Handayani',
                'jabatan_pic'        => 'Office Manager',
                'telp_pic'           => '021-29001235',
                'hp_pic'             => '087654321098',
                'email_pic'          => 'fitri@ciptakarya.digital',
            ],
            [
                'kode_entitas'       => 'ENT-009',
                'kode_bu'            => 'BU-009',
                'nama_bu'            => 'Koperasi Sejahtera Bersama',
                'nama_dati_2'        => 'Kabupaten Bogor',
                'kecamatan_bu'       => 'Cibinong',
                'kelurahan_bu'       => 'Tengah',
                'alamat_bu'          => 'Jl. Raya Bogor KM 46, Cibinong',
                'jenis_usaha'        => 'Koperasi',
                'detail_jenis_usaha' => 'Koperasi Simpan Pinjam',
                'tmt_bu'             => '2017-04-01',
                'nama_pimpinan'      => 'Suparman',
                'telp_bu'            => '021-87901234',
                'email_bu'           => 'koperasi@sejahterabersama.or.id',
                'nama_pic'           => 'Endang Susilawati',
                'jabatan_pic'        => 'Bendahara',
                'telp_pic'           => '021-87901235',
                'hp_pic'             => '083112345678',
                'email_pic'          => 'endang@sejahterabersama.or.id',
            ],
            [
                'kode_entitas'       => 'ENT-010',
                'kode_bu'            => 'BU-010',
                'nama_bu'            => 'PT Nusantara Logistik Terpadu',
                'nama_dati_2'        => 'Kota Balikpapan',
                'kecamatan_bu'       => 'Balikpapan Selatan',
                'kelurahan_bu'       => 'Damai',
                'alamat_bu'          => 'Jl. Jend. Sudirman No. 22, Balikpapan',
                'jenis_usaha'        => 'Logistik',
                'detail_jenis_usaha' => 'Freight Forwarding & Warehousing',
                'tmt_bu'             => '2020-12-10',
                'nama_pimpinan'      => 'Irfan Hakim',
                'telp_bu'            => '0542-7351234',
                'email_bu'           => 'ops@nusantaralogistik.co.id',
                'nama_pic'           => 'Diana Rahayu',
                'jabatan_pic'        => 'Koordinator Gudang',
                'telp_pic'           => '0542-7351235',
                'hp_pic'             => '081567890123',
                'email_pic'          => 'diana@nusantaralogistik.co.id',
            ],
        ];

        foreach ($badanUsahaList as $bu) {
            MasterBu::create($bu);
        }
    }
}
```

> **Penjelasan:**  
> - Membuat 10 badan usaha dari berbagai kota di Indonesia.  
> - Jenis usaha bervariasi: Manufaktur, IT, Perdagangan, Jasa, Koperasi, Logistik.  
> - Setiap BU memiliki kode entitas unik `ENT-001` s.d. `ENT-010` dan kode BU `BU-001` s.d. `BU-010`.

---

### 1.3 — Seeder Riwayat Bulanan BU (`database/seeders/RiwayatBulananBuSeeder.php`)

Buat file baru `database/seeders/RiwayatBulananBuSeeder.php` dengan isi sebagai berikut:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RiwayatBulananBu;

class RiwayatBulananBuSeeder extends Seeder
{
    public function run(): void
    {
        $riwayatList = [
            [
                'kode_entitas'        => 'ENT-001',
                'npp_staff'           => 1,        // Andi Pratama
                'periode'             => '2026-10',
                'jumlah_tenaga_kerja' => 150,
                'jumlah_angkel'       => 5,
                'jenis_bu'            => 'Besar',
            ],
            [
                'kode_entitas'        => 'ENT-002',
                'npp_staff'           => 2,        // Budi Santoso
                'periode'             => '2026-10',
                'jumlah_tenaga_kerja' => 45,
                'jumlah_angkel'       => 2,
                'jenis_bu'            => 'Kecil',
            ],
            [
                'kode_entitas'        => 'ENT-003',
                'npp_staff'           => 1,        // Andi Pratama
                'periode'             => '2026-10',
                'jumlah_tenaga_kerja' => 80,
                'jumlah_angkel'       => 3,
                'jenis_bu'            => 'Menengah',
            ],
            [
                'kode_entitas'        => 'ENT-004',
                'npp_staff'           => 3,        // Citra Dewi
                'periode'             => '2026-10',
                'jumlah_tenaga_kerja' => 20,
                'jumlah_angkel'       => 1,
                'jenis_bu'            => 'Kecil',
            ],
            [
                'kode_entitas'        => 'ENT-005',
                'npp_staff'           => 4,        // Dimas Nugroho
                'periode'             => '2026-10',
                'jumlah_tenaga_kerja' => 200,
                'jumlah_angkel'       => 8,
                'jenis_bu'            => 'Besar',
            ],
            [
                'kode_entitas'        => 'ENT-006',
                'npp_staff'           => 2,        // Budi Santoso
                'periode'             => '2026-10',
                'jumlah_tenaga_kerja' => 35,
                'jumlah_angkel'       => 1,
                'jenis_bu'            => 'Kecil',
            ],
            [
                'kode_entitas'        => 'ENT-007',
                'npp_staff'           => 3,        // Citra Dewi
                'periode'             => '2026-10',
                'jumlah_tenaga_kerja' => 15,
                'jumlah_angkel'       => 1,
                'jenis_bu'            => 'Mikro',
            ],
            [
                'kode_entitas'        => 'ENT-008',
                'npp_staff'           => 1,        // Andi Pratama
                'periode'             => '2026-10',
                'jumlah_tenaga_kerja' => 60,
                'jumlah_angkel'       => 3,
                'jenis_bu'            => 'Menengah',
            ],
            [
                'kode_entitas'        => 'ENT-009',
                'npp_staff'           => 4,        // Dimas Nugroho
                'periode'             => '2026-10',
                'jumlah_tenaga_kerja' => 10,
                'jumlah_angkel'       => 0,
                'jenis_bu'            => 'Mikro',
            ],
            [
                'kode_entitas'        => 'ENT-010',
                'npp_staff'           => 2,        // Budi Santoso
                'periode'             => '2026-10',
                'jumlah_tenaga_kerja' => 120,
                'jumlah_angkel'       => 4,
                'jenis_bu'            => 'Besar',
            ],
        ];

        foreach ($riwayatList as $riwayat) {
            RiwayatBulananBu::create($riwayat);
        }
    }
}
```

> **Penjelasan:**  
> - Membuat 10 data riwayat bulanan, masing-masing 1 per badan usaha.  
> - Periode semuanya `2026-10` (bulan berjalan saat ini).  
> - Staff (RO) di-assign secara random dari NPP 1–4 (staff yang `active`).  
> - Distribusi RO:
>   - **Andi Pratama (NPP 1)**: ENT-001, ENT-003, ENT-008 → 3 BU
>   - **Budi Santoso (NPP 2)**: ENT-002, ENT-006, ENT-010 → 3 BU
>   - **Citra Dewi (NPP 3)**: ENT-004, ENT-007 → 2 BU
>   - **Dimas Nugroho (NPP 4)**: ENT-005, ENT-009 → 2 BU
>   - **Eka Putri (NPP 5)**: tidak memegang BU (karena `inactive`)

---

### 1.4 — Update `DatabaseSeeder.php`

Ubah file `database/seeders/DatabaseSeeder.php` agar memanggil ketiga seeder di atas **secara berurutan** (urutan penting karena ada foreign key):

```php
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
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Jalankan seeder data dummy secara berurutan
        // PENTING: Urutan harus Staff → MasterBu → RiwayatBulananBu
        // karena riwayat_bulanan_bu memiliki foreign key ke staff dan master_bu
        $this->call([
            StaffSeeder::class,
            MasterBuSeeder::class,
            RiwayatBulananBuSeeder::class,
        ]);
    }
}
```

> **⚠️ PENTING:**  
> Urutan pemanggilan seeder **WAJIB** seperti di atas. Jika `RiwayatBulananBuSeeder` dijalankan sebelum `StaffSeeder` atau `MasterBuSeeder`, maka akan error karena foreign key constraint.

---

### 1.5 — Jalankan Seeder

Setelah semua file seeder dibuat, jalankan perintah berikut di terminal:

```bash
# Opsi 1: Fresh migrate + seed (HAPUS SEMUA DATA LAMA, lalu buat ulang + seed)
php artisan migrate:fresh --seed

# Opsi 2: Hanya jalankan seed (jika tabel sudah ada dan kosong)
php artisan db:seed
```

> **Catatan:** Gunakan `migrate:fresh --seed` jika ingin reset total. Gunakan `db:seed` jika hanya ingin menambahkan data dummy tanpa menghapus data existing.

---

## 🖥️ TAHAP 2: Buat View Data Badan Usaha

### 2.1 — Buat Controller (`app/Http/Controllers/BadanUsahaViewController.php`)

Buat file baru `app/Http/Controllers/BadanUsahaViewController.php`:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterBu;

class BadanUsahaViewController extends Controller
{
    /**
     * Menampilkan halaman daftar semua badan usaha beserta RO yang memegangnya.
     *
     * Query logic:
     * - Ambil semua data dari tabel master_bu
     * - Eager load relasi riwayatBulanan (beserta data staff-nya)
     *   untuk menghindari N+1 query problem
     * - Data diurutkan berdasarkan kode_entitas ascending
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Eager load: masterBu → riwayatBulanan (terbaru) → staff
        // Kita ambil riwayat bulanan terbaru saja untuk menentukan RO aktif saat ini
        $badanUsahaList = MasterBu::with(['riwayatBulanan' => function ($query) {
            $query->latest('periode')  // Ambil periode terbaru
                  ->with('staff');      // Load relasi staff (RO)
        }])
        ->orderBy('kode_entitas', 'asc')
        ->get();

        return view('badan-usaha.index', compact('badanUsahaList'));
    }
}
```

> **Penjelasan:**  
> - Menggunakan **Eager Loading** (`with()`) agar tidak terjadi N+1 query problem.  
> - Mengambil riwayat bulanan terbaru (`latest('periode')`) untuk menentukan siapa RO yang saat ini memegang BU tersebut.  
> - Relasi `staff` di-load di dalam relasi `riwayatBulanan` agar nama staff bisa diakses di view.  
>
> **⚠️ Catatan untuk developer:**  
> Di view, gunakan `$bu->riwayatBulanan->first()` untuk mengambil riwayat terbaru dari collection yang sudah di-sort.

---

### 2.2 — Buat Blade View (`resources/views/badan-usaha/index.blade.php`)

Buat folder `resources/views/badan-usaha/` kemudian buat file `index.blade.php`:

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Badan Usaha - Kepesertaan 2.0</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Inline style tambahan khusus halaman ini --}}
    <style>
        /* ========================================
           COLOR PALETTE (Hijau & Biru)
           ========================================
           Hijau utama  : #10b981 (emerald-500)
           Hijau gelap  : #065f46 (emerald-800)
           Biru utama   : #3b82f6 (blue-500)
           Biru gelap   : #1e3a5f
           Background   : #0f172a (slate-900)
           Card BG      : #1e293b (slate-800)
        */

        body {
            background: linear-gradient(135deg, #0f172a 0%, #0c1a2e 50%, #0f172a 100%);
            min-height: 100vh;
        }

        /* Gradient header bar */
        .header-gradient {
            background: linear-gradient(135deg, #065f46 0%, #1e3a5f 100%);
        }

        /* Table header gradient */
        .thead-gradient {
            background: linear-gradient(90deg, #10b981 0%, #3b82f6 100%);
        }

        /* Row hover effect */
        .table-row-hover:hover {
            background-color: rgba(16, 185, 129, 0.08);
            transition: background-color 0.2s ease;
        }

        /* Badge styles */
        .badge-ro {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .badge-jenis {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        /* Scrollbar styling */
        .custom-scrollbar::-webkit-scrollbar {
            height: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #1e293b;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #374151;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #4b5563;
        }
    </style>
</head>
<body class="text-slate-100 antialiased">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- ===== HEADER ===== --}}
        <div class="header-gradient rounded-2xl p-6 mb-8 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight">
                        📋 Data Badan Usaha
                    </h1>
                    <p class="text-emerald-200/80 text-sm mt-1">
                        Daftar seluruh badan usaha beserta Relationship Officer (RO) yang memegang.
                    </p>
                </div>
                <div class="hidden sm:flex items-center gap-2 text-sm text-slate-300">
                    <span class="bg-white/10 px-3 py-1.5 rounded-lg border border-white/20">
                        Total: <strong class="text-white">{{ $badanUsahaList->count() }}</strong> BU
                    </span>
                </div>
            </div>
        </div>

        {{-- ===== TABEL DATA ===== --}}
        <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl shadow-2xl overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-sm text-left">
                    {{-- Table Head --}}
                    <thead class="thead-gradient text-white text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3.5 font-semibold">No</th>
                            <th class="px-4 py-3.5 font-semibold">Kode Entitas</th>
                            <th class="px-4 py-3.5 font-semibold">Kode BU</th>
                            <th class="px-4 py-3.5 font-semibold min-w-[200px]">Nama Badan Usaha</th>
                            <th class="px-4 py-3.5 font-semibold">Jenis Usaha</th>
                            <th class="px-4 py-3.5 font-semibold">Kota/Kabupaten</th>
                            <th class="px-4 py-3.5 font-semibold min-w-[150px]">RO (Staff)</th>
                            <th class="px-4 py-3.5 font-semibold">Jenis BU</th>
                            <th class="px-4 py-3.5 font-semibold">Tenaga Kerja</th>
                            <th class="px-4 py-3.5 font-semibold">TMT BU</th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="divide-y divide-slate-700/50">
                        @forelse ($badanUsahaList as $index => $bu)
                            @php
                                // Ambil riwayat bulanan terbaru (item pertama dari collection yang sudah di-sort)
                                $riwayatTerbaru = $bu->riwayatBulanan->first();
                                $namaRo = $riwayatTerbaru?->staff?->name ?? '-';
                                $jenisBu = $riwayatTerbaru?->jenis_bu ?? '-';
                                $jumlahTk = $riwayatTerbaru?->jumlah_tenaga_kerja ?? 0;
                            @endphp
                            <tr class="table-row-hover">
                                <td class="px-4 py-3 text-slate-400 font-mono">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 font-mono text-emerald-400 font-medium">{{ $bu->kode_entitas }}</td>
                                <td class="px-4 py-3 font-mono text-blue-400">{{ $bu->kode_bu }}</td>
                                <td class="px-4 py-3 font-medium text-white">{{ $bu->nama_bu }}</td>
                                <td class="px-4 py-3 text-slate-300">{{ $bu->jenis_usaha ?? '-' }}</td>
                                <td class="px-4 py-3 text-slate-300">{{ $bu->nama_dati_2 ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="badge-ro inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium">
                                        {{ $namaRo }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge-jenis inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium">
                                        {{ $jenisBu }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-slate-300 text-center">{{ number_format($jumlahTk) }}</td>
                                <td class="px-4 py-3 text-slate-400 text-sm">
                                    {{ \Carbon\Carbon::parse($bu->tmt_bu)->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-4 py-8 text-center text-slate-400">
                                    Belum ada data badan usaha.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ===== FOOTER ===== --}}
        <div class="mt-6 text-center text-xs text-slate-500">
            Kepesertaan 2.0 &mdash; Data Badan Usaha
        </div>

    </div>
</body>
</html>
```

> **Penjelasan View:**  
> - **Warna dominan hijau & biru**: Header menggunakan gradient hijau-biru, thead tabel menggunakan gradient emerald→blue, badge RO berwarna biru, badge jenis BU berwarna hijau.
> - **Data RO diambil dari relasi**: `$bu->riwayatBulanan->first()->staff->name` — mengambil nama staff dari riwayat bulanan terbaru.
> - **Null-safe operator (`?->`)**: Digunakan agar tidak error jika relasi kosong.
> - **Responsive**: Menggunakan `overflow-x-auto` agar tabel bisa di-scroll horizontal di mobile.

---

### 2.3 — Tambahkan Route (`routes/web.php`)

Tambahkan route baru di file `routes/web.php`:

```php
use App\Http\Controllers\BadanUsahaViewController;

// Halaman view data badan usaha
Route::get('/badan-usaha', [BadanUsahaViewController::class, 'index']);
```

> **Penjelasan:**  
> - Route menggunakan method `GET` karena ini hanya untuk menampilkan data (read-only).  
> - URL yang bisa diakses: `http://localhost:8000/badan-usaha`  
> - Pastikan import `use` ditambahkan di bagian atas file `web.php`.

---

## 🔄 TAHAP 3: Langkah Implementasi (Step-by-Step)

Berikut urutan langkah yang **WAJIB** diikuti oleh implementor:

### Langkah 1 — Buat File Seeder
1. Buat file `database/seeders/StaffSeeder.php` → copy kode dari Bagian 1.1
2. Buat file `database/seeders/MasterBuSeeder.php` → copy kode dari Bagian 1.2
3. Buat file `database/seeders/RiwayatBulananBuSeeder.php` → copy kode dari Bagian 1.3

### Langkah 2 — Update DatabaseSeeder
4. Edit file `database/seeders/DatabaseSeeder.php` → tambahkan pemanggilan `$this->call([...])` seperti di Bagian 1.4

### Langkah 3 — Jalankan Migrasi + Seeder
5. Buka terminal, arahkan ke root project
6. Jalankan: `php artisan migrate:fresh --seed`
7. Pastikan tidak ada error. Jika ada error foreign key, periksa urutan seeder.

### Langkah 4 — Buat Controller
8. Buat file `app/Http/Controllers/BadanUsahaViewController.php` → copy kode dari Bagian 2.1

### Langkah 5 — Buat Blade View
9. Buat folder `resources/views/badan-usaha/`
10. Buat file `resources/views/badan-usaha/index.blade.php` → copy kode dari Bagian 2.2

### Langkah 6 — Tambahkan Route
11. Edit file `routes/web.php`:
    - Tambahkan `use App\Http\Controllers\BadanUsahaViewController;` di bagian atas
    - Tambahkan `Route::get('/badan-usaha', [BadanUsahaViewController::class, 'index']);`

### Langkah 7 — Test
12. Jalankan dev server: `php artisan serve` (jika belum jalan)
13. Pastikan juga Vite sedang berjalan: `npm run dev`
14. Buka browser dan akses: `http://localhost:8000/badan-usaha`
15. Verifikasi:
    - ✅ Tabel muncul dengan 10 baris data badan usaha
    - ✅ Kolom RO (Staff) terisi nama staff yang benar
    - ✅ Warna hijau & biru tampil di header, thead, dan badge
    - ✅ Tabel bisa di-scroll horizontal di layar kecil

---

## 📂 Struktur File Setelah Implementasi

```
project-root/
├── app/
│   └── Http/
│       └── Controllers/
│           ├── Api/
│           │   ├── BadanUsahaController.php    ← (existing, untuk API)
│           │   └── StaffController.php         ← (existing, untuk API)
│           ├── BadanUsahaViewController.php     ← ✨ BARU (untuk view web)
│           └── Controller.php
├── database/
│   └── seeders/
│       ├── DatabaseSeeder.php                  ← ✏️ DIUBAH
│       ├── StaffSeeder.php                     ← ✨ BARU
│       ├── MasterBuSeeder.php                  ← ✨ BARU
│       └── RiwayatBulananBuSeeder.php          ← ✨ BARU
├── resources/
│   └── views/
│       ├── badan-usaha/
│       │   └── index.blade.php                 ← ✨ BARU
│       └── welcome.blade.php
└── routes/
    ├── web.php                                 ← ✏️ DIUBAH
    └── api.php
```

---

## ⚠️ Catatan Penting untuk Implementor

1. **Jangan lupa urutan seeder** — Staff harus di-seed pertama, kemudian MasterBu, baru RiwayatBulananBu. Jika tidak, foreign key constraint akan error.

2. **Eager Loading** — Pada controller, kita tidak menggunakan `limit(1)` di dalam constraint eager loading karena bisa me-limit keseluruhan query (bukan per-parent). Sebagai gantinya, kita load semua riwayat bulanan (yang sudah di-sort `latest`) lalu di view kita ambil `->first()` untuk mendapatkan yang terbaru.

3. **Tailwind CSS v4** — Project ini menggunakan Tailwind CSS v4 via Vite. Pastikan `npm run dev` sedang berjalan agar class Tailwind ter-compile.

4. **View ini adalah fondasi** — UI yang disediakan sengaja simple dan fungsional. Developer senior (pemilik project) akan meng-ulik tampilan, menambahkan fitur search, filter, pagination, dll. di kemudian hari.

5. **Null-safe operator** — Code menggunakan `?->` (PHP 8.0+). Pastikan versi PHP minimal 8.0. Project ini menggunakan PHP 8.3, jadi seharusnya aman.

---

## 🏁 Definisi Selesai (Definition of Done)

- [x] File seeder dibuat dan bisa dijalankan tanpa error
- [x] Data dummy terisi di database (5 staff, 10 master BU, 10 riwayat bulanan)
- [x] Controller `BadanUsahaViewController` dibuat dengan eager loading yang benar
- [x] Blade view menampilkan tabel dengan kolom: No, Kode Entitas, Kode BU, Nama BU, Jenis Usaha, Kota, RO, Jenis BU, Tenaga Kerja, TMT BU
- [x] Warna UI didominasi hijau dan biru
- [x] Route `/badan-usaha` bisa diakses via browser dan menampilkan data dengan benar
- [x] Tidak ada error di console browser maupun di terminal

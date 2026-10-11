# Issue: Implementasi Master Badan Usaha & Riwayat Bulanan

## Deskripsi
Issue ini berisi perencanaan pembuatan struktur database dan API untuk fitur "Badan Usaha" dan "Riwayat Bulanan Badan Usaha". Implementasi harus dilakukan sesuai dengan panduan dan standar pengembangan web framework (seperti Laravel), mulai dari pembuatan *Migration*, *Model*, *Controller*, hingga *Routing*.

Setiap kode yang ditulis **WAJIB** diberikan penjelasan/komentar singkat agar mudah di-*review* oleh Lead Developer.

---

## 1. Perencanaan Database (Migrations)

### A. Tabel Master Badan Usaha (`master_bu`)
Tabel ini digunakan untuk menyimpan data master informasi badan usaha.

**Struktur Kolom:**
- `kode_entitas`: VARCHAR(255) PRIMARY KEY UNIQUE NOT NULL
- `kode_bu`: VARCHAR(255) UNIQUE NOT NULL
- `nama_bu`: VARCHAR(255) NOT NULL
- `nama_dati_2`: VARCHAR(255) NULLABLE
- `kecamatan_bu`: VARCHAR(255) NULLABLE
- `kelurahan_bu`: VARCHAR(255) NULLABLE
- `alamat_bu`: TEXT NULLABLE
- `jenis_usaha`: VARCHAR(255) NULLABLE
- `detail_jenis_usaha`: VARCHAR(255) NULLABLE
- `tmt_bu`: DATE NOT NULL
- `nama_pimpinan`: VARCHAR(255) NULLABLE
- `telp_bu`: VARCHAR(50) NULLABLE
- `email_bu`: VARCHAR(255) NULLABLE
- `nama_pic`: VARCHAR(255) NULLABLE
- `jabatan_pic`: VARCHAR(255) NULLABLE
- `telp_pic`: VARCHAR(50) NULLABLE
- `hp_pic`: VARCHAR(50) NULLABLE
- `email_pic`: VARCHAR(255) NULLABLE
- `created_at`: TIMESTAMP (Terisi otomatis saat baris dibuat)
- `updated_at`: TIMESTAMP (Terisi otomatis saat baris diubah)

### B. Tabel Riwayat Bulanan Badan Usaha (`riwayat_bulanan_bu`)
Tabel ini menyimpan rekam jejak jumlah karyawan atau riwayat bulanan dari masing-masing badan usaha.

**Struktur Kolom:**
- `id`: BIGINT AUTO_INCREMENT PRIMARY KEY
- `kode_entitas`: VARCHAR(255) NOT NULL -> *FOREIGN KEY menunjuk ke `master_bu.kode_entitas` (ON UPDATE CASCADE, ON DELETE CASCADE)*
- `npp_staff`: INTEGER NULLABLE -> *FOREIGN KEY menunjuk ke tabel `staff.npp` (Kosong/Nullable jika belum ada staff yang memegang)*
- `periode`: VARCHAR(7) NOT NULL -> *(Format wajib: YYYY-MM, contoh: 2026-10)*
- `jumlah_tenaga_kerja`: INTEGER DEFAULT 0
- `jumlah_angkel`: INTEGER DEFAULT 0
- `jenis_bu`: VARCHAR(50) NULLABLE -> *(Isian otomatis sistem, contoh: Mikro/Kecil/Menengah/Besar)*
- `created_at`: TIMESTAMP
- `updated_at`: TIMESTAMP

---

## 2. API Endpoint

### Registrasi Master Badan Usaha Baru

- **Method:** `POST`
- **Endpoint:** `/api/badan-usaha`
- **Tujuan:** Menyimpan pendaftaran atau data Badan Usaha baru ke dalam database.

**Request Body (Format JSON):**
```json
{
    "kode_entitas": "000123456",
    "kode_bu": "BU-9988",
    "nama_bu": "PT Bina Maju Palembang",
    "nama_dati_2": "Palembang",
    "alamat_bu": "Jl. Jend. Sudirman No. 123",
    "jenis_usaha": "Perdagangan",
    "nama_pimpinan": "Ahmad Santoso",
    "email_bu": "info@binamaju.co.id"
}
```

**Response Body (Jika Sukses):**
```json
{
    "message": "Badan Usaha berhasil ditambahkan"
}
```

**Response Body (Jika Gagal / Error):**
```json
{
    "message": "Badan Usaha gagal ditambahkan"
}
```

---

## 3. Tahapan Implementasi (Action Plan)

Berikut adalah panduan pengerjaan langkah demi langkah. Anggap framework yang digunakan adalah Laravel.

### Tahap 1: Pembuatan File Migrations
1. Buat migration untuk tabel `master_bu` (misal menggunakan perintah `php artisan make:migration create_master_bu_table`).
2. Definisikan kolom-kolomnya sesuai dengan struktur di bagian 1A. Pastikan tipe datanya tepat (contoh: `string` untuk `VARCHAR`, `text` untuk `TEXT`, dan `date` untuk tanggal).
3. Buat migration untuk tabel `riwayat_bulanan_bu` (`php artisan make:migration create_riwayat_bulanan_bu_table`).
4. Definisikan foreign key dari `kode_entitas` yang mereferensikan `master_bu`. Atur `onUpdate('cascade')` dan `onDelete('cascade')`.
5. Eksekusi migration (contoh: `php artisan migrate`).

### Tahap 2: Pembuatan File Model
1. Buat Model untuk `MasterBu`. 
   - Karena primary key bukan standar `id` yang berupa integer, pastikan kamu mendefinisikan `$primaryKey = 'kode_entitas'`, `$keyType = 'string'`, dan `$incrementing = false` pada Model.
   - Atur properti `$fillable` (atau `$guarded`) untuk menentukan kolom apa saja yang bisa diisi.
2. Buat Model untuk `RiwayatBulananBu`.
   - Buat fungsi relasi (misal `belongsTo`) yang menghubungkan model ini dengan `MasterBu`.

### Tahap 3: Pembuatan Validasi & Controller
1. Buat mekanisme validasi input dari Request (jika di Laravel, gunakan *Form Request* atau fungsi `validate()`). Pastikan `kode_entitas` dan `kode_bu` bernilai `required` dan `unique`.
2. Buat file `BadanUsahaController` (atau controller yang serupa).
3. Di dalam controller tersebut, buat method `store` (atau nama fungsi penyimpan).
4. **Logika Penyimpanan:**
   - Gunakan blok `try-catch`.
   - Dalam blok `try`, ambil input JSON, simpan menggunakan metode bawaan model (misal: `MasterBu::create()`). Kembalikan *Response JSON Success*.
   - Dalam blok `catch`, tangkap jika terjadi *exception* atau error saat query. Kembalikan *Response JSON Error*.

### Tahap 4: Konfigurasi Routing
1. Buka file konfigurasi routes API (misal `routes/api.php` di Laravel).
2. Daftarkan route `POST /badan-usaha` dan arahkan ke method `store` di `BadanUsahaController` yang baru saja dibuat.

### Aturan Wajib
1. **Berikan Komentar:** Kamu wajib memberikan komentar atau penjelasan pada fungsi dan baris logika penting agar pengerjaanmu bisa di-review dengan mudah oleh Lead Programmer.
2. **Handle Error Response:** Pastikan error database tidak tereskspos mentah-mentah ke *response*, cukup kembalikan format error JSON yang sudah disepakati di atas.

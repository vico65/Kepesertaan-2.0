# Issue: Fitur Registrasi Staff Baru

## Deskripsi
Fitur ini bertujuan untuk membuat tabel `staff` di dalam database dan menyediakan API endpoint untuk mendaftarkan staff baru.

## Kriteria Penerimaan (Acceptance Criteria)

### 1. Struktur Database
Tabel `staff` harus memiliki struktur sebagai berikut:
- `npp` (integer, primary key)
- `name` (varchar 255, not null)
- `email` (varchar 255, not null, unique)
- `passkey` (varchar 255, not null, passkey merupakan hash dari bcrypt)
- `status` (enum: 'active', 'inactive', default: 'active')
- `created_at` (timestamp, default: current_timestamp)
- `updated_at` (timestamp, default: current_timestamp on update current_timestamp)

### 2. API Endpoint
- **Method:** `POST`
- **Endpoint:** `/api/staff`
- **Request Body (JSON):**
  ```json
  {
      "name" : "staff",
      "email" : "staff@gmail.com",
      "passkey" : "rahasia"
  }
  ```
- **Response Body - Success (JSON, Status Code 201/200):**
  ```json
  {
      "message" : "User berhasil ditambahkan"
  }
  ```
- **Response Body - Error (JSON, Status Code 400/500):**
  ```json
  {
      "message" : "User gagal ditambahkan"
  }
  ```

---

## Tahapan Implementasi (Untuk Junior Programmer / AI)

Ikuti tahapan-tahapan di bawah ini secara berurutan menggunakan standar framework **Laravel**. Semua kode yang ditulis harus menyertakan komentar penjelasan agar mudah di-review oleh Lead Programmer.

### Tahap 1: Pembuatan Migration untuk Tabel `staff`

1. Jalankan perintah artisan untuk membuat file migration baru.
   ```bash
   php artisan make:migration create_staff_table
   ```
2. Buka file migration yang baru saja dibuat di folder `database/migrations/` dan sesuaikan kodenya menjadi seperti berikut:

   ```php
   <?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   return new class extends Migration
   {
       /**
        * Run the migrations.
        */
       public function up(): void
       {
           // Membuat tabel 'staff'
           Schema::create('staff', function (Blueprint $table) {
               // npp integer primary key.
               // Jika npp ini auto increment, gunakan $table->id('npp');
               // Namun karena spesifikasinya hanya integer primary key (biasanya NIK / Nomor Pokok Pegawai di-input manual), 
               // kita set sebagai integer biasa dan didefinisikan sebagai primary.
               $table->integer('npp')->primary(); 
               
               // name varchar 255 not null
               $table->string('name', 255);
               
               // email varchar 255 not null unique
               $table->string('email', 255)->unique();
               
               // passkey varchar 255 not null
               $table->string('passkey', 255);
               
               // status enum 'active' 'inactive' default 'active'
               $table->enum('status', ['active', 'inactive'])->default('active');
               
               // Laravel otomatis akan menggunakan current_timestamp untuk created_at
               // dan 'on update current_timestamp' untuk updated_at jika diset dengan method useCurrent() dan useCurrentOnUpdate()
               $table->timestamp('created_at')->useCurrent();
               $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
           });
       }

       /**
        * Reverse the migrations.
        */
       public function down(): void
       {
           // Menghapus tabel 'staff' jika dilakukan rollback
           Schema::dropIfExists('staff');
       }
   };
   ```
3. Jalankan perintah migrasi untuk mengaplikasikan pembuatan tabel di database:
   ```bash
   php artisan migrate
   ```

### Tahap 2: Pembuatan Model `Staff`

1. Jalankan perintah artisan untuk membuat file Model.
   ```bash
   php artisan make:model Staff
   ```
2. Buka file `app/Models/Staff.php` dan sesuaikan kodenya. Karena kita memiliki primary key dan penanganan timestamp yang sedikit berbeda dari default bawaan Laravel, kita perlu mendefinisikan beberapa properti.

   ```php
   <?php

   namespace App\Models;

   use Illuminate\Database\Eloquent\Factories\HasFactory;
   use Illuminate\Database\Eloquent\Model;

   class Staff extends Model
   {
       use HasFactory;

       // Mendefinisikan nama tabel secara eksplisit 
       protected $table = 'staff';

       // Menentukan primary key, karena kita menggunakan 'npp', bukan 'id' bawaan Laravel
       protected $primaryKey = 'npp';

       // Mematikan incrementing jika 'npp' tidak auto-increment dan akan diinput manual.
       public $incrementing = false;

       // Menentukan tipe data dari primary key
       protected $keyType = 'integer';

       // Karena di migration kita menggunakan trigger database (useCurrent) untuk timestamp,
       // kita matikan timestamps bawaan Eloquent agar Laravel tidak menimpanya secara otomatis dengan Carbon,
       // biarkan MySQL/Database yang mengatur tanggal dan waktunya.
       public $timestamps = false;

       // Mendefinisikan kolom-kolom apa saja yang boleh diisi melalui Mass Assignment
       protected $fillable = [
           'npp', 
           'name',
           'email',
           'passkey',
           'status'
       ];

       // Menyembunyikan atribut 'passkey' saat model dikembalikan dalam bentuk array/JSON (misal saat dipanggil di API response)
       protected $hidden = [
           'passkey',
       ];
   }
   ```

### Tahap 3: Pembuatan Controller `StaffController`

1. Jalankan perintah artisan untuk membuat file Controller.
   ```bash
   php artisan make:controller Api/StaffController
   ```
2. Buka file `app/Http/Controllers/Api/StaffController.php` dan tulis logika untuk menangani request HTTP.

   ```php
   <?php

   namespace App\Http\Controllers\Api;

   use App\Http\Controllers\Controller;
   use Illuminate\Http\Request;
   use App\Models\Staff;
   use Illuminate\Support\Facades\Hash;
   use Illuminate\Support\Facades\Log;

   class StaffController extends Controller
   {
       /**
        * Menangani request untuk menambahkan staff baru
        */
       public function store(Request $request)
       {
           try {
               // 1. Validasi input request.
               // Pastikan data yang dikirim sesuai ketentuan tabel.
               $validatedData = $request->validate([
                   // Jika npp di-input oleh user, harus divalidasi juga (uncomment bila perlu)
                   // 'npp' => 'required|integer|unique:staff,npp',
                   'name' => 'required|string|max:255',
                   'email' => 'required|string|email|max:255|unique:staff,email',
                   'passkey' => 'required|string|min:6',
               ]);

               // 2. Hash password menggunakan Bcrypt (standar Hash::make di Laravel)
               $hashedPasskey = Hash::make($request->passkey);

               // 3. Simpan data staff ke database menggunakan model Eloquent
               $staff = Staff::create([
                   // 'npp' => $request->npp, // Uncomment jika npp wajib dari request user
                   'name' => $request->name,
                   'email' => $request->email,
                   'passkey' => $hashedPasskey,
                   // status, created_at, updated_at tidak perlu diisi karena sudah ada default value di DB
               ]);

               // 4. Return response JSON sukses sesuai spesifikasi
               return response()->json([
                   'message' => 'User berhasil ditambahkan'
               ], 201); // Kode HTTP 201 Created

           } catch (\Exception $e) {
               // Log error message agar mudah ditelusuri jika ada kegagalan internal
               Log::error("Error saat menambahkan staff: " . $e->getMessage());

               // Return response JSON gagal sesuai spesifikasi
               return response()->json([
                   'message' => 'User gagal ditambahkan'
               ], 500); // Kode HTTP 500 Internal Server Error
           }
       }
   }
   ```

### Tahap 4: Konfigurasi Route API

1. Buka file routes untuk API. Tergantung pada versi Laravel (Laravel 10 ada di `routes/api.php`, Laravel 11 mungkin perlu publish API routes dengan perintah `php artisan install:api` jika file tidak ada).
2. Daftarkan endpoint-nya.

   ```php
   <?php

   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Route;
   use App\Http\Controllers\Api\StaffController;

   // Mendaftarkan endpoint POST /api/staff yang mengarah ke method store di StaffController
   Route::post('/staff', [StaffController::class, 'store']);
   ```

### Tahap 5: Pengujian (Testing)

1. Jalankan development server lokal:
   ```bash
   php artisan serve
   ```
2. Gunakan **Postman** atau **Insomnia** untuk menembak endpoint:
   - Method: **POST**
   - URL: `http://127.0.0.1:8000/api/staff`
   - Body: Raw -> JSON
   - Data JSON:
     ```json
     {
         "name" : "staff",
         "email" : "staff@gmail.com",
         "passkey" : "rahasia"
     }
     ```
3. Validasi *Response*:
   - Jika berhasil, response berupa JSON `{"message": "User berhasil ditambahkan"}`.
   - Jika format body JSON tidak valid/email ganda, aplikasi harusnya return validation error atau error JSON `{"message": "User gagal ditambahkan"}` (sesuai try-catch).
4. Validasi ke *Database*:
   - Cek ke table `staff` (via phpMyAdmin / table client lainnya).
   - Pastikan field `passkey` tidak tersimpan sebagai `"rahasia"`, melainkan sebuah teks panjang acak (hash).
   - Pastikan field `status`, `created_at`, dan `updated_at` terisi dengan benar secara otomatis.

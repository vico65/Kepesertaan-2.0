<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel master_bu untuk menyimpan data master informasi badan usaha.
     */
    public function up(): void
    {
        Schema::create('master_bu', function (Blueprint $table) {
            // Kolom kode_entitas: VARCHAR(255) PRIMARY KEY UNIQUE NOT NULL
            $table->string('kode_entitas', 255)->primary();

            // Kolom kode_bu: VARCHAR(255) UNIQUE NOT NULL
            $table->string('kode_bu', 255)->unique();

            // Kolom nama_bu: VARCHAR(255) NOT NULL
            $table->string('nama_bu', 255);

            // Kolom nama_dati_2: VARCHAR(255) NULLABLE (Kabupaten/Kota)
            $table->string('nama_dati_2', 255)->nullable();

            // Kolom kecamatan_bu: VARCHAR(255) NULLABLE
            $table->string('kecamatan_bu', 255)->nullable();

            // Kolom kelurahan_bu: VARCHAR(255) NULLABLE
            $table->string('kelurahan_bu', 255)->nullable();

            // Kolom alamat_bu: TEXT NULLABLE
            $table->text('alamat_bu')->nullable();

            // Kolom jenis_usaha: VARCHAR(255) NULLABLE
            $table->string('jenis_usaha', 255)->nullable();

            // Kolom detail_jenis_usaha: VARCHAR(255) NULLABLE
            $table->string('detail_jenis_usaha', 255)->nullable();

            // Kolom tmt_bu: DATE NOT NULL (Tanggal Mulai Terhitung Badan Usaha)
            $table->date('tmt_bu');

            // Kolom nama_pimpinan: VARCHAR(255) NULLABLE
            $table->string('nama_pimpinan', 255)->nullable();

            // Kolom telp_bu: VARCHAR(50) NULLABLE
            $table->string('telp_bu', 50)->nullable();

            // Kolom email_bu: VARCHAR(255) NULLABLE
            $table->string('email_bu', 255)->nullable();

            // Kolom nama_pic: VARCHAR(255) NULLABLE
            $table->string('nama_pic', 255)->nullable();

            // Kolom jabatan_pic: VARCHAR(255) NULLABLE
            $table->string('jabatan_pic', 255)->nullable();

            // Kolom telp_pic: VARCHAR(50) NULLABLE
            $table->string('telp_pic', 50)->nullable();

            // Kolom hp_pic: VARCHAR(50) NULLABLE
            $table->string('hp_pic', 50)->nullable();

            // Kolom email_pic: VARCHAR(255) NULLABLE
            $table->string('email_pic', 255)->nullable();

            // Kolom created_at: TIMESTAMP terisi otomatis saat baris dibuat
            $table->timestamp('created_at')->useCurrent();

            // Kolom updated_at: TIMESTAMP terisi otomatis saat baris diubah
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus tabel master_bu jika migration di-rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_bu');
    }
};

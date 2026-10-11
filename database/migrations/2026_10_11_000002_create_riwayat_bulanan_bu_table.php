<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel riwayat_bulanan_bu untuk rekam jejak bulanan badan usaha.
     */
    public function up(): void
    {
        Schema::create('riwayat_bulanan_bu', function (Blueprint $table) {
            // Kolom id: BIGINT AUTO_INCREMENT PRIMARY KEY
            $table->id();

            // Kolom kode_entitas: VARCHAR(255) NOT NULL
            // Foreign Key menunjuk ke master_bu.kode_entitas (ON UPDATE CASCADE, ON DELETE CASCADE)
            $table->string('kode_entitas', 255);
            $table->foreign('kode_entitas')
                  ->references('kode_entitas')
                  ->on('master_bu')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            // Kolom npp_staff: INTEGER NULLABLE
            // Foreign Key menunjuk ke tabel staff.npp (Kosong/Nullable jika belum ada staff yang memegang)
            $table->integer('npp_staff')->nullable();
            $table->foreign('npp_staff')
                  ->references('npp')
                  ->on('staff')
                  ->onUpdate('cascade')
                  ->onDelete('set null');

            // Kolom periode: VARCHAR(7) NOT NULL (Format wajib: YYYY-MM, contoh: 2026-10)
            $table->string('periode', 7);

            // Kolom jumlah_tenaga_kerja: INTEGER DEFAULT 0
            $table->integer('jumlah_tenaga_kerja')->default(0);

            // Kolom jumlah_angkel: INTEGER DEFAULT 0
            $table->integer('jumlah_angkel')->default(0);

            // Kolom jenis_bu: VARCHAR(50) NULLABLE (Isian otomatis sistem, contoh: Mikro/Kecil/Menengah/Besar)
            $table->string('jenis_bu', 50)->nullable();

            // Kolom created_at: TIMESTAMP terisi otomatis saat baris dibuat
            $table->timestamp('created_at')->useCurrent();

            // Kolom updated_at: TIMESTAMP terisi otomatis saat baris diubah
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus tabel riwayat_bulanan_bu jika migration di-rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_bulanan_bu');
    }
};

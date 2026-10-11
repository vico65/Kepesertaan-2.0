<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatBulananBu extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit di database
    protected $table = 'riwayat_bulanan_bu';

    // Kolom-kolom yang diizinkan untuk diisi secara massal (Mass Assignment)
    protected $fillable = [
        'kode_entitas',
        'npp_staff',
        'periode',
        'jumlah_tenaga_kerja',
        'jumlah_angkel',
        'jenis_bu',
    ];

    /**
     * Relasi ke model MasterBu (Inverse One-to-Many / Belongs To).
     * Setiap record riwayat bulanan merujuk ke satu data master badan usaha.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function masterBu(): BelongsTo
    {
        return $this->belongsTo(MasterBu::class, 'kode_entitas', 'kode_entitas');
    }

    /**
     * Relasi ke model Staff (Inverse One-to-Many / Belongs To).
     * Setiap record riwayat bulanan dapat merujuk ke seorang staff pembina.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'npp_staff', 'npp');
    }
}

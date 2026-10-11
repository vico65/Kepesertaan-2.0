<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterBu extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit di database
    protected $table = 'master_bu';

    // Menentukan primary key tabel karena menggunakan 'kode_entitas', bukan 'id' bawaan Laravel
    protected $primaryKey = 'kode_entitas';

    // Menonaktifkan auto-incrementing karena primary key bertipe string (non-integer)
    public $incrementing = false;

    // Menentukan tipe data dari primary key
    protected $keyType = 'string';

    // Kolom-kolom yang diizinkan untuk diisi secara massal (Mass Assignment)
    protected $fillable = [
        'kode_entitas',
        'kode_bu',
        'nama_bu',
        'nama_dati_2',
        'kecamatan_bu',
        'kelurahan_bu',
        'alamat_bu',
        'jenis_usaha',
        'detail_jenis_usaha',
        'tmt_bu',
        'nama_pimpinan',
        'telp_bu',
        'email_bu',
        'nama_pic',
        'jabatan_pic',
        'telp_pic',
        'hp_pic',
        'email_pic',
    ];

    /**
     * Boot logic model Eloquent.
     * Mengatur nilai default tmt_bu jika tidak dikirimkan dalam payload request.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->tmt_bu)) {
                $model->tmt_bu = now()->toDateString();
            }
        });
    }

    /**
     * Relasi ke model RiwayatBulananBu (One-to-Many).
     * Satu badan usaha dapat memiliki banyak catatan riwayat bulanan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function riwayatBulanan(): HasMany
    {
        return $this->hasMany(RiwayatBulananBu::class, 'kode_entitas', 'kode_entitas');
    }
}

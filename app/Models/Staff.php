<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    // Menentukan nama tabel secara eksplisit di database
    protected $table = 'staff';

    // Menentukan primary key tabel karena menggunakan 'npp', bukan 'id' bawaan Laravel
    protected $primaryKey = 'npp';

    // Menentukan tipe data dari primary key
    protected $keyType = 'integer';

    // Menonaktifkan timestamps bawaan Eloquent (karena kolom created_at dan updated_at 
    // telah diatur otomatis oleh MySQL menggunakan useCurrent() dan useCurrentOnUpdate())
    public $timestamps = false;

    // Kolom-kolom yang diizinkan untuk diisi secara massal (Mass Assignment)
    protected $fillable = [
        'npp',
        'name',
        'email',
        'passkey',
        'status',
    ];

    // Menyembunyikan kolom passkey saat model di-serialize ke format JSON/Array
    protected $hidden = [
        'passkey',
    ];
}

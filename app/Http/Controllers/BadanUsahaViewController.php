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
        // Eager load: masterBu -> riwayatBulanan (terbaru) -> staff
        // Mengambil riwayat bulanan yang di-sort latest untuk menentukan RO aktif
        $badanUsahaList = MasterBu::with(['riwayatBulanan' => function ($query) {
            $query->latest('periode')
                  ->with('staff');
        }])
        ->orderBy('kode_entitas', 'asc')
        ->get();

        return view('badan-usaha.index', compact('badanUsahaList'));
    }
}

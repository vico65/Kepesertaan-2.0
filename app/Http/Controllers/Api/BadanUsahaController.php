<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterBu;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BadanUsahaController extends Controller
{
    /**
     * Menyimpan pendaftaran atau data Badan Usaha baru ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // 1. Melakukan validasi data input dari request
            // - kode_entitas: wajib diisi, string, maksimal 255 karakter, dan unik di tabel master_bu
            // - kode_bu: wajib diisi, string, maksimal 255 karakter, dan unik di tabel master_bu
            // - nama_bu: wajib diisi, string, maksimal 255 karakter
            // - field lainnya bersifat opsional (nullable) dengan tipe dan batasan masing-masing
            $validator = Validator::make($request->all(), [
                'kode_entitas'        => 'required|string|max:255|unique:master_bu,kode_entitas',
                'kode_bu'             => 'required|string|max:255|unique:master_bu,kode_bu',
                'nama_bu'             => 'required|string|max:255',
                'nama_dati_2'         => 'nullable|string|max:255',
                'kecamatan_bu'        => 'nullable|string|max:255',
                'kelurahan_bu'        => 'nullable|string|max:255',
                'alamat_bu'           => 'nullable|string',
                'jenis_usaha'         => 'nullable|string|max:255',
                'detail_jenis_usaha'  => 'nullable|string|max:255',
                'tmt_bu'              => 'nullable|date',
                'nama_pimpinan'       => 'nullable|string|max:255',
                'telp_bu'             => 'nullable|string|max:50',
                'email_bu'            => 'nullable|string|email|max:255',
                'nama_pic'            => 'nullable|string|max:255',
                'jabatan_pic'         => 'nullable|string|max:255',
                'telp_pic'            => 'nullable|string|max:50',
                'hp_pic'              => 'nullable|string|max:50',
                'email_pic'           => 'nullable|string|email|max:255',
            ]);

            // Jika validasi gagal (misal kode_entitas kosong atau kode_bu sudah terdaftar),
            // kembalikan response error JSON dengan HTTP Status Code 400 (Bad Request)
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Badan Usaha gagal ditambahkan'
                ], 400);
            }

            // Ambil data yang telah divalidasi
            $data = $validator->validated();

            // Jika tanggal tmt_bu tidak disediakan di request body,
            // default-kan ke tanggal hari ini sesuai kebutuhan sistem
            if (empty($data['tmt_bu'])) {
                $data['tmt_bu'] = now()->toDateString();
            }

            // 2. Menyimpan data master badan usaha menggunakan Eloquent Model
            MasterBu::create($data);

            // 3. Mengembalikan response sukses dengan HTTP Status Code 201 (Created)
            return response()->json([
                'message' => 'Badan Usaha berhasil ditambahkan'
            ], 201);

        } catch (\Throwable $e) {
            // Mencatat log error ke sistem logging untuk keperluan investigasi tanpa mengekspos detail ke client
            Log::error('Error saat registrasi badan usaha: ' . $e->getMessage());

            // Mengembalikan response gagal dengan HTTP Status Code 500 (Internal Server Error)
            return response()->json([
                'message' => 'Badan Usaha gagal ditambahkan'
            ], 500);
        }
    }
}

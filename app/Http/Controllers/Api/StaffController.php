<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Staff;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    /**
     * Menyimpan data staff baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // 1. Melakukan validasi data input dari request
            // - name: wajib diisi, berupa string, maksimal 255 karakter
            // - email: wajib diisi, format email valid, maksimal 255 karakter, dan belum terdaftar di tabel staff
            // - passkey: wajib diisi, berupa string
            $validator = Validator::make($request->all(), [
                'name'    => 'required|string|max:255',
                'email'   => 'required|string|email|max:255|unique:staff,email',
                'passkey' => 'required|string',
            ]);

            // Jika validasi gagal (misal data kosong atau email sudah terdaftar),
            // kembalikan response error dengan status code 400 (Bad Request)
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'User gagal ditambahkan'
                ], 400);
            }

            // 2. Melakukan enkripsi passkey menggunakan algoritma Bcrypt bawaan Laravel
            $hashedPasskey = Hash::make($request->passkey);

            // 3. Menyimpan data staff ke database menggunakan Eloquent ORM
            // Nilai status, created_at, dan updated_at akan otomatis menggunakan default database
            Staff::create([
                'name'    => $request->name,
                'email'   => $request->email,
                'passkey' => $hashedPasskey,
            ]);

            // 4. Mengembalikan response sukses dengan HTTP Status Code 201 (Created)
            return response()->json([
                'message' => 'User berhasil ditambahkan'
            ], 201);

        } catch (\Throwable $e) {
            // Mencatat log error ke sistem jika terjadi kegagalan/exception
            Log::error('Error saat registrasi staff: ' . $e->getMessage());

            // Mengembalikan response gagal dengan HTTP Status Code 500 (Internal Server Error)
            return response()->json([
                'message' => 'User gagal ditambahkan'
            ], 500);
        }
    }
}

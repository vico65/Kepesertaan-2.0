<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\BadanUsahaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Rute-rute API didaftarkan di sini. Semua rute di file ini secara otomatis
| diberikan prefix '/api' oleh Laravel.
|
*/

// Endpoint POST /api/staff untuk registrasi user staff baru
// Memanggil method 'store' pada StaffController
Route::post('/staff', [StaffController::class, 'store']);

// Endpoint POST /api/badan-usaha untuk registrasi master badan usaha baru
// Memanggil method 'store' pada BadanUsahaController
Route::post('/badan-usaha', [BadanUsahaController::class, 'store']);


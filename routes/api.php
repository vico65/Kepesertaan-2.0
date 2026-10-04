<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StaffController;

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

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\TacGiaController;
use App\Http\Controllers\admin\TheLoaiController;
use App\Http\Controllers\admin\NhaXuatBanController;
use App\Http\Controllers\admin\auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth')->post('/get-token', [AuthController::class, 'getToken']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('jwt.auth')->group(function () {
    Route::get('/tac-gia', [TacGiaController::class, 'getAPITacGia']);
    Route::get('/the-loai', [TheLoaiController::class, 'getAPITheLoai']);
    Route::get('/nha-xuat-ban', [NhaXuatBanController::class, 'getAPINhaXuatBan']);
});

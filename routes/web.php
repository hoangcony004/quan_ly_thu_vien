<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\auth\AuthController;
use App\Http\Controllers\admin\auth\ForgotPasswordController;
use App\Http\Controllers\admin\TacGiaController;
use App\Http\Controllers\admin\TheLoaiController;
use App\Http\Controllers\admin\NhaXuatBanController;
use App\Http\Controllers\admin\KhoSachController;
use App\Http\Controllers\SearchController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('admin.pages.home-page');
});

Route::get('/login', [AuthController::class, 'getLogin'])->name('auth.getLogin');
Route::post('/login', [AuthController::class, 'postLogin'])->name('auth.postLogin');
Route::get('/logout', [AuthController::class, 'getlogout'])->name('auth.getLogout');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'public/admin'], function () {
        Route::get('/dashboard', [AdminController::class, 'getDashboard'])->name('dashboard');

        Route::group(['prefix' => '/kho-sach'], function () {
            Route::get('/', [KhoSachController::class, 'getKhoSach'])->name('khosach.getKhoSach');
            Route::post('/post-add-sach', [KhoSachController::class, 'postAddSach'])->name('khosach.postAddSach');
            Route::get('/edit-sach/{id}', [KhoSachController::class, 'getEditSach'])->name('khosach.getEditSach');
            Route::put('/edit-sach/{id}', [KhoSachController::class, 'postEditSach'])->name('PEditSach');
            Route::post('/xoa-sach/{id}', [KhoSachController::class, 'postDeleteSach'])->name('khosach.postDeleteSach');
            // Route::get('/search-sach', [KhoSachController::class, 'getBooks'])->name('searchSach');
        });
        Route::group(['prefix' => '/tac-gia'], function () {
            Route::get('/', [TacGiaController::class, 'getTacGia'])->name('tacgia.getTacGia');
            Route::post('/post-add-tac-gia', [TacGiaController::class, 'postAddTacGia'])->name('tacgia.postAddTacGia');
            Route::get('/edit-tac-gia/{id}', [TacGiaController::class, 'getEditTacGia'])->name('tacgia.getEditTacGia');
            Route::put('/edit-tac-gia/{id}', [TacGiaController::class, 'postEditTacGia'])->name('tacgia.postEditTacGia');
            Route::post('/tac-gia-xoa/{id}', [TacGiaController::class, 'postDeleteTacGia'])->name('tacgia.postDeleteTacGia');
            Route::get('/tim-kiem-tac-gia', [TacGiaController::class, 'getTimKiemTacGia'])->name('tacgia.getTimKiemTacGia');
        });
        Route::group(['prefix' => '/the-loai'], function () {
            Route::get('/', [TheLoaiController::class, 'getTheLoai'])->name('theloai.getTheLoai');
            Route::post('/add-the-loai', [TheLoaiController::class, 'postAddTheLoai'])->name('theloai.postAddTheLoai');
            Route::get('/edit-the-loai/{id}', [TheLoaiController::class, 'getEditTheLoai'])->name('theloai.getEditTheLoai');
            Route::put('/edit-the-loai/{id}', [TheLoaiController::class, 'postEditTheLoai'])->name('theloai.postEditTheLoai');
            Route::post('/xoa-the-loai/{id}', [TheLoaiController::class, 'postDeleteTheLoai'])->name('theloai.postDeleteTheLoai');
            Route::get('/tim-kiem-the-loai', [TheLoaiController::class, 'getSearchTheLoai'])->name('theloai.getTimKiemTheLoai');
        });
        Route::group(['prefix' => '/nha-xuat-ban'], function () {
            Route::get('/', [NhaXuatBanController::class, 'getNhaXuatBan'])->name('nhaxuatban.getNhaXuatBan');
            Route::post('/add-nha-xuat-ban', [NhaXuatBanController::class, 'postAddNhaXuatBan'])->name('nhaxuatban.postAddNhaXuatBan');
            Route::get('/edit-nha-xuat-ban/{id}', [NhaXuatBanController::class, 'getEditNhaXuatBan'])->name('nhaxuatban.getEditNhaXuatBan');
            Route::put('/edit-nha-xuat-ban/{id}', [NhaXuatBanController::class, 'postEditNhaXuatBan'])->name('nhaxuatban.postEditNhaXuatBan');
            Route::post('/xoa-nha-xuat-ban/{id}', [NhaXuatBanController::class, 'postDeleteNhaXuatBan'])->name('nhaxuatban.postDeleteNhaXuatBan');
            Route::get('/search-nha-xuat-ban', [NhaXuatBanController::class, 'getSearchNhaXuatBan'])->name('nhaxuatban.getSearchNhaXuatBan');
        });

        Route::get('/tim-kiem-chuc-nang-he-thong', [SearchController::class, 'index'])->name('admin.Search');
    });
});

// Route xóa tất cả thông báo (POST request)
Route::post('/clear-notifications', function () {
    // Xóa tất cả thông báo trong session
    session()->forget('notifications');

    // Trả về phản hồi JSON để cập nhật giao diện
    return response()->json([
        'message' => 'Đã xóa tất cả thông báo!',
        'notifications_count' => 0,
        'notifications' => []
    ]);
})->name('clear.notifications');

Route::post('/clear-toast-session', function () {
    session()->forget('toast_message');
    session()->forget('toast_type');
    return response()->json(['status' => 'success']);
});

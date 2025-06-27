<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BorrowingController;
use App\Http\Controllers\Mahasiswa\HistoryController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Mahasiswa\CartController;
use App\Http\Controllers\Mahasiswa\DashboardMahasiswaController;
use App\Http\Controllers\Mahasiswa\MahasiswaController;

// use App\Http\Controllers\Mahasiswa\DashboardMahasiswaController;

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
    if (Auth::check()) {
        $role = Auth::user()->role;
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'mahasiswa') {
            return redirect()->route('mahasiswa.dashboard');
        }
    }

    return redirect()->route('login');
});
// Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('redirectIfAuthenticated')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'index'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});


Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardAdminController::class, 'index'])
        ->name('admin.dashboard');
    Route::get('/admin/create-book', [DashboardAdminController::class, 'create'])
        ->name('admin.create');
    Route::post('/admin/store-book', [DashboardAdminController::class, 'store'])
        ->name('admin.store.book');
    Route::get('/admin/edit-book/{buku:slug}', [DashboardAdminController::class, 'edit'])
        ->name('admin.edit');
    Route::put('/admin/update-book/{buku:slug}', [DashboardAdminController::class, 'update'])
        ->name('admin.update.book');
    Route::get('/admin/show-book/{buku:slug}', [DashboardAdminController::class, 'show'])
        ->name('admin.show');
    Route::resource('/category', CategoryController::class);
    Route::get('/admin/borrowing', [BorrowingController::class, 'index'])
        ->name('admin.borrowing');
    Route::get('/admin/borrowing-edit/{id}', [BorrowingController::class, 'edit'])
        ->name('admin.borrowing-edit');
    Route::put('/admin/borrowing-update/{id}', [BorrowingController::class, 'update'])
        ->name('admin.borrowing-update');
    Route::get('/admin/borrowing-search', [BorrowingController::class, 'search'])
        ->name('admin.borrowing-search');
    Route::get('/admin/setting', [AdminController::class, 'index'])->name('admin.setting');
    Route::put('/admin/setting/{id}', [AdminController::class, 'update'])
        ->name('admin.setting.update');
});

Route::middleware(['role:mahasiswa'])->group(function () {
    Route::get('/mahasiswa/dashboard', [DashboardMahasiswaController::class, 'index'])
        ->name('mahasiswa.dashboard');
    Route::get('mahasiswa/show-book/{buku:slug}', [DashboardMahasiswaController::class, 'show'])
        ->name('mahasiswa.show');
    Route::get('/mahasiswa/history', [HistoryController::class, 'index'])
        ->name('mahasiswa.history');
    Route::get('/mahasiswa/cart/{id?}', [CartController::class, 'index'])
        ->name('mahasiswa.cart');
    Route::get('/mahasiswa/cart/remove/{id}', [CartController::class, 'remove'])
        ->name('mahasiswa.cart.remove');
    Route::get('/mahasiswa/borrow/{buku:slug}', [CartController::class, 'formBorrow'])
        ->name('mahasiswa.formBorrow');
    Route::post('/mahasiswa/borrow', [CartController::class, 'borrow'])
        ->name('mahasiswa.borrow');
    Route::get('/mahasiswa/setting', [MahasiswaController::class, 'index'])
        ->name('mahasiswa.setting');
    Route::put('/mahasiswa/setting/{id}', [MahasiswaController::class, 'update'])
        ->name('mahasiswa.setting.update');
    Route::get('/mahasiswa/change-password', [MahasiswaController::class, 'formChangePassword'])
        ->name('mahasiswa.formChangePassword');
    Route::put('/mahasiswa/change-password/{id}', [MahasiswaController::class, 'changePassword'])
        ->name('mahasiswa.changePassword');
});

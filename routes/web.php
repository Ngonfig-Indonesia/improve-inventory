<?php

use App\Http\Controllers\TransaksiMasukController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
    return view('/auth/login');
})->name('login');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // DAFTAR ITEM
    Route::get('/admin/daftaritem/', [App\Http\Controllers\ItemController::class, 'index'])->name('item.index');
    Route::get('/admin/daftaritem/add', [App\Http\Controllers\ItemController::class, 'create'])->name('item.create');
    Route::post('/admin/daftaritem/store', [App\Http\Controllers\ItemController::class, 'store'])->name('item.store');
    Route::get('/admin/daftaritem/edit/{id}', [App\Http\Controllers\ItemController::class, 'edit'])->name('item.edit');
    Route::post('/admin/daftaritem/update/{id}', [App\Http\Controllers\ItemController::class, 'update'])->name('item.update');
    Route::get('/admin/daftaritem/delete/{id}', [App\Http\Controllers\ItemController::class, 'destroy'])->name('item.delete');
    Route::get('/admin/daftaritem/show/{id}', [App\Http\Controllers\ItemController::class, 'show'])->name('item.show');

    Route::get('/admin/supplier/', [App\Http\Controllers\SupplierController::class, 'index'])->name('supplier.index');

    // TRANSAKSI MASUK
    Route::get('/admin/transaksimasuk/', [App\Http\Controllers\TransaksiMasukController::class, 'index'])->name('tmasuk.index');
    Route::get('/admin/transaksimasuk/add', [App\Http\Controllers\TransaksiMasukController::class, 'create'])->name('tmasuk.create');
    Route::post('/admin/transaksimasuk/store', [App\Http\Controllers\TransaksiMasukController::class, 'store'])->name('tmasuk.store');
    Route::get('/admin/transaksimasuk/cari', [App\Http\Controllers\TransaksiMasukController::class, 'select2'])->name('tmasuk.select2');
    Route::get('/admin/transaksimasuk/show/{id}', [App\Http\Controllers\TransaksiMasukController::class, 'show'])->name('tmasuk.show');
    Route::get('/admin/transaksimasuk/edit/{id}', [App\Http\Controllers\TransaksiMasukController::class, 'edit'])->name('tmasuk.edit');
    Route::post('/admin/transaksimasuk/update/{id}', [App\Http\Controllers\TransaksiMasukController::class, 'update'])->name('tmasuk.update');
    Route::get('/admin/transaksimasuk/delete/{id}', [App\Http\Controllers\TransaksiMasukController::class, 'delete'])->name('tmasuk.delete');
    Route::get('/admin/transaksimasuk/destroy/{id}', [App\Http\Controllers\TransaksiMasukController::class, 'destroy'])->name('tmasuk.destory');

    // TRANSAKSI KELUAR
    Route::get('/admin/transaksikeluar/', [App\Http\Controllers\TransaksikeluarController::class, 'index'])->name('tkeluar.index');
    Route::get('/admin/transaksikeluar/add', [App\Http\Controllers\TransaksikeluarController::class, 'create'])->name('tkeluar.create');
    Route::get('/admin/transaksikeluar/cari', [App\Http\Controllers\TransaksikeluarController::class, 'select2'])->name('tkeluar.select2');
    Route::get('/admin/transaksikeluar/show/{id}', [App\Http\Controllers\TransaksikeluarController::class, 'show'])->name('tkeluar.show');
    Route::post('/admin/transaksikeluar/store', [App\Http\Controllers\TransaksikeluarController::class, 'store'])->name('tkeluar.store');
    Route::get('/admin/transaksikeluar/edit/{id}', [App\Http\Controllers\TransaksikeluarController::class, 'edit'])->name('tkeluar.edit');
    Route::post('/admin/transaksikeluar/update/{id}', [App\Http\Controllers\TransaksikeluarController::class, 'update'])->name('tkeluar.update');
    Route::get('/admin/transaksikeluar/delete/{id}', [App\Http\Controllers\TransaksikeluarController::class, 'delete'])->name('tkeluar.delete');
    Route::get('/admin/transaksikeluar/destroy/{id}', [App\Http\Controllers\TransaksikeluarController::class, 'destroy'])->name('tkeluar.destory');

    // USERS
    Route::get('/admin/settings/user', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('/admin/settings/user/add', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::post('/admin/settings/user/store', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::get('/admin/settings/user/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::post('/admin/settings/user/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::get('/admin/settings/user/destroy/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

    // PERMISSION
    Route::get('/admin/settings/permission', [App\Http\Controllers\RoleController::class, 'index'])->name('permission.index');
    Route::get('/admin/settings/permission/add', [App\Http\Controllers\RoleController::class, 'create'])->name('permission.create');
    Route::post('/admin/settings/permission/store', [App\Http\Controllers\RoleController::class, 'store'])->name('permission.store');
    Route::get('/admin/settings/permission/edit/{id}', [App\Http\Controllers\RoleController::class, 'edit'])->name('permission.edit');
    Route::post('/admin/settings/permission/update/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('permission.update');
    Route::get('/admin/settings/permission/destroy/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('permission.destroy');

    // LAPORAN TRANSAKSI MASUK
    Route::get('/admin/laporan/transaksi_masuk', [App\Http\Controllers\LaporanTransaksiMasuk::class, 'index'])->name('laporan.tmasuk');
    Route::get('/admin/laporan/transaksi_masuk/between', [App\Http\Controllers\LaporanTransaksiMasuk::class, 'pertanggal'])->name('laporan.pertanggal.tmasuk');

    // LAPORAN TRANSAKSI KELUAR
    Route::get('/admin/laporan/transaksi_keluar', [App\Http\Controllers\LaporanTransaksiKeluar::class, 'index'])->name('laporan.tkeluar');
    Route::get('/admin/laporan/transaksi_keluar/between', [App\Http\Controllers\LaporanTransaksiKeluar::class, 'pertanggal'])->name('laporan.pertanggal.keluar');

    // NOTIFICATION
    Route::get('/mark-as-read', [App\Http\Controllers\ItemController::class, 'markAsRead'])->name('mark-as-read');

    // TELEGRAM
    Route::get('/admin/sendtelegram', [App\Http\Controllers\StockController::class, 'index'])->name('sendtelegram');

    // LOGS
    Route::get('/admin/logs/logs', [App\Http\Controllers\LogsController::class, 'index'])->name('logs');
});

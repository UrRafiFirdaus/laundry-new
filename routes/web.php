<?php

use App\Http\Controllers\{
    DashboardController,
    KategoriController,
    PaketController,
    PaketDetailController,
    CustomerController,
    LandingController,
    SettingController,
    RiwayatController,
    ProfileController,
    LaporanController,
    UserController,
    PembayaranController,
};
/*use GuzzleHttp\Middleware;*/
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

Route::get('/', [LandingController::class, 'index'])->name('landing.index');
Route::get('/status', [LandingController::class, 'status'])->name('landing.status');
Route::get('/tentangkami', [LandingController::class, 'about'])->name('landing.about');
Route::get('/status/cek', [LandingController::class, 'cekStatus'])->name('status.cek');



Route::post('/bayar/{kode_paket}/snap', [PembayaranController::class, 'snap']) ->middleware('throttle:30,1')->name('pembayaran.snap');
Route::get('/bayar/{kode_paket}/status', [PembayaranController::class, 'status']) ->middleware('throttle:60,1')->name('pembayaran.status');



Route::group(['middleware' => 'auth'], function() {

    Route::get('/dashboard', [DashboardController::class, 'index'])-> name('dashboard');

    Route::group(['middleware' => 'level:1'], function() {
        Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
        Route::resource('/kategori', KategoriController::class);
        
        Route::get('/customer/data', [CustomerController::class, 'data'])-> name('customer.data');
        Route::resource('/customer', CustomerController::class);

        Route::resource('/daftarpaket', PaketController::class);
        Route::get('/paketbaru/data', [PaketController::class, 'data'])->name('paketbaru.data');
        Route::get('/paketbaru', [PaketController::class, 'index'])->name('paketbaru.index');
        Route::get('/paketbaru/{id}', [PaketController::class, 'show'])->name('paketbaru.show');
        Route::get('/paketbaru/{id}/edit', [PaketController::class, 'edit'])->name('paketbaru.edit');
        Route::put('/paketbaru/{id}', [PaketController::class, 'update'])->name('paketbaru.update');
        Route::delete('/paketbaru/{id}', [PaketController::class, 'destroy'])->name('paketbaru.destroy');
        Route::post('/paketbaru/{id}/proses', [PaketController::class, 'proses'])->name('paketbaru.proses');
        Route::post('/paketbaru/cetak-barcode', [PaketController::class, 'cetakKode'])->name('paketbaru.cetakbarcode');

        Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
        Route::get('/riwayat/data', [RiwayatController::class, 'data'])->name('riwayat.data');

        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/data/{awal}/{akhir}', [LaporanController::class, 'data'])->name('laporan.data');
        Route::get('/laporan/pdf/{awal}/{akhir}', [LaporanController::class, 'exportPDF'])->name('laporan.export_pdf');

        Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
        Route::resource('/user', UserController::class);

        Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
        Route::get('/setting/first', [SettingController::class, 'show'])->name('setting.show');
        Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');

    Route::group(['middleware' => 'level:1,2'], function() {
        Route::get('/transaksi/baru', [PaketController::class, 'create'])->name('transaksi.baru');
        Route::post('/transaksi/simpan', [PaketController::class, 'store'])->name('transaksi.simpan');
        Route::get('/transaksi/selesai', [PaketController::class, 'selesai'])->name('transaksi.selesai');


        Route::get('/transaksi/{id}/data', [PaketDetailController::class, 'data'])->name('transaksi.data');
        Route::resource('/transaksi', PaketDetailController::class)
            -> except('create'.'show');


        Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
        Route::post('/profil', [UserController::class, 'updateProfil'])->name('user.update_profil');
    });

        
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

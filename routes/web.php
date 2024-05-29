<?php

use App\Http\Controllers\LatestGPSController;
use App\Http\Controllers\CashPaymentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DurasiSewaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentCallbackController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SepedaController;
use App\Http\Controllers\TipeSepedaController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserHomeController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});
Route::get('/home', [AdminController::class, 'index'])->name('admin.dashboard')->middleware(['auth', 'admin']);
Route::get('/home', [UserHomeController::class, 'index'])->name('konsumen.dashboard')->middleware(['auth', 'konsumen']);
// Route::get('/home', [UserHomeController::class, 'index'])->name('konsumen.dashboard')->middleware(['auth', 'konsumen']);

Auth::routes();

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/home', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::prefix('user')->group(function () {
        Route::get('/list', [UserController::class, 'index'])->name('user.index');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    });

    Route::prefix('tipeSepeda')->group(function () {
        Route::get('/list', [TipeSepedaController::class, 'index'])->name('tipeSepeda.index');
        Route::get('/edit/{id}', [TipeSepedaController::class, 'edit'])->name('tipeSepeda.edit');
        Route::post('/store', [TipeSepedaController::class, 'store'])->name('tipeSepeda.store');
        Route::put('/update/{id}', [TipeSepedaController::class, 'update'])->name('tipeSepeda.update');
        Route::delete('/delete/{id}', [TipeSepedaController::class, 'delete'])->name('tipeSepeda.delete');
    });

    Route::prefix('durasiSewa')->group(function () {
        Route::get('/list', [DurasiSewaController::class, 'index'])->name('durasiSewa.index');
        Route::get('/edit/{id}', [DurasiSewaController::class, 'edit'])->name('durasiSewa.edit');
        Route::post('/store', [DurasiSewaController::class, 'store'])->name('durasiSewa.store');
        Route::put('/update/{id}', [DurasiSewaController::class, 'update'])->name('durasiSewa.update');
        Route::delete('/delete/{id}', [DurasiSewaController::class, 'delete'])->name('durasiSewa.delete');
    });

    Route::prefix('sepeda')->group(function () {
        Route::get('/list', [SepedaController::class, 'index'])->name('sepeda.index');
        Route::get('/peta/{id}', [SepedaController::class, 'getLatestCoordinates'])->name('sepeda.peta');
        Route::get('/edit/{id}', [SepedaController::class, 'edit'])->name('sepeda.edit');
        Route::post('/store', [SepedaController::class, 'store'])->name('sepeda.store');
        Route::put('/update/{id}', [SepedaController::class, 'update'])->name('sepeda.update');
        Route::delete('/delete/{id}', [SepedaController::class, 'delete'])->name('sepeda.delete');
    });

    Route::prefix('transaksi')->group(function () {
        Route::get('/list', [TransactionController::class, 'index'])->name('transaksi.index');
        Route::get('/edit/{id}', [TransactionController::class, 'detail'])->name('transaksi.edit');
        Route::get('/peta/{id}', [TransactionController::class, 'getLatestCoordinates'])->name('sepeda.peta');
    });

    Route::prefix('laporan')->group(function () {
        Route::get('/list', [ReportController::class, 'index'])->name('laporan.index');
        Route::post('/export', [ReportController::class, 'export'])->name('laporan.export');
    });
});

Route::group(['prefix' => 'staff', 'namespace' => 'User', 'middleware' => ['auth', 'staff']], function () {
    Route::get('/home', [UserHomeController::class, 'index'])->name('staff.dashboard'); //home
    Route::get('/borrow', [UserHomeController::class, 'borrow'])->name('staff.borrow'); // menampilkan siapa yang minjam sepeda
    Route::get('/transaction', [UserHomeController::class, 'transaction'])->name('staff.transaction'); // menampilkan siapa yang sudah mengembalikan sepda dan pemmbayaran
    Route::get('/profile', [UserHomeController::class, 'profile'])->name('staff.profile'); // prolfie
    Route::post('/pay', [UserHomeController::class, 'paymentBorrow'])->name('staff.pay.borrow'); // pembayaran pinjam sepeda
    Route::post('/return', [UserHomeController::class, 'finishProcess'])->name('staff.pay.return'); // pengembalian sepeda
    Route::get('/transactioncash', [UserHomeController::class, 'transactioncash'])->name('staff.transactioncash');
    Route::post('/borrowcash', [UserHomeController::class, 'paymentBorrowCash'])->name('staff.paycash.borrow');
    Route::post('/returncash', [UserHomeController::class, 'finishProcess'])->name('staff.paycash.return');
    // Route::post('/payment-form', [CashPaymentController::class, 'showPaymentForm'])->name('components._tunai');
});

Route::get('/latestcoordinates/{sepedaId}', [LatestGPSController::class, 'getLatestCoordinates']);



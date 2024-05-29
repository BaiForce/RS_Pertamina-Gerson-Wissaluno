<?php

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TunaiController;
use App\Http\Controllers\Api\LokasiController;
use App\Http\Controllers\PaymentCallbackController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/payment/midtrans', [PaymentCallbackController::class, 'receive'])->name('staff.pay.notif');
Route::post('/payment/success', [PaymentCallbackController::class, 'success'])->name('staff.pay.success');
Route::post('/payment/cash', [TunaiController::class, 'receive'])->name('staff.paycash.notif');
Route::put('/paymentcash/success', [TunaiController::class, 'success'])->name('staff.paycash.success');
// Route::post('/paymentcash/success', [CashPaymentController::class, 'success'])->name('staff.paymentcash.succes');

// Route::post('/lokasi/{id_sepeda}', [LokasiController::class, 'store'])->name('lokasi.store');
Route::post('lokasi/{number_sepeda}', [LokasiController::class, 'store'])->name('lokasi.store');

Route::post('getDenda', function (Request $request) {
    $transaksi = Transaction::findOrFail($request->input('id'));
    $date = $request->input('date');
    $time = $request->input('time');

    // MENGHITUNG JUMBLAH MENIT YANG TERLEWAT
    $duration = intval($transaksi->duration->duration);
    $start_time = Carbon::parse($transaksi->start_date . ' ' . $transaksi->start_time);
    $start_time->addMinutes($duration);
    $end_time = Carbon::parse($request->date . ' ' . $request->time);
    $durationInMinutes = $start_time->diffInMinutes($end_time);

    // menghitung total denda permenit
    $hitung = $transaksi->duration->charge * $durationInMinutes;
    $kelipatan = 1000;
    $hasil_bulat = floor($hitung / $kelipatan) * $kelipatan;
    if ($hasil_bulat <= 0) {
        $totalDenda = 0;
        return response()->json(['status' => false, 'data' => null]);
    } else {
        $totalDenda = number_format($hasil_bulat, 0) ;
        return response()->json(['status' => true, 'data' => $totalDenda]);
    }
})->name('showDenda');

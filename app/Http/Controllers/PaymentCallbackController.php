<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Sepeda;
use App\Models\Pemesanan;
use App\Models\DurasiSewa;
use App\Models\TipeSepeda;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\LocationTrack;
use App\Traits\CommonHelpersTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Services\Midtrans\CallbackService;

class PaymentCallbackController extends Controller
{
    use CommonHelpersTrait;

    public function receive()
    {
        $callback = new CallbackService;

        if ($callback->isSignatureKeyVerified()) {
            $notification = $callback->getNotification();
            $order = $callback->getOrder();
            $explode = explode('-', $notification->order_id);

            if ($callback->isSuccess()) {
                Log::info($explode);
                $returnPay = Transaction::where('id', $explode[0])->where('status', '1')->first();
                if ($returnPay) {
                    $returnPay->update([
                        'total_price' => $notification->gross_amount,
                        'charge' => $notification->gross_amount,
                        'total' => $returnPay->total_price + $notification->gross_amount,
                        'status' => '2',
                    ]);
                    $sepeda = Sepeda::findOrFail($returnPay->bike_id);
                    $sepeda->status = 1;
                    $sepeda->save();
                } else {
                    Pemesanan::where('number', $order->number)->update([
                        'payment_status' => 2,
                    ]);
                }
            }

            if ($callback->isExpire()) {
                Pemesanan::where('number', $order->number)->update([
                    'payment_status' => 3,
                ]);
            }

            if ($callback->isCancelled()) {
                Pemesanan::where('number', $order->number)->update([
                    'payment_status' => 4,
                ]);
            }

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Notifikasi berhasil diproses',
                    'data' => [
                        'order' => $order,
                        'notificaiton' => $notification
                    ],
                ]);
        } else {
            return response()
                ->json([
                    'error' => true,
                    'message' => 'Signature key tidak terverifikasi',
                ], 403);
        }

        return response()->json([], 200);
    }

    public function success(Request $request)
{
    try {
        DB::transaction(function () use ($request) {
            $transaction = new Transaction();

            $sepeda = Sepeda::findOrFail($request->bike_id);
            $sepeda->status = 2;
            $sepeda->save();

            $durasi = DurasiSewa::findOrFail($request->duration_id);
            $request_image_name = 'pict' . $request->bike_id;

            // TRANSACTION TABLE
            $transaction->invoice = $request->invoice;
            $transaction->user_id = $request->user_id;
            $transaction->admin_id = $request->admin_id;
            $transaction->bike_id = $request->bike_id;
            $transaction->duration_id = $request->duration_id;
            $transaction->start_date = $request->start_date;
            $transaction->start_time = Carbon::createFromFormat('h:i A', $request->start_time)->format('H:i:s');
            $transaction->total_price = $durasi->price;
            $transaction->payment = 'qris';
            $transaction->charge = '0';
            $transaction->total = NULL;

            if ($request->file($request_image_name)) {
                // return true;
                $imagePath = $this->uploadImage($request);
                $transaction->jaminan = $imagePath;
            }
            $transaction->save(); // Simpan transaksi terlebih dahulu untuk mendapatkan ID

            $pemesanan = Pemesanan::where('number', $request->invoice)->first();
            $pemesanan->transaction_id = $transaction->id;
            $pemesanan->save();
        });

        // If no exception is thrown, the transaction will be committed automatically
        return response()->json(['success' => true, 'data' => '']);
    } catch (\Exception $e) {
        Log::info($e);
        // An exception occurred, so the transaction will be rolled back
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}


    protected function udapteTransaksi($invoiceTransaksi)
    {
    }
}

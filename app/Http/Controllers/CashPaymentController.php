<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Pemesanan;
use App\Models\Sepeda;
use App\Models\DurasiSewa;
use App\Models\TipeSepeda;
use App\Models\User;
use App\Traits\CommonHelpersTrait;
use Illuminate\Support\Facades\DB;

class CashPaymentController extends Controller

{

    use CommonHelpersTrait;


    public function showPaymentForm(Request $request)
    {
        try {
            // Mengambil pemesanan terakhir dari basis data
            $pemesanan = Pemesanan::latest()->first();

            // Jika pemesanan tidak ditemukan, tampilkan pesan yang sesuai
            if (!$pemesanan) {
                return view('components._tunai')->with(['error' => 'Pemesanan tidak ditemukan']);
            }

            // Ambil data yang diperlukan dari pemesanan
            $pemesananId = $pemesanan->id;
            $number = $pemesanan->number;
            $totalPrice = $pemesanan->total_price;

            // Kembalikan view dengan data pemesanan
            return view('components._tunai', compact('number', 'totalPrice', 'pemesananId'));
        } catch (\Exception $e) {
            // Tangani kesalahan yang terjadi dan kembalikan respons sesuai kebutuhan
            return view('components._tunai')->with(['error' => $e->getMessage()]);
        }
    }


    // buat id pemesananan metode tunai dengan routeNameCash
    public function paymentBorrowCash(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $transaction = new Transaction();
                $pemesanan = new Pemesanan();

                $sepeda = Sepeda::findOrFail($request->bike_id);
                $durasi = DurasiSewa::findOrFail($request->duration_id);
                $jenis = TipeSepeda::findOrFail($sepeda->jenis_id);
                $user = User::findOrFail($request->user_id);

                //GENERATE INVOICE NUMBER
                $invoice_number = $transaction->generateOrderID($jenis->name);

                //PEMESANAN TRACK TABLE
                $pemesanan->number = $invoice_number;
                $pemesanan->transaction_id = NULL;
                $pemesanan->payment = 'tunai';
                $pemesanan->total_price = $durasi->price;
                $pemesanan->note = '-';
                $pemesanan->payment_status = '1';
                $pemesanan->save();

                // Update sepeda status
                $sepeda->status = 0; // Atur status sepeda sesuai kebutuhan
                $sepeda->save();
            });

            // Jika tidak ada pengecualian yang dilempar, transaksi akan berhasil
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Tangani pengecualian
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function finishProcesscash(Request $request)
    {
        try {
            $transaction = Transaction::findOrFail($request->trans_id);
            $durasi = DurasiSewa::findOrFail($transaction->duration_id);

            $start_time = $transaction->start_time;
            $end_time = Carbon::parse($request->end_time);
            $duration = $durasi->duration;

            // Convert start_time and end_time to Carbon instances
            $start = Carbon::createFromFormat('H:i:s', $start_time);
            $end = Carbon::createFromFormat('H:i:s', $end_time->format('H:i:s')); // Ensure end_time is in the correct format

            // Calculate the difference between start and end times
            $durationInMinutes = $start->diffInMinutes($end);

            // Convert $duration string to an integer
            $duration = intval($duration);

            // Check if the duration is greater than $duration
            if ($durationInMinutes > $duration) {
                // Handle case where duration exceeds allowed duration
                // You can add custom logic here if needed
            } elseif ($durationInMinutes <= $duration) {
                DB::transaction(function () use ($transaction, $request, $end) {
                    $sepeda = Sepeda::findOrFail($transaction->bike_id);
                    $sepeda->status = 1;
                    $sepeda->save();

                    // Update transaction status
                    $transaction->end_date = $request->end_date;
                    $transaction->end_time = $end;
                    $transaction->status = '2'; // Mark transaction as completed
                    $transaction->save();
                });

                return response()->json(['success' => true, 'charge' => false]);
            }
        } catch (\Exception $e) {
            // An exception occurred, so the transaction will be rolled back
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }



    public function success(Request $request)
    {
        $pemesananId = $request->input('pemesanan_id');

        // Mengambil pemesanan berdasarkan ID
        $pemesanan = Pemesanan::find($pemesananId);

        if ($pemesanan) {
            // Mengubah status pembayaran menjadi 2
            $pemesanan->status_payment = 2;
            $pemesanan->save();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Pemesanan tidak ditemukan']);
        }
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\DurasiSewa;
use App\Models\Pemesanan;
use App\Models\Sepeda;
use App\Models\TipeSepeda;
use App\Models\Transaction;
use App\Models\User;
use App\Services\Midtrans\CreateSnapTokenService;
use App\Services\Midtrans\CreateSnapTokenServiceReturn;
use App\Traits\CommonHelpersTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserHomeController extends Controller
{
    use CommonHelpersTrait;

    public function index(Request $request)
    {
        $searchQuery = $request->input('query');

        $sepedaQuery = Sepeda::with('jenis', 'durasi');

        // Apply search filter only if query is provided
        if ($searchQuery) {
            $sepedaQuery->whereHas('jenis', function ($innerQuery) use ($searchQuery) {
                $innerQuery->where('name', 'like', '%' . $searchQuery . '%');
            });
        }

        $sepeda = $sepedaQuery->get();

        $konsumen = User::where('role', 'konsumen')->get();
        // dd($transaction->toArray());
        return view('userHome', compact('sepeda', 'konsumen'));
    }

    public function borrow()
    {
        $sepeda = Sepeda::with('jenis', 'durasi')->get();
        $transaction = Transaction::with('user', 'admin', 'sepeda', 'sepeda.jenis', 'duration')->where('admin_id', Auth::user()->id)->where('status', 1)->get();
        $konsumen = User::where('role', 'konsumen')->get();
        // dd($transaction->toArray());
        return view('userHomeBorrow', compact('sepeda', 'transaction', 'konsumen'));
    }

    public function transaction()
    {
        $sepeda = Sepeda::with('jenis', 'durasi')->get();
        $transaction = Transaction::with('user', 'admin', 'sepeda', 'sepeda.jenis', 'duration')->where('admin_id', Auth::user()->id)->where('status', 2)->get();
        $konsumen = User::where('role', 'konsumen')->get();
        // dd($transaction->toArray());
        return view('userHomeTransaction', compact('sepeda', 'transaction', 'konsumen'));
    }
    public function profile()
    {
        return view('userHomeProfile');
    }



    public function paymentBorrow(Request $request)
    {
        try {
            $snapToken = '';
            DB::transaction(function () use ($request, &$snapToken) {
                $transaction = new Transaction();
                $pemesanan = new Pemesanan();

                $sepeda = Sepeda::findOrFail($request->bike_id);
                // $sepeda->status = 2;
                $sepeda->save();

                $durasi = DurasiSewa::findOrFail($request->duration_id);
                $jenis = TipeSepeda::findOrFail($sepeda->jenis_id);
                $user = User::findOrFail($request->user_id);

                //GENERATE INOVICE NUMBER
                $invoice_number = $transaction->generateOrderID($jenis->name);

                //GENERATE PAYMENT & SNAPTOKEN
                $midtrans = new CreateSnapTokenService($sepeda, $durasi, $jenis, $invoice_number, $user);
                $snapToken = $midtrans->getSnapToken();
            });

            // If no exception is thrown, the transaction will be committed automatically
            return response()->json(['success' => true, 'data' => $snapToken]);
        } catch (\Exception $e) {
            // An exception occurred, so the transaction will be rolled back
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function paymentBorrowCash(Request $request)
    {
        $durasi = DurasiSewa::findOrFail($request->duration_id);
        if ($request->input('total_price') < $durasi->price) return response()->json(['success' => false, 'message' => 'Uang anda tidak cukup!']);
        try {
            DB::transaction(function () use ($request, $durasi) {
                $transaction = new Transaction();
                $pemesanan = new Pemesanan();

                $sepeda = Sepeda::findOrFail($request->bike_id);
                $jenis = TipeSepeda::findOrFail($sepeda->jenis_id);
                $user = User::findOrFail($request->user_id);

                //GENERATE INVOICE NUMBER
                $invoice_number = $transaction->generateOrderID($jenis->name);

                // CREATE TRANSACTION LANGSUNG TANPA MIDTRANSACTION
                $transaction->invoice = $invoice_number;
                $transaction->user_id = $request->input('user_id');
                $transaction->admin_id = $request->input('admin_id');
                $transaction->bike_id = $request->input('bike_id');
                $transaction->duration_id = $request->input('duration_id');
                $transaction->start_date = $request->input('start_date');
                $transaction->start_time = date('H:i:s', strtotime($request->input('start_time')));
                $transaction->amount = $durasi->price; // BIAYA SEWA SESUAI DURASI
                $transaction->payment = 'tunai';
                $transaction->status = '1';
                $transaction->jaminan = '-';
                $transaction->save();

                //PEMESANAN TRACK TABLE
                $pemesanan->number = $invoice_number;
                $pemesanan->transaction_id = $transaction->id;
                $pemesanan->payment = 'tunai';
                $pemesanan->total_price = $request->input('total_price'); // TOTAL UANG USER
                $pemesanan->note = '-';
                $pemesanan->payment_status = '2';
                $pemesanan->snap_token = NULL;
                $pemesanan->save();

                // Update sepeda status if needed
                $sepeda->status = 2;
                $sepeda->save();

                // Update transaction status if needed
                // $transaction->status = '2';
                // $transaction->save();
            });

            // Jika tidak ada pengecualian yang dilempar, peminjaman tunai berhasil
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Tangani pengecualian
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function finishProcess(Request $request)
    {
        try {
            $snapToken = '';

            $transaction = Transaction::findOrFail($request->trans_id);
            $durasi = DurasiSewa::findOrFail($transaction->duration_id);
            $duration = $durasi->duration;

            // MENGHITUNG JUMBLAH MENIT YANG TERLEWAT
            $duration = intval($duration);
            $start_time = Carbon::parse($transaction->start_date . ' ' . $transaction->start_time);
            $start_time->addMinutes($duration);
            $end_time = Carbon::parse($request->end_date . ' ' . $request->end_time);
            $durationInMinutes = $start_time->diffInMinutes($end_time);

            // menghitung total denda permenit
            $totalDenda = $durasi->charge * $durationInMinutes;
            // Convert start_time and end_time to Carbon instances
            // $start = Carbon::createFromFormat('H:i:s', $start_time);
            $end_times = Carbon::parse($request->end_time);
            // $end = Carbon::createFromFormat('H:i:s', $end_times->format('H:i:s'));

            // Check if the duration is greater than $duration
            if ($durationInMinutes > 0) {
                $hasil = DB::transaction(function () use ($transaction, &$snapToken, $request, $durasi, $end_times, $totalDenda) {
                    $pemesanan = new Pemesanan();

                    $sepeda = Sepeda::findOrFail($transaction->bike_id);
                    $jenis = TipeSepeda::findOrFail($sepeda->jenis_id);
                    $user = User::findOrFail($transaction->user_id);

                    //GENERATE INOVICE NUMBER
                    $invoice_number = $transaction->generateOrderID($jenis->name);

                    if ($request->input('payment') == 'qris') {
                        $sepeda = Sepeda::findOrFail($transaction->bike_id);
                        $sepeda->status = 1;
                        $sepeda->save();
                        //GENERATE PAYMENT & SNAPTOKEN
                        $transaction->payment = 'qris';
                        $transaction->end_date = $request->end_date;
                        $transaction->end_time = $end_times;
                        $transaction->save();

                        $midtrans = new CreateSnapTokenServiceReturn($sepeda, $totalDenda, $jenis, $invoice_number, $user, $transaction->id);
                        $snapToken = $midtrans->getSnapToken();

                        return response()->json(['success' => true, 'data' => $snapToken]);
                    } else if ($request->input('payment') == 'tunai') {
                        if ((int) $request->total_price < $totalDenda) {
                            return response()->json(['success' => false, 'message' => 'Uang anda tidak cukup!']);
                        } else {
                            $sepeda = Sepeda::findOrFail($transaction->bike_id);
                            $sepeda->status = 1;
                            $sepeda->save();

                            //TRANSACTION TABLE
                            $transaction->end_date = $request->end_date;
                            $transaction->end_time = $end_times;
                            $transaction->total_price = $request->total_price;
                            $transaction->charge = $totalDenda;
                            $transaction->total = $request->total_price + $transaction->amount + $totalDenda;
                            $transaction->payment = 'tunai';
                            $transaction->status = '2';
                            $transaction->save();

                            return response()->json(['success' => true, 'data' => $snapToken]);
                        }
                    } else {
                        $sepeda = Sepeda::findOrFail($transaction->bike_id);
                        $sepeda->status = 1;
                        $sepeda->save();
                        //TRANSACTION TABLE
                        $transaction->end_date = $request->end_date;
                        $transaction->end_time = $end_times;
                        $transaction->total_price = $transaction->amount;
                        $transaction->total = $transaction->amount;
                        $transaction->status = '2';
                        $transaction->save();

                        return response()->json(['success' => true, 'data' => $snapToken]);
                    }
                });

                return $hasil;
            } elseif ($durationInMinutes <= 0) {
                DB::transaction(function () use ($transaction, $request, $end_times) {
                    $sepeda = Sepeda::findOrFail($transaction->bike_id);
                    $sepeda->status = 1;
                    $sepeda->save();

                    //TRANSACTION TABLE
                    $transaction->end_date = $request->end_date;
                    $transaction->end_time = $end_times->toTimeString();
                    $transaction->total = $transaction->amount;
                    $transaction->status = '2';
                    $transaction->save();
                });
                return response()->json(['success' => true, 'charge' => false]);
            }
        } catch (\Exception $e) {
            // An exception occurred, so the transaction will be rolled back
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}

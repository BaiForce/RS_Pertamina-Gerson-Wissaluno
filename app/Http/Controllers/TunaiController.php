<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DurasiSewa;
use App\Models\LocationTrack;
use App\Models\Pemesanan;
use App\Models\Sepeda;
use App\Models\TipeSepeda;
use App\Models\Transaction;
use App\Models\User;
use App\Services\Midtrans\CallbackService;
use App\Traits\CommonHelpersTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TunaiController extends Controller
{
    use CommonHelpersTrait;


    public function success(Request $request)
    {
        $pemesananId = $request->input('pemesanan_id');

        // Mengambil pemesanan berdasarkan ID
        $pemesanan = Pemesanan::find($pemesananId);

        if ($pemesanan) {
            // Mengubah status pembayaran menjadi 2
            $pemesanan->payment_status = 2;
            $pemesanan->save();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Pemesanan tidak ditemukan']);
        }
    }
}

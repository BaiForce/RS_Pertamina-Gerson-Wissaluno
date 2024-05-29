<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Transaction;
use App\Models\Lokasi;
use Illuminate\Http\Request;


class TransactionController extends Controller
{
    public function index()
    {
        $transaction = Transaction::with('user', 'admin', 'sepeda', 'sepeda.jenis', 'duration')->get();
        $no = 1;
        return view('pesanan.index', compact('transaction', 'no'));

    }

   public function detail(Request $request, $id)
    {
        try {
            // Cari transaksi berdasarkan ID yang diterima
            $transaction = Transaction::with('user', 'admin', 'sepeda', 'sepeda.jenis', 'duration')->findOrFail($id);
            $no = 1;
            return view('pesanan.edit', compact('transaction', 'no'));
        } catch (\Exception $e) {
            // Tangani jika transaksi tidak ditemukan
            return back()->with('error', 'Transaksi tidak ditemukan.');
        }
    }


    public function getLatestCoordinates(Request $request)
    {
        try {
            // Mendapatkan data lokasi terbaru untuk setiap id_sepeda
            $latestCoordinates = [];
            $sepedaIds = Lokasi::select('id_sepeda')->distinct()->pluck('id_sepeda');
            foreach ($sepedaIds as $sepedaId) {
                $latestGPSData = Lokasi::where('id_sepeda', $sepedaId)->latest()->first();
                if ($latestGPSData) {
                    $latitude = $latestGPSData->latitude;
                    $longitude = $latestGPSData->longitude;
                    $latestCoordinates[] = [
                        'id_sepeda' => $sepedaId,
                        'latitude' => $latitude,
                        'longitude' => $longitude
                    ];
                }
            }

            if (!empty($latestCoordinates)) {
                return view('sepeda.peta', compact('latitude', 'longitude'));
            } else {
                return response()->json([
                    'error' => 'No GPS coordinates available for any sepeda.'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch GPS coordinates.'
            ], 500);
        }
    }
}

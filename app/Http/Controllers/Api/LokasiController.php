<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LokasiResource;
use App\Models\Lokasi;
use App\Models\Sepeda;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $number
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $number)
    {
        // Validasi input
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        // Dapatkan id sepeda berdasarkan nomor sepeda
        $sepeda = Sepeda::where('number', $number)->first();

        // Jika sepeda tidak ditemukan, kembalikan pesan kesalahan
        if (!$sepeda) {
            return response()->json(['error' => 'Sepeda dengan nomor tersebut tidak ditemukan'], 404);
        }

        // Buat data lokasi baru
        $lokasi = Lokasi::create([
            'id_sepeda' => $sepeda->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        // Kembalikan data lokasi yang baru dibuat
        return new LokasiResource($lokasi);
    }
}

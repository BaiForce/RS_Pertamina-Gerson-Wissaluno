<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lokasi;

class LatestGPSController extends Controller
{
    /**
     * Get the latest GPS coordinates for all sepeda.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
                    $number = $latestGPSData->sepeda->number; // Ambil nomor sepeda melalui relasi
                    $latestCoordinates[] = [
                        'id_sepeda' => $sepedaId,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'number' => $number
                    ];
                }
            }

            if (!empty($latestCoordinates)) {
                return response()->json($latestCoordinates);
            } else {
                return view('sepeda.peta');
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch GPS coordinates.'
            ], 500);
        }
    }
}

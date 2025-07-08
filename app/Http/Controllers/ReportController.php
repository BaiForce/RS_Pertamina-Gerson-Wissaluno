<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Transaction;
use App\Models\Rute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    // app/Http/Controllers/ReportController.php
    public function index()
    {
        Log::info('Masuk ke ReportController@index');

        // Ambil semua driver dengan relasi yang diperlukan
        $drivers = Driver::with(['transactions' => function ($query) {
            $query->with('rute'); // Pastikan rute dimuat
        }])->get();

        // 1. Hitung jumlah trip per driver menggunakan accessor
        $tripCounts = $drivers->map(function ($driver) {
            return [
                'id' => $driver->id,
                'name' => $driver->name,
                'total_trip' => $driver->transactions->count(),
                'total_distance' => $driver->total_distance, // Gunakan accessor
                'total_cost' => $driver->total_cost, // Gunakan accessor
                'total_late' => $driver->total_late // Gunakan accessor
            ];
        });

        // 2. Hitung total keterlambatan per driver
        $lateCounts = $drivers->map(function ($driver) {
            return [
                'driver' => $driver,
                'total_late' => $driver->total_late, // Gunakan accessor
            ];
        })->sortByDesc('total_late')->values();

        $mostLateDriver = $lateCounts[0]['driver'] ?? null;
        $secondMostLateDriver = $lateCounts[1]['driver'] ?? null;

        // 3. Hitung total cost per driver
        $costCounts = $drivers->map(function ($driver) {
            return [
                'driver' => $driver,
                'total_cost' => $driver->total_cost, // Gunakan accessor
            ];
        })->sortByDesc('total_cost')->values();

        $secondHighestCostDriver = $costCounts[1]['driver'] ?? null;

        // 4. Hitung total jarak tempuh per driver
        $distanceCounts = $drivers->map(function ($driver) {
            return [
                'driver' => $driver,
                'total_distance' => $driver->total_distance, // Gunakan accessor
            ];
        })->sortByDesc('total_distance')->values();

        $mostDistanceDriver = $distanceCounts[0]['driver'] ?? null;

        // 5. Siapkan data grafik
        $chartData = $drivers->map(function ($driver) {
            return [
                'name' => $driver->name,
                'distance' => $driver->total_distance, // Gunakan accessor
                'cost' => $driver->total_cost, // Gunakan accessor
            ];
        });

        Log::info('Selesai proses dan akan me-return view');

        return view('reports.index', compact(
            'mostLateDriver',
            'secondMostLateDriver',
            'secondHighestCostDriver',
            'mostDistanceDriver',
            'tripCounts',
            'chartData'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function index()
    {
        Log::info('Masuk ke ReportController@index');

        // Ambil semua driver dan relasi transactions dan rute
        $drivers = Driver::with('transactions.rute')->get();

        // 1. Hitung jumlah trip per driver
        $tripCounts = $drivers->map(function ($driver) {
            return [
                'id' => $driver->id,
                'name' => $driver->name,
                'total_trip' => $driver->transactions->count(),
            ];
        });

        // 2. Hitung total keterlambatan per driver
        $lateCounts = $drivers->map(function ($driver) {
            return [
                'driver' => $driver,
                'total_late' => $driver->transactions->sum('late'),
            ];
        })->sortByDesc('total_late')->values();

        $mostLateDriver = $lateCounts[0]['driver'] ?? null;
        $secondMostLateDriver = $lateCounts[1]['driver'] ?? null;

        // 3. Hitung total cost per driver
        $costCounts = $drivers->map(function ($driver) {
            return [
                'driver' => $driver,
                'total_cost' => $driver->transactions->sum('total_cost'),
            ];
        })->sortByDesc('total_cost')->values();

        $secondHighestCostDriver = $costCounts[1]['driver'] ?? null;

        // 4. Hitung total jarak tempuh per driver
        $distanceCounts = $drivers->map(function ($driver) {
            return [
                'driver' => $driver,
                'total_distance' => $driver->transactions->sum(function ($t) {
                    return $t->rute->distance ?? 0;
                }),
            ];
        })->sortByDesc('total_distance')->values();

        $mostDistanceDriver = $distanceCounts[0]['driver'] ?? null;

        // 5. Siapkan data grafik
        $chartData = $drivers->map(function ($driver) {
            return [
                'name' => $driver->name,
                'distance' => $driver->transactions->sum(function ($t) {
                    return $t->rute->distance ?? 0;
                }),
                'cost' => $driver->transactions->sum('total_cost'),
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

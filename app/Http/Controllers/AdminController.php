<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        Log::info('Masuk ke AdminController@index');

        // Ambil semua driver dengan relasi yang diperlukan
        $drivers = Driver::with(['transactions.rute'])->get();

        // Debugging - Pastikan data dimuat dengan benar
        Log::debug('Driver pertama:', [
            'name' => $drivers->first()->name ?? null,
            'total_distance' => $drivers->first()->total_distance ?? null,
            'transactions_count' => $drivers->first()->transactions->count() ?? null,
            'first_transaction' => $drivers->first()->transactions->first() ?? null
        ]);

        // 1. Hitung statistik utama
        $stats = [
            'total_drivers' => $drivers->count(),
            'total_trips' => $drivers->sum(function ($driver) {
                return $driver->transactions->count();
            }),
            'total_distance' => $drivers->sum(function ($driver) {
                return $driver->total_distance;
            }),
            'total_cost' => $drivers->sum('total_cost')
        ];

        // 2. Hitung jumlah trip per driver
        $tripCounts = $drivers->map(function ($driver) {
            return [
                'id' => $driver->id,
                'name' => $driver->name,
                'total_trip' => $driver->transactions->count(),
                'total_distance' => $driver->total_distance,
                'total_cost' => $driver->total_cost,
                'total_late' => $driver->total_late
            ];
        });

        // 3. Driver terlambat
        $lateCounts = $drivers->sortByDesc(function ($driver) {
            return $driver->total_late;
        })->values();

        $mostLateDriver = $lateCounts->first();
        $secondMostLateDriver = $lateCounts->get(1);

        // 4. Driver dengan biaya tertinggi
        $costCounts = $drivers->sortByDesc('total_cost')->values();
        $highestCostDriver = $costCounts->first();
        $secondHighestCostDriver = $costCounts->get(1);

        // 5. Driver dengan jarak tempuh terjauh
        $distanceCounts = $drivers->sortByDesc('total_distance')->values();
        $mostDistanceDriver = $distanceCounts->first();

        // 6. Siapkan data grafik
        $chartData = [
            'labels' => $drivers->pluck('name')->toArray(),
            'distance' => $drivers->pluck('total_distance')->toArray(),
            'cost' => $drivers->pluck('total_cost')->toArray(),
            'trips' => $drivers->pluck('transactions')->map->count()->toArray()
        ];

        Log::info('Selesai proses dan akan me-return view');

        return view('home', [
            'type_menu' => 'dashboard',
            'stats' => $stats,
            'mostLateDriver' => $mostLateDriver,
            'secondMostLateDriver' => $secondMostLateDriver,
            'highestCostDriver' => $highestCostDriver,
            'secondHighestCostDriver' => $secondHighestCostDriver,
            'mostDistanceDriver' => $mostDistanceDriver,
            'tripCounts' => $tripCounts,
            'chartData' => $chartData
        ]);
    }
}
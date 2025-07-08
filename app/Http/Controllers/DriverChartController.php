<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverChartController extends Controller
{
    public function driverDistanceCostChart()
    {
        // Ambil data driver dengan total jarak dan biaya
        $drivers = Driver::with('transactions.rute')->get();

        $chartData = $drivers->map(function ($driver) {
            return [
                'driver_name' => $driver->name,
                'total_distance' => $driver->transactions->sum(function ($transaction) {
                    return $transaction->rute->distance;
                }),
                'total_cost' => $driver->transactions->sum('total_cost')
            ];
        });

        return view('reports.driver_distance_cost', compact('chartData'));
    }
}

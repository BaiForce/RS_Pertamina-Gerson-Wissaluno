<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Driver;
use App\Models\Rute;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // In your TransactionController's index method
    public function index()
    {
        $transactions = Transaction::with(['driver', 'rute'])->get();
        $drivers = Driver::all(); // Get all drivers
        $rutes = Rute::all(); // Get all routes
        $no = 1; // Counter for table rows

        return view('transactions.index', compact('transactions', 'drivers', 'rutes', 'no'));
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $driver = Driver::all();
        $rutes = Rute::all();
        return view('transactions.edit', compact('transaction', 'driver', 'rutes'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'driver_id' => 'required|exists:drivers,id',
                'rute_id' => 'required|exists:rutes,id',
                'date' => 'required|date',
                'actual_time' => 'required|integer|min:1',
                'standard_time' => 'required|integer|min:1',
                'total_cost' => 'required|integer|min:1'
            ]);

            $transaction = new Transaction();
            $transaction->driver_id = $request->driver_id;
            $transaction->rute_id = $request->rute_id;
            $transaction->date = $request->date;
            $transaction->actual_time = $request->actual_time;
            $transaction->standard_time = $request->standard_time;
            $transaction->total_cost = $request->total_cost;
            $transaction->save();

            return redirect()->route('transactions.index')->with('message', 'Transaksi berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Transaksi gagal ditambahkan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $transaction = Transaction::findOrFail($id);

            $request->validate([
                'driver_id' => 'required|exists:drivers,id',
                'rute_id' => 'required|exists:rutes,id',
                'date' => 'required|date',
                'actual_time' => 'required|integer|min:1',
                'standard_time' => 'required|integer|min:1',
                'total_cost' => 'required|integer|min:1'
            ]);

            $transaction->driver_id = $request->driver_id;
            $transaction->rute_id = $request->rute_id;
            $transaction->date = $request->date;
            $transaction->actual_time = $request->actual_time;
            $transaction->standard_time = $request->standard_time;
            $transaction->total_cost = $request->total_cost;
            $transaction->save();

            return redirect()->route('transactions.index')->with('message', 'Transaksi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Transaksi gagal diperbarui: ' . $e->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            $transaction->delete();

            return redirect()->route('transactions.index')->with('message', 'Transaksi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Transaksi gagal dihapus: ' . $e->getMessage());
        }
    }
}

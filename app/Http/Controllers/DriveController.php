<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriveController extends Controller
{
    public function index()
    {
        $drivers = Driver::all();
        $no = 1;
        return view('drivers.index', compact('drivers', 'no'));
    }

    public function edit($id)
    {
        $driver = Driver::findOrFail($id);
        return view('drivers.edit', compact('driver'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'license_plate' => 'required|string|unique:drivers|max:20'
            ]);

            $driver = new Driver();
            $driver->name = $request->name;
            $driver->license_plate = $request->license_plate;
            $driver->save();

            return redirect()->route('drivers.index')->with('message', 'Driver berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Driver gagal ditambahkan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $driver = Driver::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'license_plate' => 'required|string|max:20|unique:drivers,license_plate,' . $id
            ]);

            $driver->name = $request->name;
            $driver->license_plate = $request->license_plate;
            $driver->save();

            return redirect()->route('drivers.index')->with('message', 'Driver berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Driver gagal diperbarui: ' . $e->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $driver = Driver::findOrFail($id);

            // Check if driver has transactions before deleting
            if ($driver->transactions()->exists()) {
                return redirect()->back()->with('error', 'Driver tidak dapat dihapus karena memiliki transaksi terkait.');
            }

            $driver->delete();

            return redirect()->route('drivers.index')->with('message', 'Driver berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Driver gagal dihapus: ' . $e->getMessage());
        }
    }
}

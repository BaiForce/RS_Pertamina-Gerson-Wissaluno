<?php

namespace App\Http\Controllers;

use App\Models\Rute;
use Illuminate\Http\Request;

class RuteController extends Controller
{
    public function index()
    {
        $rutes = Rute::all();
        $no = 1;
        return view('rutes.index', compact('rutes', 'no'));
    }

    public function edit($id)
    {
        $rute = Rute::findOrFail($id);
        return view('rutes.edit', compact('rute'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'start_point' => 'required|string|max:50',
                'end_point' => 'required|string|max:50',
                'distance' => 'required|integer|min:1',
                'standard_time' => 'required|integer|min:1',
                'price_per_km' => 'required|integer|min:1'
            ]);

            $rute = new Rute();
            $rute->start_point = $request->start_point;
            $rute->end_point = $request->end_point;
            $rute->distance = $request->distance;
            $rute->standard_time = $request->standard_time;
            $rute->price_per_km = $request->price_per_km;
            $rute->save();

            return redirect()->route('rutes.index')->with('message', 'Rute berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Rute gagal ditambahkan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $rute = Rute::findOrFail($id);

            $request->validate([
                'start_point' => 'required|string|max:50',
                'end_point' => 'required|string|max:50',
                'distance' => 'required|integer|min:1',
                'standard_time' => 'required|integer|min:1',
                'price_per_km' => 'required|integer|min:1'
            ]);

            $rute->start_point = $request->start_point;
            $rute->end_point = $request->end_point;
            $rute->distance = $request->distance;
            $rute->standard_time = $request->standard_time;
            $rute->price_per_km = $request->price_per_km;
            $rute->save();

            return redirect()->route('rutes.index')->with('message', 'Rute berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Rute gagal diperbarui: ' . $e->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $rute = Rute::findOrFail($id);

            // Check if rute has transactions before deleting
            if ($rute->transactions()->exists()) {
                return redirect()->back()->with('error', 'Rute tidak dapat dihapus karena memiliki transaksi terkait.');
            }

            $rute->delete();

            return redirect()->route('rutes.index')->with('message', 'Rute berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Route gagal dihapus: ' . $e->getMessage());
        }
    }
}

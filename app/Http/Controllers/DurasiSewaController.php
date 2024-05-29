<?php

namespace App\Http\Controllers;

use App\Models\DurasiSewa;
use App\Models\TipeSepeda;
use App\Models\Transaction;
use App\Traits\CommonHelpersTrait;
use Illuminate\Http\Request;

class DurasiSewaController extends Controller
{
    use CommonHelpersTrait;

    public function index()
    {
        $durasiSewa = DurasiSewa::with('jenis')->get();
        $no = 1;
        $tipe = TipeSepeda::all();
        return view('durasiSewa.index', compact('durasiSewa', 'no', 'tipe'));
    }

    public function edit($id)
    {
        $durasiSewa = DurasiSewa::with('jenis')->where('id', $id)->first();
        $no = 1;
        $tipe = TipeSepeda::all();
        return view('durasiSewa.edit', compact('durasiSewa', 'no', 'tipe'));
    }

    public function store(Request $request)
    {
        try {


            $durasiSewaTerdaftar = DurasiSewa::where('jenis_id', $request->jenis_id)
            ->where('duration', $request->duration)
            ->exists();

        // Jika durasi sewa sudah terdaftar, kembalikan pesan peringatan
        if ($durasiSewaTerdaftar) {
            return redirect()->back()->with('warning', 'Durasi sewa ' . $request->duration . ' menit sudah digunakan untuk jenis sepeda yang sama');
        }

        $request->validate([
            'jenis_id' => 'required',
            'duration' => ['required', 'numeric', 'min:0'], // Menambahkan aturan untuk memastikan nilai numerik
            'price' => ['required', 'numeric', 'min:0'],
            'charge' => ['required', 'numeric', 'min:0'],
            ]);

            $durasiSewa = new DurasiSewa();
            $durasiSewa->jenis_id = $request->jenis_id;
            $durasiSewa->duration = $request->duration;
            $durasiSewa->price = $request->price;
            $durasiSewa->charge = $request->charge;

            $durasiSewa->save();

            return redirect()->route('durasiSewa.index')->with('message', 'Data Durasi Sewa yang Ditambahkan Telah Tersimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data Durasi Sewa yang Ditambahkan Tidak Tersimpan');
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $durasiSewa = DurasiSewa::findOrFail($id);

            // Periksa apakah ada durasi sewa lain dengan durasi yang sama
            $durasiSewaTerdaftar = DurasiSewa::where('duration', $request->duration)
                ->whereNotIn('id', [$id]) // Mengecualikan ID durasi sewa yang sedang diperbarui
                ->exists();

            if ($durasiSewaTerdaftar) {
                return redirect()->back()->with('warning', 'Durasi ' . $request->duration . ' Sudah Digunakan');
            }

            // Validasi data yang diinputkan
            $request->validate([
                'jenis_id' => 'required',
                'duration' => ['required', 'numeric', 'min:0'],
                'price' => ['required', 'numeric', 'min:0'],
                'charge' => ['required', 'numeric', 'min:0'],
            ]);

            // Periksa apakah masih ada transaksi yang menggunakan durasi sewa ini
            $transaksiDenganDurasi = Transaction::where('duration_id', $id)->exists();
            if ($transaksiDenganDurasi) {
                return redirect()->back()->with('warning', 'Tidak dapat mengubah durasi sewa karena masih ada transaksi yang menggunakan durasi sewa ini.');
            }

            // Update data durasi sewa
            $durasiSewa = DurasiSewa::findOrFail($id);
            $durasiSewa->jenis_id = $request->jenis_id;
            $durasiSewa->duration = $request->duration;
            $durasiSewa->price = $request->price;
            $durasiSewa->charge = $request->charge;
            $durasiSewa->save();

            return redirect()->route('durasiSewa.index')->with('message', 'Data Durasi Sewa yang Diubah Telah Tersimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data Durasi Sewa yang Diubah Tidak Tersimpan');
        }
    }


    public function delete(Request $request, $id)
    {
        try {
            // Cek apakah ada transaksi yang menggunakan durasi sewa yang akan dihapus
            $transaksiDenganDurasi = Transaction::where('duration_id', $id)->exists();
            if ($transaksiDenganDurasi) {
                return redirect()->back()->with('warning', 'Tidak dapat menghapus durasi sewa karena masih ada transaksi yang menggunakan durasi sewa ini.');
            }

            // Jika tidak ada transaksi yang menggunakan durasi sewa yang akan dihapus, lanjutkan dengan penghapusan durasi sewa
            $durasiSewa = DurasiSewa::findOrFail($id);
            $durasiSewa->delete();
            return redirect()->route('durasiSewa.index')->with('message', 'Data Durasi Sewa yang Dihapus Telah Berhasil');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data Durasi Sewa yang Dihapus Tidak Berhasil');
        }
    }

}

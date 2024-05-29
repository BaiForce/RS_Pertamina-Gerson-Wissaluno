<?php

namespace App\Http\Controllers;

use App\Models\TipeSepeda;
use App\Models\DurasiSewa;
use App\Models\Sepeda;
use App\Traits\CommonHelpersTrait;
use Illuminate\Http\Request;

class TipeSepedaController extends Controller
{
    use CommonHelpersTrait;

    public function index()
    {
        $tipeSepeda = TipeSepeda::all();
        $no = 1;
        return view('tipeSepeda.index', compact('tipeSepeda', 'no'));
    }

    public function edit($id)
    {
        $tipeSepeda = TipeSepeda::findOrFail($id);
        return view('tipeSepeda.edit', compact('tipeSepeda'));
    }

    public function store(Request $request)
    {
        try {

            $tipesepedaTerdaftar = TipeSepeda::where('name', $request->name)->exists();

                if ($tipesepedaTerdaftar) {
                    return redirect()->back()->with('warning', 'Jenis ' . $request->name . ' Sudah Digunakan');
                }

            $request->validate([
                'name' => 'required|unique:tipe_sepedas,name',
            ]);

            $tipeSepeda = new TipeSepeda();
            $tipeSepeda->name = $request->name;

            if ($request->file('pict')) {
                $imagePath = $this->uploadImageArticle($request);
                $tipeSepeda->pict = $imagePath;
            }

            $tipeSepeda->save();

            return redirect()->route('tipeSepeda.index')->with('message', 'Data Tipe Sepeda yang Ditambahkan Telah Tersimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', ' Data Tipe Sepeda yang Ditambahkan Tidak Tersimpan');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Ambil data tipe sepeda berdasarkan ID
            $tipeSepeda = TipeSepeda::findOrFail($id);

            // Periksa apakah ada tipe sepeda lain dengan nama yang sama
            $tipesepedaTerdaftar = TipeSepeda::where('name', $request->name)
                ->whereNotIn('id', [$id]) // Mengecualikan ID tipe sepeda yang sedang diperbarui
                ->exists();

            if ($tipesepedaTerdaftar) {
                return redirect()->back()->with('warning', 'Jenis' . $request->name . ' Sudah Digunakan');
            }

            // Validasi data yang diinputkan
            $request->validate([
                'name' => 'required|unique:tipe_sepedas,name,' . $id, // Memastikan nama tipe sepeda unik, kecuali untuk tipe sepeda yang sedang diperbarui
            ]);

            // Update data tipe sepeda
            if ($request->has('name')) {
                $tipeSepeda->name = $request->name;
            }

            if ($request->file('pict')) {
                $imagePath = $this->uploadImageArticle($request);
                $this->deleteImage($tipeSepeda->pict);
                $tipeSepeda->pict = $imagePath;
            }

            $tipeSepeda->save();

            return redirect()->route('tipeSepeda.index')->with('message', 'Data Tipe Sepeda yang Diubah Telah Tersimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data Tipe Sepeda yang Diubah Tidak Tersimpan');
        }
    }



    public function delete(Request $request, $id)
    {
        try {
            // Periksa apakah tipe sepeda dengan ID yang diberikan ada yang terkait dengan entitas sepeda
            $sepedaCount = Sepeda::where('jenis_id', $id)->count();

            // Periksa apakah tipe sepeda dengan ID yang diberikan ada yang terkait dengan entitas durasi sewa
            $durasiSewaCount = DurasiSewa::where('jenis_id', $id)->count();

            // Jika ada sepeda atau durasi sewa yang terkait, berikan pesan error dan kembalikan ke halaman sebelumnya
            if ($sepedaCount > 0 || $durasiSewaCount > 0) {
                return redirect()->back()->with('warning', 'Tipe Sepeda ini Memiliki Keterkaitan dengan Data Lain dan Tidak Dapat Dihapus');
            }

            // Jika tidak ada keterkaitan, hapus tipe sepeda
            $tipeSepeda = TipeSepeda::findOrFail($id);
            $tipeSepeda->delete();

            // Redirect ke halaman index dengan pesan sukses
            return redirect()->route('tipeSepeda.index')->with('message', 'Data Tipe Sepeda yang Dihapus Telah Berhasil');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, kembalikan ke halaman sebelumnya dengan pesan error
            return redirect()->back()->with('error', 'Data Sepeda yang Dihapus Tidak Berhasil');
        }
    }

}

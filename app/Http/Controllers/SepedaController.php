<?php

namespace App\Http\Controllers;

use App\Models\Sepeda;
use App\Models\TipeSepeda;
use App\Models\Lokasi;
use App\Traits\CommonHelpersTrait;
use Illuminate\Http\Request;

class SepedaController extends Controller
{
    use CommonHelpersTrait;

    public function index()
    {
        $sepeda = Sepeda::with('jenis')->get();
        $no = 1;
        $tipe = TipeSepeda::all();
        return view('sepeda.index', compact('sepeda', 'no', 'tipe'));
    }


    public function edit($id)
    {
        $sepeda = Sepeda::with('jenis')->where('id', $id)->first();
        $tipe = TipeSepeda::all();
        return view('sepeda.edit', compact('sepeda', 'tipe'));
    }

    public function store(Request $request)
    {
    try {

        $sepedaTerdaftar = Sepeda::where('number', $request->number)->exists();

                if ($sepedaTerdaftar) {
                    return redirect()->back()->with('warning', 'Nomor Sepeda' . $request->number . ' Sudah Digunakan');
                }

        $request->validate([
            'jenis_id' => 'required',
            'number' => 'required|numeric', // Memastikan nomor sepeda unik
            'color' => 'required',
            'pict' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Aturan validasi untuk gambar
            // 'gps_number' => 'required|unique:sepedas,gps_number', // Memastikan nomor GPS unik
        ]);

        $sepeda = new Sepeda();
        $sepeda->jenis_id = $request->jenis_id;
        // $sepeda->gps_number = $request->gps_number;
        $sepeda->number = $request->number;
        $sepeda->color = $request->color;

        if ($request->file('pict')) {
            $imagePath = $this->uploadImageArticle($request);
            $sepeda->pict = $imagePath;
        }

        $sepeda->save();

        return redirect()->route('sepeda.index')->with('message', 'Data Sepeda yang Ditambahkan Telah Tersimpan');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Data Sepeda yang Ditambahkan Tidak Tersimpan');
    }
    }


    public function update(Request $request, $id)
    {
        try {

        $sepeda = Sepeda::findOrFail($id);
            // Periksa status sepeda Untuk Update
            if ($sepeda->status == 2) {
                return redirect()->back()->with('warning', 'Data Sepeda Tidak Dapat Diubah Karena Sepeda Sedang Dipinjam');
            }

            $sepedaTerdaftar = Sepeda::where('number', $request->number)
            ->whereNotIn('id', [$id]) // Mengecualikan ID sepeda yang sedang diperbarui
            ->exists();

            if ($sepedaTerdaftar) {
                return redirect()->back()->with('warning', 'Nomor Sepeda ' . $request->number . ' Sudah Digunakan');
            }

            $request->validate([
                'jenis_id' => 'required',
                'number' => 'required|numeric', // Memastikan nomor sepeda unik
                'color' => 'required',
                'pict' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Aturan validasi untuk gambar
                // 'gps_number' => 'required|unique:sepedas,gps_number', // Memastikan nomor GPS unik
            ]);


                $sepeda->jenis_id = $request->jenis_id;
                // $sepeda->gps_number = $request->gps_number;
                $sepeda->number = $request->number;
                $sepeda->color = $request->color;

                if ($request->file('pict')) {
                    $imagePath = $this->uploadImageArticle($request);
                    $sepeda->pict = $imagePath;
                }

                $sepeda->save();

                return redirect()->route('sepeda.index')->with('message', 'Data Sepeda yang Diubah Telah Tersimpan');
            } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data Sepeda yang Diubah Tidak Tersimpan');
        }
    }


    public function delete(Request $request, $id)
    {
        try {
            $sepeda = Sepeda::findOrFail($id);

            // Periksa apakah sepeda sedang dipinjam
            if ($sepeda->status == 2) {
                return redirect()->back()->with('warning', 'Data Sepeda Tidak Dapat Dihapus Karena Sepeda Sedang Dipinjam');
            }

            // Periksa apakah ada lokasi yang terkait dengan sepeda
            $lokasi = Lokasi::where('id_sepeda', $sepeda->id)->first();

            // Jika tidak ada lokasi terkait, atau status sepeda tersedia, maka hapus sepeda
            if (!$lokasi || $sepeda->status == 1) {
                if ($lokasi) {
                    $lokasi->delete(); // Hapus lokasi terkait jika ada
                }
                $sepeda->delete(); // Hapus sepeda
                return redirect()->route('sepeda.index')->with('message', 'Data Sepeda yang Dihapus Telah Berhasil');
            } else {
                return redirect()->back()->with('warning', 'Data Sepeda Tidak Dapat Dihapus Karena Masih Terkait dengan Lokasi');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data Sepeda yang Dihapus Tidak Berhasil');
        }
    }

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
                return view('sepeda.peta', compact('latestCoordinates'));
            } else {
                return response()->json([
                    'error' => 'No GPS coordinates available for any sepeda.'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch GPS coordinates.'
            ], 500);
        }
    }
}

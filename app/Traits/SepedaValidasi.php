<?php

namespace App\Traits;

use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;

trait BicycleValidationTrait
{
    protected function sendFailedAddBicycleResponse(Request $request)
    {
        $messages = [];

        // Lakukan validasi sesuai kebutuhan Anda
        $request->validate([
            'jenis_id' => 'required',
            'number' => 'required|unique:sepedas,number|numeric', // Memastikan nomor sepeda unik
            'color' => 'required',
            'pict' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Aturan validasi untuk gambar
            // 'gps_number' => 'required|unique:sepedas,gps_number', // Memastikan nomor GPS unik
        ]);

        // Jika validasi gagal, tambahkan pesan error ke dalam array $messages
        $errors = $request->errors()->all();
        foreach ($errors as $error) {
            $messages['error'][] = Lang::get('validation.'.$error);
        }

        // Throw ValidationException dengan pesan error yang telah dikumpulkan
        throw ValidationException::withMessages($messages);
    }
}

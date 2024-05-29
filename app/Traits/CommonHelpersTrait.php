<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait CommonHelpersTrait
{
    private function normalizePrice($price)
    {
        return str_replace(',', '', $price);
    }

    // private function uploadImage($request)
    // {
    //     $imagePath = null;

    //     if ($request->hasFile('image')) {
    //         $imageName = 'package/' . time() . '_' . $request->file('image')->getClientOriginalName();
    //         $imagePath = $request->file('image')->storeAs('', $imageName, 'public');
    //     }

    //     return $imagePath;
    // }

    private function uploadImageArticle($request)
    {
        $imagePath = null;

        if ($request->hasFile('pict')) {
            $imageName = 'user/' . time() . '_' . $request->file('pict')->getClientOriginalName();
            $imagePath = $request->file('pict')->storeAs('', $imageName, 'public');
        }

        return $imagePath;
    }

    private function uploadImage($request)
    {
        $imagePath = null;
        $imageNames = 'pict' . $request->bike_id;

        if ($request->hasFile($imageNames)) {
            $imageName = 'user/' . time() . '_' . $request->file($imageNames)->getClientOriginalName();
            $imagePath = $request->file($imageNames)->storeAs('', $imageName, 'public');
        }

        return $imagePath;
    }

    private function deleteImage($image)
    {
        if ($image && Storage::disk('public')->exists($image)) {
            return Storage::disk('public')->delete($image);
        }
    }
}

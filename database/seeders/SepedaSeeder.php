<?php

namespace Database\Seeders;

use App\Models\Sepeda;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SepedaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new Sepeda();
        $data->jenis_id = '1';
        $data->number = '1';
        $data->color = 'Putih';
        $data->pict = 'user/1716166684_download (4).jpeg';
        $data->status = '1';
        $data->save();

        $data = new Sepeda();
        $data->jenis_id = '2';
        $data->number = '2';
        $data->color = 'Merah';
        $data->pict = 'user/1716166704_download (2).jpeg';
        $data->status = '1';
        $data->save();

        $data = new Sepeda();
        $data->jenis_id = '1';
        $data->number = '3';
        $data->color = 'Biru';
        $data->pict = 'user/1716166712_download (3).jpeg';
        $data->status = '1';
        $data->save();

        $data = new Sepeda();
        $data->jenis_id = '2';
        $data->number = '4';
        $data->color = 'Ungu';
        $data->pict = 'user/1716166758_download (1).jpeg';
        $data->status = '1';
        $data->save();

        $data = new Sepeda();
        $data->jenis_id = '1';
        $data->number = '5';
        $data->color = 'Hijau';
        $data->pict = 'user/1716166766_download (4).jpeg';
        $data->status = '1';
        $data->save();

        $data = new Sepeda();
        $data->jenis_id = '2';
        $data->number = '6';
        $data->color = 'Hitam';
        $data->pict = 'user/1716166773_download.jpeg';
        $data->status = '1';
        $data->save();
    }
}

<?php

namespace Database\Seeders;

use App\Models\DurasiSewa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DurasiSewaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new DurasiSewa();
        $data->jenis_id = '1';
        $data->duration = '60';
        $data->price = '12000';
        $data->charge = '1000';
        $data->save();

        $data = new DurasiSewa();
        $data->jenis_id = '1';
        $data->duration = '90';
        $data->price = '20000';
        $data->charge = '2000';
        $data->save();

        $data = new DurasiSewa();
        $data->jenis_id = '2';
        $data->duration = '90';
        $data->price = '20000';
        $data->charge = '2000';
        $data->save();

        $data = new DurasiSewa();
        $data->jenis_id = '2';
        $data->duration = '120';
        $data->price = '20000';
        $data->charge = '2000';
        $data->save();
    }
}

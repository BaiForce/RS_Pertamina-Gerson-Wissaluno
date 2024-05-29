<?php

namespace Database\Seeders;

use App\Models\TipeSepeda;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipeSepedaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new TipeSepeda();
        $data->name = 'Scooter';
        $data->pict = 'user/1713366541_WhatsApp Image 2024-04-08 at 10.43.10_14a50b5b.jpg';
        $data->save();

        $data = new TipeSepeda();
        $data->name = 'Sepeda';
        $data->pict = 'user/1713366541_WhatsApp Image 2024-04-08 at 10.43.10_14a50b5b.jpg';
        $data->save();
    }
}

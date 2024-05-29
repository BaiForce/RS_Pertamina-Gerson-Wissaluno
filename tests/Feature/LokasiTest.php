<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Sepeda;
use App\Models\Lokasi;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LokasiTest extends TestCase
{
    use RefreshDatabase;

    public function test_kirim_data_lokasi()
    {

        $lokasi = Sepeda::create([
            'jenis_id' => '1',
            'gps_number' => '10',
            'number' => '10',
            'color' => 'Hijau',
            'pict' => 'gambar.jpg',
        ]);

        // Melakukan permintaan POST ke rute API dengan menyertakan id_sepeda dari objek $lokasi
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])
        ->postJson('/api/lokasi/' . $lokasi->number, [
            'latitude' => -1.279252,
            'longitude' => 116.818861,
        ]);

        $this->assertDatabaseHas('lokasis', [
            'id_sepeda' => $lokasi->id,
            'latitude' => -1.279252,
            'longitude' => 116.818861,
        ]);

        $response->assertStatus(201);
    }

    public function test_admin_dapat_melihat_data_lokasi()
{
    // Buat user admin
    $user = User::create([
        'name' => 'Admin23',
        'email' => 'admin23@mail.com',
        'password' => bcrypt('admin@123'),
        'role' => 'admin',
        'number' => '818238123',
        'address' => 'jalan',
    ]);

    // Buat data sepeda dan lokasi terkait
    $sepeda = Sepeda::create([
        'jenis_id' => '1',
        'gps_number' => '10',
        'number' => '10',
        'color' => 'Hijau',
        'pict' => 'gambar.jpg',
    ]);

    $lokasi = Lokasi::create([
        'id_sepeda' => $sepeda->id,
        'latitude' => '-1.279252',
        'longitude' => '116.818861',
    ]);

    // Lakukan permintaan untuk melihat data lokasi
    $response = $this->actingAs($user)
        ->get(route('sepeda.peta', ['id' => $lokasi->id]));

    // Periksa bahwa respons memiliki status OK (200)
    $response->assertStatus(200);

    }

}

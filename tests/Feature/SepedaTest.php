<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Sepeda;
use App\Models\TipeSepeda;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SepedaTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dapat_melihat_data_sepeda()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'admin',
            'number' => '818238123',
            'address' => 'jalan',
        ]);

        Sepeda::create([
            'jenis_id' => '1',
            'gps_number' => '10',
            'number' => '10',
            'color' => 'Hijau',
            'pict' => 'gambar.jpg',
        ]);

        $response = $this->actingAs($user)
            ->get(route('sepeda.index'));

        $response->assertStatus(200);
    }

    public function test_admin_dapat_menambah_data_sepeda()
{
    $user = User::create([
        'name' => 'Admin23',
        'email' => 'admin23@mail.com',
        'password' => bcrypt('admin@123'),
        'role' => 'admin',
        'number' => '818238123',
        'address' => 'jalan',
    ]);

    $fakeImage = UploadedFile::fake()->image('gambar.jpg');

    $response = $this->actingAs($user)
        ->post(route('sepeda.store'), [
            'jenis_id' => '1',
            'gps_number' => '10',
            'number' => '10',
            'color' => 'Hijau',
            'pict' => $fakeImage, // Menggunakan gambar palsu
        ]);

    $response->assertStatus(302)
    ->assertRedirect(route('sepeda.index'));

    $this->assertDatabaseHas('sepedas', [
        'jenis_id' => '1',
        'gps_number' => '10',
        'number' => '10',
        'color' => 'Hijau',
        // 'pict' => $fakeImage, // Menggunakan nama file gambar palsu
    ]);
}


    public function test_admin_dapat_mengubah_data_sepeda()
    {
        $user = User::create([
            'name' => 'Admin23',
            'email' => 'admin23@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'admin',
            'number' => '818238123',
            'address' => 'jalan',
        ]);

        $fakeImage = UploadedFile::fake()->image('gambar.jpg');

        $sepeda = Sepeda::create([
            'jenis_id' => '1',
            'gps_number' => '10',
            'number' => '10',
            'color' => 'Hijau',
            'pict' => $fakeImage,
        ]);


        $responseEditSepeda = $this->actingAs($user)
            ->put(route('sepeda.update', $sepeda), [
                'jenis_id' => '2',
                'gps_number' => '5',
                'number' => '5',
                'color' => 'Merah',
                // 'pict' => 'gambar23.jpg',
            ]);

        $responseEditSepeda->assertStatus(302)
        ->assertRedirect(route('sepeda.index'));

        // Assertion to check if the data is updated in the database
        $this->assertDatabaseHas('sepedas', [
            'id' => $sepeda->id,
            'jenis_id' => '2',
            'gps_number' => '5',
            'number' => '5',
            'color' => 'Merah',
            // 'pict' => 'gambar23.jpg',
        ]);
    }

    public function test_admin_dapat_menghapus_data_sepeda()
    {
        $user = User::create([
            'name' => 'Admin23',
            'email' => 'admin23@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'admin',
            'number' => '818238123',
            'address' => 'jalan',
        ]);

         $sepeda = Sepeda::create([
            'jenis_id' => '1',
            'gps_number' => '10',
            'number' => '10',
            'color' => 'Hijau',
            'pict' => 'gambar.jpg',
        ]);

        $responseDeleteSepeda = $this->actingAs($user)
            ->delete(route('sepeda.delete', $sepeda));

        $responseDeleteSepeda->assertStatus(302)
        ->assertRedirect(route('sepeda.index'));

        $this->assertDatabaseMissing('sepedas', ['id' => $sepeda->id]);
    }
}

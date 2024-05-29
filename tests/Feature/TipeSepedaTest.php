<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\TipeSepeda;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TipeSepedaTest extends TestCase
{
    use RefreshDatabase;


    public function test_admin_dapat_melihat_data_tipe_sepeda()
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

        TipeSepeda::create([
            'name' => 'sepeda',
            'pict' => $fakeImage
        ]);

        $response = $this->actingAs($user)
            ->get(route('tipeSepeda.index'));

        $response->assertStatus(200);
    }

    public function test_admin_dapat_menambah_data_tipe_sepeda()
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
            ->post(route('tipeSepeda.store'), [
                'name' => 'sepeda',
                'pict' => $fakeImage,
            ]);

        $response->assertStatus(302)
            ->assertRedirect(route('tipeSepeda.index'));

        $this->assertDatabaseHas('tipe_sepedas', [
            'name' => 'sepeda',
            // 'pict' => 'gambar.jpg',
        ]);
    }

    public function test_admin_dapat_mengedit_data_tipe_sepeda()
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

        $tipeSepeda = TipeSepeda::create([
            'name' => 'sepeda',
            'pict' => 'gambar.jpg',
        ]);

        $responseEditTipe = $this->actingAs($user)
            ->put(route('tipeSepeda.update', $tipeSepeda), [
                'name' => 'sepeda23',
                'pict' => $fakeImage,
            ]);

        $responseEditTipe->assertStatus(302)
            ->assertRedirect(route('tipeSepeda.index'));

        $this->assertDatabaseHas('tipe_sepedas', [
            'id' => $tipeSepeda->id,
            'name' => 'sepeda23',
            // 'pict' => 'gambar.jpg', // Menggunakan nama file gambar palsu
        ]);
    }

    public function test_admin_dapat_menghapus_data_tipe_sepeda()
    {
        $user = User::create([
            'name' => 'Admin23',
            'email' => 'admin23@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'admin',
            'number' => '818238123',
            'address' => 'jalan',
        ]);

        $tipeSepeda = TipeSepeda::create([
            'name' => 'sepeda',
            'pict' => 'gambar.jpg',
        ]);

        $responseDeleteTipe = $this->actingAs($user)
            ->delete(route('tipeSepeda.delete', $tipeSepeda));

        $responseDeleteTipe->assertStatus(302)
            ->assertRedirect(route('tipeSepeda.index'));

        $this->assertDatabaseMissing('tipe_sepedas', ['id' => $tipeSepeda->id]);
    }

}

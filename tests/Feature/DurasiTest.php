<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\DurasiSewa;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DurasiTest extends TestCase


{
    use RefreshDatabase;

    public function test_admin_dapat_melihat_durasi()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'admin',
            'number' => '818238123',
            'address' => 'jalan',
        ]);

        $durasi = DurasiSewa::create([
            'jenis_id' => '1',
            'duration' => '30',
            'price' => '20000',
            'charge' => '2000',
        ]);

        $response = $this->actingAs($user)
            ->get(route('durasiSewa.index'));

        $response->assertStatus(200);
    }

    public function test_admin_dapat_menghapus_data_tambah_durasi()
    {
        $user = User::create([
            'name' => 'Admin23',
            'email' => 'admin23@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'admin',
            'number' => '818238123',
            'address' => 'jalan',
        ]);

        $dataDurasi = [
            'jenis_id' => '1',
            'duration' => '30',
            'price' => '20000',
            'charge' => '2000',
        ];

        $response = $this->actingAs($user)
            ->post(route('durasiSewa.store'), $dataDurasi);

        $response->assertStatus(302)
                 ->assertRedirect(route('durasiSewa.index'));
    }

    public function test_admin_dapat_menghapus_data_edit_durasi()
    {
        $user = User::create([
            'name' => 'Admin23',
            'email' => 'admin23@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'admin',
            'number' => '818238123',
            'address' => 'jalan',
        ]);

        $durasi = DurasiSewa::create([
            'jenis_id' => '1',
            'duration' => '30',
            'price' => '20000',
            'charge' => '2000',
        ]);

        $dataEditDurasi = [
            'jenis_id' => '2',
            'duration' => '10',
            'price' => '4000',
            'charge' => '4000',
        ];

        $responseEditDurasi = $this->actingAs($user)
            ->put(route('durasiSewa.update', $durasi), $dataEditDurasi);

        $responseEditDurasi->assertStatus(302)
                            ->assertRedirect(route('durasiSewa.index'));
    }

    public function test_admin_dapat_menghapus_data_durasi()
    {
        $user = User::create([
            'name' => 'Admin23',
            'email' => 'admin23@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'admin',
            'number' => '818238123',
            'address' => 'jalan',
        ]);

         $durasi = DurasiSewa::create([
            'jenis_id' => '2',
            'duration' => '10',
            'price' => '4000',
            'charge' => '4000',
        ]);

        $responseDeleteDurasi = $this->actingAs($user)
            ->delete(route('durasiSewa.delete', $durasi));

        $responseDeleteDurasi->assertStatus(302)
                             ->assertRedirect(route('durasiSewa.index')); // Assert redirect ke halaman indeks durasi sewa
    }


}

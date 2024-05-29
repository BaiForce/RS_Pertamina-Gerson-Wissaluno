<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Sepeda;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListSepedaTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_dapat_melihat_list_sepeda()
        {

            $user = User::create([
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'password' => bcrypt('admin@123'),
                'role' => 'staff',
                'number' => '818238123',
                'address' => 'jalan',
            ]);

            Sepeda::create([
                'jenis_id' => '1',
                'gps_number' => '10',
                'number' => '10',
                'color' => 'Hijau',
                'pict' => 'gambar.jpg',
                'status' => '1'
            ]);

            $response = $this->actingAs($user)
                ->get(route('staff.dashboard'));

            $response->assertStatus(200);
        }

        // public function test_staff_peminjaman_sepeda()
        // {

        //     $user = User::create([
        //         'name' => 'Admin',
        //         'email' => 'admin@mail.com',
        //         'password' => bcrypt('admin@123'),
        //         'role' => 'staff',
        //         'number' => '818238123',
        //         'address' => 'jalan',
        //     ]);

        //     Transactiom::create([
        //         'jenis_id' => '1',
        //         'gps_number' => '10',
        //         'number' => '10',
        //         'color' => 'Hijau',
        //         'pict' => 'gambar.jpg',
        //         'status' => '1'
        //     ]);

        //     $response = $this->actingAs($user)
        //         ->get(route('staff.dashboard'));

        //     $response->assertStatus(200);
        // }
}

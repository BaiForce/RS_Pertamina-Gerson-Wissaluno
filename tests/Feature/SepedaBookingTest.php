<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Sepeda;
use App\Models\DurasiSewa;
use App\Models\TipeSepeda;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SepedaBookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_dapat_melakukan_peminjaman_sepeda_dengan_metode_tunai()
    {



        $user = User::create([
            'name' => 'Staff',
            'email' => 'staff@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'staff',
            'number' => '818238123',
            'address' => 'jalan',
        ]);

        $konsumen = User::create([
            'name' => 'Staff',
            'email' => 'staff2@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'konsumen',
            'number' => '818238123',
            'address' => 'jalan',
        ]);
        $tipeSepeda = TipeSepeda::create([
            'name' => 'sepeda',
            'pict' => 'gambar.jpg'
        ]);

        $sepeda = Sepeda::create([
            'jenis_id' => $tipeSepeda->id,
            'gps_number' => '10',
            'number' => '10',
            'color' => 'Hijau',
            'pict' => 'gambar.jpg',
            'status' => '1'
        ]);

        $durasi = DurasiSewa::create([
            'jenis_id' => '1',
            'duration' => '30',
            'price' => '20000',
            'charge' => '2000',
        ]);

        $data = [
            'admin_id' => $user->id,
            'bike_id' => $sepeda->id,
            'user_id' => $konsumen->id,
            'duration_id' => $durasi->id,
            'payment' => 'tunai',
            'total_price' => '80000',
            'start_date' => '2024-05-25',
            'start_time' => '09:00 AM',
            'pict' => 'gambar.jpg'
        ];

        $response = $this->actingAs($user)
            ->post(route('staff.paycash.borrow'), $data);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_staff_tidak_dapat_melakukan_peminjaman_sepeda_dengan_uang_tunai_tidak_cukup()
    {

        $user = User::create([
            'name' => 'Staff',
            'email' => 'staff@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'staff',
            'number' => '818238123',
            'address' => 'jalan',
        ]);

        $konsumen = User::create([
            'name' => 'Staff',
            'email' => 'staff3@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'konsumen',
            'number' => '818238123',
            'address' => 'jalan',
        ]);

        $tipeSepeda = TipeSepeda::create([
            'name' => 'sepeda',
            'pict' => 'gambar.jpg'
        ]);

        $sepeda = Sepeda::create([
            'jenis_id' => $tipeSepeda->id,
            'gps_number' => '10',
            'number' => '10',
            'color' => 'Hijau',
            'pict' => 'gambar.jpg',
            'status' => '1'
        ]);

        $durasi = DurasiSewa::create([
            'jenis_id' => '1',
            'duration' => '30',
            'price' => '2000',
            'charge' => '2000',
        ]);

        $data = [
            'admin_id' => $user->id,
            'bike_id' => $sepeda->id,
            'user_id' => $konsumen->id,
            'duration_id' => $durasi->id,
            'payment' => 'tunai',
            'total_price' => '100',
            'start_date' => '2024-05-25',
            'start_time' => '09:00 AM',
            'pict' => 'gambar.jpg'
        ];

        $response = $this->actingAs($user)
            ->post(route('staff.paycash.borrow'), $data);

        $response->assertStatus(200)
            ->assertJson(['success' => false]);
    }

    public function test_staff_dapat_melakukan_peminjaman_sepeda_dengan_metode_qriss()
    {

        $user = User::create([
            'name' => 'Staff',
            'email' => 'staff@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'staff',
            'number' => '818238123',
            'address' => 'jalan',
        ]);

        $konsumen = User::create([
            'name' => 'Staff',
            'email' => 'staff2@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'konsumen',
            'number' => '818238123',
            'address' => 'jalan',
        ]);
        $tipeSepeda = TipeSepeda::create([
            'name' => 'sepeda',
            'pict' => 'gambar.jpg'
        ]);

        $sepeda = Sepeda::create([
            'jenis_id' => $tipeSepeda->id,
            'gps_number' => '10',
            'number' => '10',
            'color' => 'Hijau',
            'pict' => 'gambar.jpg',
            'status' => '1'
        ]);

        $durasi = DurasiSewa::create([
            'jenis_id' => '1',
            'duration' => '30',
            'price' => '20000',
            'charge' => '2000',
        ]);

        $data = [
            'admin_id' => $user->id,
            'bike_id' => $sepeda->id,
            'user_id' => $konsumen->id,
            'duration_id' => $durasi->id,
            'payment' => 'qriss',
            'start_date' => '2024-05-25',
            'start_time' => '09:00 AM',
            'pict' => 'gambar.jpg'
        ];

        $response = $this->actingAs($user)
            ->post(route('staff.pay.borrow'), $data);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

}

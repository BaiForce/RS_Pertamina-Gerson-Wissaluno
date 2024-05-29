<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LaporanTest extends TestCase
{
    use RefreshDatabase;

   public function test_admin_dapat_melihat_laporan()
   {

       $user = User::create([
           'name' => 'Admin',
           'email' => 'admin@mail.com',
           'password' => bcrypt('admin@123'),
           'role' => 'admin',
           'number' => '818238123',
           'address' => 'jalan',
       ]);

       Transaction::create([
            'invoice'=> 'sepeda_invoice_number_490',
            'user_id' => '1',
            'admin_id' => '1',
            'bike_id' => '1',
            'duration_id' => '1',
            'start_date' => '2024-05-24',
            'end_date' => '2024-05-25',
            'start_time'=> '09:00:00',
            'end_time' => '18:00:00',
            'total_price'=> '100000',
            'amount' => '1',
            'charge' => '1000',
            'total' => '100000',
            'payment' => 'tunai',
            'status' => '1',
            'jaminan' => 'gambar.jpg'
       ]);

       $response = $this->actingAs($user)
           ->get(route('laporan.index'));

       $response->assertStatus(200);
   }


   public function test_admin_dapat_mengexport_laporan()
   {

       $user = User::create([
           'name' => 'Admin',
           'email' => 'admin@mail.com',
           'password' => bcrypt('admin@123'),
           'role' => 'admin',
           'number' => '818238123',
           'address' => 'jalan',
       ]);

       Transaction::create([
            'invoice'=> 'sepeda_invoice_number_490',
            'user_id' => '1',
            'admin_id' => '1',
            'bike_id' => '1',
            'duration_id' => '1',
            'start_date' => '2024-05-24',
            'end_date' => '2024-05-25',
            'start_time'=> '09:00:00',
            'end_time' => '18:00:00',
            'total_price'=> '100000',
            'amount' => '1',
            'charge' => '0',
            'total' => '100000',
            'payment' => 'tunai',
            'status' => '1',
            'jaminan' => 'gambar.jpg'
       ]);

       $response = $this->actingAs($user)
           ->post(route('laporan.export'));

       $response->assertStatus(200)
           ;
   }
}

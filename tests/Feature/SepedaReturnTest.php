<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Sepeda;
use App\Models\DurasiSewa;
use App\Models\TipeSepeda;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SepedaReturnTest extends TestCase
{
    use RefreshDatabase;


    public function test_staff_dapat_melakukan_penegembalian_sepeda_tanpa_pembayaran_denda()
    {
    // Setup pengguna dan data dummy
    $user = User::create([
        'name' => 'Staff',
        'email' => 'staff@mail.com',
        'password' => bcrypt('admin@123'),
        'role' => 'staff',
        'number' => '818238123',
        'address' => 'jalan',
    ]);

    $konsumen = User::create([
        'name' => 'Konsumen',
        'email' => 'konsumen@mail.com',
        'password' => bcrypt('konsumen@123'),
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

    // Data untuk pengujian pengembalian tanpa pembayaran tunai dan denda
    $data = [
        'end_date' => '2024-05-25',
        'end_time' => '09:00:00',
    ];

    $transaction = Transaction::create([
        'invoice'=> 'sepeda_invoice_number_490',
        'admin_id' => $user->id,
        'bike_id' => $sepeda->id,
        'user_id' => $konsumen->id,
        'duration_id' => $durasi->id,
        'start_date' => '2024-05-24',
        'start_time'=> '09:00:00',
        'total_price' => 0, // Harga total adalah 0 karena tidak ada pembayaran tunai
        'charge' => 0, // Denda juga 0 karena tidak ada
        'amount' => 0, // Pembayaran juga 0
        'total' => 0, // Total juga 0
        'status' => '1',
        'jaminan' => 'gambar.jpg'
    ]);

    // Update trans_id di $data setelah transaksi dibuat
    $data['trans_id'] = $transaction->id;

    // Mengirimkan permintaan POST ke endpoint dengan data dummy
    $response = $this->actingAs($user)
        ->post(route('staff.paycash.return'), $data);

    // Memastikan bahwa pengembalian berhasil tanpa pembayaran tunai dan denda
    $response->assertStatus(200)
        ->assertJson(['success' => true]);
    }

    public function test_staff_dapat_melakukan_penegmbalian_sepeda_dengan_uang_tunai()
    {
        // Setup pengguna dan data dummy
        $user = User::create([
            'name' => 'Staff',
            'email' => 'staff@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'staff',
            'number' => '818238123',
            'address' => 'jalan',
        ]);

        $konsumen = User::create([
            'name' => 'Konsumen',
            'email' => 'konsumen@mail.com',
            'password' => bcrypt('konsumen@123'),
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

        // Data untuk pengujian pengembalian dengan tunai
        $data = [
            'trans_id' => 1, // ID Transaksi dummy yang nanti akan diganti
            'end_date' => '2024-05-25',
            'end_time' => '09:00:00',
            'payment' => 'tunai',
            'charge' => '2000',
            'total_price' => '2000' // Total harga tunai kurang dari total denda
        ];

        $transaction = Transaction::create([
            'invoice'=> 'sepeda_invoice_number_490',
            'admin_id' => $user->id,
            'bike_id' => $sepeda->id,
            'user_id' => $konsumen->id,
            'duration_id' => $durasi->id,
            'start_date' => '2024-05-24',
            'start_time'=> '09:00:00',
            'total_price' => $data['total_price'],
            'charge' => $data['charge'],
            'amount' => 20000,
            'total' => 20000 + $data['charge'], // Menghitung total sebagai penjumlahan amount dan charge
            'payment' => 'tunai',
            'status' => '1',
            'jaminan' => 'gambar.jpg'
        ]);

        // Update trans_id di $data setelah transaksi dibuat
        $data['trans_id'] = $transaction->id;

        // Mengirimkan permintaan POST ke endpoint dengan data dummy
        $response = $this->actingAs($user)
            ->post(route('staff.paycash.return'), $data);

        // Memastikan bahwa pengembalian gagal jika uang tidak cukup
        $response->assertStatus(200)
            ->assertJson(['success' => false, 'message' => 'Uang anda tidak cukup!']);
    }

    public function test_staff_dapat_melakukan_penegmbalian_sepeda_dengan_qriss()
    {
        // Setup pengguna dan data dummy
        $user = User::create([
            'name' => 'Staff',
            'email' => 'staff@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'staff',
            'number' => '818238123',
            'address' => 'jalan',
        ]);

        $konsumen = User::create([
            'name' => 'Konsumen',
            'email' => 'konsumen@mail.com',
            'password' => bcrypt('konsumen@123'),
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

        // Data untuk pengujian pengembalian dengan tunai
        $data = [
            'trans_id' => 1, // ID Transaksi dummy yang nanti akan diganti
            'end_date' => '2024-05-25',
            'end_time' => '09:00:00',
            'payment' => 'tunai',
            'charge' => '2000',
            'total_price' => '2000' // Total harga tunai kurang dari total denda
        ];

        $transaction = Transaction::create([
            'invoice'=> 'sepeda_invoice_number_490',
            'admin_id' => $user->id,
            'bike_id' => $sepeda->id,
            'user_id' => $konsumen->id,
            'duration_id' => $durasi->id,
            'start_date' => '2024-05-24',
            'start_time'=> '09:00:00',
            'total_price' => $data['total_price'],
            'charge' => $data['charge'],
            'amount' => 20000,
            'total' => 20000 + $data['charge'], // Menghitung total sebagai penjumlahan amount dan charge
            'payment' => 'qris',
            'status' => '1',
            'jaminan' => 'gambar.jpg'
        ]);

        // Update trans_id di $data setelah transaksi dibuat
        $data['trans_id'] = $transaction->id;

        // Mengirimkan permintaan POST ke endpoint dengan data dummy
        $response = $this->actingAs($user)
            ->post(route('staff.pay.return'), $data);

        // Memastikan bahwa pengembalian gagal jika uang tidak cukup
        $response->assertStatus(200);
    }



}

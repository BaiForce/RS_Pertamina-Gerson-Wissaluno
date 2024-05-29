<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dapat_melihat_data_user()
    {
        $user = User::create([
            'name' => 'Admin23',
            'email' => 'admin23@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'admin',
            'number' => '818238123',
            'address' => 'jalan',
        ]);

        User::create([
            'name' => 'andi',
            'email' => 'andi@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'admin',
            'number' => '818238123',
            'address' => 'jalan garuda',
        ]);

        $response = $this->actingAs($user)
            ->get(route('user.index'));

        $response->assertStatus(200);

    }

    public function test_admin_dapat_menambah_data_user()
    {
        $user = User::create([
            'name' => 'Admin23',
            'email' => 'admin23@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'admin',
            'number' => '818238123',
            'address' => 'jalan',
        ]);

        $response = $this->actingAs($user)
            ->post(route('user.store'), [
                'name' => 'andi',
                'email' => 'andi@mail.com',
                'password' => 'admin@123',
                'role' => 'admin',
                'number' => '818238123',
                'address' => 'jalan garuda',
            ]);

        $response->assertStatus(302)
                 ->assertRedirect(route('user.index'));  // Memeriksa apakah respons mengarahkan ke rute user.index

        $this->assertDatabaseHas('users', [
            'name' => 'andi',
            'email' => 'andi@mail.com',
            'role' => 'admin',
            'number' => '818238123',
            'address' => 'jalan garuda',
        ]);
    }

    public function test_admin_dapat_mengubah_data_user()
    {
        $user = User::create([
            'name' => 'Admin23',
            'email' => 'admin23@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'admin',
            'number' => '818238123',
            'address' => 'jalan',
        ]);

        $responseTambahUser = $this->actingAs($user)
            ->post(route('user.store'), [
                'name' => 'andi',
                'email' => 'andi@mail.com',
                'password' => 'admin@123',
                'role' => 'admin',
                'number' => '818238123',
                'address' => 'jalan garuda',
            ]);

        $userId = User::where('email', 'andi@mail.com')->first()->id;

        $responseEditUser = $this->actingAs($user)
            ->put(route('user.update', $userId), [
                'name' => 'andi baru',
                'email' => 'andi.baru@mail.com',
                'password' => 'admin@123',
                'role' => 'admin',
                'number' => '818238123',
                'address' => 'jalan baru',
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'andi baru',
            'email' => 'andi.baru@mail.com',
            'role' => 'admin',
            'number' => '818238123',
            'address' => 'jalan baru',
        ]);

        $responseEditUser->assertStatus(302)
                         ->assertRedirect(route('user.index'));  // Memeriksa apakah respons mengarahkan ke rute user.index
    }

    public function test_admin_dapat_menghapus_data_user()
    {
        $user = User::create([
            'name' => 'Admin23',
            'email' => 'admin23@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'admin',
            'number' => '818238123',
            'address' => 'jalan',
        ]);

        $responseTambahUser = $this->actingAs($user)
            ->post(route('user.store'), [
                'name' => 'andi',
                'email' => 'andi@mail.com',
                'password' => 'admin@123',
                'role' => 'admin',
                'number' => '818238123',
                'address' => 'jalan garuda',
            ]);

        $userId = User::where('email', 'andi@mail.com')->first()->id;

        $responseDeleteUser = $this->actingAs($user)
            ->delete(route('user.delete', $userId));

        $this->assertDatabaseMissing('users', ['id' => $userId]);  // Memeriksa apakah data pengguna telah dihapus dari basis data

        $responseDeleteUser->assertStatus(302)
                           ->assertRedirect(route('user.index'));  // Memeriksa apakah respons mengarahkan ke rute user.index
    }
}


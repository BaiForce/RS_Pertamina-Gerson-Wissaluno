<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;

class LogoutTest extends TestCase
{

    use RefreshDatabase;

    public function test_pengguna_dapat_melakukan_logout_dari_server()
    {

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'staff',
            'number' => '818238123',
            'address' => 'jalan',
        ]);
        $response = $this->actingAs($user)
        ->post('/logout');

        $response->assertStatus(302);
    }
}

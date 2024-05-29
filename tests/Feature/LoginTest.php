<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use RefreshDatabase;


    public function test_pengguna_dapat_login()
    {

        $user = User::create([
            'name' => 'Admin23',
            'email' => 'admin23@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'staff',
            'number' => '818238123',
            'address' => 'jalan',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin23@mail.com',
            'password' => 'admin@123',
        ]);

        $this->assertAuthenticated();

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_pengguna_tidak_dapat_login__dengan_email_salah()
    {

        $user = User::create([
            'name' => 'Admin23',
            'email' => 'admin23@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'staff',
            'number' => '818238123',
            'address' => 'jalan',
        ]);


        $response = $this->post('/login', [
            'email' => 'admin23@mail.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();

        $response->assertSessionHasErrors(['password']);
    }

    public function test_pengguna_tidak_dapat_login__dengan_password_salah()
    {

        $user = User::create([
            'name' => 'Admin23',
            'email' => 'admin23@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'staff',
            'number' => '818238123',
            'address' => 'jalan',
        ]);


        $response = $this->post('/login', [
            'email' => 'admin@mail.com',
            'password' => 'admin123',
        ]);

        $this->assertGuest();

        $response->assertSessionHasErrors(['email']);
    }

    public function test_pengguna_tidak_dapat_login_dengan_email_password_kosong()
    {

        $user = User::create([
            'name' => 'Admin23',
            'email' => 'admin23@mail.com',
            'password' => bcrypt('admin@123'),
            'role' => 'staff',
            'number' => '818238123',
            'address' => 'jalan',
        ]);


        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $this->assertGuest();

        $response->assertSessionHasErrors(['email', 'password']);

    }
}


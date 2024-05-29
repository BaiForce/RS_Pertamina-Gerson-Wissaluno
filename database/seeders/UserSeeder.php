<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new User();
        $data->name = 'Admin';
        $data->email = 'admin@mail.com';
        $data->role = 'admin';
        $data->number = '0813500900627';
        $data->address = 'Jl matahari no 23';
        $data->password = Hash::make('admin123');
        $data->save();

        $data = new User();
        $data->name = 'Konsumen';
        $data->email = 'konsumen@mail.com';
        $data->role = 'konsumen';
        $data->number = '0813500900627';
        $data->address = 'Jl matahari no 23';
        $data->password = Hash::make('admin123');
        $data->save();

        $data = new User();
        $data->name = 'Andi ';
        $data->email = 'andi@mail.com';
        $data->role = 'konsumen';
        $data->number = '0813500900627';
        $data->address = 'Jl matahari no 23';
        $data->password = Hash::make('admin123');
        $data->save();

        $data = new User();
        $data->name = 'Staff';
        $data->email = 'staff@mail.com';
        $data->role = 'staff';
        $data->number = '0813500900627';
        $data->address = 'Jl matahari no 23';
        $data->password = Hash::make('admin123');
        $data->save();

        $data = new User();
        $data->name = 'Staff2';
        $data->email = 'staff2@mail.com';
        $data->role = 'staff';
        $data->number = '0813500900627';
        $data->address = 'Jl matahari no 23';
        $data->password = Hash::make('admin123');
        $data->save();
    }
}

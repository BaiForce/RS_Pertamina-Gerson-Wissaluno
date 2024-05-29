<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;
    protected $table = 'pemesanans';
    protected $guarded = [];

    public function user()
    {
        $this->hasOne(User::class, 'id', 'user_id');
    }

    public function admin()
    {
        $this->hasOne(User::class, 'id', 'admin_id');
    }

    public function bike()
    {
        $this->hasOne(Sepeda::class, 'id', 'bike_id');
    }
}

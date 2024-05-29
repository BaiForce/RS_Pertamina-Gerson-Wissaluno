<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{

    use HasFactory;

    protected $fillable = [
        'id_sepeda',
        'latitude',
        'longitude',
    ];

    public function sepeda()
    {
        return $this->belongsTo(Sepeda::class, 'id_sepeda', 'id');
    }

}

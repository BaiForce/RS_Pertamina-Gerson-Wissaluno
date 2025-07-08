<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rute extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_point',
        'end_point',
        'distance',
        'standard_time',
        'price_per_km',
        'total_cost'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->total_cost = $model->distance * $model->price_per_km;
        });
        // static::saving(function ($model) {
        //     // Perhitungan total_cost berdasarkan (jarak + waktu) * harga per km
        //     $model->total_cost = ($model->distance + $model->standard_time) * $model->price_per_km;
        // });
    }

    /**
     * Get all transactions for this route
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get route name (start to end)
     */
    public function getRouteNameAttribute(): string
    {
        return "{$this->start_point} to {$this->end_point}";
    }
}

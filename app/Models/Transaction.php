<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'rute_id',
        'date',
        'actual_time',
        'standard_time',
        'total_cost',
        'late'
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically calculate late minutes when saving
        static::saving(function ($model) {
            $model->late = max(0, $model->actual_time - $model->standard_time);
        });
    }

    /**
     * Get the driver for this transaction
     */

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    /**
     * Get the route for this transaction
     */ // In Transaction model
    public function rute(): BelongsTo
    {
        return $this->belongsTo(Rute::class, 'rute_id');
    }

    /**
     * Check if transaction was late
     */
    public function getIsLateAttribute(): bool
    {
        return $this->late > 0;
    }
}

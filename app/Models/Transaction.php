<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];
    public const PAYMENT_CHANNELS = [
        'credit_card', 'mandiri_clickpay', 'cimb_clicks',
        'bca_klikbca', 'bca_klikpay', 'bri_epay', 'echannel', 'permata_va',
        'bca_va', 'bni_va', 'other_va', 'gopay', 'indomaret',
        'danamon_online', 'akulaku'
    ];

    public const EXPIRY_DURATION = 1;
    public const EXPIRY_UNIT = 'days';


    public const CHALLENGE = 'challenge';
    public const SUCCESS = 'success';
    public const SETTLEMENT = 'settlement';
    public const PENDING = 'pending';
    public const DENY = 'deny';
    public const EXPIRE = 'expire';
    public const CANCEL = 'cancel';
    function generateOrderID($jenis_name)
    {
        $prefix = strtoupper($jenis_name); // Get the first letter of the package type
        $datetime = now()->format('YmdHis');
        // $unique = uniqid();
        // Adjust the range as needed
        $randomNumber = random_int(100, 999);

        $orderID = "{$prefix}_{$datetime}_{$randomNumber}";

        return $orderID;
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function admin()
    {
        return $this->hasOne(User::class, 'id', 'admin_id');
    }

    public function sepeda()
    {
        return $this->hasOne(Sepeda::class, 'id', 'bike_id');
    }

    public function duration()
    {
        return $this->hasOne(DurasiSewa::class, 'id', 'duration_id');
    }

}

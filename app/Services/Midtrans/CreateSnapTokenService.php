<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    protected $sepeda;
    protected $durasi;
    protected $jenis;
    protected $invoice_number;
    protected $user;

    public function __construct($sepeda, $durasi, $jenis, $invoice_number, $user)
    {
        parent::__construct();

        $this->sepeda = $sepeda;
        $this->durasi = $durasi;
        $this->jenis = $jenis;
        $this->invoice_number = $invoice_number;
        $this->user = $user;
    }

    public function getSnapToken()
    {

        $params = [
            "payment_type" => "qris",
            'transaction_details' => [
                'order_id' => $this->invoice_number,
                'gross_amount' => $this->durasi->price,
            ],
            'item_details' => [
                [
                    'id' => 1,
                    'price' => $this->durasi->price,
                    'quantity' => 1,
                    'name' => $this->jenis->name . '-' . $this->sepeda->number,
                    "brand" => $this->jenis->name . '-' . $this->sepeda->number,
                    "category" => $this->jenis->name,
                    "merchant_name" => "SAHABAT E-BIKE"
                ],
            ],
            'customer_details' => [
                'first_name' => "Konsumen",
                "last_name" => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->number,
            ],
            "qris" => [
                "acquirer" => "gopay"
            ]
            // 'enabled_payments' => [$bankType],
            // $bankType => [
            //     'va_number' => $this->customer_detail->va_number,
            // ],
        ];

        $snapToken = Snap::getSnapToken($params);
        return $snapToken;
    }
}

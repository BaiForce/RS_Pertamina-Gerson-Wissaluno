<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;

class CreateSnapTokenServiceReturn extends Midtrans
{
    protected $sepeda;
    protected $denda;
    protected $jenis;
    protected $invoice_number;
    protected $user;
    protected $transaction_id;

    public function __construct($sepeda, $denda, $jenis, $invoice_number, $user, $transaction_id)
    {
        parent::__construct();

        $this->sepeda = $sepeda;
        $this->denda = $denda;
        $this->jenis = $jenis;
        $this->invoice_number = $invoice_number;
        $this->user = $user;
        $this->transaction_id = $transaction_id;
    }

    public function getSnapToken()
    {
        $params = [
            "payment_type" => "qris",
            'transaction_details' => [
                'order_id' => $this->transaction_id . '-' . $this->invoice_number,
                'gross_amount' => $this->denda,
            ],
            'item_details' => [
                [
                    'id' => 1,
                    'price' => $this->denda,
                    'quantity' => 1,
                    'name' => $this->jenis->name . '-' . $this->sepeda->number,
                    "brand" => $this->jenis->name . '-' . $this->sepeda->number,
                    "category" => $this->jenis->name,
                    "merchant_name" => "SAHABAT E-BIKE23"
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

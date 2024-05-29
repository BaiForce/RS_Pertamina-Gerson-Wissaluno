<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class TransactionsExport implements FromCollection, WithHeadings, WithEvents
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        // Mapping transaction data
        $transactionRows = $this->transactions->map(function ($transaction) {
            // Menggunakan kondisional untuk menentukan teks status berdasarkan kode status
            $statusText = '';
            switch ($transaction->status) {
                case 1:
                    $statusText = 'Sedang Dalam Peminjaman';
                    break;
                case 2:
                    $statusText = 'Sudah Pengembalian';
                    break;
                case 3:
                    $statusText = 'Kadaluarsa';
                    break;
                default:
                    $statusText = 'Unknown';
                    break;
            }

            return [
                'Id Transaksi' => $transaction->id,
                'Invoice' => $transaction->invoice,
                'Nama User' => $transaction->user->name,
                'Nama Admin' => $transaction->admin->name,
                'Nomor Sepeda' => $transaction->sepeda->number,
                'Tanggal Mulai' => $transaction->start_date,
                'Tanggal Selesai' => $transaction->end_date,
                'Waktu Mulai' => $transaction->start_time,
                'Waktu Selesai' => $transaction->end_time,
                'Jumlah' => $transaction->amount,
                'Biaya' => $transaction->charge,
                'Total' => $transaction->total,
                'Pembayaran' => $transaction->payment,
                'Status' => $statusText,
                'Jaminan' => $transaction->jaminan,
            ];
        });

        return $transactionRows;
    }

    public function headings(): array
    {
        return [
            'Id Transaksi',
            'Invoice',
            'Nama User',
            'Nama Admin',
            'Nomor Sepeda',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Waktu Mulai',
            'Waktu Selesai',
            'Jumlah',
            'Biaya',
            'Total',
            'Pembayaran',
            'Status',
            'Jaminan',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Mendapatkan worksheet
                $sheet = $event->sheet->getDelegate();

                // Mengatur garis batas untuk seluruh sel pada tabel
                $sheet->getStyle('A1:O' . $sheet->getHighestRow())->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);
            },
        ];
    }
}

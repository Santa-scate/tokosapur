<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Sale::with('user', 'details.product')
                    ->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])
                    ->orderBy('created_at', 'asc')
                    ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Tanggal',
            'Nama Kasir',
            'Detail Produk',
            'Total Harga',
            'Total Bayar',
            'Kembalian',
        ];
    }

    /**
     * @param mixed $sale
     *
     * @return array
     */
    public function map($sale): array
    {
        $productDetails = $sale->details->map(function ($detail) {
            return $detail->product->name . ' (' . $detail->quantity . 'x)';
        })->implode(', ');

        return [
            $sale->id,
            $sale->created_at->format('d-m-Y H:i'),
            $sale->user->name,
            $productDetails,
            $sale->total_price,
            $sale->total_received,
            $sale->change,
        ];
    }
}


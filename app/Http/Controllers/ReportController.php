<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Jobs\GenerateSalesReportJob;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Tetapkan tanggal default: bulan ini
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        // Ambil data penjualan berdasarkan rentang tanggal
        $sales = Sale::with('user', 'details.product')
                    ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        // Hitung total pendapatan untuk ringkasan
        $totalRevenue = $sales->sum('total_price');

        return view('reports.index', compact('sales', 'startDate', 'endDate', 'totalRevenue'));
    }


public function exportPdf(Request $request)
{
    // Ambil tanggal dari request
    $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
    $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

    // Kirim tugas untuk membuat laporan ke antrian
    GenerateSalesReportJob::dispatch($startDate, $endDate, auth()->user());

    // Langsung arahkan kembali pengguna dengan pesan sukses
    return redirect()->route('reports.index')
                     ->with('success', 'Laporan sedang dibuat. Proses ini mungkin memakan waktu beberapa menit. Hasilnya akan disimpan di server.');
}


    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        return Excel::download(new SalesExport($startDate, $endDate), 'laporan-penjualan-'.$startDate.'-'.$endDate.'.xlsx');
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\JsonResponse; // <-- Tambahkan ini
use Illuminate\Support\Facades\DB;  // <-- Tambahkan ini
use Carbon\Carbon;                 // <-- Pastikan ini ada

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalUsers = User::where('role', 'kasir')->count();
        $todaySales = Sale::whereDate('created_at', Carbon::today())->sum('total_price');
        $monthSales = Sale::whereMonth('created_at', Carbon::now()->month)->sum('total_price');

        return view('dashboard', compact('totalProducts', 'totalUsers', 'todaySales', 'monthSales'));
    }

    /**
     * Menyediakan data penjualan untuk grafik dashboard.
     */
    public function chartData(): JsonResponse
    {
        $salesData = Sale::select(
            // Ambil tanggal saja dari created_at
            DB::raw('DATE(created_at) as date'),
            // Jumlahkan total_price untuk setiap tanggal
            DB::raw('SUM(total_price) as total')
        )
        // Filter data hanya untuk 7 hari terakhir
        ->whereBetween('created_at', [Carbon::now()->subDays(6), Carbon::now()])
        // Kelompokkan berdasarkan tanggal
        ->groupBy('date')
        // Urutkan berdasarkan tanggal
        ->orderBy('date', 'ASC')
        ->get();

        // Siapkan array untuk label (tanggal) dan data (total penjualan)
        $labels = [];
        $data = [];

        // Buat rentang tanggal 7 hari untuk memastikan semua hari ada di grafik
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::parse($date)->format('d M'); // Format tanggal (e.g., 29 Jun)

            // Cari data penjualan untuk tanggal ini
            $sale = $salesData->firstWhere('date', $date);
            // Jika ada penjualan, masukkan totalnya. Jika tidak, masukkan 0.
            $data[] = $sale ? $sale->total : 0;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }
}


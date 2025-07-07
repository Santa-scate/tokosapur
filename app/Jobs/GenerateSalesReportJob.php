<?php

namespace App\Jobs;

use App\Models\Sale;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf; // <-- PENTING
use App\Notifications\ReportGenerated;
use Carbon\Carbon; // <-- PENTING
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB; // <-- PENTING
use Illuminate\Support\Facades\Log; // <-- PENTING

class GenerateSalesReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $startDate;
    protected $endDate;
    protected $user;

    public function __construct(string $startDate, string $endDate, User $user)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->user = $user;
    }

    public function handle(): void
    {
        Log::info("Memulai pembuatan laporan untuk user: {$this->user->email} dari {$this->startDate} sampai {$this->endDate}");

        try {
            $sales = Sale::with('user')
                        ->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])
                        ->get();
            $totalRevenue = $sales->sum('total_price');

            $pdf = Pdf::loadView('reports.pdf', [
                'sales' => $sales,
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'totalRevenue' => $totalRevenue
            ]);

            $filename = 'laporan-penjualan-' . $this->startDate . '-ke-' . $this->endDate . '.pdf';
            // Pastikan folder reports ada di storage/app/public/
            $pdf->save(storage_path('app/public/reports/' . $filename));

            // KIRIM NOTIFIKASI KE USER YANG MEMINTA
            $this->user->notify(new ReportGenerated($filename));

            Log::info("Laporan '{$filename}' berhasil dibuat. Notifikasi terkirim.");

           // Log::info("Laporan '{$filename}' berhasil dibuat untuk user: {$this->user->email}");
            // Di aplikasi nyata, di sini Anda bisa mengirim notifikasi email atau notifikasi web ke user.

        } catch (\Exception $e) {
            // Catat error ke log jika terjadi kegagalan di dalam job
            Log::error("Gagal membuat laporan untuk user: {$this->user->email}. Error: " . $e->getMessage());
            // Melempar kembali exception akan membuat job ditandai sebagai 'failed'
            throw $e;
        }
    }
}



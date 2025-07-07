<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast; // <-- PENTING
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class ReportGenerated extends Notification implements ShouldBroadcast // <-- IMPLEMENTASIKAN
{
    use Queueable;

    public $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    // Tentukan channel pengiriman notifikasi
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast']; // Kirim ke DB dan siarkan
    }

    // Format data yang disimpan ke database
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Laporan Anda siap!',
            'filename' => $this->filename,
            'link' => '/storage/reports/' . $this->filename,
        ];
    }

    // Format data yang disiarkan secara real-time
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'message' => 'Laporan Anda "' . $this->filename . '" telah selesai dibuat dan siap diunduh.',
            'link' => '/storage/reports/' . $this->filename,
        ]);
    }
}


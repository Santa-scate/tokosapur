<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            // Tambahkan kolom customer_id setelah kolom user_id
            $table->foreignId('customer_id')
                  ->nullable() // Boleh kosong, untuk transaksi "Tamu"
                  ->after('user_id')
                  ->constrained('customers') // Foreign key ke tabel customers
                  ->onDelete('set null'); // Jika pelanggan dihapus, transaksi tetap ada tapi customer_id jadi null
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            // Logika untuk membatalkan migrasi (menghapus kolom)
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
        });
    }
};


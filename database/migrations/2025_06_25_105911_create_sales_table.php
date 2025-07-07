<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
  {
    Schema::create('sales', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users'); // Kasir yang melakukan transaksi
        $table->integer('total_price');
        $table->integer('total_received'); // Uang yang diterima
        $table->integer('change'); // Kembalian
        $table->timestamps();
     });
   }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};

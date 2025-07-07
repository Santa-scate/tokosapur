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
        Schema::create('stock_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Produk mana yang stoknya masuk
            $table->foreignId('user_id')->constrained('users'); // Siapa yang mencatat (Admin)
            $table->integer('quantity'); // Jumlah stok yang ditambahkan
            $table->text('notes')->nullable(); // Catatan tambahan (misal: dari supplier X)
            $table->timestamps(); // Tanggal pencatatan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_ins');
    }
};


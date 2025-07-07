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
    Schema::create('sale_details', function (Blueprint $table) {
         $table->id();
         $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');
         $table->foreignId('product_id')->constrained('products');
         $table->integer('quantity');
         $table->integer('price_at_sale'); // Harga produk saat transaksi
         $table->integer('subtotal');
         $table->timestamps();
     });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_details');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable(); // Boleh kosong, tapi jika diisi harus unik
            $table->string('phone')->unique()->nullable(); // Boleh kosong, tapi jika diisi harus unik
            $table->text('address')->nullable(); // Alamat boleh kosong
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};


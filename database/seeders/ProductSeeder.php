<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create(['name' => 'Kopi Hitam', 'code' => 'P001', 'price' => 5000, 'stock' => 100]);
        Product::create(['name' => 'Teh Manis', 'code' => 'P002', 'price' => 4000, 'stock' => 100]);
        Product::create(['name' => 'Roti Bakar', 'code' => 'P003', 'price' => 12000, 'stock' => 50]);
    }
}


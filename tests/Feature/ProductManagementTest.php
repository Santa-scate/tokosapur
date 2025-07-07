<?php


namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    // Trait ini akan otomatis me-reset database untuk setiap test.
    // Ini memastikan setiap tes berjalan di lingkungan yang bersih.
    use RefreshDatabase;

    /**
     * Tes untuk memastikan user dengan role 'kasir' tidak bisa mengakses halaman tambah produk.
     */
    public function test_cashier_cannot_access_create_product_page(): void
    {
        // 1. Persiapan (Arrange)
        // Buat user dengan role 'kasir'
        $cashier = User::factory()->create(['role' => 'kasir']);

        // 2. Aksi (Act)
        // Bertindak sebagai user kasir dan coba akses halaman tambah produk
        $response = $this->actingAs($cashier)->get(route('products.create'));

        // 3. Pengecekan (Assert)
        // Pastikan dia mendapatkan status 403 (Forbidden) karena Policy kita
        $response->assertStatus(403);
    }

    /**
     * Tes untuk memastikan admin bisa menambahkan produk baru.
     */
    public function test_admin_can_create_a_new_product(): void
    {
        // 1. Persiapan (Arrange)
        // Buat user dengan role 'admin'
        $admin = User::factory()->create(['role' => 'admin']);
        // Siapkan data produk yang akan dikirim
        $productData = [
            'name' => 'Kopi Robusta Baru',
            'code' => 'P010',
            'price' => 25000,
            'stock' => 100,
        ];

        // 2. Aksi (Act)
        // Bertindak sebagai admin dan kirim request POST untuk menyimpan produk
        $response = $this->actingAs($admin)->post(route('products.store'), $productData);

        // 3. Pengecekan (Assert)
        // Pastikan tidak ada error validasi
        $response->assertSessionHasNoErrors();
        // Pastikan data produk yang kita kirim ada di dalam database
        $this->assertDatabaseHas('products', [
            'code' => 'P010',
            'name' => 'Kopi Robusta Baru'
        ]);
        // Pastikan setelah berhasil, kita diarahkan kembali ke halaman daftar produk
        $response->assertRedirect(route('products.index'));
    }
}


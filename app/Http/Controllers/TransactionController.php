<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- Penting untuk DB Transaction

class TransactionController extends Controller
{
    /**
     * Menampilkan halaman transaksi utama.
     */
    public function index()
    {
        $products = Product::where('stock', '>', 0)->orderBy('name')->get();
        $customers = Customer::orderBy('name')->get(); // <-- Tambahkan ini

        // Kirim kedua data ke view
        return view('transaction.index', compact('products', 'customers'));
    }

    /**
     * Menyimpan data transaksi baru.
     */

// app/Http/Controllers/TransactionController.php

public function store(Request $request)
{
    // Validasi dasar
    $request->validate([
        'cart' => 'required|array|min:1',
        'cart.*.id' => 'required|exists:products,id',
        'cart.*.quantity' => 'required|integer|min:1',
        'total_received' => 'required|integer|min:0',
        'customer_id' => 'nullable|exists:customers,id', // <-- Tambahkan validasi ini
    ]);

    DB::beginTransaction();

    try {
        // ... (logika hitung total harga tetap sama) ...
        $cart = $request->cart;
        $totalPrice = 0;
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if ($product->stock < $item['quantity']) {
                throw new \Exception('Stok produk ' . $product->name . ' tidak mencukupi.');
            }
            $totalPrice += $product->price * $item['quantity'];
        }
        if ($request->total_received < $totalPrice) {
            throw new \Exception('Uang yang diterima kurang dari total belanja.');
        }

        // 1. Buat record di tabel 'sales'
        $sale = Sale::create([
            'user_id' => auth()->id(),
            'customer_id' => $request->customer_id, // <-- Simpan ID pelanggan
            'total_price' => $totalPrice,
            'total_received' => $request->total_received,
            'change' => $request->total_received - $totalPrice,
        ]);

        // ... (logika simpan sale_details dan kurangi stok tetap sama) ...
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            SaleDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price_at_sale' => $product->price,
                'subtotal' => $product->price * $item['quantity'],
            ]);
            $product->decrement('stock', $item['quantity']);
        }

        DB::commit();

        return redirect()->route('transaction.show', $sale->id)->with('success', 'Transaksi berhasil disimpan.');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('transaction.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

    /**
     * Menampilkan struk transaksi.
     */
    public function show(Sale $sale)
    {
        // Eager load relasi untuk efisiensi query
        $sale->load('details.product', 'user');
        return view('transaction.receipt', compact('sale'));
    }
}

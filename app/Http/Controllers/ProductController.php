<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Terapkan policy ke semua method resource secara otomatis.
     */
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

    // ... fungsi index(), create(), store() biarkan seperti sebelumnya ...
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'code'  => 'required|string|unique:products,code',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }


    /**
     * Tampilkan form untuk mengedit produk.
     * HAPUS FUNGSI edit(string $id) YANG LAMA, GUNAKAN YANG INI.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update produk yang ada di database.
     * HAPUS FUNGSI update(Request $request, string $id) YANG LAMA, GUNAKAN YANG INI.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'code'  => 'required|string|unique:products,code,' . $product->id,
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk dari database.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}




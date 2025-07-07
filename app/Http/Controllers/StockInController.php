<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    /**
     * Menampilkan riwayat stok masuk.
     */
    public function index()
    {
        $stockIns = StockIn::with('product', 'user')->latest()->paginate(15);
        return view('stock-ins.index', compact('stockIns'));
    }

    /**
     * Menampilkan form untuk menambah stok masuk.
     */
    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('stock-ins.create', compact('products'));
    }

    /**
     * Menyimpan data stok masuk baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // 1. Buat catatan di tabel stock_ins
            StockIn::create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'notes' => $request->notes,
                'user_id' => auth()->id(),
            ]);

            // 2. Update (tambah) stok di tabel products
            $product = Product::find($request->product_id);
            $product->increment('stock', $request->quantity);

            DB::commit();

            return redirect()->route('stock-ins.index')->with('success', 'Stok berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}


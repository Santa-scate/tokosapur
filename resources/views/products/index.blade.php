<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Notifikasi Sukses --}}
                    @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    {{-- Tombol Tambah Produk, hanya muncul jika diizinkan oleh Policy --}}
                    @can('create', App\Models\Product::class)
                    <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mb-4">
                        Tambah Produk Baru
                    </a>
                    @endcan
                    
                    {{-- Tabel Daftar Produk --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Kode</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Nama Produk</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Harga</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Stok</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse($products as $product)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $product->code }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $product->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($product->price) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $product->stock }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('products.destroy', $product->id) }}" method="POST" class="flex space-x-2">
                                            
                                            {{-- Otorisasi untuk tombol Edit --}}
                                            @can('update', $product)
                                            <a href="{{ route('products.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">Edit</a>
                                            @endcan

                                            {{-- Otorisasi untuk tombol Hapus --}}
                                            @can('delete', $product)
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">Hapus</button>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Data Produk belum Tersedia.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Stok Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    <a href="{{ route('stock-ins.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mb-4">
                        Catat Stok Masuk Baru
                    </a>
                    
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase">Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase">Jumlah Masuk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase">Dicatat Oleh</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($stockIns as $stockIn)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $stockIn->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $stockIn->product->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $stockIn->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $stockIn->user->name }}</td>
                                <td class="px-6 py-4">{{ $stockIn->notes }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">Belum ada riwayat stok masuk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $stockIns->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


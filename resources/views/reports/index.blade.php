<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Penjualan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

{{-- Tambahkan blok ini untuk menampilkan notifikasi --}}
@if(session('success'))
<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
    <strong class="font-bold">Sukses!</strong>
    <span class="block sm:inline">{{ session('success') }}</span>
</div>
@endif


                    <form method="GET" action="{{ route('reports.index') }}" class="mb-6">
                        <div class="flex items-end space-x-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium">Tanggal Selesai</label>
                                <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700">
                            </div>
                            <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">Filter</button>
                        </div>
                    </form>

                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-lg font-bold">Total Pendapatan: Rp {{ number_format($totalRevenue) }}</h3>
                            <p class="text-sm">Untuk periode {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('reports.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="py-2 px-4 border border-red-500 rounded-md text-sm font-medium text-red-500 hover:bg-red-50">Export PDF</a>
                            <a href="{{ route('reports.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="py-2 px-4 border border-green-500 rounded-md text-sm font-medium text-green-500 hover:bg-green-50">Export Excel</a>
                        </div>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase">Tgl & Waktu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase">Kasir</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase">Detail Produk</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800">
                            @forelse ($sales as $sale)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $sale->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($sale->total_price) }}</td>
                                <td class="px-6 py-4">
                                    @foreach($sale->details as $detail)
                                    <span class="text-xs">{{ $detail->product->name }} ({{ $detail->quantity }}x), </span>
                                    @endforeach
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">Tidak ada data penjualan pada periode ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


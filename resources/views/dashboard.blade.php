<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p>Berikut adalah ringkasan aktivitas toko Anda.</p>
                </div>
            </div>

            {{-- Tampilkan ringkasan dan grafik HANYA UNTUK ADMIN --}}
            @if(auth()->user()->role === 'admin')
            <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-gray-800 p-4 shadow-sm rounded-lg">
                    <h4 class="text-gray-500 dark:text-gray-400">Total Produk</h4>
                    <p class="text-3xl font-bold">{{ $totalProducts }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-4 shadow-sm rounded-lg">
                    <h4 class="text-gray-500 dark:text-gray-400">Penjualan Hari Ini</h4>
                    <p class="text-3xl font-bold">Rp {{ number_format($todaySales) }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-4 shadow-sm rounded-lg">
                    <h4 class="text-gray-500 dark:text-gray-400">Penjualan Bulan Ini</h4>
                    <p class="text-3xl font-bold">Rp {{ number_format($monthSales) }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-4 shadow-sm rounded-lg">
                    <h4 class="text-gray-500 dark:text-gray-400">Jumlah Kasir</h4>
                    <p class="text-3xl font-bold">{{ $totalUsers }}</p>
                </div>
            </div>

            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Grafik Penjualan 7 Hari Terakhir</h3>
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Sisipkan script HANYA JIKA user adalah admin --}}
    @if(auth()->user()->role === 'admin')
        {{-- Gunakan @push untuk mengirim script ke stack 'scripts' di layout utama (jika ada) --}}
        {{-- atau letakkan langsung di sini --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('salesChart');

                // Ambil data dari endpoint yang kita buat
                fetch('{{ route("dashboard.chart") }}')
                    .then(response => response.json())
                    .then(apiData => {
                        new Chart(ctx, {
                            type: 'bar', // Tipe grafik: batang
                            data: {
                                labels: apiData.labels, // Label sumbu X (tanggal)
                                datasets: [{
                                    label: 'Total Penjualan (Rp)',
                                    data: apiData.data, // Data sumbu Y (total penjualan)
                                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    });
            });
        </script>
    @endif
</x-app-layout>


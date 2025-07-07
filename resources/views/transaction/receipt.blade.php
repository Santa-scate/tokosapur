<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Struk Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" id="receipt">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-center text-lg font-bold">{{ setting('app_name', config('app.name')) }}</h3>
                    <p class="text-center text-sm">{{ setting('app_address') }}</p>
                    <hr class="my-3 border-dashed">

                    <p>No. Transaksi: {{ $sale->id }}</p>
                    <p>Tanggal: {{ $sale->created_at->format('d/m/Y H:i') }}</p>
                    <p>Kasir: {{ $sale->user->name }}</p>

                    @if($sale->customer)
                    <p>Pelanggan: {{ $sale->customer->name }}</p>
                    @endif
                    <hr class="my-3 border-dashed">

                    @foreach($sale->details as $detail)
                    <div class="flex justify-between">
                        <div>
                            <p>{{ $detail->product->name }}</p>
                            <p class="text-sm">{{ $detail->quantity }} x Rp {{ number_format($detail->price_at_sale) }}</p>
                        </div>
                        <p>Rp {{ number_format($detail->subtotal) }}</p>
                    </div>
                    @endforeach

                    <hr class="my-3 border-dashed">

                    <div class="flex justify-between font-bold">
                        <p>Total</p>
                        <p>Rp {{ number_format($sale->total_price) }}</p>
                    </div>
                    <div class="flex justify-between">
                        <p>Bayar</p>
                        <p>Rp {{ number_format($sale->total_received) }}</p>
                    </div>
                    <div class="flex justify-between">
                        <p>Kembali</p>
                        <p>Rp {{ number_format($sale->change) }}</p>
                    </div>

                    <hr class="my-3 border-dashed">
                    <p class="text-center">{{ setting('receipt_footer', 'Terima Kasih!') }}</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('transaction.index') }}" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">Transaksi Baru</a>
                <button onclick="printReceipt()" class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-600 dark:text-gray-200">
                    Cetak Struk
                </button>
            </div>
        </div>
    </div>
    <script>
        function printReceipt() {
            const printContents = document.getElementById('receipt').innerHTML;
            const originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
</x-app-layout>



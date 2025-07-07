<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Halaman Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="transaction()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Notifikasi Error --}}
            @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Gagal!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="md:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-medium mb-4">Daftar Produk</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($products as $product)
                                    <div @click="addToCart({{ $product }})" class="border rounded-lg p-3 text-center cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <p class="font-bold">{{ $product->name }}</p>
                                        <p class="text-sm">Rp {{ number_format($product->price) }}</p>
                                        <p class="text-xs text-gray-500">Stok: {{ $product->stock }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <form action="{{ route('transaction.store') }}" method="POST" @submit.prevent="submitTransaction">
                                @csrf
                                
                                <div class="mb-4">
                                    <label for="customer_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Pelanggan</label>
                                    <select name="customer_id" id="customer_id" x-model="customerId" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                        <option value="">-- Pilih Pelanggan (Tamu) --</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <hr class="my-4">
                                
                                <h3 class="text-lg font-medium mb-4">Keranjang</h3>
                                <div class="space-y-2 mb-4" style="min-height: 100px;">
                                    <template x-for="(item, index) in cart" :key="index">
                                        <div class="flex justify-between items-center text-sm">
                                            <div>
                                                <p class="font-semibold" x-text="item.name"></p>
                                                <p class="text-xs text-gray-500">Rp <span x-text="formatRupiah(item.price)"></span> x <span x-text="item.quantity"></span></p>
                                            </div>
                                            <div class="flex items-center">
                                                <p class="mr-4 font-bold">Rp <span x-text="formatRupiah(item.price * item.quantity)"></span></p>
                                                <button type="button" @click="removeFromCart(index)" class="text-red-500 hover:text-red-700 font-bold">&times;</button>
                                            </div>
                                            <input type="hidden" :name="`cart[${index}][id]`" :value="item.id">
                                            <input type="hidden" :name="`cart[${index}][quantity]`" :value="item.quantity">
                                        </div>
                                    </template>
                                    <template x-if="cart.length === 0">
                                        <p class="text-sm text-gray-500 text-center">Keranjang masih kosong</p>
                                    </template>
                                </div>
                                
                                <hr class="my-4 border-dashed">

                                <div class="flex justify-between font-bold text-xl mb-4">
                                    <p>Total:</p>
                                    <p>Rp <span x-text="formatRupiah(totalPrice)"></span></p>
                                </div>

                                <div class="space-y-2">
                                    <div>
                                        <label for="total_received" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Uang Diterima</label>
                                        <input type="number" id="total_received" name="total_received" x-model.number="totalReceived" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700" placeholder="Masukkan jumlah uang...">
                                    </div>
                                    <div class="flex justify-between font-semibold">
                                        <p>Kembalian:</p>
                                        <p>Rp <span x-text="formatRupiah(change)"></span></p>
                                    </div>
                                </div>
                                
                                <div class="mt-6 flex space-x-2">
                                    <button type="submit" class="flex-1 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50" :disabled="cart.length === 0 || totalReceived < totalPrice">
                                        Proses Transaksi
                                    </button>
                                    <button type="button" @click="resetTransaction()" class="flex-1 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-600 dark:text-gray-200">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script Alpine.js yang Lengkap --}}
    <script>
        function transaction() {
            return {
                cart: [],
                totalReceived: 0,
                customerId: '', 
                
                get totalPrice() {
                    return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
                },
                
                get change() {
                    if (this.totalReceived < this.totalPrice) return 0;
                    const result = this.totalReceived - this.totalPrice;
                    return result >= 0 ? result : 0;
                },

                addToCart(product) {
                    const existingItem = this.cart.find(item => item.id === product.id);
                    if (existingItem) {
                        if (existingItem.quantity < product.stock) {
                            existingItem.quantity++;
                        } else {
                            alert('Stok produk tidak mencukupi!');
                        }
                    } else {
                        if (product.stock > 0) {
                            this.cart.push({ ...product, quantity: 1 });
                        } else {
                            alert('Stok produk habis!');
                        }
                    }
                },

                removeFromCart(index) {
                    this.cart.splice(index, 1);
                },
                
                resetTransaction() {
                    this.cart = [];
                    this.totalReceived = 0;
                    this.customerId = '';
                },

                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID').format(number);
                },

                submitTransaction(event) {
                    if (this.cart.length === 0) {
                        alert('Keranjang masih kosong.');
                        return;
                    }
                    if (this.totalReceived < this.totalPrice) {
                        alert('Uang yang diterima tidak mencukupi.');
                        return;
                    }
                    event.target.submit();
                }
            }
        }
    </script>
</x-app-layout>


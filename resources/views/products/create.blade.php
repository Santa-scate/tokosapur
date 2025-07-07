<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Produk Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nama Produk</label>
                            <input type="text" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700" name="name" value="{{ old('name') }}">
                            @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="mt-4">
                            <label for="code" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Kode Produk</label>
                            <input type="text" id="code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700" name="code" value="{{ old('code') }}">
                            @error('code') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="mt-4">
                            <label for="price" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Harga</label>
                            <input type="number" id="price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700" name="price" value="{{ old('price') }}">
                            @error('price') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="mt-4">
                            <label for="stock" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Stok</label>
                            <input type="number" id="stock" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700" name="stock" value="{{ old('stock') }}">
                            @error('stock') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="mt-4">
                            <label for="description" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Deskripsi (Opsional)</label>
                            <textarea id="description" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700">{{ old('description') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('products.index') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


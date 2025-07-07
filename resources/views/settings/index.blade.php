<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pengaturan Aplikasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('settings.update') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <x-input-label for="app_name" :value="__('Nama Toko / Aplikasi')" />
                            <x-text-input id="app_name" class="block mt-1 w-full" type="text" name="app_name" :value="old('app_name', $settings['app_name'] ?? config('app.name'))" required />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="app_address" :value="__('Alamat Toko')" />
                            <textarea id="app_address" name="app_address" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ old('app_address', $settings['app_address'] ?? '') }}</textarea>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="app_phone" :value="__('No. Telepon Toko')" />
                            <x-text-input id="app_phone" class="block mt-1 w-full" type="text" name="app_phone" :value="old('app_phone', $settings['app_phone'] ?? '')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="receipt_footer" :value="__('Teks Footer Struk')" />
                            <x-text-input id="receipt_footer" class="block mt-1 w-full" type="text" name="receipt_footer" :value="old('receipt_footer', $settings['receipt_footer'] ?? 'Terima Kasih!')" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Simpan Pengaturan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


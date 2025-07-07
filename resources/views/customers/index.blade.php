<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Pelanggan') }}
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

                    <a href="{{ route('customers.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 mb-4">
                        Tambah Pelanggan
                    </a>
                    
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase">No. Telepon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($customers as $customer)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $customer->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $customer->email ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $customer->phone ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="flex space-x-2">
                                        <a href="{{ route('customers.edit', $customer->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">Belum ada data pelanggan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


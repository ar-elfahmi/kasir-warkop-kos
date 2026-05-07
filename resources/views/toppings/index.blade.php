<x-app-layout>
    <div class="max-w-3xl mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">Topping</h1>
            <a href="{{ route('toppings.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">
                + Tambah Topping
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left px-4 py-3 font-medium">Nama</th>
                        <th class="text-right px-4 py-3 font-medium">Harga</th>
                        <th class="text-center px-4 py-3 font-medium">Digunakan di</th>
                        <th class="text-center px-4 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($toppings as $topping)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $topping->name }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($topping->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-center text-xs text-gray-500">
                                {{ $topping->menuItems->pluck('name')->implode(', ') ?: '—' }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex gap-1 justify-center">
                                    <a href="{{ route('toppings.edit', $topping->id) }}"
                                        class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200">
                                        Edit
                                    </a>
                                    <form action="{{ route('toppings.destroy', $topping->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus topping {{ $topping->name }}?')">
                                        @csrf @method('DELETE')
                                        <button class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded hover:bg-red-200">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                                Belum ada topping
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <a href="{{ route('menu-items.index') }}" class="text-sm text-blue-600 hover:underline">
                &larr; Kembali ke menu
            </a>
        </div>
    </div>
</x-app-layout>

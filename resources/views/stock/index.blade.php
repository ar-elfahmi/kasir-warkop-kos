<x-app-layout>
    <div class="max-w-4xl mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">Stok</h1>
            <a href="/stock/restock" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">
                + Tambah Stok
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left px-4 py-3 font-medium">Item</th>
                        <th class="text-left px-4 py-3 font-medium">Variant</th>
                        <th class="text-right px-4 py-3 font-medium">Harga</th>
                        <th class="text-right px-4 py-3 font-medium">Stok</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($variants as $variant)
                        <tr>
                            <td class="px-4 py-3">{{ $variant->menuItem?->name ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $variant->size ? ucfirst($variant->size) : 'Reguler' }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($variant->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right {{ $variant->stock <= 5 ? 'text-red-600 font-bold' : '' }}">
                                {{ $variant->stock }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h2 class="text-lg font-bold mb-3">Riwayat Restok</h2>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @forelse ($stockEntries as $entry)
                <div class="flex justify-between items-center px-4 py-3 border-b text-sm">
                    <div>
                        <p class="font-medium">{{ $entry->variant?->menuItem?->name ?? '—' }} ({{ $entry->variant?->size ? ucfirst($entry->variant->size) : 'Reguler' }})</p>
                        <p class="text-gray-500 text-xs">{{ $entry->note ?? '—' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-green-600 font-medium">+{{ $entry->quantity }}</p>
                        <p class="text-gray-400 text-xs">{{ $entry->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-400 text-center py-8">Belum ada riwayat restok</p>
            @endforelse
        </div>
    </div>
</x-app-layout>

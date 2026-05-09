<x-app-layout>
    <div class="max-w-4xl mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold text-deep-charcoal">Stok</h1>
            <div class="flex gap-2">
                <a href="/stock/restock" class="px-3 py-3 bg-success-green text-white rounded-8 text-sm font-semibold h-12 inline-flex items-center hover:bg-green-700 transition">
                    + Tambah Stok
                </a>
                <a href="/stock/adjust" class="px-3 py-3 bg-success-green text-white rounded-8 text-sm font-semibold h-12 inline-flex items-center hover:bg-green-700 transition">
                    Koreksi Stok
                </a>
            </div>
        </div>

        <div class="bg-white border border-light-border rounded-8 overflow-hidden shadow-l1 mb-6">
            <table class="w-full text-sm">
                <thead class="bg-very-light-gray">
                    <tr>
                        <th class="text-left px-4 py-3 font-semibold text-deep-charcoal">Item</th>
                        <th class="text-left px-4 py-3 font-semibold text-deep-charcoal">Kategori</th>
                        <th class="text-right px-4 py-3 font-semibold text-deep-charcoal">Stok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-light-border">
                    @foreach ($menuItems as $item)
                        <tr>
                            <td class="px-4 py-3 text-deep-charcoal font-semibold">{{ $item->name }}</td>
                            <td class="px-4 py-3 text-deep-charcoal">{{ $item->category?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-right {{ $item->stock <= 5 ? 'text-error-red font-bold' : 'text-deep-charcoal' }}">
                                {{ $item->stock }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h2 class="text-lg font-bold text-deep-charcoal mb-3">Riwayat Restok</h2>
        <div class="bg-white border border-light-border rounded-8 overflow-hidden shadow-l1">
            @forelse ($stockEntries as $entry)
                <div class="flex justify-between items-center px-4 py-3 border-b border-light-border text-sm">
                    <div>
                        <p class="font-semibold text-deep-charcoal">{{ $entry->menuItem?->name ?? '—' }}</p>
                        <p class="text-zinc-text text-xs">{{ $entry->note ?? '—' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-success-green font-semibold">+{{ $entry->quantity }}</p>
                        <p class="text-light-gray text-xs">{{ $entry->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            @empty
                <p class="text-light-gray text-center py-8">Belum ada riwayat restok</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
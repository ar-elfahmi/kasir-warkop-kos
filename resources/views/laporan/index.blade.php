<x-app-layout>
    <div class="max-w-5xl mx-auto p-4 space-y-6">
        <h1 class="text-xl font-bold">Laporan</h1>

        {{-- Filter --}}
        <form method="GET" class="flex flex-wrap gap-3 items-end bg-white rounded-lg shadow p-4">
            <div>
                <label class="block text-sm font-medium mb-1">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}"
                    class="border rounded-lg p-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ $dateTo }}"
                    class="border rounded-lg p-2 text-sm">
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">
                Filter
            </button>
        </form>

        {{-- Per Kategori --}}
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="font-bold mb-3">Ringkasan per Kategori</h2>
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left px-4 py-2 font-medium">Kategori</th>
                        <th class="text-right px-4 py-2 font-medium">Terjual</th>
                        <th class="text-right px-4 py-2 font-medium">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($categorySummary as $cat)
                        <tr>
                            <td class="px-4 py-2">{{ $cat->name }}</td>
                            <td class="px-4 py-2 text-right">{{ $cat->total_qty }}</td>
                            <td class="px-4 py-2 text-right">Rp {{ number_format($cat->total_sales, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Per Item --}}
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="font-bold mb-3">Ringkasan per Item</h2>
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left px-4 py-2 font-medium">Item</th>
                        <th class="text-right px-4 py-2 font-medium">Terjual</th>
                        <th class="text-right px-4 py-2 font-medium">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($itemSummary as $item)
                        <tr>
                            <td class="px-4 py-2">{{ $item->item_name }}</td>
                            <td class="px-4 py-2 text-right">{{ $item->total_qty }}</td>
                            <td class="px-4 py-2 text-right">Rp {{ number_format($item->total_sales, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Riwayat Transaksi --}}
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="font-bold mb-3">Riwayat Transaksi</h2>
            @forelse ($transactions as $tx)
                <a href="/laporan/{{ $tx->id }}" class="flex justify-between items-center px-4 py-3 border-b hover:bg-gray-50 text-sm">
                    <div>
                        <p class="font-medium">#{{ $tx->id }} — {{ $tx->payment_method === 'tunai' ? 'Tunai' : 'QRIS' }}</p>
                        <p class="text-gray-500 text-xs">{{ $tx->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium">Rp {{ number_format($tx->total, 0, ',', '.') }}</p>
                    </div>
                </a>
            @empty
                <p class="text-gray-400 text-center py-8">Tidak ada transaksi</p>
            @endforelse
        </div>
    </div>
</x-app-layout>

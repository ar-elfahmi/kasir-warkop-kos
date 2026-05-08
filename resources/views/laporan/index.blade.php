<x-app-layout>
    <div class="max-w-5xl mx-auto p-4 space-y-6">
        <h1 class="text-xl font-bold text-deep-charcoal">Laporan</h1>

        {{-- Filter --}}
        <form method="GET" class="flex flex-wrap gap-3 items-end bg-white border border-light-border rounded-8 p-4 shadow-l1">
            <div>
                <label class="block text-sm font-medium text-slate-btn mb-1">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}"
                    class="border border-light-border bg-very-light-gray rounded-6 p-3 h-12 text-sm text-deep-charcoal focus:border-slate-btn focus:ring-slate-btn">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-btn mb-1">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ $dateTo }}"
                    class="border border-light-border bg-very-light-gray rounded-6 p-3 h-12 text-sm text-deep-charcoal focus:border-slate-btn focus:ring-slate-btn">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-btn mb-1">Metode Bayar</label>
                <select name="payment_method"
                    class="border border-light-border bg-very-light-gray rounded-6 p-3 h-12 text-sm text-deep-charcoal focus:border-slate-btn focus:ring-slate-btn">
                    <option value="">Semua __ </option>
                    <option value="tunai" {{ $paymentMethod === 'tunai  ' ? 'selected' : '' }}>Tunai</option>
                    <option value="qris" {{ $paymentMethod === 'qris  ' ? 'selected' : '' }}>QRIS</option>
                </select>
            </div>
            <button type="submit" class="px-3 py-3 bg-slate-btn text-white rounded-8 text-sm font-semibold h-12 hover:bg-gray-600 transition">
                Filter
            </button>
        </form>

        {{-- Per Kategori --}}
        <div class="bg-white border border-light-border rounded-8 p-4 shadow-l1">
            <h2 class="font-bold text-deep-charcoal mb-3">Ringkasan per Kategori</h2>
            <table class="w-full text-sm">
                <thead class="bg-very-light-gray">
                    <tr>
                        <th class="text-left px-4 py-2 font-semibold text-deep-charcoal">Kategori</th>
                        <th class="text-right px-4 py-2 font-semibold text-deep-charcoal">Terjual</th>
                        <th class="text-right px-4 py-2 font-semibold text-deep-charcoal">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-light-border">
                    @foreach ($categorySummary as $cat)
                    <tr>
                        <td class="px-4 py-2 text-deep-charcoal">{{ $cat->name }}</td>
                        <td class="px-4 py-2 text-right text-deep-charcoal">{{ $cat->total_qty }}</td>
                        <td class="px-4 py-2 text-right text-deep-charcoal">Rp {{ number_format($cat->total_sales, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Per Item --}}
        <div class="bg-white border border-light-border rounded-8 p-4 shadow-l1">
            <h2 class="font-bold text-deep-charcoal mb-3">Ringkasan per Item</h2>
            <table class="w-full text-sm">
                <thead class="bg-very-light-gray">
                    <tr>
                        <th class="text-left px-4 py-2 font-semibold text-deep-charcoal">Item</th>
                        <th class="text-right px-4 py-2 font-semibold text-deep-charcoal">Terjual</th>
                        <th class="text-right px-4 py-2 font-semibold text-deep-charcoal">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-light-border">
                    @foreach ($itemSummary as $item)
                    <tr>
                        <td class="px-4 py-2 text-deep-charcoal">{{ $item->item_name }}</td>
                        <td class="px-4 py-2 text-right text-deep-charcoal">{{ $item->total_qty }}</td>
                        <td class="px-4 py-2 text-right text-deep-charcoal">Rp {{ number_format($item->total_sales, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Riwayat Transaksi --}}
        <div class="bg-white border border-light-border rounded-8 p-4 shadow-l1">
            <h2 class="font-bold text-deep-charcoal mb-3">Riwayat Transaksi</h2>
            @foreach ($transactions as $tx)
            <a href="/laporan/{{ $tx->id }}" class="flex justify-between items-center px-4 py-3 border-b border-light-border hover:bg-very-light-gray text-sm">
                <div>
                    <p class="font-semibold text-deep-charcoal">#{{ $tx->id }} — {{ $tx->payment_method === 'tunai' ? 'Tunai' : 'QRIS' }}</p>
                    <p class="text-zinc-text text-xs">{{ $tx->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="text-right">
                    <p class="font-semibold text-deep-charcoal">Rp {{ number_format($tx->total, 0, ',', '.') }}</p>
                </div>
            </a>
            @endforeach

            @if($transactions->count() == 0)
            <p class="text-light-gray text-center py-8">Tidak ada transaksi</p>
            @endif

            @if($transactions->count() > 0)
            <div class="flex justify-between items-center px-4 py-3 border-t border-light-border mt-2 pt-3">
                <p class="font-bold text-deep-charcoal">Total Transaksi</p>
                <p class="font-bold text-deep-charcoal">Rp {{ number_format($grandTotal, 0, ',', '.') }}</p>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
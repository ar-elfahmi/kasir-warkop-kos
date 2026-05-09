<x-app-layout>
    <div class="max-w-lg mx-auto p-4">
        <a href="/laporan" class="text-slate-btn text-sm mb-4 inline-block hover:text-deep-charcoal">&larr; Kembali</a>

        <div class="bg-white border border-light-border rounded-8 p-4 shadow-l1">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-lg font-bold text-deep-charcoal">Transaksi #{{ $transaction->id }}</h1>
                    <p class="text-zinc-text text-sm">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <span class="px-3 py-1 bg-very-light-gray text-slate-btn rounded-full text-sm font-medium">
                    {{ $transaction->payment_method === 'tunai' ? 'Tunai' : 'QRIS' }}
                </span>
            </div>

            <div class="border-t border-b border-light-border py-3 space-y-2 mb-4">
                @foreach ($transaction->items as $item)
                    <div class="flex justify-between text-sm">
                        <div>
                            <p class="font-semibold text-deep-charcoal">{{ $item->item_name }}</p>
                            <p class="text-xs text-zinc-text">{{ $item->variant_label }} x{{ $item->qty }}</p>
                        </div>
                        <p class="font-semibold text-deep-charcoal">Rp {{ number_format($item->total_price, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-between font-bold text-lg text-deep-charcoal mb-4">
                <span>Total</span>
                <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
            </div>

            <div class="text-sm text-zinc-text space-y-1">
                @if ($transaction->payment_method === 'tunai')
                    <p>Dibayar: Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</p>
                    <p class="font-medium text-success-green">Kembali: Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
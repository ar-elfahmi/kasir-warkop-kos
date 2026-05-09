<x-app-layout>
    <div class="max-w-lg mx-auto p-4">
        <div class="bg-white border border-light-border rounded-8 p-6 text-center shadow-l1">
            <div class="text-4xl mb-3">✔️</div>
            <h1 class="text-xl font-bold text-deep-charcoal mb-1">Pembayaran Berhasil</h1>
            <p class="text-zinc-text text-sm mb-6">Struk #{{ $transaction->id }}</p>

            <div class="border-t border-b border-light-border py-4 mb-4 text-left space-y-2">
                @foreach ($transaction->items as $item)
                    <div class="flex justify-between text-sm">
                        <div>
                            <p class="font-semibold text-deep-charcoal">{{ $item->item_name }}</p>
                            <p class="text-xs text-zinc-text">{{ $item->variant_label }} x{{ $item->qty }} @ Rp {{ number_format($item->unit_price, 0, ',', '.') }}</p>
                        </div>
                        <p class="font-semibold text-deep-charcoal">Rp {{ number_format($item->total_price, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-between font-bold text-lg text-deep-charcoal mb-4">
                <span>Total</span>
                <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
            </div>

            <div class="text-sm text-zinc-text space-y-1 mb-6">
                <p>Metode Bayar: {{ $transaction->payment_method === 'tunai' ? 'Tunai' : 'QRIS' }}</p>
                @if ($transaction->payment_method === 'tunai')
                    <p>Dibayar: Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</p>
                    <p class="font-medium text-success-green">Kembali: Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</p>
                @endif
            </div>

            <div class="text-xs text-light-gray mb-6">
                {{ $transaction->created_at->format('d/m/Y H:i') }}
            </div>

            <div class="flex gap-3">
                <a href="/pos" class="flex-1 px-3 py-3 bg-success-green text-white rounded-8 text-sm font-semibold h-12 inline-flex items-center justify-center hover:bg-green-700 transition">
                    Pesanan Baru
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
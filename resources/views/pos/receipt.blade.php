<x-app-layout>
    <div class="max-w-lg mx-auto p-4">
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <div class="text-4xl mb-3">✔️</div>
            <h1 class="text-xl font-bold mb-1">Pembayaran Berhasil</h1>
            <p class="text-gray-500 text-sm mb-6">Struk #{{ $transaction->id }}</p>

            <div class="border-t border-b py-4 mb-4 text-left space-y-2">
                @foreach ($transaction->items as $item)
                    <div class="flex justify-between text-sm">
                        <div>
                            <p class="font-medium">{{ $item->item_name }}</p>
                            <p class="text-xs text-gray-500">{{ $item->variant_label }} x{{ $item->qty }} @ Rp {{ number_format($item->unit_price, 0, ',', '.') }}</p>
                            @foreach ($item->toppings as $topping)
                                <p class="text-xs text-gray-400 ml-2">+ {{ $topping->topping_name }}</p>
                            @endforeach
                        </div>
                        <p class="font-medium">Rp {{ number_format($item->total_price, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-between font-bold text-lg mb-4">
                <span>Total</span>
                <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
            </div>

            <div class="text-sm text-gray-600 space-y-1 mb-6">
                <p>Metode Bayar: {{ $transaction->payment_method === 'tunai' ? 'Tunai' : 'QRIS' }}</p>
                @if ($transaction->payment_method === 'tunai')
                    <p>Dibayar: Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</p>
                    <p class="font-medium text-green-600">Kembali: Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</p>
                @endif
            </div>

            <div class="text-xs text-gray-400 mb-6">
                {{ $transaction->created_at->format('d/m/Y H:i') }}
            </div>

            <div class="flex gap-3">
                <a href="/pos" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium text-center">
                    Pesanan Baru
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

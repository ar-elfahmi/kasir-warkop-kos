<x-app-layout>
    <div class="max-w-lg mx-auto p-4">
        <a href="/laporan" class="text-blue-600 text-sm mb-4 inline-block">&larr; Kembali</a>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-lg font-bold">Transaksi #{{ $transaction->id }}</h1>
                    <p class="text-gray-500 text-sm">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                    {{ $transaction->payment_method === 'tunai' ? 'Tunai' : 'QRIS' }}
                </span>
            </div>

            <div class="border-t border-b py-3 space-y-2 mb-4">
                @foreach ($transaction->items as $item)
                    <div class="flex justify-between text-sm">
                        <div>
                            <p class="font-medium">{{ $item->item_name }}</p>
                            <p class="text-xs text-gray-500">{{ $item->variant_label }} x{{ $item->qty }}</p>
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

            <div class="text-sm text-gray-600 space-y-1">
                @if ($transaction->payment_method === 'tunai')
                    <p>Dibayar: Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</p>
                    <p class="font-medium text-green-600">Kembali: Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

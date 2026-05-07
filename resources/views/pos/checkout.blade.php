<x-app-layout>
    <div class="max-w-2xl mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">Pembayaran</h1>

        <div class="bg-white rounded-lg shadow p-4 mb-4">
            <h2 class="font-semibold mb-3">Ringkasan Pesanan</h2>
            @foreach ($cartItems as $key => $item)
                @php
                    $variant = \App\Models\Variant::find($item['variant_id']);
                    $itemName = $variant?->menuItem?->name ?? 'Item';
                    $sizeLabel = $variant?->size ? ucfirst($variant->size) : 'Reguler';
                    $subtotal = ($variant?->price ?? 0) * $item['qty'];
                    foreach ($item['toppings'] as $t) {
                        $subtotal += $t['price'] * $item['qty'];
                    }
                @endphp
                <div class="flex justify-between py-2 border-b text-sm">
                    <div>
                        <p class="font-medium">{{ $itemName }}</p>
                        <p class="text-gray-500 text-xs">{{ $sizeLabel }} x{{ $item['qty'] }}</p>
                        @if (!empty($item['toppings']))
                            <p class="text-xs text-gray-400">
                                @foreach ($item['toppings'] as $t)
                                    + {{ $t['name'] }}@if (!$loop->last), @endif
                                @endforeach
                            </p>
                        @endif
                    </div>
                    <p class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                </div>
            @endforeach
            <div class="flex justify-between font-bold text-lg pt-3">
                <span>Total</span>
                <span>Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
            </div>
        </div>

        <form method="POST" action="/pos/checkout/process" class="space-y-4">
            @csrf

            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="font-semibold mb-3">Metode Pembayaran</h2>
                <div class="space-y-2">
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer has-[:checked]:bg-blue-50 has-[:checked]:border-blue-500">
                        <input type="radio" name="payment_method" value="tunai" class="mr-3" checked>
                        <div>
                            <span class="font-medium">Tunai</span>
                            <p class="text-xs text-gray-500">Bayar dengan uang tunai</p>
                        </div>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer has-[:checked]:bg-blue-50 has-[:checked]:border-blue-500">
                        <input type="radio" name="payment_method" value="qris" class="mr-3">
                        <div>
                            <span class="font-medium">QRIS</span>
                            <p class="text-xs text-gray-500">Scan QRIS (offline)</p>
                        </div>
                    </label>
                </div>
                @error('payment_method')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div id="tunai-input" class="bg-white rounded-lg shadow p-4">
                <label class="block font-semibold mb-2">Jumlah Dibayar</label>
                <input type="number" name="paid_amount" id="paid_amount"
                    class="w-full border rounded-lg p-3 text-lg font-bold"
                    placeholder="Masukkan jumlah tunai" min="0">
                @error('paid_amount')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <div id="change-display" class="mt-3 text-right hidden">
                    <span class="text-gray-500">Kembali: </span>
                    <span class="font-bold text-lg" id="change-amount">Rp 0</span>
                </div>
            </div>

            @error('stock')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ $message }}
                </div>
            @enderror

            <button type="submit" class="w-full py-3 bg-blue-600 text-white font-bold rounded-lg text-lg">
                Bayar Sekarang
            </button>
        </form>
    </div>

    <script>
        const radioTunai = document.querySelector('input[value="tunai"]');
        const radioQris = document.querySelector('input[value="qris"]');
        const tunaiInput = document.getElementById('tunai-input');
        const paidInput = document.getElementById('paid_amount');
        const changeDisplay = document.getElementById('change-display');
        const changeAmount = document.getElementById('change-amount');
        const total = {{ $cartTotal }};

        function togglePayment() {
            if (radioQris.checked) {
                tunaiInput.classList.add('hidden');
            } else {
                tunaiInput.classList.remove('hidden');
            }
        }

        radioTunai.addEventListener('change', togglePayment);
        radioQris.addEventListener('change', togglePayment);

        paidInput.addEventListener('input', function() {
            const paid = parseInt(this.value) || 0;
            if (paid >= total) {
                changeDisplay.classList.remove('hidden');
                changeAmount.textContent = 'Rp ' + (paid - total).toLocaleString('id-ID');
            } else {
                changeDisplay.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>

<x-app-layout>
    <div class="flex flex-col lg:flex-row h-[calc(100vh-4rem)]">
        {{-- Menu Panel --}}
        <div class="flex-1 overflow-y-auto p-4 pb-32 lg:pb-4">
            {{-- Category Filter --}}
            <div class="flex gap-2 overflow-x-auto pb-3 mb-4" id="category-filter">
                <button class="category-btn px-3 py-1.5 rounded-full text-sm font-medium bg-slate-btn text-white whitespace-nowrap"
                    data-category="all">
                    Semua
                </button>
                @foreach ($categories as $category)
                    <button class="category-btn px-3 py-1.5 rounded-full text-sm font-medium bg-very-light-gray text-slate-btn hover:bg-light-border whitespace-nowrap"
                        data-category="{{ $category->id }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>

            {{-- Menu Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4" id="menu-grid">
                @foreach ($menuItems as $item)
                    <div class="menu-card bg-white border border-light-border rounded-8 shadow-l1 hover:shadow-l3 cursor-pointer transition-shadow"
                        data-category="{{ $item->category_id }}"
                        data-item="{{ $item->id }}">
                        <div class="p-3">
                            <h3 class="font-semibold text-base text-deep-charcoal mb-2">{{ $item->name }}</h3>
                            <div class="space-y-1">
                                @foreach ($item->variants as $variant)
                            <div class="variant-btn text-sm bg-very-light-gray rounded-6 p-2 border border-light-border hover:border-slate-btn {{ $item->stock <= 0 ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer' }}"
                                         data-variant-id="{{ $variant->id }}"
                                         data-variant-label="{{ $variant->size ? ucfirst($variant->size) : 'Reguler' }}"
                                         data-variant-price="{{ $variant->price }}"
                                         data-item-name="{{ $item->name }}"
                                         data-stock="{{ $item->stock }}">
                                         <span class="font-medium text-deep-charcoal">{{ $variant->size ? ucfirst($variant->size) : 'Reguler' }}</span>
                                         <span class="text-deep-charcoal font-semibold">Rp {{ number_format($variant->price, 0, ',', '.') }}</span>
                                         @if ($item->stock <= 0)
                                             <span class="block text-error-red font-medium mt-1 text-xs">Stok Habis</span>
                                         @elseif ($item->stock <= 5)
                                             <span class="block text-warning-red text-xs mt-1">Sisa {{ $item->stock }}</span>
                                         @endif
                                     </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Cart Panel --}}
        <div class="w-full lg:w-96 bg-white border-l border-light-border p-4 flex flex-col">
            <h2 class="text-lg font-bold text-deep-charcoal mb-3">Pesanan</h2>

            <div class="flex-1 overflow-y-auto space-y-2 mb-4">
                @forelse ($cartItems as $key => $item)
                    @php
                        $variant = \App\Models\Variant::find($item['variant_id']);
                        $itemName = $variant?->menuItem?->name ?? 'Item';
                        $sizeLabel = $variant?->size ? ucfirst($variant->size) : 'Reguler';
                        $subtotal = ($variant?->price ?? 0) * $item['qty'];
                    @endphp
                    <div class="bg-very-light-gray rounded-8 p-3 text-sm">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-semibold text-deep-charcoal">{{ $itemName }}</p>
                                <p class="text-zinc-text text-xs">{{ $sizeLabel }} x{{ $item['qty'] }}</p>
                            </div>
                            <div class="text-right flex-shrink-0 ml-2">
                                <p class="font-semibold text-deep-charcoal">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                                <form action="/pos/cart/remove" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="key" value="{{ $key }}">
                                    <button class="text-error-red text-xs hover:underline">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-light-gray text-center py-8">Belum ada pesanan</p>
                @endforelse
            </div>

            <div class="border-t border-light-border pt-3 space-y-3">
                <div class="flex justify-between text-lg font-bold text-deep-charcoal">
                    <span>Total</span>
                    <span>Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex gap-2">
                    @if (!empty($cartItems))
                        <form action="/pos/cart/clear" method="POST" class="flex-1">
                            @csrf
                            <button class="w-full px-3 py-3 bg-slate-btn text-white rounded-8 text-sm font-semibold h-12 hover:bg-gray-600 transition">
                                Hapus Semua
                            </button>
                        </form>
                    @endif
                    <a href="/pos/checkout"
                       class="flex-1 px-3 py-3 bg-success-green text-white rounded-8 text-sm font-semibold h-12 text-center flex items-center justify-center hover:bg-green-700 transition {{ empty($cartItems) ? 'opacity-50 pointer-events-none' : '' }}">
                        Bayar
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div id="item-modal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-8 max-w-md w-full p-5 shadow-l3">
            <h3 class="text-lg font-bold text-deep-charcoal mb-4" id="modal-item-name">Item</h3>

            <form id="add-to-cart-form" method="POST" action="/pos/cart/add">
                @csrf
                <input type="hidden" name="variant_id" id="modal-variant-id">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-btn mb-1">Jumlah</label>
                    <div class="flex items-center gap-3">
                        <button type="button" class="qty-btn w-10 h-10 rounded-full bg-very-light-gray text-lg font-bold text-slate-btn hover:bg-light-border" data-dir="-1">-</button>
                        <input type="number" name="qty" id="modal-qty" value="1" min="1" class="w-16 text-center text-lg font-bold border border-light-border rounded-6 text-deep-charcoal">
                        <button type="button" class="qty-btn w-10 h-10 rounded-full bg-very-light-gray text-lg font-bold text-slate-btn hover:bg-light-border" data-dir="1">+</button>
                    </div>
                </div>

                <div class="mb-4">

                <p class="text-lg font-bold text-deep-charcoal mb-4">
                    Rp <span id="modal-price">0</span>
                </p>

                <div class="flex gap-2">
                    <button type="button" id="modal-close" class="flex-1 px-3 py-3 bg-slate-btn text-white rounded-8 text-sm font-semibold h-12 hover:bg-gray-600 transition">Batal</button>
                    <button type="submit" class="flex-1 px-3 py-3 bg-success-green text-white rounded-8 text-sm font-semibold h-12 hover:bg-green-700 transition">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let selectedVariant = null;
        let basePrice = 0;

        document.querySelectorAll('.variant-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const stock = parseInt(this.dataset.stock || '0');
                if (stock <= 0) return;
                e.stopPropagation();
                selectedVariant = {
                    id: this.dataset.variantId,
                    label: this.dataset.variantLabel,
                    price: parseInt(this.dataset.variantPrice),
                };
                basePrice = selectedVariant.price;

                document.getElementById('modal-item-name').textContent =
                    this.dataset.itemName + ' - ' + selectedVariant.label;
                document.getElementById('modal-variant-id').value = selectedVariant.id;
                document.getElementById('modal-qty').value = 1;

                updatePrice();
                document.getElementById('item-modal').classList.remove('hidden');
                document.getElementById('item-modal').classList.add('flex');
            });
        });

        document.getElementById('item-modal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        document.getElementById('modal-close').addEventListener('click', closeModal);

        function closeModal() {
            document.getElementById('item-modal').classList.add('hidden');
            document.getElementById('item-modal').classList.remove('flex');
        }

        document.querySelectorAll('.qty-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const input = document.getElementById('modal-qty');
                let val = parseInt(input.value) || 1;
                val += parseInt(this.dataset.dir);
                if (val < 1) val = 1;
                input.value = val;
                updatePrice();
            });
        });

        document.getElementById('modal-qty').addEventListener('input', updatePrice);

        function updatePrice() {
            const qty = parseInt(document.getElementById('modal-qty').value) || 1;
            let total = basePrice * qty;
            document.getElementById('modal-price').textContent = total.toLocaleString('id-ID');
        }

        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.category-btn').forEach(b => {
                    b.classList.remove('bg-slate-btn', 'text-white');
                    b.classList.add('bg-very-light-gray', 'text-slate-btn');
                });
                this.classList.remove('bg-very-light-gray', 'text-slate-btn');
                this.classList.add('bg-slate-btn', 'text-white');

                const cat = this.dataset.category;
                document.querySelectorAll('.menu-card').forEach(card => {
                    if (cat === 'all' || card.dataset.category === cat) {
                        card.classList.remove('hidden');
                    } else {
                        card.classList.add('hidden');
                    }
                });
            });
        });

        document.getElementById('modal-qty').addEventListener('change', function() {
            if (parseInt(this.value) < 1) this.value = 1;
            updatePrice();
        });
    </script>
</x-app-layout>
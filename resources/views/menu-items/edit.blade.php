<x-app-layout>
    <div class="max-w-6xl mx-auto p-4">
        <h1 class="text-xl font-bold text-deep-charcoal mb-4">Edit Item: {{ $menuItem->name }}</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Edit Item Form --}}
            <div class="bg-white border border-light-border rounded-8 p-4 shadow-l1">
                <h2 class="font-semibold text-deep-charcoal mb-3">Detail Item</h2>
                <form method="POST" action="{{ route('menu-items.update', $menuItem->id) }}" class="space-y-4">
                    @csrf @method('PUT')

                    <div>
                        <label class="block font-medium text-sm text-slate-btn mb-1">Kategori</label>
                        <select name="category_id" class="w-full border border-light-border bg-very-light-gray rounded-6 p-3 h-12 text-deep-charcoal focus:border-slate-btn focus:ring-slate-btn">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $menuItem->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-error-red text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-slate-btn mb-1">Nama Item</label>
                        <input type="text" name="name" value="{{ old('name', $menuItem->name) }}"
                            class="w-full border border-light-border bg-very-light-gray rounded-6 p-3 h-12 text-deep-charcoal focus:border-slate-btn focus:ring-slate-btn">
                        @error('name')
                            <p class="text-error-red text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-slate-btn mb-1">Deskripsi</label>
                        <textarea name="description" class="w-full border border-light-border bg-very-light-gray rounded-6 p-3 text-deep-charcoal focus:border-slate-btn focus:ring-slate-btn" rows="2">{{ old('description', $menuItem->description) }}</textarea>
                        @error('description')
                            <p class="text-error-red text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-slate-btn mb-1">Stok</label>
                        <input type="number" name="stock" value="{{ old('stock', $menuItem->stock) }}"
                            class="w-full border border-light-border bg-very-light-gray rounded-6 p-3 h-12 text-deep-charcoal focus:border-slate-btn focus:ring-slate-btn" min="0" required>
                        @error('stock')
                            <p class="text-error-red text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full py-3 bg-success-green text-white font-semibold rounded-8 h-12 hover:bg-green-700 transition">
                        Update
                    </button>
                </form>
            </div>

            {{-- Manage Variants --}}
            <div class="bg-white border border-light-border rounded-8 p-4 shadow-l1">
                <h2 class="font-semibold text-deep-charcoal mb-3">Variant</h2>

                <div class="mb-4 p-3 bg-very-light-gray rounded-6">
                    <p class="text-sm text-slate-btn">Stok Saat Ini</p>
                    <p class="text-2xl font-bold text-deep-charcoal">{{ $menuItem->stock }}</p>
                </div>

                <table class="w-full text-sm mb-4">
                    <thead class="bg-very-light-gray">
                        <tr>
                            <th class="text-left px-3 py-2 font-semibold text-deep-charcoal">Nama Variant</th>
                            <th class="text-right px-3 py-2 font-semibold text-deep-charcoal">Harga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-light-border">
                        @forelse ($menuItem->variants as $variant)
                            <tr>
                                <td class="px-3 py-2 text-deep-charcoal">{{ $variant->size ? ucfirst($variant->size) : 'Reguler' }}</td>
                                <td class="px-3 py-2 text-right text-deep-charcoal">Rp {{ number_format($variant->price, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-3 py-4 text-center text-light-gray">
                                    Belum ada variant
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <h3 class="font-medium text-sm text-slate-btn mb-2">Tambah Variant Baru</h3>
                <form method="POST" action="{{ route('variants.store') }}" class="space-y-3">
                    @csrf
                    <input type="hidden" name="menu_item_id" value="{{ $menuItem->id }}">

                    <div>
                        <label class="block text-xs font-medium text-slate-btn mb-1">Ukuran (opsional)</label>
                        <input type="text" name="size" class="w-full border border-light-border bg-very-light-gray rounded-6 p-3 h-12 text-deep-charcoal text-sm focus:border-slate-btn focus:ring-slate-btn"
                            placeholder="besar/kecil">
                    </div>

                    <div class="flex gap-2">
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-slate-btn mb-1">Harga</label>
                            <input type="number" name="price" class="w-full border border-light-border bg-very-light-gray rounded-6 p-3 h-12 text-deep-charcoal text-sm focus:border-slate-btn focus:ring-slate-btn" min="0" required>
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-slate-btn mb-1">Stok</label>
                            <input type="number" name="stock" class="w-full border border-light-border bg-very-light-gray rounded-6 p-3 h-12 text-deep-charcoal text-sm focus:border-slate-btn focus:ring-slate-btn" min="0" required>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 bg-success-green text-white text-sm font-semibold rounded-8 h-12 hover:bg-green-700 transition">
                        + Tambah Variant
                    </button>
                </form>
            </div>

            {{-- Manage Toppings --}}
            <div class="bg-white border border-light-border rounded-8 p-4 shadow-l1 lg:col-span-2">
                <h2 class="font-semibold text-deep-charcoal mb-3">Topping</h2>

                @php
                    $assignedToppingIds = $menuItem->toppings->pluck('id')->toArray();
                    $allToppings = \App\Models\Topping::all();
                @endphp

                <form method="POST" action="{{ route('toppings.assign') }}" class="space-y-3">
                    @csrf
                    <input type="hidden" name="menu_item_id" value="{{ $menuItem->id }}">

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                        @forelse ($allToppings as $topping)
                            <label class="flex items-center gap-2 p-2 bg-very-light-gray rounded-6 cursor-pointer text-sm">
                                <input type="checkbox" name="topping_ids[]" value="{{ $topping->id }}"
                                    {{ in_array($topping->id, $assignedToppingIds) ? 'checked' : '' }}
                                    class="rounded border-light-border text-slate-btn">
                                <span class="text-deep-charcoal">{{ $topping->name }} (+Rp {{ number_format($topping->price, 0, ',', '.') }})</span>
                            </label>
                        @empty
                            <p class="text-light-gray col-span-full text-center py-4">
                                Belum ada topping. Buat topping dulu.
                            </p>
                        @endforelse
                    </div>

                    @if ($allToppings->isNotEmpty())
                        <button type="submit" class="px-3 py-3 bg-slate-btn text-white text-sm font-semibold rounded-8 h-12 hover:bg-gray-600 transition">
                            Simpan Pengaturan Topping
                        </button>
                    @endif
                </form>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('menu-items.index') }}" class="text-sm text-slate-btn hover:text-deep-charcoal">
                &larr; Kembali ke daftar menu
            </a>
        </div>
    </div>
</x-app-layout>
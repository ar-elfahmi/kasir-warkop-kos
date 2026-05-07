<x-app-layout>
    <div class="max-w-6xl mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">Edit Item: {{ $menuItem->name }}</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Edit Item Form --}}
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="font-semibold mb-3">Detail Item</h2>
                <form method="POST" action="{{ route('menu-items.update', $menuItem->id) }}" class="space-y-4">
                    @csrf @method('PUT')

                    <div>
                        <label class="block font-medium text-sm mb-1">Kategori</label>
                        <select name="category_id" class="w-full border rounded-lg p-2">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $menuItem->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm mb-1">Nama Item</label>
                        <input type="text" name="name" value="{{ old('name', $menuItem->name) }}"
                            class="w-full border rounded-lg p-2">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm mb-1">Deskripsi</label>
                        <textarea name="description" class="w-full border rounded-lg p-2" rows="2">{{ old('description', $menuItem->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full py-2 bg-blue-600 text-white font-medium rounded-lg">
                        Update
                    </button>
                </form>
            </div>

            {{-- Manage Variants --}}
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="font-semibold mb-3">Variant</h2>

                <table class="w-full text-sm mb-4">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left px-3 py-2 font-medium">Nama</th>
                            <th class="text-right px-3 py-2 font-medium">Harga</th>
                            <th class="text-right px-3 py-2 font-medium">Stok</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($menuItem->variants as $variant)
                            <tr>
                                <td class="px-3 py-2">{{ $variant->size ? ucfirst($variant->size) : 'Reguler' }}</td>
                                <td class="px-3 py-2 text-right">Rp {{ number_format($variant->price, 0, ',', '.') }}</td>
                                <td class="px-3 py-2 text-right">{{ $variant->stock }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-3 py-4 text-center text-gray-400">
                                    Belum ada variant
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <h3 class="font-medium text-sm mb-2">Tambah Variant Baru</h3>
                <form method="POST" action="{{ route('variants.store') }}" class="space-y-3">
                    @csrf
                    <input type="hidden" name="menu_item_id" value="{{ $menuItem->id }}">

                    <div>
                        <label class="block text-xs font-medium mb-1">Ukuran (opsional)</label>
                        <input type="text" name="size" class="w-full border rounded-lg p-2 text-sm"
                            placeholder="besar/kecil">
                    </div>

                    <div class="flex gap-2">
                        <div class="flex-1">
                            <label class="block text-xs font-medium mb-1">Harga</label>
                            <input type="number" name="price" class="w-full border rounded-lg p-2 text-sm" min="0" required>
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-medium mb-1">Stok</label>
                            <input type="number" name="stock" class="w-full border rounded-lg p-2 text-sm" min="0" required>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-2 bg-green-600 text-white text-sm font-medium rounded-lg">
                        + Tambah Variant
                    </button>
                </form>
            </div>

            {{-- Manage Toppings --}}
            <div class="bg-white rounded-lg shadow p-4 lg:col-span-2">
                <h2 class="font-semibold mb-3">Topping</h2>

                @php
                    $assignedToppingIds = $menuItem->toppings->pluck('id')->toArray();
                    $allToppings = \App\Models\Topping::all();
                @endphp

                <form method="POST" action="{{ route('toppings.assign') }}" class="space-y-3">
                    @csrf
                    <input type="hidden" name="menu_item_id" value="{{ $menuItem->id }}">

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                        @forelse ($allToppings as $topping)
                            <label class="flex items-center gap-2 p-2 bg-gray-50 rounded cursor-pointer text-sm">
                                <input type="checkbox" name="topping_ids[]" value="{{ $topping->id }}"
                                    {{ in_array($topping->id, $assignedToppingIds) ? 'checked' : '' }}
                                    class="rounded">
                                <span>{{ $topping->name }} (+Rp {{ number_format($topping->price, 0, ',', '.') }})</span>
                            </label>
                        @empty
                            <p class="text-gray-400 col-span-full text-center py-4">
                                Belum ada topping. Buat topping dulu.
                            </p>
                        @endforelse
                    </div>

                    @if ($allToppings->isNotEmpty())
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg">
                            Simpan Pengaturan Topping
                        </button>
                    @endif
                </form>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('menu-items.index') }}" class="text-sm text-blue-600 hover:underline">
                &larr; Kembali ke daftar menu
            </a>
        </div>
    </div>
</x-app-layout>

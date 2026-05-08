<x-app-layout>
    <div class="max-w-lg mx-auto p-4">
        <h1 class="text-xl font-bold text-deep-charcoal mb-4">Tambah Item Menu</h1>

        <form method="POST" action="{{ route('menu-items.store') }}" class="bg-white border border-light-border rounded-8 p-4 space-y-4 shadow-l1">
            @csrf

            <div>
                <label class="block font-medium text-sm text-slate-btn mb-1">Kategori</label>
                <select name="category_id" class="w-full border border-light-border bg-very-light-gray rounded-6 p-3 h-12 text-deep-charcoal focus:border-slate-btn focus:ring-slate-btn">
                    <option value="">Pilih kategori...</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border border-light-border bg-very-light-gray rounded-6 p-3 h-12 text-deep-charcoal focus:border-slate-btn focus:ring-slate-btn" placeholder="Contoh: Kopi Susu">
                @error('name')
                    <p class="text-error-red text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium text-sm text-slate-btn mb-1">Deskripsi (opsional)</label>
                <textarea name="description" class="w-full border border-light-border bg-very-light-gray rounded-6 p-3 text-deep-charcoal focus:border-slate-btn focus:ring-slate-btn" rows="2" placeholder="Deskripsi item...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-error-red text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium text-sm text-slate-btn mb-1">Stok Awal</label>
                <input type="number" name="stock" value="{{ old('stock', 0) }}"
                    class="w-full border border-light-border bg-very-light-gray rounded-6 p-3 h-12 text-deep-charcoal focus:border-slate-btn focus:ring-slate-btn" min="0" required>
                @error('stock')
                    <p class="text-error-red text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full py-3 bg-success-green text-white font-semibold rounded-8 h-12 hover:bg-green-700 transition">
                Simpan
            </button>
        </form>
    </div>
</x-app-layout>
<x-app-layout>
    <div class="max-w-lg mx-auto p-4">
        <h1 class="text-xl font-bold text-deep-charcoal mb-4">Tambah Stok</h1>

        <form method="POST" action="/stock/restock" class="bg-white border border-light-border rounded-8 p-4 space-y-4 shadow-l1">
            @csrf

            <div>
                <label class="block font-medium text-sm text-slate-btn mb-1">Item</label>
                <select name="menu_item_id" class="w-full border border-light-border bg-very-light-gray rounded-6 p-3 h-12 text-deep-charcoal focus:border-slate-btn focus:ring-slate-btn">
                    <option value="">Pilih item...</option>
                    @foreach ($menuItems as $item)
                        <option value="{{ $item->id }}" {{ old('menu_item_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->name }} (stok: {{ $item->stock }})
                        </option>
                    @endforeach
                </select>
                @error('menu_item_id')
                    <p class="text-error-red text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium text-sm text-slate-btn mb-1">Jumlah</label>
                <input type="number" name="quantity" value="{{ old('quantity') }}"
                    class="w-full border border-light-border bg-very-light-gray rounded-6 p-3 h-12 text-deep-charcoal focus:border-slate-btn focus:ring-slate-btn" min="1">
                @error('quantity')
                    <p class="text-error-red text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium text-sm text-slate-btn mb-1">Catatan (opsional)</label>
                <input type="text" name="note" value="{{ old('note') }}"
                    class="w-full border border-light-border bg-very-light-gray rounded-6 p-3 h-12 text-deep-charcoal focus:border-slate-btn focus:ring-slate-btn" placeholder="Misal: dari supplier">
                @error('note')
                    <p class="text-error-red text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full py-3 bg-success-green text-white font-semibold rounded-8 h-12 hover:bg-green-700 transition">
                Simpan
            </button>
        </form>
    </div>
</x-app-layout>
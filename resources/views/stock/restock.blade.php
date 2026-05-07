<x-app-layout>
    <div class="max-w-lg mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">Tambah Stok</h1>

        <form method="POST" action="/stock/restock" class="bg-white rounded-lg shadow p-4 space-y-4">
            @csrf

            <div>
                <label class="block font-medium text-sm mb-1">Item</label>
                <select name="variant_id" class="w-full border rounded-lg p-2">
                    <option value="">Pilih item...</option>
                    @foreach ($variants as $variant)
                        <option value="{{ $variant->id }}" {{ old('variant_id') == $variant->id ? 'selected' : '' }}>
                            {{ $variant->menuItem?->name ?? '—' }} — {{ $variant->size ? ucfirst($variant->size) : 'Reguler' }} (stok: {{ $variant->stock }})
                        </option>
                    @endforeach
                </select>
                @error('variant_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium text-sm mb-1">Jumlah</label>
                <input type="number" name="quantity" value="{{ old('quantity') }}"
                    class="w-full border rounded-lg p-2" min="1">
                @error('quantity')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium text-sm mb-1">Catatan (opsional)</label>
                <input type="text" name="note" value="{{ old('note') }}"
                    class="w-full border rounded-lg p-2" placeholder="Misal: dari supplier">
                @error('note')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full py-2 bg-blue-600 text-white font-medium rounded-lg">
                Simpan
            </button>
        </form>
    </div>
</x-app-layout>

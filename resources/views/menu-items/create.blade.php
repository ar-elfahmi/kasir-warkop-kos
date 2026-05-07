<x-app-layout>
    <div class="max-w-lg mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">Tambah Item Menu</h1>

        <form method="POST" action="{{ route('menu-items.store') }}" class="bg-white rounded-lg shadow p-4 space-y-4">
            @csrf

            <div>
                <label class="block font-medium text-sm mb-1">Kategori</label>
                <select name="category_id" class="w-full border rounded-lg p-2">
                    <option value="">Pilih kategori...</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border rounded-lg p-2" placeholder="Contoh: Kopi Susu">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium text-sm mb-1">Deskripsi (opsional)</label>
                <textarea name="description" class="w-full border rounded-lg p-2" rows="2" placeholder="Deskripsi item...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full py-2 bg-blue-600 text-white font-medium rounded-lg">
                Simpan
            </button>
        </form>
    </div>
</x-app-layout>

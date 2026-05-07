<x-app-layout>
    <div class="max-w-lg mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">Tambah Topping</h1>

        <form method="POST" action="{{ route('toppings.store') }}" class="bg-white rounded-lg shadow p-4 space-y-4">
            @csrf

            <div>
                <label class="block font-medium text-sm mb-1">Nama Topping</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border rounded-lg p-2" placeholder="Contoh: Telur">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium text-sm mb-1">Harga Tambahan</label>
                <input type="number" name="price" value="{{ old('price') }}"
                    class="w-full border rounded-lg p-2" min="0" placeholder="Contoh: 3000">
                @error('price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full py-2 bg-blue-600 text-white font-medium rounded-lg">
                Simpan
            </button>
        </form>

        <div class="mt-4">
            <a href="{{ route('toppings.index') }}" class="text-sm text-blue-600 hover:underline">
                &larr; Kembali
            </a>
        </div>
    </div>
</x-app-layout>

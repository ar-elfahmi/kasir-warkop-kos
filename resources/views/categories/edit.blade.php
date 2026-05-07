<x-app-layout>
    <div class="max-w-lg mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">Edit Kategori</h1>

        <form method="POST" action="{{ route('categories.update', $category->id) }}" class="bg-white rounded-lg shadow p-4 space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block font-medium text-sm mb-1">Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}"
                    class="w-full border rounded-lg p-2">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full py-2 bg-blue-600 text-white font-medium rounded-lg">
                Update
            </button>
        </form>

        <div class="mt-4">
            <a href="{{ route('categories.index') }}" class="text-sm text-blue-600 hover:underline">
                &larr; Kembali
            </a>
        </div>
    </div>
</x-app-layout>

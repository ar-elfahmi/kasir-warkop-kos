<x-app-layout>
    <div class="max-w-lg mx-auto p-4">
        <h1 class="text-xl font-bold text-deep-charcoal mb-4">Tambah Kategori</h1>

        <form method="POST" action="{{ route('categories.store') }}" class="bg-white border border-light-border rounded-8 p-4 space-y-4 shadow-l1">
            @csrf

            <div>
                <label class="block font-medium text-sm text-slate-btn mb-1">Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border border-light-border bg-very-light-gray rounded-6 p-3 h-12 text-deep-charcoal focus:border-slate-btn focus:ring-slate-btn" placeholder="Contoh: Minuman">
                @error('name')
                    <p class="text-error-red text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full py-3 bg-success-green text-white font-semibold rounded-8 h-12 hover:bg-green-700 transition">
                Simpan
            </button>
        </form>

        <div class="mt-4">
            <a href="{{ route('categories.index') }}" class="text-sm text-slate-btn hover:text-deep-charcoal">
                &larr; Kembali
            </a>
        </div>
    </div>
</x-app-layout>
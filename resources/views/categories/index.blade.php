<x-app-layout>
    <div class="max-w-2xl mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold text-deep-charcoal">Kategori</h1>
            <a href="{{ route('categories.create') }}" class="px-3 py-3 bg-success-green text-white rounded-8 text-sm font-semibold h-12 inline-flex items-center hover:bg-green-700 transition">
                + Tambah Kategori
            </a>
        </div>

        <div class="bg-white border border-light-border rounded-8 overflow-hidden shadow-l1">
            <table class="w-full text-sm">
                <thead class="bg-very-light-gray">
                    <tr>
                        <th class="text-left px-4 py-3 font-semibold text-deep-charcoal">Nama</th>
                        <th class="text-center px-4 py-3 font-semibold text-deep-charcoal">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-light-border">
                    @foreach ($categories as $category)
                        <tr>
                            <td class="px-4 py-3 text-deep-charcoal">{{ $category->name }}</td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex gap-1 justify-center">
                                    <a href="{{ route('categories.edit', $category->id) }}"
                                        class="px-2 py-1 text-xs bg-very-light-gray text-slate-btn rounded-6 hover:bg-light-border">
                                        Edit
                                    </a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus kategori {{ $category->name }}?')">
                                        @csrf @method('DELETE')
                                        <button class="px-2 py-1 text-xs bg-red-50 text-error-red rounded-6 hover:bg-red-100">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <a href="{{ route('menu-items.index') }}" class="text-sm text-slate-btn hover:text-deep-charcoal">
                &larr; Kembali ke menu
            </a>
        </div>
    </div>
</x-app-layout>
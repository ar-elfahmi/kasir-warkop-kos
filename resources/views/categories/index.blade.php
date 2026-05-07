<x-app-layout>
    <div class="max-w-2xl mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">Kategori</h1>
            <a href="{{ route('categories.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">
                + Tambah Kategori
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left px-4 py-3 font-medium">Nama</th>
                        <th class="text-center px-4 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($categories as $category)
                        <tr>
                            <td class="px-4 py-3">{{ $category->name }}</td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex gap-1 justify-center">
                                    <a href="{{ route('categories.edit', $category->id) }}"
                                        class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200">
                                        Edit
                                    </a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus kategori {{ $category->name }}?')">
                                        @csrf @method('DELETE')
                                        <button class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded hover:bg-red-200">
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
            <a href="{{ route('menu-items.index') }}" class="text-sm text-blue-600 hover:underline">
                &larr; Kembali ke menu
            </a>
        </div>
    </div>
</x-app-layout>

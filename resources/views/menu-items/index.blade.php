<x-app-layout>
    <div class="max-w-6xl mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">Menu</h1>
            <a href="{{ route('menu-items.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">
                + Tambah Item
            </a>
        </div>

        @foreach ($menuItems->groupBy(fn($i) => $i->category?->name ?? 'Tanpa Kategori') as $categoryName => $items)
            <div class="mb-6">
                <h2 class="text-lg font-bold mb-3">{{ $categoryName }}</h2>
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left px-4 py-3 font-medium">Nama</th>
                                <th class="text-left px-4 py-3 font-medium">Variant</th>
                                <th class="text-right px-4 py-3 font-medium">Harga</th>
                                <th class="text-right px-4 py-3 font-medium">Stok</th>
                                <th class="text-center px-4 py-3 font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($items as $item)
                                @foreach ($item->variants as $i => $variant)
                                    <tr>
                                        @if ($i === 0)
                                            <td class="px-4 py-3 font-medium" rowspan="{{ max(1, $item->variants->count()) }}">
                                                {{ $item->name }}
                                                @if ($item->description)
                                                    <p class="text-xs text-gray-400 font-normal">{{ $item->description }}</p>
                                                @endif
                                            </td>
                                        @endif
                                        <td class="px-4 py-3">{{ $variant->size ? ucfirst($variant->size) : 'Reguler' }}</td>
                                        <td class="px-4 py-3 text-right">Rp {{ number_format($variant->price, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-right {{ $variant->stock <= 5 ? 'text-red-600 font-bold' : '' }}">
                                            {{ $variant->stock }}
                                        </td>
                                        @if ($i === 0)
                                            <td class="px-4 py-3 text-center" rowspan="{{ max(1, $item->variants->count()) }}">
                                                <div class="flex gap-1 justify-center">
                                                    <a href="{{ route('menu-items.edit', $item->id) }}"
                                                        class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('menu-items.destroy', $item->id) }}" method="POST"
                                                        onsubmit="return confirm('Hapus item {{ $item->name }}?')">
                                                        @csrf @method('DELETE')
                                                        <button class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded hover:bg-red-200">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach

        <div class="flex gap-3 mt-8">
            <a href="{{ route('categories.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium">
                Kelola Kategori
            </a>
            <a href="{{ route('toppings.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium">
                Kelola Topping
            </a>
        </div>
    </div>
</x-app-layout>

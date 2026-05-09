<x-app-layout>
    <div class="max-w-6xl mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold text-deep-charcoal">Menu</h1>
            <a href="{{ route('menu-items.create') }}" class="px-3 py-3 bg-success-green text-white rounded-8 text-sm font-semibold h-12 inline-flex items-center hover:bg-green-700 transition">
                + Tambah Item
            </a>
        </div>

        @foreach ($menuItems->groupBy(fn($i) => $i->category?->name ?? 'Tanpa Kategori') as $categoryName => $items)
            <div class="mb-6">
                <h2 class="text-lg font-bold text-deep-charcoal mb-3">{{ $categoryName }}</h2>
                <div class="bg-white border border-light-border rounded-8 overflow-hidden shadow-l1">
                    <table class="w-full text-sm">
                        <thead class="bg-very-light-gray">
                            <tr>
                                <th class="text-left px-4 py-3 font-semibold text-deep-charcoal">Nama</th>
                                <th class="text-left px-4 py-3 font-semibold text-deep-charcoal">Variant</th>
                                <th class="text-right px-4 py-3 font-semibold text-deep-charcoal">Harga</th>
                                <th class="text-right px-4 py-3 font-semibold text-deep-charcoal">Stok</th>
                                <th class="text-center px-4 py-3 font-semibold text-deep-charcoal">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-light-border">
                            @foreach ($items as $item)
                                @foreach ($item->variants as $i => $variant)
                                    <tr>
                                        @if ($i === 0)
                                            <td class="px-4 py-3 font-semibold text-deep-charcoal" rowspan="{{ max(1, $item->variants->count()) }}">
                                                {{ $item->name }}
                                                @if ($item->description)
                                                    <p class="text-xs text-light-gray font-normal">{{ $item->description }}</p>
                                                @endif
                                            </td>
                                        @endif
                                        <td class="px-4 py-3 text-deep-charcoal">{{ $variant->size ? ucfirst($variant->size) : 'Reguler' }}</td>
                                        <td class="px-4 py-3 text-right text-deep-charcoal">Rp {{ number_format($variant->price, 0, ',', '.') }}</td>
                                        @if ($i === 0)
                                            <td class="px-4 py-3 text-right {{ $item->stock <= 5 ? 'text-error-red font-bold' : 'text-deep-charcoal' }}" rowspan="{{ max(1, $item->variants->count()) }}">
                                                {{ $item->stock }}
                                            </td>
                                            <td class="px-4 py-3 text-center" rowspan="{{ max(1, $item->variants->count()) }}">
                                                <div class="flex gap-1 justify-center">
                                                    <a href="{{ route('menu-items.edit', $item->id) }}"
                                                        class="px-2 py-1 text-xs bg-very-light-gray text-slate-btn rounded-6 hover:bg-light-border">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('menu-items.destroy', $item->id) }}" method="POST"
                                                        onsubmit="return confirm('Hapus item {{ $item->name }}?')">
                                                        @csrf @method('DELETE')
                                                        <button class="px-2 py-1 text-xs bg-red-50 text-error-red rounded-6 hover:bg-red-100">
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
            <a href="{{ route('categories.index') }}" class="px-3 py-3 bg-slate-btn text-white rounded-8 text-sm font-semibold h-12 inline-flex items-center hover:bg-gray-600 transition">
                Kelola Kategori
            </a>
        </div>
    </div>
</x-app-layout>
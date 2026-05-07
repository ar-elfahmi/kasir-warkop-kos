<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $todayTotal = \App\Models\Transaction::whereDate('created_at', today())->sum('total');
                $todayCount = \App\Models\Transaction::whereDate('created_at', today())->count();
                $todayItems = \App\Models\TransactionItem::whereHas('transaction', fn($q) => $q->whereDate('created_at', today()))->sum('qty');
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-gray-500 text-sm">Penjualan Hari Ini</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($todayTotal, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-gray-500 text-sm">Transaksi Hari Ini</p>
                    <p class="text-2xl font-bold">{{ $todayCount }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-gray-500 text-sm">Item Terjual</p>
                    <p class="text-2xl font-bold">{{ $todayItems }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="font-semibold text-lg mb-3">Aksi Cepat</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <a href="{{ route('pos.index') }}" class="px-4 py-3 bg-blue-600 text-white rounded-lg text-center text-sm font-medium">
                            POS Kasir
                        </a>
                        <a href="{{ route('menu-items.index') }}" class="px-4 py-3 bg-green-600 text-white rounded-lg text-center text-sm font-medium">
                            Atur Menu
                        </a>
                        <a href="{{ route('stock.restock') }}" class="px-4 py-3 bg-yellow-600 text-white rounded-lg text-center text-sm font-medium">
                            Restok
                        </a>
                        <a href="{{ route('laporan.index') }}" class="px-4 py-3 bg-purple-600 text-white rounded-lg text-center text-sm font-medium">
                            Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-deep-charcoal leading-tight">
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
                <div class="bg-white shadow-l1 rounded-8 p-6">
                    <p class="text-medium-gray text-sm">Penjualan Hari Ini</p>
                    <p class="text-2xl font-bold text-deep-charcoal">Rp {{ number_format($todayTotal, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white shadow-l1 rounded-8 p-6">
                    <p class="text-medium-gray text-sm">Transaksi Hari Ini</p>
                    <p class="text-2xl font-bold text-deep-charcoal">{{ $todayCount }}</p>
                </div>
                <div class="bg-white shadow-l1 rounded-8 p-6">
                    <p class="text-medium-gray text-sm">Item Terjual</p>
                    <p class="text-2xl font-bold text-deep-charcoal">{{ $todayItems }}</p>
                </div>
            </div>

            <div class="bg-white shadow-l1 rounded-8">
                <div class="p-6">
                    <h3 class="font-semibold text-lg text-deep-charcoal mb-3">Aksi Cepat</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <a href="{{ route('pos.index') }}" class="px-4 py-3 bg-slate-btn text-white rounded-8 text-center text-sm font-semibold hover:bg-gray-600 transition">
                            POS Kasir
                        </a>
                        <a href="{{ route('menu-items.index') }}" class="px-4 py-3 bg-success-green text-white rounded-8 text-center text-sm font-semibold hover:bg-green-700 transition">
                            Atur Menu
                        </a>
                        <a href="{{ route('stock.restock') }}" class="px-4 py-3 bg-slate-btn text-white rounded-8 text-center text-sm font-semibold hover:bg-gray-600 transition">
                            Restok
                        </a>
                        <a href="{{ route('laporan.index') }}" class="px-4 py-3 bg-slate-btn text-white rounded-8 text-center text-sm font-semibold hover:bg-gray-600 transition">
                            Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
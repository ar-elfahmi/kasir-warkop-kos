<x-app-layout>
    <div class="max-w-2xl mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">Pengaturan</h1>

        <div class="grid grid-cols-1 gap-6">
            {{-- App Info --}}
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="font-semibold mb-2">Aplikasi</h2>
                <p class="text-sm text-gray-500">Nama Warung</p>
                <p class="font-medium">{{ config('app.name', 'Warkop Kos') }}</p>
            </div>

            {{-- Change Password --}}
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="font-semibold mb-3">Ganti Password</h2>
                <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                    @csrf @method('PUT')

                    <div>
                        <label class="block font-medium text-sm mb-1">Password Saat Ini</label>
                        <input type="password" name="current_password" class="w-full border rounded-lg p-2">
                        @error('current_password', 'updatePassword')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm mb-1">Password Baru</label>
                        <input type="password" name="password" class="w-full border rounded-lg p-2">
                        @error('password', 'updatePassword')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="w-full border rounded-lg p-2">
                    </div>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg">
                        Ganti Password
                    </button>
                </form>
            </div>

            {{-- Quick Links --}}
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="font-semibold mb-3">Menu Lainnya</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <a href="{{ route('toppings.index') }}" class="px-4 py-3 bg-gray-100 rounded-lg text-sm font-medium hover:bg-gray-200">
                        Kelola Topping
                    </a>
                    <a href="{{ route('categories.index') }}" class="px-4 py-3 bg-gray-100 rounded-lg text-sm font-medium hover:bg-gray-200">
                        Kelola Kategori
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

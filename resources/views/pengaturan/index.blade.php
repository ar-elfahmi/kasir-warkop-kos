<x-app-layout>
    <div class="max-w-2xl mx-auto p-4">
        <h1 class="text-xl font-bold text-deep-charcoal mb-4">Pengaturan</h1>

        <div class="grid grid-cols-1 gap-6">
            {{-- App Info --}}
            <div class="bg-white border border-light-border rounded-8 p-4 shadow-l1">
                <h2 class="font-semibold text-deep-charcoal mb-2">Aplikasi</h2>
                <p class="text-sm text-zinc-text">Nama Warung</p>
                <p class="font-semibold text-deep-charcoal">{{ config('app.name', 'Warkop Kos') }}</p>
            </div>

            {{-- Change Password --}}
            <div class="bg-white border border-light-border rounded-8 p-4 shadow-l1">
                <h2 class="font-semibold text-deep-charcoal mb-3">Ganti Password</h2>
                <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                    @csrf @method('PUT')

                    <div>
                        <label class="block font-medium text-sm text-slate-btn mb-1">Password Saat Ini</label>
                        <input type="password" name="current_password" class="w-full border border-light-border bg-very-light-gray rounded-6 p-3 h-12 text-deep-charcoal focus:border-slate-btn focus:ring-slate-btn">
                        @error('current_password', 'updatePassword')
                            <p class="text-error-red text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-slate-btn mb-1">Password Baru</label>
                        <input type="password" name="password" class="w-full border border-light-border bg-very-light-gray rounded-6 p-3 h-12 text-deep-charcoal focus:border-slate-btn focus:ring-slate-btn">
                        @error('password', 'updatePassword')
                            <p class="text-error-red text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-slate-btn mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="w-full border border-light-border bg-very-light-gray rounded-6 p-3 h-12 text-deep-charcoal focus:border-slate-btn focus:ring-slate-btn">
                    </div>

                    <button type="submit" class="px-3 py-3 bg-slate-btn text-white text-sm font-semibold rounded-8 h-12 hover:bg-gray-600 transition">
                        Ganti Password
                    </button>
                </form>
            </div>

            {{-- Quick Links --}}
            <div class="bg-white border border-light-border rounded-8 p-4 shadow-l1">
                <h2 class="font-semibold text-deep-charcoal mb-3">Menu Lainnya</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <a href="{{ route('categories.index') }}" class="px-4 py-3 bg-very-light-gray rounded-8 text-sm font-semibold text-slate-btn hover:bg-light-border transition">
                        Kelola Kategori
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
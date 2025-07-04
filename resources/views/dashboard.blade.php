<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-900 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-pink-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Welcome Box --}}
            <div class="bg-white rounded-2xl shadow border-l-4 border-pink-400 p-6 flex items-center gap-4">
                <img src="https://cdn-icons-png.flaticon.com/512/4205/4205352.png" class="w-14 h-14" alt="Welcome">
                <div>
                    <h3 class="text-pink-900 text-xl font-bold mb-1">🎉 Selamat datang!</h3>
                    <p class="text-sm text-pink-700">Sistem Arsip Surat — semangat mengelola surat dengan rapi dan teratur 💌</p>
                </div>
            </div>

            {{-- Shortcut Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-pink-100 rounded-xl p-5 text-center shadow hover:shadow-lg transition">
                    <div class="text-3xl font-bold text-pink-900">📥</div>
                    <p class="mt-2 font-medium text-pink-800">Kelola Surat Masuk</p>
                </div>
                <div class="bg-pink-100 rounded-xl p-5 text-center shadow hover:shadow-lg transition">
                    <div class="text-3xl font-bold text-pink-900">📤</div>
                    <p class="mt-2 font-medium text-pink-800">Kelola Surat Keluar</p>
                </div>
                <div class="bg-pink-100 rounded-xl p-5 text-center shadow hover:shadow-lg transition">
                    <div class="text-3xl font-bold text-pink-900">📂</div>
                    <p class="mt-2 font-medium text-pink-800">Jenis Surat</p>
                </div>
                <div class="bg-pink-100 rounded-xl p-5 text-center shadow hover:shadow-lg transition">
                    <div class="text-3xl font-bold text-pink-900">👥</div>
                    <p class="mt-2 font-medium text-pink-800">Pengguna Aktif</p>
                </div>
            </div>

            {{-- Quote Box --}}
            <div class="bg-white rounded-xl shadow p-4 text-center border-t-2 border-pink-300 italic text-pink-700 text-sm">
                “Setiap arsip punya cerita, dan kamu yang merapikannya ✨”
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-pink-900">
            {{ __('Daftar User') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-pink-50">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Notifikasi Sukses --}}
            @if(session('success'))
            <div class="p-4 bg-green-100 text-green-800 border border-green-300 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
            @endif

            {{-- Form Pencarian --}}
            <form method="GET" action="{{ route('user.index') }}" class="mb-4">
                <div class="flex flex-col sm:flex-row items-center gap-3">
                    <div class="relative w-full sm:w-[400px]">
                        <input type="text" name="q" placeholder="Cari nama atau email..." value="{{ request('q') }}"
                            class="w-full px-4 py-2 pl-10 rounded-lg border border-pink-300 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-400 bg-white placeholder-pink-400" />
                        <div class="absolute left-3 top-2.5 text-pink-400 text-sm">🔍</div>
                    </div>
                    <button type="submit"
                        class="px-4 py-2 bg-pink-600 hover:bg-pink-700 text-white rounded-lg text-sm font-semibold shadow transition">
                        Cari
                    </button>
                </div>
            </form>

            {{-- Tabel User --}}
            <div class="overflow-x-auto rounded-xl shadow bg-white border border-pink-300">
                <table class="min-w-full text-sm table-fixed border-separate border-spacing-0">
                    <thead class="bg-pink-100 text-pink-800 uppercase font-semibold">
                        <tr>
                            <th class="px-4 py-3 border-b-2 border-pink-500 text-left">NO</th>
                            <th class="px-4 py-3 border-b-2 border-pink-500 text-left">NAMA</th>
                            <th class="px-4 py-3 border-b-2 border-pink-500 text-left">EMAIL</th>
                            <th class="px-4 py-3 border-b-2 border-pink-500 text-left">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800">
                        @forelse ($users as $index => $user)
                        <tr class="border-b border-pink-200 hover:bg-pink-50 transition">
                            <td class="px-4 py-3 border-r border-pink-200">{{ $index + $users->firstItem() }}</td>
                            <td class="px-4 py-3 border-r border-pink-200">{{ $user->name }}</td>
                            <td class="px-4 py-3 border-r border-pink-200">{{ $user->email }}</td>
                            <td class="px-4 py-3">
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus user ini?');"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:underline text-sm">🗑️ Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center px-4 py-4 text-sm text-gray-500 bg-pink-100 border-t border-pink-300">
                                Tidak ada data user.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $users->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
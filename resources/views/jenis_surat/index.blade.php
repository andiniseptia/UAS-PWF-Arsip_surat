<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-900 leading-tight">
            {{ __('Data Jenis Surat') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-pink-50">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- TOMBOL TAMBAH -->
            <div class="flex justify-between items-center">
                <a href="{{ route('jenis_surat.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-pink-600 hover:bg-pink-700 text-white text-sm font-semibold rounded-lg shadow transition">
                    ➕ Tambah Jenis Surat
                </a>
            </div>

            <!-- FORM CARI -->
            <form action="{{ route('jenis_surat.index') }}" method="GET" class="mb-4">
                <div class="flex flex-col sm:flex-row items-center gap-3">
                    <div class="relative w-full sm:w-[400px]">
                        <input type="text" name="q" placeholder="Cari kode atau keterangan surat..."
                            value="{{ request('q') }}"
                            class="w-full px-4 py-2 pl-10 rounded-lg border border-pink-300 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-400 bg-white placeholder-pink-400" />
                        <div class="absolute left-3 top-2.5 text-pink-400 text-sm">🔍</div>
                    </div>
                    <button type="submit"
                        class="px-4 py-2 bg-pink-600 hover:bg-pink-700 text-white rounded-lg text-sm font-semibold shadow transition-all">
                        Cari
                    </button>
                </div>
            </form>

            <!-- TABEL DATA -->
            <div class="overflow-x-auto rounded-xl shadow bg-white border border-pink-300">
                <table class="min-w-full text-sm table-fixed border-separate border-spacing-0">
                    <thead class="bg-pink-100 text-pink-800 uppercase font-semibold">
                        <tr>
                            <th class="px-4 py-3 border-b-2 border-pink-500 text-left">NO</th>
                            <th class="px-4 py-3 border-b-2 border-pink-500 text-left">KODE SURAT</th>
                            <th class="px-4 py-3 border-b-2 border-pink-500 text-left">KETERANGAN</th>
                            <th class="px-4 py-3 border-b-2 border-pink-500 text-left">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800">
                        @forelse ($jenisSurats as $index => $item)
                        <tr class="border-b border-pink-200 hover:bg-pink-50 transition">
                            <td class="px-4 py-3 border-r border-pink-200">{{ $index + $jenisSurats->firstItem() }}</td>
                            <td class="px-4 py-3 border-r border-pink-200">{{ $item->kodeSurat }}</td>
                            <td class="px-4 py-3 border-r border-pink-200">{{ $item->keterangan }}</td>
                            <td class="px-4 py-3">
                                <div class="flex space-x-3">
                                    <a href="{{ route('jenis_surat.edit', $item->id) }}"
                                        class="text-yellow-500 hover:underline">✏️ Edit</a>
                                    <form action="{{ route('jenis_surat.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">🗑️ Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-500">Tidak ada data yang cocok.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINASI -->
            <div class="mt-6">
                {{ $jenisSurats->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
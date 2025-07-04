<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-900 leading-tight">
            {{ __('Data Surat Masuk') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-pink-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Tombol Tambah -->
            <div>
                <a href="{{ route('surat_masuk.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-pink-600 hover:bg-pink-700 text-white text-sm font-semibold rounded-lg shadow transition">
                    ➕ Tambah Surat Masuk
                </a>
            </div>

            <!-- Form Pencarian -->
            <form action="{{ route('surat_masuk.index') }}" method="GET">
                <div class="flex flex-col sm:flex-row items-center gap-3">
                    <div class="relative w-full sm:w-[400px]">
                        <input type="text" name="search" placeholder="Cari no surat, pengirim, jenis..."
                            value="{{ request('search') }}"
                            class="w-full px-4 py-2 pl-10 rounded-lg border border-pink-300 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-400 bg-white placeholder-pink-400" />
                        <div class="absolute left-3 top-2.5 text-pink-400 text-sm">🔍</div>
                    </div>
                    <button type="submit"
                        class="px-4 py-2 bg-pink-600 hover:bg-pink-700 text-white rounded-lg text-sm font-semibold shadow transition-all">
                        Cari
                    </button>
                </div>
            </form>

            <!-- Tabel -->
            <div class="overflow-x-auto rounded-xl shadow bg-white border border-pink-300">
                <table class="min-w-full text-sm border-separate border-spacing-0">
                    <thead class="bg-pink-100 text-pink-900 uppercase font-semibold">
                        <tr>
                            <th class="px-4 py-3 border-b-2 border-pink-500 text-left">No</th>
                            <th class="px-4 py-3 border-b-2 border-pink-500 text-left">No Surat Masuk</th>
                            <th class="px-4 py-3 border-b-2 border-pink-500 text-left">Tanggal</th>
                            <th class="px-4 py-3 border-b-2 border-pink-500 text-left">Pengirim</th>
                            <th class="px-4 py-3 border-b-2 border-pink-500 text-left">Jenis Surat</th>
                            <th class="px-4 py-3 border-b-2 border-pink-500 text-left">File</th>
                            <th class="px-4 py-3 border-b-2 border-pink-500 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800">
                        @forelse ($suratMasuk as $index => $item)
                        <tr class="border-b border-pink-200 hover:bg-pink-50 transition">
                            <td class="px-4 py-3 text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">{{ $item->no_surat_masuk }}</td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d-m-Y') }}</td>
                            <td class="px-4 py-3">{{ $item->pengirim }}</td>
                            <td class="px-4 py-3">{{ optional($item->jenisSurat)->keterangan }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('surat_masuk.download', $item->id_surat_masuk) }}" class="text-indigo-600 hover:underline">📄 Lihat</a>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex space-x-2">
                                    <a href="{{ route('surat_masuk.edit', $item->id_surat_masuk) }}" class="text-yellow-600 hover:underline">✏️ Edit</a>
                                    <form action="{{ route('surat_masuk.destroy', $item->id_surat_masuk) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">🗑️ Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-4 text-center text-pink-800 bg-pink-100 font-medium">
                                Tidak ada data yang cocok.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginasi -->
            <div class="mt-6">
                {{ $suratMasuk->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
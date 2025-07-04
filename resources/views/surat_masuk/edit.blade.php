<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-pink-700 leading-tight flex items-center gap-2">
            <img src="https://img.icons8.com/emoji/48/000000/envelope-emoji.png" class="w-6 h-6" alt="Mail Icon" />
            Edit Surat Masuk
        </h2>
    </x-slot>

    <div class="py-12 bg-pink-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-pink-200 rounded-xl shadow-md px-4 sm:px-8 md:px-12 py-10">

                {{-- Notifikasi error --}}
                @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                    <strong class="font-bold">Oops!</strong> Ada kesalahan:
                    <ul class="list-disc pl-5 mt-2 text-sm">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('surat_masuk.update', $suratMasuk->id_surat_masuk) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nomor Surat --}}
                        <div class="px-1">
                            <label for="no_surat_masuk" class="block text-sm font-semibold text-pink-700 mb-1">Mailing Number</label>
                            <input type="text" name="no_surat_masuk" id="no_surat_masuk"
                                value="{{ old('no_surat_masuk', $suratMasuk->no_surat_masuk) }}"
                                class="w-full rounded-lg border border-pink-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                        </div>

                        {{-- Tanggal Masuk --}}
                        <div class="px-1">
                            <label for="tanggal_masuk" class="block text-sm font-semibold text-pink-700 mb-1">Entry Date</label>
                            <input type="date" name="tanggal_masuk" id="tanggal_masuk"
                                value="{{ old('tanggal_masuk', $suratMasuk->tanggal_masuk) }}"
                                class="w-full rounded-lg border border-pink-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                        </div>

                        {{-- Pengirim --}}
                        <div class="px-1">
                            <label for="pengirim" class="block text-sm font-semibold text-pink-700 mb-1">Sender</label>
                            <input type="text" name="pengirim" id="pengirim"
                                value="{{ old('pengirim', $suratMasuk->pengirim) }}"
                                class="w-full rounded-lg border border-pink-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                        </div>

                        {{-- Jenis Surat --}}
                        <div class="px-1">
                            <label for="jenis_surat_id" class="block text-sm font-semibold text-pink-700 mb-1">Letter Type</label>
                            <select name="jenis_surat_id" id="jenis_surat_id"
                                class="w-full rounded-lg border border-pink-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                                <option value="">-- Pilih Jenis Surat --</option>
                                @foreach($jenisSurat as $jenis)
                                <option value="{{ $jenis->id }}"
                                    {{ old('jenis_surat_id', $suratMasuk->jenis_surat_id) == $jenis->id ? 'selected' : '' }}>
                                    {{ $jenis->keterangan }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- File --}}
                    <div class="mt-6 px-1">
                        <label for="file" class="block text-sm font-semibold text-pink-700 mb-1">New Files (PDF, DOC)</label>
                        <p class="text-sm text-gray-700 mb-2">
                            File saat ini: <a href="{{ route('surat_masuk.download', $suratMasuk->id_surat_masuk) }}"
                                class="text-indigo-500 underline hover:text-indigo-700">Unduh File Saat Ini</a>
                        </p>
                        <input type="file" name="file" id="file"
                            class="w-full text-sm text-gray-900 border border-pink-300 rounded-lg cursor-pointer bg-pink-100 focus:outline-none focus:ring-pink-500 focus:border-pink-500">
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end gap-4 mt-8 px-1">
                        <a href="{{ route('surat_masuk.index') }}"
                            class="px-5 py-2 rounded-md bg-gray-400 hover:bg-gray-500 text-white font-semibold text-sm shadow">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-5 py-2 rounded-md bg-pink-600 hover:bg-pink-700 text-white font-semibold text-sm shadow">
                            Perbarui
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
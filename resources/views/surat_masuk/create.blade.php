<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-pink-700 leading-tight flex items-center gap-2">
            <img src="https://img.icons8.com/emoji/48/000000/envelope-emoji.png" class="w-6 h-6" alt="Mail Icon" />
            Tambah Surat Masuk
        </h2>
    </x-slot>

    <div class="py-12 bg-pink-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-pink-200 rounded-xl shadow-md p-8">

                {{-- Alert error --}}
                @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <strong class="font-bold">Oops!</strong> Ada masalah dengan input:
                    <ul class="list-disc pl-5 mt-2 text-sm">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('surat_masuk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nomor Surat --}}
                        <div>
                            <label for="no_surat_masuk" class="block text-sm font-semibold text-pink-700 mb-1">Nomor Surat</label>
                            <input type="text" name="no_surat_masuk" id="no_surat_masuk" value="{{ old('no_surat_masuk') }}"
                                class="w-full rounded-lg border border-pink-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                        </div>

                        {{-- Tanggal Masuk --}}
                        <div>
                            <label for="tanggal_masuk" class="block text-sm font-semibold text-pink-700 mb-1">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" id="tanggal_masuk" value="{{ old('tanggal_masuk') }}"
                                class="w-full rounded-lg border border-pink-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                        </div>

                        {{-- Pengirim --}}
                        <div>
                            <label for="pengirim" class="block text-sm font-semibold text-pink-700 mb-1">Pengirim</label>
                            <input type="text" name="pengirim" id="pengirim" value="{{ old('pengirim') }}"
                                class="w-full rounded-lg border border-pink-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                        </div>

                        {{-- Jenis Surat --}}
                        <div>
                            <label for="jenis_surat_id" class="block text-sm font-semibold text-pink-700 mb-1">Jenis Surat</label>
                            <select name="jenis_surat_id" id="jenis_surat_id"
                                class="w-full rounded-lg border border-pink-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                                <option value="">-- Pilih Jenis Surat --</option>
                                @foreach($jenisSurat as $jenis)
                                <option value="{{ $jenis->id }}" {{ old('jenis_surat_id') == $jenis->id ? 'selected' : '' }}>
                                    {{ $jenis->keterangan }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Upload File --}}
                    <div class="mt-6">
                        <label for="file" class="block text-sm font-semibold text-pink-700 mb-1">Unggah File (PDF, DOC)</label>
                        <input type="file" name="file" id="file"
                            class="w-full text-sm text-gray-900 border border-pink-300 rounded-lg cursor-pointer bg-pink-100 focus:outline-none focus:ring-pink-500 focus:border-pink-500" required>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end gap-4 mt-8">
                        <a href="{{ route('surat_masuk.index') }}"
                            class="px-5 py-2 rounded-md bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold text-sm shadow">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-5 py-2 rounded-md bg-pink-600 hover:bg-pink-700 text-white font-semibold text-sm shadow">
                            Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
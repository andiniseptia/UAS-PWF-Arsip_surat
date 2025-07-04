<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Surat Keluar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-pink-50 dark:bg-pink-200 overflow-hidden shadow-md rounded-xl border border-pink-300">
                <div class="p-6 text-gray-900 dark:text-gray-800">

                    {{-- Menampilkan error validasi jika ada --}}
                    @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Oops!</strong>
                        <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
                        <ul class="list-disc pl-5 mt-2">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('surat_keluar.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="no_surat_keluar" class="block text-sm font-medium text-pink-800">Nomor Surat</label>
                            <input type="text" name="no_surat_keluar" id="no_surat_keluar" value="{{ old('no_surat_keluar') }}"
                                class="mt-1 block w-full rounded-xl border-pink-300 bg-white shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                        </div>

                        <div class="mb-4">
                            <label for="tanggal_keluar" class="block text-sm font-medium text-pink-800">Tanggal Keluar</label>
                            <input type="date" name="tanggal_keluar" id="tanggal_keluar" value="{{ old('tanggal_keluar') }}"
                                class="mt-1 block w-full rounded-xl border-pink-300 bg-white shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                        </div>

                        <div class="mb-4">
                            <label for="tujuan" class="block text-sm font-medium text-pink-800">Tujuan</label>
                            <input type="text" name="tujuan" id="tujuan" value="{{ old('tujuan') }}"
                                class="mt-1 block w-full rounded-xl border-pink-300 bg-white shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                        </div>

                        <div class="mb-4">
                            <label for="jenis_surat_id" class="block text-sm font-medium text-pink-800">Jenis Surat</label>
                            <select name="jenis_surat_id" id="jenis_surat_id"
                                class="mt-1 block w-full rounded-xl border-pink-300 bg-white shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                                <option value="">-- Pilih Jenis Surat --</option>
                                @foreach($jenisSurat as $jenis)
                                <option value="{{ $jenis->id }}" {{ old('jenis_surat_id') == $jenis->id ? 'selected' : '' }}>
                                    {{ $jenis->keterangan }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="file" class="block text-sm font-medium text-pink-800">Upload File (PDF, Doc)</label>
                            <input type="file" name="file" id="file"
                                class="mt-1 block w-full text-sm border border-pink-300 bg-white rounded-xl shadow-sm focus:outline-none focus:border-pink-500 focus:ring-pink-500" required>
                        </div>

                        {{-- Tombol aksi --}}
                        <div class="flex items-center justify-end mt-6 gap-x-4">
                            <a href="{{ route('surat_keluar.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 text-white border border-gray-700 rounded-xl font-semibold text-xs uppercase tracking-widest hover:bg-gray-700 transition duration-150">
                                Batal
                            </a>

                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-900 text-white rounded-xl font-semibold text-xs uppercase tracking-widest hover:bg-black focus:ring-2 focus:ring-pink-300 transition duration-150">
                                Simpan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
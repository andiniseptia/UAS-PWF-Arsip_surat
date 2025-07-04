<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-pink-900">
            {{ __('Tambah Jenis Surat') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-pink-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ERROR MESSAGE --}}
            @if($errors->any())
            <div class="p-4 bg-red-100 text-red-800 border border-red-300 rounded-lg shadow-sm">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- FORM TAMBAH --}}
            <div class="bg-white border border-pink-300 rounded-xl shadow-md p-6">
                <form action="{{ route('jenis_surat.store') }}" method="POST">
                    @csrf

                    {{-- KODE SURAT --}}
                    <div class="mb-5">
                        <label for="kodeSurat" class="block font-medium text-sm text-pink-900 mb-1">Kode Surat</label>
                        <input type="text" id="kodeSurat" name="kodeSurat"
                            class="w-full px-4 py-2 border border-pink-300 rounded-lg shadow-sm focus:ring-2 focus:ring-pink-400 focus:outline-none bg-white text-sm text-gray-800"
                            value="{{ old('kodeSurat') }}" required>
                    </div>

                    {{-- KETERANGAN --}}
                    <div class="mb-6">
                        <label for="keterangan" class="block font-medium text-sm text-pink-900 mb-1">Keterangan</label>
                        <input type="text" id="keterangan" name="keterangan"
                            class="w-full px-4 py-2 border border-pink-300 rounded-lg shadow-sm focus:ring-2 focus:ring-pink-400 focus:outline-none bg-white text-sm text-gray-800"
                            value="{{ old('keterangan') }}" required>
                    </div>

                    {{-- TOMBOL --}}
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('jenis_surat.index') }}"
                            class="inline-flex items-center px-5 py-2 bg-pink-100 text-pink-800 border border-pink-300 rounded-lg font-medium text-sm hover:bg-pink-200 transition">
                            ⬅️ Kembali
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-5 py-2 bg-pink-600 text-white rounded-lg font-semibold text-sm hover:bg-pink-700 transition focus:outline-none focus:ring-2 focus:ring-pink-400">
                            💾 Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
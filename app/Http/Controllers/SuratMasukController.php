<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\SuratMasuk;
use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    /**
     * Menampilkan daftar surat masuk beserta statistik.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = SuratMasuk::with('jenisSurat');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('no_surat_masuk', 'like', "%{$search}%")
                    ->orWhere('pengirim', 'like', "%{$search}%")
                    ->orWhereHas('jenisSurat', function ($subq) use ($search) {
                        $subq->where('keterangan', 'like', "%{$search}%");
                    });
            });
        }

        $suratMasuk = $query->orderBy('tanggal_masuk', 'desc')->paginate(10);

        // Statistik
        $totalSurat = SuratMasuk::count();
        $suratKeputusan = SuratMasuk::whereHas('jenisSurat', function ($q) {
            $q->where('keterangan', 'like', '%keputusan%');
        })->count();

        return view('surat_masuk.index', compact('suratMasuk', 'totalSurat', 'suratKeputusan'));
    }

    /**
     * Menampilkan form tambah surat masuk.
     */
    public function create()
    {
        $jenisSurat = JenisSurat::all();
        return view('surat_masuk.create', compact('jenisSurat'));
    }

    /**
     * Menyimpan data surat masuk baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_surat_masuk' => 'required|unique:surat_masuk',
            'tanggal_masuk'  => 'required|date',
            'pengirim'       => 'required',
            'file'           => 'required|file|mimes:pdf,doc,docx|max:10240',
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
        ]);

        $file = $request->file('file')->store('surat_masuk', 'public');

        SuratMasuk::create([
            'no_surat_masuk' => $request->no_surat_masuk,
            'tanggal_masuk'  => $request->tanggal_masuk,
            'pengirim'       => $request->pengirim,
            'file'           => $file,
            'jenis_surat_id' => $request->jenis_surat_id,
        ]);

        return redirect()->route('surat_masuk.index')->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit surat masuk.
     */
    public function edit($id)
    {
        $suratMasuk = SuratMasuk::findOrFail($id);
        $jenisSurat = JenisSurat::all();
        return view('surat_masuk.edit', compact('suratMasuk', 'jenisSurat'));
    }

    /**
     * Menyimpan perubahan data surat masuk.
     */
    public function update(Request $request, $id)
    {
        $suratMasuk = SuratMasuk::findOrFail($id);

        $request->validate([
            'no_surat_masuk' => 'required|unique:surat_masuk,no_surat_masuk,' . $id . ',id_surat_masuk',
            'tanggal_masuk'  => 'required|date',
            'pengirim'       => 'required',
            'file'           => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
        ]);

        $file = $suratMasuk->file;

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($suratMasuk->file);
            $file = $request->file('file')->store('surat_masuk', 'public');
        }

        $suratMasuk->update([
            'no_surat_masuk' => $request->no_surat_masuk,
            'tanggal_masuk'  => $request->tanggal_masuk,
            'pengirim'       => $request->pengirim,
            'file'           => $file,
            'jenis_surat_id' => $request->jenis_surat_id,
        ]);

        return redirect()->route('surat_masuk.index')->with('success', 'Surat masuk berhasil diperbarui.');
    }

    /**
     * Mengunduh file surat masuk.
     */
    public function download($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        $pathToFile = storage_path('app/public/' . $surat->file);
        $extension = pathinfo($pathToFile, PATHINFO_EXTENSION);
        $newFilename = 'surat-' . Str::slug($surat->pengirim) . '-' . $surat->tanggal_masuk . '.' . $extension;
        $headers = ['Content-Type' => mime_content_type($pathToFile)];
        return response()->download($pathToFile, $newFilename, $headers);
    }

    /**
     * Menghapus surat masuk.
     */
    public function destroy($id)
    {
        $suratMasuk = SuratMasuk::findOrFail($id);

        Storage::disk('public')->delete($suratMasuk->file);
        $suratMasuk->delete();

        return redirect()->route('surat_masuk.index')->with('success', 'Surat masuk berhasil dihapus.');
    }
}

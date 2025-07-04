<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\SuratKeluar;
use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = SuratKeluar::with('jenisSurat');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('no_surat_keluar', 'like', "%{$search}%")
                  ->orWhere('tujuan', 'like', "%{$search}%")
                  ->orWhereHas('jenisSurat', function($subq) use ($search) {
                      $subq->where('keterangan', 'like', "%{$search}%");
                  });
            });
        }

        $suratKeluar = $query->orderBy('tanggal_keluar', 'desc')->paginate(10);

        return view('surat_keluar.index', compact('suratKeluar'));
    }

    public function create()
    {
        $jenisSurat = JenisSurat::all();
        return view('surat_keluar.create', compact('jenisSurat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_surat_keluar' => 'required|unique:surat_keluar,no_surat_keluar',
            'tanggal_keluar'  => 'required|date',
            'tujuan'          => 'required',
            'file'            => 'required|file|mimes:pdf,doc,docx|max:10240',
            'jenis_surat_id'  => 'required|exists:jenis_surat,id',
        ]);

        $filePath = $request->file('file')->store('surat_keluar', 'public');

        SuratKeluar::create([
            'no_surat_keluar' => $request->no_surat_keluar,
            'tanggal_keluar'  => $request->tanggal_keluar,
            'tujuan'          => $request->tujuan,
            'file'            => $filePath,
            'jenis_surat_id'  => $request->jenis_surat_id,
        ]);

        return redirect()->route('surat_keluar.index')->with('success', 'Surat keluar berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $suratKeluar = SuratKeluar::findOrFail($id);
        $jenisSurat = JenisSurat::all();
        return view('surat_keluar.edit', compact('suratKeluar', 'jenisSurat'));
    }

    public function update(Request $request, $id)
    {
        $suratKeluar = SuratKeluar::findOrFail($id);

        $request->validate([
            'no_surat_keluar' => 'required|unique:surat_keluar,no_surat_keluar,' . $id . ',id_surat_keluar',
            'tanggal_keluar'  => 'required|date',
            'tujuan'          => 'required',
            'file'            => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'jenis_surat_id'  => 'required|exists:jenis_surat,id',
        ]);

        $filePath = $suratKeluar->file;

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($suratKeluar->file);
            $filePath = $request->file('file')->store('surat_keluar', 'public');
        }

        $suratKeluar->update([
            'no_surat_keluar' => $request->no_surat_keluar,
            'tanggal_keluar'  => $request->tanggal_keluar,
            'tujuan'          => $request->tujuan,
            'file'            => $filePath,
            'jenis_surat_id'  => $request->jenis_surat_id,
        ]);

        return redirect()->route('surat_keluar.index')->with('success', 'Surat keluar berhasil diperbarui.');
    }

    public function download($id)
    {
        $surat = SuratKeluar::findOrFail($id);
        $pathToFile = storage_path('app/public/' . $surat->file);
        $newFilename = 'surat-' . Str::slug($surat->tujuan) . '-' . $surat->tanggal_keluar . '.' . pathinfo($pathToFile, PATHINFO_EXTENSION);
        return response()->download($pathToFile, $newFilename, [
            'Content-Type' => mime_content_type($pathToFile),
        ]);
    }

    public function destroy($id)
    {
        $suratKeluar = SuratKeluar::findOrFail($id);
        Storage::disk('public')->delete($suratKeluar->file);
        $suratKeluar->delete();

        return redirect()->route('surat_keluar.index')->with('success', 'Surat keluar berhasil dihapus.');
    }
}

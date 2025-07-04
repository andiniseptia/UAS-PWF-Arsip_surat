<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use Illuminate\Http\Request;

class JenisSuratController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        $jenisSurats = JenisSurat::when($query, function ($qbuilder) use ($query) {
            $qbuilder->where('keterangan', 'like', "%{$query}%")
                ->orWhere('kodeSurat', 'like', "%{$query}%");
        })->paginate(10);

        return view('jenis_surat.index', compact('jenisSurats'));
    }

    public function create()
    {
        return view('jenis_surat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kodeSurat' => 'required|unique:jenis_surat,kodeSurat',
            'keterangan' => 'required|string|max:255',
        ]);

        JenisSurat::create([
            'kodeSurat' => strtoupper($request->kodeSurat),
            'keterangan' => ucfirst($request->keterangan),
        ]);

        return redirect()->route('jenis_surat.index')->with('success', 'Jenis surat berhasil ditambahkan.');
    }

    public function edit(JenisSurat $jenisSurat)
    {
        return view('jenis_surat.edit', compact('jenisSurat'));
    }

    public function update(Request $request, JenisSurat $jenisSurat)
    {
        $request->validate([
            'kodeSurat' => 'required|unique:jenis_surat,kodeSurat,' . $jenisSurat->id,
            'keterangan' => 'required|string|max:255',
        ]);

        $jenisSurat->update([
            'kodeSurat' => strtoupper($request->kodeSurat),
            'keterangan' => ucfirst($request->keterangan),
        ]);

        return redirect()->route('jenis_surat.index')->with('success', 'Jenis surat berhasil diupdate.');
    }

    public function destroy(JenisSurat $jenisSurat)
    {
        $jenisSurat->delete();

        return redirect()->route('jenis_surat.index')->with('success', 'Jenis surat berhasil dihapus.');
    }
}

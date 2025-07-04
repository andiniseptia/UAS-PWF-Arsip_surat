@extends('layouts.app')

@section('title', 'Surat Keluar')

@section('content')
<h2>Daftar Surat Keluar</h2>
<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>No</th>
            <th>Nomor Surat</th>
            <th>Tanggal</th>
            <th>Tujuan</th>
            <th>Perihal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <!-- Contoh baris -->
        <tr>
            <td>1</td>
            <td>SK-001</td>
            <td>2025-06-18</td>
            <td>Sekolah ABC</td>
            <td>Permohonan Data</td>
            <td><button class="btn btn-sm btn-info">Lihat</button></td>
        </tr>
    </tbody>
</table>
@endsection

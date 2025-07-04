@extends('layouts.app')

@section('title', 'Surat Masuk')

@section('content')
<h2>Daftar Surat Masuk</h2>
<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>No</th>
            <th>Nomor Surat</th>
            <th>Tanggal</th>
            <th>Pengirim</th>
            <th>Perihal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <!-- Contoh baris -->
        <tr>
            <td>1</td>
            <td>SM-001</td>
            <td>2025-06-19</td>
            <td>Dinas Pendidikan</td>
            <td>Undangan Rapat</td>
            <td><button class="btn btn-sm btn-info">Lihat</button></td>
        </tr>
    </tbody>
</table>
@endsection

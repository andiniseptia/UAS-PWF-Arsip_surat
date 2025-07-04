<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\JenisSurat;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahSuratMasuk = SuratMasuk::count();
        $jumlahSuratKeluar = SuratKeluar::count();
        $jumlahJenisSurat = JenisSurat::count();
        $jumlahUser = User::count();

        return view('dashboard', compact(
            'jumlahSuratMasuk',
            'jumlahSuratKeluar',
            'jumlahJenisSurat',
            'jumlahUser'
        ));
    }
}

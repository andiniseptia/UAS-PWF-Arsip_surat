<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\JenisSuratController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 🔁 Ubah route dashboard ke controller
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // 📁 Download file surat
    Route::get('/surat-masuk/{id}/download', [SuratMasukController::class, 'download'])->name('surat_masuk.download');
    Route::get('/surat-keluar/{id}/download', [SuratKeluarController::class, 'download'])->name('surat_keluar.download');

    // 👤 Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

 // 📨 Jenis Surat
    Route::resource('jenis_surat', JenisSuratController::class);
    Route::get('/jenis_surat', [JenisSuratController::class, 'index'])->name('jenis_surat.index');

    // 📬 Surat Masuk
    Route::resource('surat_masuk', SuratMasukController::class);
    Route::get('/surat_masuk', [SuratMasukController::class, 'index'])->name('surat_masuk.index');

    // 📤 Surat Keluar
    Route::resource('surat_keluar', SuratKeluarController::class);
    Route::get('/surat_keluar', [SuratKeluarController::class, 'index'])->name('surat_keluar.index');

    // 👥 Users
    Route::resource('user', UserController::class);
});

require __DIR__ . '/auth.php';

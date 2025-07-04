<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\JenisSurat;
use App\Models\SuratKeluar;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Auth\Authenticatable;

class SuratKeluarCreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function halaman_form_tambah_surat_keluar_bisa_diakses_user_login(): void
    {
        /** @var Authenticatable $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('surat_keluar.create'));

        $response->assertStatus(200);
        $response->assertSeeText('Tambah Surat Keluar');
    }

    /** @test */
    public function user_dapat_menyimpan_data_surat_keluar_dengan_file(): void
    {
        Storage::fake('public');

        /** @var Authenticatable $user */
        $user = User::factory()->create();
        $jenis = JenisSurat::factory()->create([
            'kodeSurat' => 'KS-001', // ❗ Pastikan kolom wajib diisi di sini
        ]);

        $noSurat = 'SK-' . now()->format('YmdHis') . '-' . uniqid();

        $response = $this->actingAs($user)->post(route('surat_keluar.store'), [
            'no_surat_keluar' => $noSurat,
            'tanggal_keluar'  => now()->format('Y-m-d'),
            'tujuan'          => 'Universitas ABC',
            'jenis_surat_id'  => $jenis->id,
            'file'            => UploadedFile::fake()->create('surat.pdf', 100, 'application/pdf'),
        ]);

        $response->assertRedirect(route('surat_keluar.index'));

        $this->assertDatabaseHas('surat_keluar', [
            'no_surat_keluar' => $noSurat,
            'tujuan'          => 'Universitas ABC',
            'jenis_surat_id'  => $jenis->id,
        ]);

        // Pakai id_surat_keluar karena tidak ada created_at
        $latest = SuratKeluar::orderByDesc('id_surat_keluar')->first();

        $this->assertTrue(Storage::disk('public')->exists($latest->file));
    }

    /** @test */
    public function validasi_gagal_jika_input_kosong(): void
    {
        /** @var Authenticatable $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('surat_keluar.store'), []);

        $response->assertSessionHasErrors([
            'no_surat_keluar',
            'tanggal_keluar',
            'tujuan',
            'jenis_surat_id',
            'file',
        ]);
    }
}

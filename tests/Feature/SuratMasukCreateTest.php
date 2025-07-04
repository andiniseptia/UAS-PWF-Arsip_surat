<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\JenisSurat;
use App\Models\SuratMasuk;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class SuratMasukCreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function halaman_tambah_surat_masuk_dapat_diakses_user_login(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('surat_masuk.create'));

        $response->assertStatus(200);
        $response->assertSeeText('Tambah Surat Masuk');
    }

    /** @test */
    public function user_bisa_menyimpan_surat_masuk_dengan_data_valid(): void
    {
        Storage::fake('public');

        /** @var User $user */
        $user = User::factory()->create();

        $jenis = JenisSurat::factory()->create();

        $file = UploadedFile::fake()->create('surat.pdf', 100, 'application/pdf');

        $response = $this->actingAs($user)->post(route('surat_masuk.store'), [
            'no_surat_masuk' => 'SM-2025',
            'tanggal_masuk' => now()->format('Y-m-d'),
            'pengirim' => 'Dinas Pendidikan',
            'jenis_surat_id' => $jenis->id,
            'file' => $file,
        ]);

        $response->assertRedirect(route('surat_masuk.index'));

        $this->assertDatabaseHas('surat_masuk', [
            'no_surat_masuk' => 'SM-2025',
            'pengirim' => 'Dinas Pendidikan',
            'jenis_surat_id' => $jenis->id,
        ]);

        // ✅ Hindari merah dengan deklarasi tipe eksplisit untuk Intelephense
        $latest = SuratMasuk::latest('id_surat_masuk')->first();
        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('public');
        $disk->assertExists($latest->file);
    }

    /** @test */
    public function validasi_gagal_jika_input_kosong(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('surat_masuk.store'), []);

        $response->assertSessionHasErrors([
            'no_surat_masuk',
            'tanggal_masuk',
            'pengirim',
            'jenis_surat_id',
            'file',
        ]);
    }

    /** @test */
    public function guest_tidak_bisa_akses_form_tambah(): void
    {
        $response = $this->get(route('surat_masuk.create'));

        $response->assertRedirect('/login');
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\JenisSurat;
use App\Models\SuratMasuk;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SuratMasukEditTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function halaman_edit_bisa_diakses_user_login(): void
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->createOne();

        $jenis = JenisSurat::factory()->create();
        $surat = SuratMasuk::factory()->create([
            'jenis_surat_id' => $jenis->id,
        ]);

        $response = $this->actingAs($user)->get(route('surat_masuk.edit', $surat->id_surat_masuk));

        $response->assertStatus(200);
        $response->assertSeeText('Edit Surat Masuk');
        $response->assertSee($surat->no_surat_masuk);
    }

    /** @test */
    public function user_dapat_memperbarui_surat_masuk(): void
    {
        Storage::fake('local');

        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->createOne();

        $jenisLama = JenisSurat::factory()->create();
        $jenisBaru = JenisSurat::factory()->create();

        $surat = SuratMasuk::factory()->create([
            'no_surat_masuk' => 'SM-1001',
            'pengirim' => 'Instansi Lama',
            'jenis_surat_id' => $jenisLama->id,
        ]);

        $fileBaru = UploadedFile::fake()->create('file_baru.pdf', 100, 'application/pdf');

        $response = $this->actingAs($user)->put(route('surat_masuk.update', $surat->id_surat_masuk), [
            'no_surat_masuk' => 'SM-2002',
            'tanggal_masuk' => now()->format('Y-m-d'),
            'pengirim' => 'Instansi Baru',
            'jenis_surat_id' => $jenisBaru->id,
            'file' => $fileBaru,
        ]);

        $response->assertRedirect(route('surat_masuk.index'));

        $this->assertDatabaseHas('surat_masuk', [
            'no_surat_masuk' => 'SM-2002',
            'pengirim' => 'Instansi Baru',
            'jenis_surat_id' => $jenisBaru->id,
        ]);
    }

    /** @test */
    public function validasi_gagal_jika_input_kosong_saat_update(): void
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->createOne();

        $jenis = JenisSurat::factory()->create();
        $surat = SuratMasuk::factory()->create(['jenis_surat_id' => $jenis->id]);

        $response = $this->actingAs($user)->put(route('surat_masuk.update', $surat->id_surat_masuk), []);

        $response->assertSessionHasErrors([
            'no_surat_masuk',
            'tanggal_masuk',
            'pengirim',
            'jenis_surat_id',
        ]);
    }

    /** @test */
    public function guest_tidak_bisa_akses_halaman_edit(): void
    {
        $surat = SuratMasuk::factory()->create();

        $response = $this->get(route('surat_masuk.edit', $surat->id_surat_masuk));

        $response->assertRedirect('/login');
    }
}

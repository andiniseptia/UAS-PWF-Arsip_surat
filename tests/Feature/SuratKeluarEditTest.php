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

class SuratKeluarEditTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_dapat_mengakses_form_edit_surat_keluar(): void
    {
        /** @var Authenticatable $user */
        $user = User::factory()->create();

        $jenis = JenisSurat::factory()->create([
            'kodeSurat' => 'KS-001'
        ]);

        $surat = SuratKeluar::factory()->create([
            'jenis_surat_id' => $jenis->id,
        ]);

        $response = $this->actingAs($user)->get(route('surat_keluar.edit', $surat->id_surat_keluar));

        $response->assertStatus(200);
        $response->assertSee('Edit Surat Keluar');
        $response->assertSee($surat->no_surat_keluar);
    }

    /** @test */
    public function user_dapat_mengupdate_data_surat_keluar(): void
    {
        Storage::fake('public');

        /** @var Authenticatable $user */
        $user = User::factory()->create();

        $jenis = JenisSurat::factory()->create([
            'kodeSurat' => 'KS-002'
        ]);

        $surat = SuratKeluar::factory()->create([
            'jenis_surat_id' => $jenis->id,
            'file' => 'surat_keluar/original.pdf'
        ]);

        $response = $this->actingAs($user)->put(route('surat_keluar.update', $surat->id_surat_keluar), [
            'no_surat_keluar' => 'SK-EDIT-001',
            'tanggal_keluar'  => now()->format('Y-m-d'),
            'tujuan'          => 'Universitas Negeri',
            'jenis_surat_id'  => $jenis->id,
            'file'            => UploadedFile::fake()->create('updated.pdf', 150),
        ]);

        $response->assertRedirect(route('surat_keluar.index'));

        $this->assertDatabaseHas('surat_keluar', [
            'id_surat_keluar' => $surat->id_surat_keluar,
            'no_surat_keluar' => 'SK-EDIT-001',
            'tujuan'          => 'Universitas Negeri',
        ]);
    }

    /** @test */
    public function validasi_edit_gagal_jika_kosong(): void
    {
        /** @var Authenticatable $user */
        $user = User::factory()->create();

        $jenis = JenisSurat::factory()->create([
            'kodeSurat' => 'KS-003'
        ]);

        $surat = SuratKeluar::factory()->create([
            'jenis_surat_id' => $jenis->id,
        ]);

        $response = $this->actingAs($user)->put(route('surat_keluar.update', $surat->id_surat_keluar), []);

        $response->assertSessionHasErrors([
            'no_surat_keluar',
            'tanggal_keluar',
            'tujuan',
            'jenis_surat_id',
        ]);
    }
}

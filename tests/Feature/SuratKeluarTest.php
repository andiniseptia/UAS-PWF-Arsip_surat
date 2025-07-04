<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\JenisSurat;
use App\Models\SuratKeluar;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SuratKeluarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function halaman_index_surat_keluar_bisa_diakses_user_login(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('surat_keluar.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Data Surat Keluar');
    }

    /** @test */
    public function data_surat_keluar_muncul_di_tabel(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $jenis = JenisSurat::factory()->create([
            'kodeSurat' => 'KS-999',
            'keterangan' => 'Pengumuman',
        ]);

        SuratKeluar::factory()->create([
            'no_surat_keluar' => 'SK-123',
            'tujuan' => 'Universitas',
            'jenis_surat_id' => $jenis->id,
            'file' => 'surat_keluar/dummy.pdf',
        ]);

        $response = $this->actingAs($user)->get(route('surat_keluar.index'));

        $response->assertStatus(200);
        $response->assertSeeText('SK-123');
        $response->assertSeeText('Universitas');
        $response->assertSeeText('Pengumuman');
    }

    /** @test */
    public function fitur_pencarian_surat_keluar_berfungsi(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $jenis = JenisSurat::factory()->create([
            'kodeSurat' => 'KS-888',
            'keterangan' => 'Umum',
        ]);

        SuratKeluar::factory()->create([
            'no_surat_keluar' => 'SK-AAA',
            'tujuan' => 'Instansi A',
            'jenis_surat_id' => $jenis->id,
            'file' => 'surat_keluar/fileA.pdf',
        ]);

        SuratKeluar::factory()->create([
            'no_surat_keluar' => 'SK-BBB',
            'tujuan' => 'Instansi B',
            'jenis_surat_id' => $jenis->id,
            'file' => 'surat_keluar/fileB.pdf',
        ]);

        $response = $this->actingAs($user)->get(route('surat_keluar.index', ['search' => 'AAA']));

        $response->assertStatus(200);
        $response->assertSeeText('SK-AAA');
        $response->assertDontSeeText('SK-BBB');
    }

    /** @test */
    public function guest_tidak_bisa_akses_halaman_surat_keluar(): void
    {
        $response = $this->get(route('surat_keluar.index'));
        $response->assertRedirect('/login');
    }
}

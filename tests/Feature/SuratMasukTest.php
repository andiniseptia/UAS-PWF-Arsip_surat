<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\SuratMasuk;
use App\Models\JenisSurat;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SuratMasukTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function halaman_surat_masuk_dapat_diakses_oleh_user_login(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('surat_masuk.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Data Surat Masuk');
        $response->assertSeeText('Tambah Surat Masuk');
    }

    /** @test */
    public function surat_masuk_muncul_di_tabel(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $jenis = JenisSurat::factory()->create([
            'keterangan' => 'Undangan',
        ]);

        SuratMasuk::factory()->create([
            'no_surat_masuk' => 'SM-001',
            'pengirim' => 'Kementerian',
            'jenis_surat_id' => $jenis->id,
        ]);

        $response = $this->actingAs($user)->get(route('surat_masuk.index'));

        $response->assertStatus(200);
        $response->assertSeeText('SM-001');
        $response->assertSeeText('Kementerian');
        $response->assertSeeText('Undangan');
    }

    /** @test */
    public function fitur_pencarian_berfungsi(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        SuratMasuk::factory()->create(['no_surat_masuk' => 'SM-ABC']);
        SuratMasuk::factory()->create(['no_surat_masuk' => 'SM-XYZ']);

        $response = $this->actingAs($user)->get(route('surat_masuk.index', ['search' => 'ABC']));

        $response->assertStatus(200);
        $response->assertSeeText('SM-ABC');
        $response->assertDontSeeText('SM-XYZ');
    }

    /** @test */
    public function guest_tidak_bisa_akses_surat_masuk(): void
    {
        $response = $this->get(route('surat_masuk.index'));

        $response->assertRedirect('/login');
    }
}

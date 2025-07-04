<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\JenisSurat;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JenisSuratTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_dapat_melihat_daftar_jenis_surat()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        JenisSurat::factory()->count(3)->create();

        $response = $this->actingAs($user)->get(route('jenis_surat.index'));

        $response->assertStatus(200);

        $response->assertViewHas('jenisSurats', function ($jenisSurats) {
            return $jenisSurats instanceof \Illuminate\Contracts\Pagination\Paginator
                || $jenisSurats instanceof \Illuminate\Pagination\LengthAwarePaginator;
        });
    }

    /** @test */
    public function user_dapat_menambahkan_jenis_surat_baru()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $data = [
            'kodeSurat' => 'js-001',
            'keterangan' => 'jenis surat test',
        ];

        $response = $this->actingAs($user)->post(route('jenis_surat.store'), $data);

        $response->assertRedirect(route('jenis_surat.index'));

        $this->assertDatabaseHas('jenis_surat', [
            'kodeSurat' => 'JS-001',
            'keterangan' => 'Jenis surat test',
        ]);
    }

    /** @test */
    public function user_dapat_mengedit_jenis_surat()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $jenis = JenisSurat::factory()->create([
            'kodeSurat' => 'JS-100',
            'keterangan' => 'Jenis Lama',
        ]);

        $data = [
            'kodeSurat' => 'js-200',
            'keterangan' => 'jenis baru',
        ];

        $response = $this->actingAs($user)->put(
            route('jenis_surat.update', ['jenis_surat' => $jenis->id]),
            $data
        );

        $response->assertRedirect(route('jenis_surat.index'));

        $this->assertDatabaseHas('jenis_surat', [
            'id' => $jenis->id,
            'kodeSurat' => 'JS-200',
            'keterangan' => 'Jenis baru',
        ]);
    }

    /** @test */
    public function user_dapat_menghapus_jenis_surat()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $jenisSurat = JenisSurat::factory()->create();

        $response = $this->actingAs($user)->delete(
            route('jenis_surat.destroy', ['jenis_surat' => $jenisSurat->id])
        );

        $response->assertRedirect(route('jenis_surat.index'));

        $this->assertDatabaseMissing('jenis_surat', [
            'id' => $jenisSurat->id,
        ]);
    }

    /** @test */
    public function validasi_gagal_jika_input_kosong()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('jenis_surat.store'), []);

        $response->assertSessionHasErrors(['kodeSurat', 'keterangan']);
    }
}

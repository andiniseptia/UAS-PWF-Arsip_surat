<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JenisSuratCreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_dapat_mengakses_halaman_tambah_jenis_surat(): void
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('jenis_surat.create'));

        $response->assertStatus(200);
        $response->assertSeeText('Tambah Jenis Surat');
        $response->assertSeeText('Kode Surat');
        $response->assertSeeText('Keterangan');
    }

    /** @test */
    public function user_dapat_menyimpan_jenis_surat_baru(): void
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

        $data = [
            'kodeSurat' => '1',
            'keterangan' => 'Surat Izin',
        ];

        $response = $this->actingAs($user)->post(route('jenis_surat.store'), $data);

        $response->assertRedirect(route('jenis_surat.index'));

        // Pastikan nama tabel sesuai migration
        $this->assertDatabaseHas('jenis_surat', $data);
    }

    /** @test */
    public function validasi_gagal_jika_input_kosong(): void
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('jenis_surat.store'), []);

        $response->assertSessionHasErrors(['kodeSurat', 'keterangan']);
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\JenisSurat;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JenisSuratEditTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_dapat_mengakses_halaman_edit_jenis_surat()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable|\App\Models\User $user */
        $user = User::factory()->create();

        $jenis = JenisSurat::factory()->create([
            'kodeSurat' => 'JS-123',
            'keterangan' => 'Contoh Surat',
        ]);

        $response = $this->actingAs($user)->get(route('jenis_surat.edit', $jenis->id));

        $response->assertStatus(200);
        $response->assertSee('Edit Jenis Surat');
        $response->assertSee('JS-123');
        $response->assertSee('Contoh Surat');
    }

    /** @test */
    public function user_dapat_mengupdate_data_jenis_surat()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable|\App\Models\User $user */
        $user = User::factory()->create();

        $jenis = JenisSurat::factory()->create([
            'kodeSurat' => 'JS-123',
            'keterangan' => 'Lama',
        ]);

        $data = [
            'kodeSurat' => 'JS-999',
            'keterangan' => 'Baru',
        ];

        $response = $this->actingAs($user)->put(route('jenis_surat.update', $jenis->id), $data);

        $response->assertRedirect(route('jenis_surat.index'));
        $this->assertDatabaseHas('jenis_surat', $data);
    }

    /** @test */
    public function validasi_edit_gagal_jika_input_kosong()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable|\App\Models\User $user */
        $user = User::factory()->create();

        $jenis = JenisSurat::factory()->create([
            'kodeSurat' => 'JS-001',
            'keterangan' => 'Surat Awal',
        ]);

        $response = $this->actingAs($user)->from(route('jenis_surat.edit', $jenis->id))
            ->put(route('jenis_surat.update', $jenis->id), []);

        $response->assertSessionHasErrors(['kodeSurat', 'keterangan']);
        $response->assertRedirect(route('jenis_surat.edit', $jenis->id)); // memastikan redirect kembali ke form edit
    }
}

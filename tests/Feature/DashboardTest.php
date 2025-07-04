<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function dashboard_dapat_diakses_oleh_user_yang_login(): void
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->createOne();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSeeText('Selamat datang');
        $response->assertSeeText('Kelola Surat Masuk');
        $response->assertSeeText('Kelola Surat Keluar');
        $response->assertSeeText('Jenis Surat');
        $response->assertSeeText('Pengguna Aktif');
    }


    /** @test */
    public function dashboard_tidak_dapat_diakses_oleh_guest(): void
    {
        // Act: Akses halaman dashboard tanpa login
        $response = $this->get('/dashboard');

        // Assert: Harus diarahkan ke halaman login
        $response->assertRedirect('/login');
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function halaman_user_dapat_diakses_user_login(): void
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->createOne(['is_admin' => true]); // harus admin

        $response = $this->actingAs($user)->get(route('user.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Daftar User');
    }

    /** @test */
    public function pencarian_user_berfungsi(): void
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->createOne(['is_admin' => true]); // harus admin

        User::factory()->create(['name' => 'Alice Wonderland']);
        User::factory()->create(['name' => 'Bob Marley']);

        $response = $this->actingAs($user)->get(route('user.index', ['q' => 'Alice']));

        $response->assertStatus(200);
        $response->assertSeeText('Alice Wonderland');
        $response->assertDontSeeText('Bob Marley');
    }
}
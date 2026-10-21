<?php

namespace Tests\Feature;

use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AksesUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_hanya_user_aktif_yang_bisa_masuk_panel(): void
    {
        $panel = Filament::getPanel('admin');

        $this->assertTrue(User::factory()->create(['is_active' => true])->canAccessPanel($panel));
        $this->assertFalse(User::factory()->create(['is_active' => false])->canAccessPanel($panel));
    }

    public function test_user_nonaktif_tidak_bisa_login_api(): void
    {
        User::factory()->create([
            'email' => 'staf@recehan.com',
            'password' => 'rahasia123',
            'is_active' => false,
        ]);

        $this->postJson('/api/login', [
            'email' => 'staf@recehan.com',
            'password' => 'rahasia123',
        ])->assertStatus(422)->assertJsonValidationErrors('email');
    }

    public function test_login_api_dibatasi_lima_kali_per_menit(): void
    {
        foreach (range(1, 5) as $i) {
            $this->postJson('/api/login', [
                'email' => 'tidak-ada@recehan.com',
                'password' => 'salah',
            ])->assertStatus(422);
        }

        $this->postJson('/api/login', [
            'email' => 'tidak-ada@recehan.com',
            'password' => 'salah',
        ])->assertStatus(429);
    }
}

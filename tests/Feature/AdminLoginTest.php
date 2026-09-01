<?php

namespace Tests\Feature;

use App\Models\User;
use Filament\Auth\Pages\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_loads(): void
    {
        $this->get('/admin/login')->assertStatus(200);
    }

    public function test_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'dickymulyadi@gmail.com',
            'password' => bcrypt('Bapekom8'),
        ]);

        Livewire::test(Login::class)
            ->set('data.email', 'dickymulyadi@gmail.com')
            ->set('data.password', 'Bapekom8')
            ->call('authenticate')
            ->assertHasNoErrors()
            ->assertRedirect();

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_with_wrong_password_rejected(): void
    {
        User::factory()->create([
            'email' => 'dickymulyadi@gmail.com',
            'password' => bcrypt('Bapekom8'),
        ]);

        Livewire::test(Login::class)
            ->set('data.email', 'dickymulyadi@gmail.com')
            ->set('data.password', 'wrongpassword')
            ->call('authenticate')
            ->assertHasErrors(['data.email']);

        $this->assertGuest();
    }
}

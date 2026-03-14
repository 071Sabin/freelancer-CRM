<?php

namespace Tests\Feature\Auth;

use App\Livewire\Dashboard;
use App\Livewire\Login;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders_correctly()
    {
        // Visit the route
        $this->get(route('login'))
            ->assertStatus(200) // Verify it loads without crashing
            ->assertSeeLivewire(Login::class) // Verify your component is on the page
            ->assertSee('Sign In'); // Verify specific UI text is visible
    }

    public function test_user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create();
        Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('useAuthentication')
            ->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_logout(){
        $user = User::factory()->create();
        $this->actingAs($user)->post(route('logout'))
        ->assertRedirect(route('login'));
    }
}

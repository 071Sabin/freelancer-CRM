<?php

namespace Tests\Feature\Auth;

use App\Livewire\Register;
use Database\Seeders\PlanSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;
use Livewire\Component;
use Livewire\Livewire;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_page_renders_correctly(){
        $this->get(route('register'))
        ->assertStatus(200)
        ->assertSeeLivewire(Register::class)
        ->assertSee('Register');
    }
    public function test_user_can_successfully_register()
    {
        $this->seed(PlanSeeder::class);

        Livewire::test(Register::class)
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('registerUser')
            ->assertRedirect(route('login'))
            ->assertSessionHas('success', 'Registration successful! Please log in.');

        $this->assertDatabaseHas('users', [
            'name' => 'test user',
            'email' => 'test@example.com',
        ]);

        $this->assertDatabaseHas('invoice_settings', [
            'user_id' => 1,
            'prefix' => 'INV',
            'next_number' => 1,
        ]);

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => 1,
            'plan_id' => 1,
            'status' => 'active',
        ]);
    }
}

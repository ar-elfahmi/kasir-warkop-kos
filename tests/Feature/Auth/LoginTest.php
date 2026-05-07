<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_valid_username_and_password(): void
    {
        $user = User::factory()->create([
            'username' => 'kasirwarkop',
            'password' => bcrypt('rahasia123'),
        ]);

        $response = $this->post('/login', [
            'username' => 'kasirwarkop',
            'password' => 'rahasia123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_username(): void
    {
        User::factory()->create([
            'username' => 'kasirwarkop',
            'password' => bcrypt('rahasia123'),
        ]);

        $response = $this->post('/login', [
            'username' => 'salahusername',
            'password' => 'rahasia123',
        ]);

        $response->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    public function test_user_cannot_login_with_invalid_password(): void
    {
        User::factory()->create([
            'username' => 'kasirwarkop',
            'password' => bcrypt('rahasia123'),
        ]);

        $response = $this->post('/login', [
            'username' => 'kasirwarkop',
            'password' => 'salahpassword',
        ]);

        $response->assertSessionHasErrors('username');
        $this->assertGuest();
    }
}

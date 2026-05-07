<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_change_password_with_valid_current_password(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('passwordlama'),
        ]);

        $response = $this->actingAs($user)->put('/password', [
            'current_password' => 'passwordlama',
            'password' => 'passwordbaru',
            'password_confirmation' => 'passwordbaru',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertTrue(password_verify('passwordbaru', $user->fresh()->password));
    }

    public function test_user_cannot_change_password_with_invalid_current_password(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('passwordlama'),
        ]);

        $response = $this->actingAs($user)->put('/password', [
            'current_password' => 'salahpassword',
            'password' => 'passwordbaru',
            'password_confirmation' => 'passwordbaru',
        ]);

        $response->assertSessionHasErrors('current_password', null, 'updatePassword');
        $this->assertTrue(password_verify('passwordlama', $user->fresh()->password));
    }
}

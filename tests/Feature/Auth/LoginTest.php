<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase {
  use RefreshDatabase;

  /**
   * Test that a user can login with valid credentials.
   *
   * @return void
   */
  public function testUserCanLoginWithValidCredentials() {
    $user = User::factory()->create();

    $response = $this->post('/login', [
      'email' => $user->email,
      'password' => 'password',
    ]);

    $response->assertRedirect('/admin/dashboard');
    $this->assertAuthenticatedAs($user);
  }

  /**
   * Test that a user cannot login with invalid credentials.
   *
   * @return void
   */
  public function testUserCannotLoginWithInvalidCredentials() {
    $user = User::factory()->create();

    $response = $this->post('/login', [
      'email' => $user->email,
      'password' => 'wrong-password',
    ]);

    $response->assertRedirect('/'); // Updated assertion
    $response->assertSessionHasErrors('email');
    $this->assertGuest();
  }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebRoutesTest extends TestCase {
  use RefreshDatabase;

  /**
   * Test if the welcome page returns a 200 status code.
   */
  public function testWelcomePage() {
    $response = $this->get('/');

    $response->assertStatus(200);
  }

  /**
   * Test if the admin dashboard route returns a 302 status code when not authenticated.
   */
  public function testAdminDashboardRouteWhenNotAuthenticated() {
    $response = $this->get('/admin/dashboard');

    $response->assertStatus(302); // 302 is the status code for redirection when not authenticated
  }

  /**
   * Test if the admin dashboard route returns a 200 status code when authenticated.
   */
  public function testAdminDashboardRouteWhenAuthenticated() {
    /** @var User $user */
    $user = User::factory()->create([
      'id' => 111,
    ]);

    // Authenticate the user
    $this->actingAs($user);

    $response = $this->get('/admin/dashboard');

    $response->assertStatus(200); // 200 is the status code for redirection when authenticated
  }
}

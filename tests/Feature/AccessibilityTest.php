<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessibilityTest extends TestCase {
    /**
     * A basic accessibility test.
     *
     * @return void
     */
    public function testAccessibilityTest() {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PerformanceTest extends TestCase {
  /**
   * Test the performance of a specific endpoint.
   */
  public function testShouldLoadWelcomePageWithinOneSecond() {
    // Start measuring time
    $startTime = microtime(true);

    // Make HTTP request to the endpoint you want to test
    $response = $this->get('/');

    // Check if the response is successful (status code 200)
    $response->assertStatus(200);

    // End measuring time
    $endTime = microtime(true);

    // Calculate execution time
    $executionTime = $endTime - $startTime;

    // Assert that the execution time is within an acceptable range
    $this->assertLessThan(1000, $executionTime);
  }

  /**
   * Test the performance of a specific endpoint.
   */
  public function testShouldLoadLoginPageWithinOneSecond() {
    // Start measuring time
    $startTime = microtime(true);

    // Make HTTP request to the endpoint you want to test
    $response = $this->get('/login');

    // Check if the response is successful (status code 200)
    $response->assertStatus(200);

    // End measuring time
    $endTime = microtime(true);

    // Calculate execution time
    $executionTime = $endTime - $startTime;

    // Assert that the execution time is within an acceptable range
    $this->assertLessThan(1000, $executionTime);
  }
}

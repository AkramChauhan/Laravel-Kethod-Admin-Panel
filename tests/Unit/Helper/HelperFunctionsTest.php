<?php

use Tests\TestCase;
use Illuminate\Support\Facades\View;

class HelperFunctionsTest extends TestCase {
  /**
   * Test snakeToNormal function.
   *
   * @return void
   */
  public function testSnakeToNormal() {

    // Test cases
    $this->assertEquals('Snake Case', snakeToNormal('snake_case'));
    $this->assertEquals('Another Example', snakeToNormal('another_example'));
    $this->assertEquals('Single', snakeToNormal('single'));
    $this->assertEquals('Title Case', snakeToNormal('title_case'));
    $this->assertEquals('All Caps', snakeToNormal('all_caps'));
  }

  /**
   * Test kview function.
   *
   * @return void
   */
  public function testKview() {
    // Arrange
    $viewPath = 'home';
    $array = [
      'app_layout' => 'backend.layouts.app',
      'theme_name' => 'backend',
      'dashboard_cards' => [],
      'data' => [
        'name' => 'Akram'
      ]
    ];

    // Act
    $result = kview($viewPath, $array);
    // Assert
    $this->assertInstanceOf(\Illuminate\View\View::class, $result); // Ensure it returns a View instance
    $this->assertEquals(View::make('backend.home', $array)->render(), $result->render());

    $this->assertEquals('backend.home', $result->getData()['new_v_path']);
    $this->assertEquals('backend', $result->getData()['theme_name']);
    $this->assertEquals('backend.layouts.app', $result->getData()['app_layout']);
  }

  /**
   * Test singular_module_name function.
   *
   * @return void
   */
  public function testPluralSnakeToSingularSnake() {

    $test_cases = [
      'pages' => 'page',
      'snake_cases' => 'snake_case',
      'tables' => 'table',
      'comments' => 'comment',
      'posts' => 'post',
      'lifes' => 'life',
      'babies' => 'baby',
      'parties' => 'party',
      'batteries' => 'battery',
      'families' => 'family',
      'supplies' => 'supply',
    ];

    // Test cases
    foreach ($test_cases as $inputs => $expected) {
      $this->assertEquals($expected, singular_module_name($inputs));
    }
  }
}

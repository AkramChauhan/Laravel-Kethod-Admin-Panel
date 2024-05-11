<?php

namespace Tests\Unit\Models;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;

class SettingTest extends TestCase {
  use RefreshDatabase;

  public function tearDown(): void {
    Mockery::close();
  }

  public function testSettingHasKeyValue() {
    $user = Setting::factory()->create([
      'key' => 'AKRAM_KEY',
      'value' => 'AKRAM_VALUE',
    ]);


    $this->assertEquals('AKRAM_KEY', $user->key);
    $this->assertEquals('AKRAM_VALUE', $user->value);

    $value = get_setting('test_key');
    $this->assertEquals('', $value);

    $value = get_setting('AKRAM_KEY');
    $this->assertEquals('AKRAM_VALUE', $value);
  }
}

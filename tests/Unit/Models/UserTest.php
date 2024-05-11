<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase {
    use RefreshDatabase;

    public function testUserHasNameAndEmail() {
        $user = User::factory()->create([
            'name' => 'Akram Chauhan',
            'email' => 'akram.chauhan@example.com',
        ]);

        $this->assertEquals('Akram Chauhan', $user->name);
        $this->assertEquals('akram.chauhan@example.com', $user->email);
    }
}

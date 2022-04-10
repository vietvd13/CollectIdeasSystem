<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAuthLoginBySuperQacAccount() {
        $response = $this->post('/api/auth/login', [
            'email' => "aqc@gmail.com",
            'password' => 'password'
        ]);
        $response->assertJson([
            "status" => 200
        ], $strict = false);
    }
}

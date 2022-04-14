<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
        $this->faker = Faker::create();
    }

    public function testAuthLoginByEmpty() {
        $response = $this->post('/api/auth/login', [
            'email' => '',
            'password' => ''
        ]);
        $response->assertJson([
            "message" => "The given data was invalid.",
            "errors" => [
                "email" => [
                    "email not null"
                ],
                "password" => [
                    "password not null"
                    ]
            ]]);
    }

    public function testAuthLoginByWrongPassword() {
        $response = $this->post('/api/auth/login', [
            'email' => '123@123.com',
            'password' => '123@123'
        ]);
        $response->assertJson([
            "status" => 403,
            "message" => "message.error.unauthenticate",
            "internal_message" => null,
            "data_error" => null
        ]);
    }

    public function testAuthLoginBySuperAdminAccount() {
        $response = $this->post('/api/auth/login', [
            'email' => "admin@gmail.com",
            'password' => 'password'
        ]);
        $response->assertJson([
            "status" => 200
        ], $strict = false);
    }

    public function testAuthLoginBySuperQamAccount() {
        $response = $this->post('/api/auth/login', [
            'email' => "qam@gmail.com",
            'password' => 'password'
        ]);
        $response->assertJson([
            "status" => 200
        ], $strict = false);
    }

    public function testAuthLoginBySuperQacAccount() {
        $response = $this->post('/api/auth/login', [
            'email' => "qac@gmail.com",
            'password' => 'password'
        ]);
        $response->assertJson([
            "status" => 200
        ], $strict = false);
    }

    public function testAuthLoginBySuperStaffAccount() {
        $response = $this->post('/api/auth/login', [
            'email' => "staff@gmail.com",
            'password' => 'password'
        ]);
        $response->assertJson([
            "status" => 200
        ], $strict = false);
    }

    public function testAuthUserInformationWithoutLogin() {
        $response = $this->get('/api/auth/user');
        $response->assertJson([
            "message" => 'Unauthenticated.'
        ], $strict = false);
    }

    public function testAuthenticatedUserInformation() {
        $login = $this->post('/api/auth/login', [
            'email' => "admin@gmail.com",
            'password' => 'password'
        ])->decodeResponseJson();

        $response = $this->get('/api/auth/user', [
            'Authorization' => 'Bearer ' . $login['data']['token']
        ]);
        $response->assertJson([
            "status" => 200
        ], $strict = false);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
use Illuminate\Http\UploadedFile;
use App\Models\User;
class UserTest extends TestCase
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

    public function testGetListUser() {
        $login = $this->post('/api/auth/login', [
            'email' => "admin@gmail.com",
            'password' => 'password'
        ])->decodeResponseJson();

        $response = $this->get('/api/users?per_page=5&page=1', [
            'Authorization' => 'Bearer ' . $login['data']['token']
        ]);

        $response->assertJson([
            "status" => 200
        ], $strict = false);
    }

    public function testCreateUserWithAvatar() {
        $login = $this->post('/api/auth/login', [
            'email' => "admin@gmail.com",
            'password' => 'password'
        ])->decodeResponseJson();

        $response = $this->post('/api/users', [
            "avatar_path" => UploadedFile::fake()->image('avatar.png'),
            "name" => "12345678",
            "email" => "admin123@gmail.com",
            "password" => "password",
            "birth" => "2020-11-20",
            "role" => 1,
            "department_id" => 2
        ],
        [
            'Authorization' => 'Bearer ' . $login['data']['token']
        ]);

        $this->assertInstanceOf(User::class, User::where('email', 'admin123@gmail.com')->first());
    }

    public function testCreateUserWithoutAvatar() {
        $login = $this->post('/api/auth/login', [
            'email' => "admin@gmail.com",
            'password' => 'password'
        ])->decodeResponseJson();

        $response = $this->post('/api/users', [
            "avatar_path" => null,
            "name" => "12345678",
            "email" => "noavatar@gmail.com",
            "password" => "password",
            "birth" => "2020-11-20",
            "role" => 1,
            "department_id" => 2
        ],
        [
            'Authorization' => 'Bearer ' . $login['data']['token']
        ]);

        $this->assertInstanceOf(User::class, User::where('email', 'noavatar@gmail.com')->first());
    }

    public function testFindUser() {
        $login = $this->post('/api/auth/login', [
            'email' => "admin@gmail.com",
            'password' => 'password'
        ])->decodeResponseJson();

        $response = $this->get('/api/users/1',
        [
            'Authorization' => 'Bearer ' . $login['data']['token']
        ]);

        $response->assertJson([
            "status" => 200
        ], $strict = false);
    }

    public function testUpdateUserWithoutAvatar() {
        $login = $this->post('/api/auth/login', [
            'email' => "admin@gmail.com",
            'password' => 'password'
        ])->decodeResponseJson();

        $response = $this->put('/api/users/1', [
            "avatar_path" => null,
            "name" => "12345678",
            "new_password" => "password",
            "birth" => "2020-11-20",
            "role" => 1,
            "department_id" => 2
        ],
        [
            'Authorization' => 'Bearer ' . $login['data']['token']
        ]);
        $response->assertJson([
            "status" => 200
        ], $strict = false);

    }

    public function testUpdateUserWithAvatar() {
        $login = $this->post('/api/auth/login', [
            'email' => "admin@gmail.com",
            'password' => 'password'
        ])->decodeResponseJson();

        $response = $this->put('/api/users/1', [
            "avatar_path" => UploadedFile::fake()->image('avatar.png'),
            "name" => "New Name Update",
            "new_password" => "password",
            "birth" => "2020-11-20",
            "role" => 1,
            "department_id" => 2
        ],
        [
            'Authorization' => 'Bearer ' . $login['data']['token']
        ]);
        $this->assertInstanceOf(User::class, User::where('name', 'New Name Update')->first());

    }
}

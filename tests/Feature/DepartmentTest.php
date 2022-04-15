<?php

namespace Tests\Feature;

use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
class DepartmentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    protected $token;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
        $this->faker = Faker::create();

        $login = $this->post('/api/auth/login', [
            'email' => "admin@gmail.com",
            'password' => 'password'
        ])->decodeResponseJson();

        $this->token = $login['data']['token'];
    }

    public function testGetListDepartment() {
        $response = $this->get('/api/department?per_page=5&page=1', [
            'Authorization' => 'Bearer ' .  $this->token
        ]);

        $response->assertJson([
            "status" => 200
        ], $strict = false);
    }

    public function testCreateDepartment() {
        $response = $this->post('/api/department', [
            'name' => "new department"
        ],[
            'Authorization' => 'Bearer ' .  $this->token
        ]);

        $response->assertStatus(200);
    }

    public function testUpdateDepartment() {
        $response = $this->post('/api/department', [
            'name' => "new department"
        ],[
            'Authorization' => 'Bearer ' .  $this->token
        ]);

        $response = $this->put('/api/department/5', [
            'name' => "new department updated"
        ],[
            'Authorization' => 'Bearer ' .  $this->token
        ]);

        $response->assertStatus(200);
    }

    public function testDeleteDepartment() {
        $response = $this->post('/api/department', [
            'name' => "new department"
        ],[
            'Authorization' => 'Bearer ' .  $this->token
        ]);

        $response = $this->delete('/api/department/5', [
            'Authorization' => 'Bearer ' .  $this->token
        ]);

        $response->assertStatus(200);
    }

    public function testGetOne() {
        $response = $this->get('/api/department/1', [
            'Authorization' => 'Bearer ' .  $this->token
        ]);

        $response->assertStatus(200);
    }
}

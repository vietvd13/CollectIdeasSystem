<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
use Illuminate\Http\UploadedFile;
use App\Models\User;
class CategoryTest extends TestCase
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

    public function testGetListCategory() {
        $login = $this->post('/api/auth/login', [
            'email' => "admin@gmail.com",
            'password' => 'password'
        ])->decodeResponseJson();

        $response = $this->get('/api/category?per_page=5&page=1', [
            'Authorization' => 'Bearer ' . $login['data']['token']
        ]);

        $response->assertJson([
            "status" => 200
        ], $strict = false);
    }

    public function testCreateCategory() {
        $login = $this->post('/api/auth/login', [
            'email' => "admin@gmail.com",
            'password' => 'password'
        ])->decodeResponseJson();

        $response = $this->post('/api/category', [
            "description" => "description",
            "end_collect_date" => "2022-04-12",
            "start_collect_date" => "2022-04-11",
            "topic_name" => "new topic name testing"
        ],
        [
            'Authorization' => 'Bearer ' . $login['data']['token']
        ]);

        $this->assertInstanceOf(Category::class, Category::where('topic_name', 'new topic name testing')->first());
    }

    public function testUpdateCategory() {
        $login = $this->post('/api/auth/login', [
            'email' => "admin@gmail.com",
            'password' => 'password'
        ])->decodeResponseJson();

        $this->post('/api/category', [
            "description" => "description",
            "end_collect_date" => "2022-04-12",
            "start_collect_date" => "2022-04-11",
            "topic_name" => "new topic name testing"
        ],
        [
            'Authorization' => 'Bearer ' . $login['data']['token']
        ]);

        $id = Category::first()->id;
        $response = $this->put('/api/category/'. $id, [
            "description" => "new description",
            "end_collect_date" => "2022-04-12",
            "start_collect_date" => "2022-04-11",
            "topic_name" => "new topic name testing updated"
        ],
        [
            'Authorization' => 'Bearer ' . $login['data']['token']
        ]);

        $this->assertInstanceOf(Category::class, Category::where('topic_name', 'new topic name testing updated')->first());
    }

    public function testDeleteCategory() {
        $login = $this->post('/api/auth/login', [
            'email' => "admin@gmail.com",
            'password' => 'password'
        ])->decodeResponseJson();

        $response = $this->delete('/api/category/1',
        [
            'Authorization' => 'Bearer ' . $login['data']['token']
        ]);

        $this->assertNotInstanceOf(Category::class, Category::where('topic_name', 'new topic name testing updated')->first());
    }

    public function testGetOne() {
        $login = $this->post('/api/auth/login', [
            'email' => "admin@gmail.com",
            'password' => 'password'
        ])->decodeResponseJson();
        $this->post('/api/category', [
            "description" => "description",
            "end_collect_date" => "2022-04-12",
            "start_collect_date" => "2022-04-11",
            "topic_name" => "new topic name testing"
        ],
        [
            'Authorization' => 'Bearer ' . $login['data']['token']
        ]);
        $response = $this->get('/api/category/1',
        [
            'Authorization' => 'Bearer ' . $login['data']['token']
        ]);

        $response->assertJson([
            "status" => 200
        ], $strict = false);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory as Faker;
use Illuminate\Http\UploadedFile;
use App\Models\Category;
class IdeaTest extends TestCase
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

        Category::create([
            'topic_name' => "fake category",
            "start_date" => "2022-04-01",
            "start_collect_date" => "2022-05-01",
            "end_collect_date" => "2022-06-01",
            "description" => "fake description",
            "owner" => 1
        ]);
    }

    public function testGetListIdeas() {
        $response = $this->get('/api/idea?category_id=1&page=1&per_page=5', [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
    }

    public function testCreateIdea() {
        $response = $this->post('/api/idea',[
            "category_id" => 1,
            "contents" => "contetns idea",
            "files" => [
                UploadedFile::fake()->image('avatar.png')
            ]
        ], [
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(200);

    }

   public function testLikeIdea() {
        $response = $this->post('/api/idea',[
            "category_id" => 1,
            "contents" => "contetns idea",
            "files" => [
                UploadedFile::fake()->image('avatar.png')
            ]
        ], [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response = $this->post('/api/idea/like', [
            "idea_id" => 1,
            "type" => 1
        ],[
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
    }

    public function testDislikeIdea() {
        $response = $this->post('/api/idea',[
            "category_id" => 1,
            "contents" => "contetns idea",
            "files" => [
                UploadedFile::fake()->image('avatar.png')
            ]
        ], [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response = $this->post('/api/idea/like', [
            "idea_id" => 1,
            "type" => 0
        ],[
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
    }

    public function testCommentInAnIdea() {
        $response = $this->post('/api/idea',[
            "category_id" => 1,
            "contents" => "contetns idea",
            "files" => [
                UploadedFile::fake()->image('avatar.png')
            ]
        ], [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response = $this->post('/api/idea/comment', [
            "comment" => "fake comment",
            "idea_id" => 1
        ],[
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
    }

    public function testCommentAnonymous() {
        $response = $this->post('/api/idea',[
            "category_id" => 1,
            "contents" => "contetns idea",
            "files" => [
                UploadedFile::fake()->image('avatar.png')
            ]
        ], [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response = $this->post('/api/idea/comment', [
            "comment" => "/private fake comment",
            "idea_id" => 1
        ],[
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
    }
}

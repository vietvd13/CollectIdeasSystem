<?php

namespace Tests\Feature;

use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
use Illuminate\Http\UploadedFile;
use App\Models\Category;
class DashboardTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    protected $tokenAdmin;
    protected $tokenQac;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
        $this->faker = Faker::create();

        $login = $this->post('/api/auth/login', [
            'email' => "admin@gmail.com",
            'password' => 'password'
        ])->decodeResponseJson();

        $this->tokenAdmin = $login['data']['token'];

        $login = $this->post('/api/auth/login', [
            'email' => "qam@gmail.com",
            'password' => 'password'
        ])->decodeResponseJson();

        $this->tokenQac = $login['data']['token'];
    }

    public function testChartDonut() {
        $response = $this->get('/api/dasboard/chart-donut?limit=5', [
            'Authorization' => 'Bearer ' .  $this->tokenAdmin
        ]);

        $response->assertStatus(200);
    }

    public function testTotalIdeaInCategory() {
        $response = $this->get('/api/dasboard/total', [
            'Authorization' => 'Bearer ' .  $this->tokenAdmin
        ]);

        $response->assertStatus(200);
    }

    public function testDownloadZip() {
        $response = $this->post('/api/category', [
            "description" => "description",
            "end_collect_date" => "2022-04-12",
            "start_collect_date" => "2022-04-11",
            "topic_name" => "new topic name testing"
        ],
        [
            'Authorization' => 'Bearer ' .  $this->tokenAdmin
        ]);

        $response = $this->get('dasboard/export/category?category_id=1', [
            'Authorization' => 'Bearer ' .  $this->tokenQac
        ]);

        $response->assertStatus(200);
    }

    public function testDownloadAttatchFile() {
        Category::create([
            'topic_name' => "fake category",
            "start_date" => "2022-04-01",
            "start_collect_date" => "2022-05-01",
            "end_collect_date" => "2022-06-01",
            "description" => "fake description",
            "owner" => 1
        ]);

        $response = $this->post('/api/idea',[
            "category_id" => 1,
            "contents" => "contetns idea",
            "files" => [
                UploadedFile::fake()->image('avatar.png')
            ]
        ], [
            'Authorization' => 'Bearer ' . $this->tokenQac
        ]);

        $response = $this->get('/api/idea/download?idea_id=1', [
            'Authorization' => 'Bearer ' .  $this->tokenQac
        ]);
        $response->assertStatus(200);
    }
}

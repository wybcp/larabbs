<?php

namespace Tests\Feature;

use App\Models\User;
use Auth;
use function factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\ActingJWTUser;

class TopicApiTest extends TestCase
{
    protected $user;
    use ActingJWTUser;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
//    public function testExample()
//    {
//        $this->assertTrue(true);
//    }

    public function testStoreTopic()
    {
        $data = ['category_id' => 2, 'body' => 'test body', 'title' => 'test title'];

        $response = $this->JWTActingAs($this->user)->json('POST', 'api/topics', $data);

        $assert_data = [
            'category_id' => 2,
            'user_id'     => $this->user->id,
            'title'       => 'test title',
            'body'        => clean('test body', 'user_topic_body'),
        ];

//        $response->assertStatus(201)->assertJsonFragment($assert_data);
        $response->assertStatus(201);
    }
}

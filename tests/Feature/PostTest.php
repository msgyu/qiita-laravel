<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testtop()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testPostsIndex()
    {
        $response = $this->get('/posts');

        $response->assertStatus(200);
    }

    public function testPostsShow()
    {
        $response = $this->get('/posts/10');

        $response->assertStatus(200);
    }

    public function testPostsCreate()
    {
        $response = $this->get('/posts/create');

        $response->assertStatus(302);
    }

    public function testPostsStore()
    {
        $response = $this->post('/posts');

        $response->assertStatus(302);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PagesControllerTest extends TestCase
{
    public function test_endpoint_returns_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

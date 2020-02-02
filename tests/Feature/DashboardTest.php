<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_the_homepage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

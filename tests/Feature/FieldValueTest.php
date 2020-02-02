<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FieldValueTest extends TestCase
{
    /** @test */
    public function a_user_can_see_all_field_values()
    {
        $this->get('/api/fieldvalues')->assertStatus(200);
    }
}

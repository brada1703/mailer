<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FieldTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_field_has_a_path()
    {
        $field = factory('App\Field')->create();

        $response = $this->get('/api/fields/' . $field->id);

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FieldTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_user_can_see_all_fields()
    {
        $this->get('/')->assertStatus(200);
    }

    /** @test */
    public function a_user_can_create_a_new_field()
    {
        // $this->withoutExceptionHandling();

        // $attributes = factory('App\Field')->raw();

        $attributes = [
            'created_at' => date('Y-m-d H:i:s'),
            'title' => $this->faker->word,
            'type' => 'string',
        ];

        $this->post('/api/fields', $attributes);

        $this->assertDatabaseHas('fields', $attributes);

        $this->get('/api/fields')->assertSee($attributes['title']);
    }

    /** @test */
    public function a_title_name_must_be_unique()
    {
        $attributes = [
            'created_at' => date('Y-m-d H:i:s'),
            'title' => $this->faker->word,
            'type' => 'string',
        ];

        $this->post('/api/fields', $attributes);

        $this->post('/api/fields', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_title_is_required_on_a_new_field()
    {
        $attributes = [
            'created_at' => date('Y-m-d H:i:s'),
            'title' => '',
            'type' => 'string',
        ];

        $this->post('/api/fields', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_title_must_be_at_least_3_characters_long_on_a_new_field()
    {
        $attributes = [
            'created_at' => date('Y-m-d H:i:s'),
            'title' => 'a',
            'type' => 'string',
        ];

        $this->post('/api/fields', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_type_is_required_on_a_new_field()
    {
        $attributes = [
            'created_at' => date('Y-m-d H:i:s'),
            'title' => $this->faker->word,
            'type' => '',
        ];

        $this->post('/api/fields', $attributes)->assertSessionHasErrors('type');
    }

    /** @test */
    public function a_new_field_must_have_a_type_within_date_number_string_boolean()
    {
        $attributes = [
            'created_at' => date('Y-m-d H:i:s'),
            'title' => $this->faker->word,
            'type' => $this->faker->randomElement(['date', 'number', 'string', 'boolean']),
        ];

        $this->post('/api/fields', $attributes);

        $this->assertDatabaseHas('fields', $attributes);
    }

    /** @test */
    public function a_user_can_see_a_single_field()
    {
        $field = factory('App\Field')->create();

        $this->get('/api/fields/' . $field->id)->assertSee($field->title);
    }

    /** @test */
    public function a_user_can_edit_a_field()
    {
        $this->withoutExceptionHandling();

        $field = factory('App\Field')->create();

        $response = $this->patch('/api/fields/' . $field->id, [
            'title' => 'edited_' . $this->faker->word,
            'type' => 'string',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function a_title_is_required_on_an_updated_field()
    {
        // $this->withoutExceptionHandling();

        $field = factory('App\Field')->create();

        $response = $this->patch('/api/fields/' . $field->id, [
            'title' => '',
            'type' => 'string',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_title_must_be_at_least_3_characters_long_on_an_updated_field()
    {
        // $this->withoutExceptionHandling();

        $field = factory('App\Field')->create();

        $response = $this->patch('/api/fields/' . $field->id, [
            'title' => 'a',
            'type' => 'string',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_type_is_required_on_an_updated_field()
    {
        // $this->withoutExceptionHandling();

        $field = factory('App\Field')->create();

        $response = $this->patch('/api/fields/' . $field->id, [
            'title' => $this->faker->name,
            'type' => '',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $response->assertSessionHasErrors('type');
    }

    /** @test */
    public function a_user_can_delete_a_field()
    {
        // $this->withoutExceptionHandling();

        $field = factory('App\Field')->create();

        $response = $this->delete('/api/fields/' . $field->id);

        $response->assertStatus(200);
    }
}

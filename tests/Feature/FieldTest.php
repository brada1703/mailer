<?php

namespace Tests\Feature;

use App\Field;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FieldTest extends TestCase
{
    // Index

    /** @test */
    public function a_user_can_see_all_fields()
    {
        $response = $this->get('/api/fields');
        $response->assertStatus(200);
    }

    // Store

    /** @test */
    public function a_user_can_create_a_new_field()
    {
        // $this->withoutExceptionHandling();

        $response = $this->post('/api/fields', [
            'created_at' => date('Y-m-d H:i:s'),
            'title' => 'test',
            'type' => 'string',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function a_title_is_required_on_a_new_field()
    {
        $response = $this->post(
            '/api/fields',
            array_merge($this->createData(), ['title' => ''])
        );

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_title_must_be_at_least_3_characters_long_on_a_new_field()
    {
        $response = $this->post(
            '/api/fields',
            array_merge($this->createData(), ['title' => 'a'])
        );

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_type_is_required_on_a_new_field()
    {
        $response = $this->post(
            '/api/fields',
            array_merge($this->createData(), ['type' => ''])
        );

        $response->assertSessionHasErrors('type');
    }

    // Test to see if Field type is in:date,number,string,boolean

    // Show

    /** @test */
    public function a_user_can_see_a_single_field()
    {
        $response = $this->get('/api/fields/1');
        $response->assertStatus(200);
    }

    // Update

    /** @test */
    public function a_user_can_edit_a_field()
    {
        $this->withoutExceptionHandling();

        $response = $this->patch('/api/fields/1', [
            'title' => 'test',
            'type' => 'string',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function a_title_is_required_on_an_updated_field()
    {
        $response = $this->patch('/api/fields/1', array_merge($this->updateData(), ['title' => '']));
        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_title_must_be_at_least_3_characters_long_on_an_updated_field()
    {
        $response = $this->patch('/api/fields/1', array_merge($this->updateData(), ['title' => 'a']));
        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_type_is_required_on_an_updated_field()
    {
        $response = $this->patch('/api/fields/1', array_merge($this->updateData(), ['type' => '']));
        $response->assertSessionHasErrors('type');
    }

    // Delete

    /** @test */
    public function a_user_can_delete_a_field()
    {
        $this->withoutExceptionHandling();

        $response = $this->delete('/api/fields/1');

        $response->assertStatus(200);
    }

    private function createData()
    {
        return [
            'created_at' => date('Y-m-d H:i:s'),
            'title' => 'test',
            'type' => 'string',
        ];
    }

    private function updateData()
    {
        return [
            'updated_at' => date('Y-m-d H:i:s'),
            'title' => 'test',
            'type' => 'string',
        ];
    }
}

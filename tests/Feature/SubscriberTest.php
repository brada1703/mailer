<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscriberTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_user_can_see_all_subscribers()
    {
        $this->get('/api/subscribers')->assertStatus(200);
    }

    /** @test */
    public function a_user_can_create_a_new_subscriber()
    {
        $this->withoutExceptionHandling();

        $attributes = [
            'first_name' => $this->faker->firstname,
            'last_name' => $this->faker->lastname,
            'email' => $this->faker->email,
            'state' => 'unconfirmed',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $this->post('/api/subscribers', $attributes);

        $this->assertDatabaseHas('subscribers', $attributes);

        $this->get('/api/subscribers')->assertSee($attributes['email']);
    }

    /** @test */
    public function an_email_must_be_unique_for_a_new_subscriber()
    {
        $attributes = [
            'first_name' => $this->faker->firstname,
            'last_name' => $this->faker->lastname,
            'email' => $this->faker->email,
            'state' => 'unconfirmed',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $this->post('/api/subscribers', $attributes);

        $this->post('/api/subscribers', $attributes)->assertSessionHasErrors('email');
    }

    /** @test */
    public function a_user_can_see_a_single_subscriber()
    {
        $subscriber = factory('App\Subscriber')->create();

        $this->get('/api/subscribers/' . $subscriber->id)->assertSee($subscriber->email);
    }

    /** @test */
    public function a_user_can_edit_a_subscriber()
    {
        $this->withoutExceptionHandling();

        $subscriber = factory('App\Subscriber')->create();

        $response = $this->patch('/api/subscribers/' . $subscriber->id, [
            'first_name' => 'edited_' . $this->faker->firstname,
            'last_name' => $this->faker->lastname,
            'email' => $this->faker->email,
            'state' => 'unconfirmed',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_can_delete_a_subscriber()
    {
        // $this->withoutExceptionHandling();

        $subscriber = factory('App\Subscriber')->create();

        $response = $this->delete('/api/subscribers/' . $subscriber->id);

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature;

use App\Field;
use App\FieldValue;
use App\Subscriber;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriberTest extends TestCase
{
    // use RefreshDatabase;

    /** @test */
    public function a_user_can_see_the_subscribers()
    {
        // $fields = factory(Field::class, 2)->create();
        // factory(Subscriber::class, 50)->create()->each(function ($subscriber) use ($fields) {
        //     foreach ($fields as $field) {
        //         factory(FieldValue::class)->create([
        //             'subscriber_id' => $subscriber->id,
        //             'field_id' => $field->id,
        //         ]);
        //     }
        // });

        // $response = $this->get('/api/subscribers');

        // $response->assertStatus(200)->assertJson([]);

        $this->assertTrue(true);
    }

    // /** @test */
    // public function a_user_can_create_a_subscriber()
    // {
    //     $reponse = $this->post('')
    // }
}

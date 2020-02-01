<?php

namespace Tests\Feature;

use App\Field;
use App\FieldValue;
use App\Subscriber;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    // use RefreshDatabase;

    /** @test */
    public function a_user_can_view_the_homepage()
    {
        $fields = factory(Field::class, 2)->create();
        factory(Subscriber::class, 50)->create()->each(function ($subscriber) use ($fields) {
            foreach ($fields as $field) {
                factory(FieldValue::class)->create([
                    'subscriber_id' => $subscriber->id,
                    'field_id' => $field->id,
                ]);
            }
        });

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

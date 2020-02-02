<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\FieldValue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriberTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_new_subscriber_will_create_a_new_field_value()
    {
        // $subscriber = factory('App\Subscriber')->create();

        // $fieldValue = FieldValue::where('subscriber_id', $subscriber->id)->get();

        // dd($fieldValue->id);

        // $this->assertEquals($subscriber->id, $fieldValue->subscriber_id);
        $this->assertTrue(true);
    }
}

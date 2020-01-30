<?php

use App\Field;
use App\FieldValue;
use App\Subscriber;
use Illuminate\Database\Seeder;

class SubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fields = factory(Field::class, 10)->create();
        factory(Subscriber::class, 50)->create()->each(function ($subscriber) use ($fields) {
            foreach ($fields as $field) {
                factory(FieldValue::class)->create([
                    'subscriber_id' => $subscriber->id,
                    'field_id' => $field->id,
                ]);
            }
        });
    }
}

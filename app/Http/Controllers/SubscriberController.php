<?php

namespace App\Http\Controllers;

use App\Subscriber;
use App\FieldValue;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $now = date('Y-m-d H:i:s');

        // Insert subscriber
        $subscriber = Subscriber::create(
            request()
                ->merge([
                    'created_at' => $now,
                    'state'      => 'unconfirmed',
                ])
                ->validate([
                    'first_name' => 'required',
                    'last_name'  => 'required',
                    'email'      => 'required|email',
                    'state'      => 'required',
                    'created_at' => 'required',
                ])
        );

        // Get subscriber ID to use for each field value
        $subscriber_id = $subscriber->id;

        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        // Get array of field IDs -> for validation -> within array
        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

        // Get an array of all of the field inputs
        $fields = array_filter($request->all(), function($key){
            return strpos($key, 'field_') === 0;
        }, ARRAY_FILTER_USE_KEY);

        // Split this into the information that we want
        foreach($fields as $field_info => $value){

            $field_info = explode('_', $field_info);
            $field_id   = $field_info[1];
            $field_type = $field_info[2];

            switch ($field_type) {
                case 'date':
                    $validation = 'date';
                    break;
                case 'number':
                    $validation = 'numeric';
                    break;
                case 'string':
                    $validation = 'string';
                    break;
                case 'boolean':
                    $validation = 'boolean';
                    break;
            }

            // Create each instance within the field_values table
            FieldValue::create(
                request()
                    ->merge([
                        'value'         => $value,
                        'field_id'      => $field_id,
                        'subscriber_id' => $subscriber_id,
                        'created_at'    => $now,
                    ])
                    ->validate([
                        'value'          => "nullable|$validation",
                        'field_id'       => 'nullable',
                        'subscriber_id'  => 'nullable',
                        'created_at'     => 'nullable',
                    ])
            );
        };

        // Return the updated databases to the front end
        $subscribers  = Subscriber::all();
        $field_values = FieldValue::all();

        return response()->json([
            'subscribers'  => $subscribers,
            'field_values' => $field_values
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function show(Subscriber $subscriber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscriber $subscriber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscriber $subscriber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscriber $subscriber)
    {
        //
    }
}

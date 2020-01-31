<?php

namespace App\Http\Controllers\API;

use App\FieldValue;
use App\Http\Controllers\Controller;
use App\Rules\EmailDomainActive;
use App\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index()
    {
        return response()->json(Subscriber::orderBy('created_at', 'desc')->get());
    }

    public function store(Request $request)
    {
        $now = date('Y-m-d H:i:s');

        $subscriber = Subscriber::create(
            request()
                ->merge([
                    'state' => 'unconfirmed',
                    'created_at' => $now,
                ])
                ->validate([
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => ['required', 'email', new EmailDomainActive],
                    'state' => 'required',
                    'created_at' => 'required',
                ])
        );

        // Get subscriber ID to use for each field value
        $subscriber_id = $subscriber->id;

        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        // Get array of field IDs -> for validation -> within array
        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

        // Get an array of all of the field inputs
        $fields = array_filter($request->all(), function ($key) {
            return strpos($key, 'field_') === 0;
        }, ARRAY_FILTER_USE_KEY);

        // Split this into the information that we want

        // REDO THIS AND GET THE DATA TYPE FROM THE DATABASE
        // NEVER TRUST PEOPLE
        // $available_fields = Field::all();
        // loop through to find the IDs in there

        foreach ($fields as $field_info => $value) {
            $field_info = explode('_', $field_info);
            $field_id = $field_info[1];
            $field_type = $field_info[2];

            switch ($field_type) {
                case 'date':
                    $validation = 'date';
                    $value = date('Y-m-d', strtotime($value));
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

            FieldValue::create(
                request()
                    ->merge([
                        'value' => $value,
                        'field_id' => $field_id,
                        'subscriber_id' => $subscriber_id,
                        'created_at' => $now,
                    ])
                    ->validate([
                        'value' => "nullable|$validation",
                        'field_id' => 'nullable',
                        'subscriber_id' => 'nullable',
                        'created_at' => 'nullable',
                    ])
            );
        };

        return response()->json([
            'subscribers' => Subscriber::orderBy('created_at', 'desc')->get(),
            'fieldValues' => FieldValue::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function show($id)
    {
        $subscriber = Subscriber::where('id', $id)->get();
        $values = FieldValue::where('subscriber_id', $id)->get();
        return response()->json([
            'subscriber' => $subscriber,
            'values' => $values
        ]);
    }

    public function update(Request $request, $id)
    {
        return response()->json(null, 501);
    }

    public function destroy($id)
    {
        $subscriber = Subscriber::where('id', $id);
        $subscriber->delete();

        return response()->json([
            'subscribers' => Subscriber::orderBy('created_at', 'desc')->get(),
            'fieldValues' => FieldValue::orderBy('created_at', 'desc')->get()
        ]);
    }
}

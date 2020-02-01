<?php

namespace App\Http\Controllers\API;

use App\Field;
use App\FieldValue;
use App\Http\Controllers\Controller;
use App\Rules\EmailDomainActive;
use App\Subscriber;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
                    'email' => ['required', 'email', 'unique:subscribers,email', new EmailDomainActive],
                    'state' => 'required',
                    'created_at' => 'required',
                ])
        );

        $subscriber_id = $subscriber->id;

        // Get all field inputs
        $fields = array_filter($request->all(), function ($key) {
            return strpos($key, 'field_') === 0;
        }, ARRAY_FILTER_USE_KEY);

        // Split inputs into ID and get Type from DB
        foreach ($fields as $field_info => $value) {
            $field_info = explode('_', $field_info);
            $field_id = $field_info[1];
            $field_type = Field::where('id', $field_id)->first() ? Field::where('id', $field_id)->pluck('type')[0] : null;

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
                    $validation = 'in:true,false';
                    break;
                default:
                    $validation = 'string';
            }

            try {
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
            } catch (Exception $e) {
                // Delete already created Subscriber to avoid duplicates if FieldValue fails
                $subscriber = Subscriber::where('id', $subscriber_id);
                $subscriber->delete();
            }
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
        $now = date('Y-m-d H:i:s');

        $subscriber = Subscriber::where('id', $id)->firstOrFail();
        $subscriber->update(
            request()
                ->merge([
                    'updated_at' => $now,
                ])
                ->validate([
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => ['required', 'email', new EmailDomainActive],
                    'updated_at' => 'required',
                ])
        );

        $subscriber_id = $subscriber->id;

        // Get all field inputs
        $fields = array_filter($request->all(), function ($key) {
            return strpos($key, 'field_') === 0;
        }, ARRAY_FILTER_USE_KEY);

        // Split inputs into ID and get Type from DB
        foreach ($fields as $field_info => $value) {
            $field_info = explode('_', $field_info);
            $field_id = $field_info[1];
            $field_type = Field::where('id', $field_id)->first() ? Field::where('id', $field_id)->pluck('type')[0] : null;

            switch ($field_type) {
                case 'date':
                    $validation = 'date';
                    $value = $value ? date('Y-m-d', strtotime($value)) : '';
                    break;
                case 'number':
                    $validation = 'numeric';
                    break;
                case 'string':
                    $validation = 'string';
                    break;
                case 'boolean':
                    $validation = 'in:true,false';
                    break;
                default:
                    $validation = 'string';
            }

            try {
                $fieldValue = FieldValue::where(['subscriber_id' => $subscriber_id, 'field_id' => $field_id])->firstOrFail();
                $fieldValue->update(
                    request()
                        ->merge([
                            'value' => $value,
                            'updated_at' => $now,
                        ])
                        ->validate([
                            'value' => "nullable|$validation",
                            'updated_at' => 'nullable',
                        ])
                );
            } catch (ModelNotFoundException $e) {
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
            }
        };

        return response()->json([
            'subscribers' => Subscriber::orderBy('created_at', 'desc')->get(),
            'fieldValues' => FieldValue::orderBy('created_at', 'desc')->get()
        ]);
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

<?php

namespace App\Http\Controllers\API;

use App\FieldValue;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriberRequest;
use App\Subscriber;

class SubscriberController extends Controller
{
    public function index()
    {
        return response()->json(Subscriber::orderBy('created_at', 'desc')->get());
    }

    public function store(SubscriberRequest $request)
    {
        $subscriber = Subscriber::create($request->validated());

        $subscriber_id = $subscriber->id;
        $fields = $this->getFields($request->validated());

        foreach ($fields as $field => $value) {
            $field = explode('_', $field);
            $field_id = $field[1];
            FieldValue::create([
                'subscriber_id' => $subscriber_id,
                'field_id' => $field_id,
                'value' => $value,
            ]);
        }

        return response()->json([
            'subscribers' => Subscriber::orderBy('created_at', 'desc')->get(),
            'fieldValues' => FieldValue::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function show($id)
    {
        $subscriber = Subscriber::where('id', $id)->get();
        $values = FieldValue::where('subscriber_id', $id)->get();
        return response()->json(['subscriber' => $subscriber, 'values' => $values]);
    }

    public function update(SubscriberRequest $request, $id)
    {
        $subscriber = Subscriber::where('id', $id)->firstOrFail();
        $subscriber->update($request->validated());

        $fields = $this->getFields($request->validated());
        foreach ($fields as $field => $value) {
            $field = explode('_', $field);
            $field_id = $field[1];
            $field_value = FieldValue::where(['subscriber_id' => $id, 'field_id' => $field_id]);
            $field_value->update(['value' => $value]);
        }

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

    private function getFields($data)
    {
        return array_filter($data, function ($key) {
            return strpos($key, 'field_') === 0;
        }, ARRAY_FILTER_USE_KEY);
    }
}

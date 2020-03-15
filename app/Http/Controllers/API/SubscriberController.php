<?php

namespace App\Http\Controllers\API;

use App\Field;
use App\FieldValue;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriberRequest;
use App\Rules\EmailDomainActive;
use App\Subscriber;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Validator;

class SubscriberController extends Controller
{
    public function index()
    {
        return response()->json(Subscriber::orderBy('created_at', 'desc')->get());
    }

    public function store(SubscriberRequest $request)
    {
        $fields = new FieldService;
        $errors = $fields->validateFields($request);

        if ($errors) {
            $validator = Validator::make($request->all(), []);
            foreach ($errors as $error) {
                $validator->getMessageBag()->add($error['field_title'], 'This field is required');
            }
            return response()->json($validator->messages(), 422);
        }

        $subscriber = Subscriber::create($request->validated());
        $subscriber_id = $subscriber->id;
        $fields->createField($subscriber_id, $request);

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

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'email', 'unique:subscribers,email,' . $id, new EmailDomainActive]
        ]);

        $fields = new FieldService;
        $errors = $fields->validateFields($request);

        if ($errors) {
            $validator = Validator::make($request->all(), []);
            foreach ($errors as $error) {
                $validator->getMessageBag()->add($error['field_title'], 'This field is required');
            }
            return response()->json($validator->messages(), 422);
        }

        $subscriber = Subscriber::where('id', $id)->firstOrFail();
        $subscriber->update($request->all());
        $subscriber_id = $subscriber->id;
        $fields->updateField($subscriber_id, $request);

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

class FieldService
{
    public function validateFields($request)
    {
        $fields = $this->getFields($request);
        $allFieldsInformation = $this->getValidationType($fields);
        $validateAllFields = $this->validateAllFields($allFieldsInformation);
        $errors = $this->getValidationErrors($validateAllFields);
        return $errors;
    }

    public function createField($subscriber_id, $request)
    {
        $fields = $this->getFields($request);
        $allFieldsInformation = $this->getValidationType($fields);

        foreach ($allFieldsInformation as $field) {
            FieldValue::create([
                'value' => $field['value'],
                'field_id' => $field['field_id'],
                'subscriber_id' => $subscriber_id
            ]);
        }
        return true;
    }

    public function updateField($subscriber_id, $request)
    {
        $fields = $this->getFields($request);
        $allFieldsInformation = $this->getValidationType($fields);

        foreach ($allFieldsInformation as $field) {
            $fieldValue = FieldValue::where(['subscriber_id' => $subscriber_id, 'field_id' => $field['field_id']])->firstOrFail();
            $fieldValue->update(['value' => $field['value']]);
        }
        return true;
    }

    public function getFields($request)
    {
        return array_filter($request->toArray(), function ($key) {
            return strpos($key, 'field_') === 0;
        }, ARRAY_FILTER_USE_KEY);
    }

    public function getValidationType($fields)
    {
        foreach ($fields as $field_info => $value) {
            $field_info = explode('_', $field_info);
            $field_id = $field_info[1];
            $field_type = Field::where('id', $field_id)->first() ? Field::where('id', $field_id)->pluck('type')[0] : null;
            $field_title = Field::where('id', $field_id)->first() ? Field::where('id', $field_id)->pluck('title')[0] : null;

            switch ($field_type) {
                case 'date': $validation = 'date'; $value = date('Y-m-d', strtotime($value)); break;
                case 'number': $validation = 'numeric'; $value = intval($value); break;
                case 'string': $validation = 'string'; break;
                case 'boolean': $validation = 'in:true,false'; break;
                default: $validation = 'string';
            }

            $information[] = ['field_id' => $field_id, 'field_title' => $field_title, 'validation' => $validation, 'value' => $value];
        };

        return $information;
    }

    public function validateAllFields($allFieldsInformation)
    {
        foreach ($allFieldsInformation as $fieldInformation) {
            $allInformation[] = [
                'field_title' => $fieldInformation['field_title'],
                'field_id' => $fieldInformation['field_id'],
                'value' => $fieldInformation['value'],
                'valid' => !Validator::make(
                    ['value' => $fieldInformation['value']],
                    ['value' => 'required']
                )->fails()
            ];
        }

        return $allInformation;
    }

    public function getValidationErrors($validateAllFields)
    {
        $errors = [];

        foreach ($validateAllFields as $field) {
            if ($field['valid'] == false) {
                $errors[] = ['field_title' => $field['field_title']];
            }
        }

        return $errors;
    }
}

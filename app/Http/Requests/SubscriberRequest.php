<?php

namespace App\Http\Requests;

use App\Field;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\EmailDomainActive;
use Illuminate\Http\Request;

class SubscriberRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    {
        $update = '';

        if ($request->subscriber) {
            $update = ',' . $request->subscriber;
        }

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'email', 'unique:subscribers,email' . $update, new EmailDomainActive]
        ];

        $fields = $this->getFields($request);
        $fieldInformation = $this->getValidationType($fields);
        $field_rules = [];

        foreach ($fieldInformation as $field_name => $validation) {
            $field_rules[$field_name] = 'required|' . $validation;
        }

        $total_rules = array_merge($field_rules, $rules);

        return $total_rules;
    }

    private function getFields($request)
    {
        return array_filter($request->toArray(), function ($key) {
            return strpos($key, 'field_') === 0;
        }, ARRAY_FILTER_USE_KEY);
    }

    private function getValidationType($fields)
    {
        $information = [];

        foreach ($fields as $field_number => $value) {
            $field = explode('_', $field_number);
            $field_id = $field[1];
            $field_type = Field::where('id', $field_id)->first() ? Field::where('id', $field_id)->pluck('type')[0] : null;

            switch ($field_type) {
                case 'date': $validation = 'date'; break;
                case 'number': $validation = 'numeric'; break;
                case 'string': $validation = 'string'; break;
                case 'boolean': $validation = 'in:true,false'; break;
                default: $validation = 'string';
            }
            $information[$field_number] = $validation;
        };

        return $information;
    }
}

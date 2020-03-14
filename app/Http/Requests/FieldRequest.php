<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FieldRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|unique:fields,title|min:3',
            'type' => 'required|in:date,number,string,boolean'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required!',
            'type.required' => 'Type is required!'
        ];
    }
}

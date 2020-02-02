<?php

namespace App\Http\Controllers\API;

use App\Field;
use App\FieldValue;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index()
    {
        return response()->json(Field::orderBy('created_at', 'desc')->get());
    }

    public function store(Request $request)
    {
        Field::create(
            request()
                ->merge([
                    'created_at' => date('Y-m-d H:i:s'),
                ])
                ->validate([
                    'title' => 'required|unique:fields,title|min:3',
                    'type' => 'required|in:date,number,string,boolean',
                    'created_at' => 'required',
                ])
        );

        return response()->json([
            'fields' => Field::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function show($id)
    {
        $field = Field::where('id', $id)->get();
        return response()->json(['field' => $field]);
    }

    public function update(Request $request, $id)
    {
        $field = Field::where('id', $id)->firstOrFail();

        $field->update(
            request()
                ->merge([
                    'updated_at' => date('Y-m-d H:i:s'),
                ])
                ->validate([
                    'title' => 'required|min:3',
                    'type' => 'required|in:date,number,string,boolean',
                    'updated_at' => 'required',
                ])
        );

        return response()->json([
            'fields' => Field::orderBy('created_at', 'desc')->get(),
            'fieldValues' => FieldValue::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function destroy($id)
    {
        $field = Field::where('id', $id);
        $field->delete();
        return response()->json([
            'fields' => Field::orderBy('created_at', 'desc')->get(),
        ]);
    }
}

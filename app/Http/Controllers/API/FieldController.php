<?php

namespace App\Http\Controllers\API;

use App\Field;
use App\FieldValue;
use App\Http\Controllers\Controller;
use App\Http\Requests\FieldRequest;

class FieldController extends Controller
{
    public function index()
    {
        return response()->json(Field::orderBy('created_at', 'desc')->get());
    }

    public function store(FieldRequest $request)
    {
        Field::create($request->validated());
        return response()->json(['fields' => Field::orderBy('created_at', 'desc')->get()]);
    }

    public function show($id)
    {
        $field = Field::where('id', $id)->get();
        return response()->json(['field' => $field]);
    }

    public function update(FieldRequest $request, $id)
    {
        $field = Field::where('id', $id)->firstOrFail();
        $field->update($request->validated());
        return response()->json([
            'fields' => Field::orderBy('created_at', 'desc')->get(),
            'fieldValues' => FieldValue::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function destroy($id)
    {
        $field = Field::where('id', $id);
        $field->delete();
        return response()->json(['fields' => Field::orderBy('created_at', 'desc')->get()]);
    }
}

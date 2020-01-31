<?php

namespace App\Http\Controllers\API;

use App\Field;
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
                    'title' => 'required',
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
        //
    }

    public function update(Request $request, $id)
    {
        //
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

<?php

namespace App\Http\Controllers;

use App\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return response()->json(Field::orderBy('created_at', 'desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Field::create(
        //     request()
        //         ->merge([
        //             'created_at' => date('Y-m-d H:i:s'),
        //         ])
        //         ->validate([
        //             'title' => 'required',
        //             'type' => 'required|in:date,number,string,boolean',
        //             'created_at' => 'required',
        //         ])
        // );

        // return response()->json([
        //     'fields' => Field::orderBy('created_at', 'desc')->get()
        // ]);
    }
}

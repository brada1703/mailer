<?php

namespace App\Http\Controllers;

use App\FieldValue;
use Illuminate\Http\Request;

class FieldValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(FieldValue::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FieldValue  $fieldValue
     * @return \Illuminate\Http\Response
     */
    public function show(FieldValue $fieldValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FieldValue  $fieldValue
     * @return \Illuminate\Http\Response
     */
    public function edit(FieldValue $fieldValue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FieldValue  $fieldValue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FieldValue $fieldValue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FieldValue  $fieldValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(FieldValue $fieldValue)
    {
        //
    }
}

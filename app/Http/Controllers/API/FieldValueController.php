<?php

namespace App\Http\Controllers\API;

use App\FieldValue;
use App\Http\Controllers\Controller;

class FieldValueController extends Controller
{
    public function index()
    {
        return response()->json(FieldValue::all());
    }
}

<?php

namespace App\Http\Controllers;

use App\Field;
use App\Subscriber;
use App\FieldValue;

class DashboardController extends Controller
{
    /**
     * Show the dashboard for the our only user.
     *
     * @param  int  $id
     * @return View
     */
    public function __invoke()
    {
        return view('dashboard', [
            'fieldvalues' => FieldValue::all(),
            'subscribers' => Subscriber::orderBy('created_at', 'desc')->get(),
            'fields' => Field::orderBy('created_at', 'desc')->get(),
        ]);
    }
}

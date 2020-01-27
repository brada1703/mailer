<?php

namespace App\Http\Controllers;

use App\Field;
use App\Subscriber;
use App\FieldValue;
use Illuminate\Support\Facades\DB;

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
            'subscribers' => Subscriber::all(),
            'fields' => Field::all(),
        ]);
    }
}

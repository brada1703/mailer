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
        // $fields = DB::table('fields')
        //     ->join('field_values', 'field_values.field_id','fields.id')
        //     ->select(

        //     )
        //     ->get();
        // dd($fields);
        // $subscribers = Subscriber::all();
        // $subscribers = DB::table('subscribers')
        //     ->join('field_values', 'field_values.subscriber_id', 'subscribers.id')
        //     ->join('fields', 'field_values.field_id', 'fields.id')
        //     ->select(
        //         'subscribers.id',
        //         'subscribers.email',
        //         'subscribers.first_name',
        //         'subscribers.last_name',
        //         'subscribers.state',
        //         'fields.title',
        //         'field_values.value as Test',
        //     )
        //     // ->groupBy('field_values.subscriber_id')
        //     ->get();
        // dd($subscribers);

        // $subscribers = DB::table('field_values')
        //     ->join('fields','fields.id','field_values.field_id')
        //     // ->join('subscribers','subscribers.id','field_values.subscriber_id')
        //     ->select('subscribers.*','fields.*','field_values.*')
        //     // ->select('email')
        //     ->get();
        // dd($subscribers);

        return view('dashboard', [
            'fieldvalues' => FieldValue::all(),
            'subscribers' => Subscriber::all(),
            'fields' => Field::all(),
        ]);
    }
}

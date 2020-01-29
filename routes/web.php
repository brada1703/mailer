<?php

Route::get('/', 'DashboardController');
Route::resource('fieldvalues', 'FieldValueController')->only(['index']);
Route::resource('fields', 'FieldController')->only(['index','store']);
Route::resource('subscribers', 'SubscriberController')->only(['index','store']);
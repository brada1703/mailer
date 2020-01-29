<?php

Route::get('/', 'DashboardController');
Route::resource('fields', 'FieldController')->only(['index','store','update','destroy']);
Route::resource('subscribers', 'SubscriberController')->only(['index','store','update','destroy']);

// Then add the API resource controllers
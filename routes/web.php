<?php

Route::get('/', 'DashboardController');
Route::resource('fields', 'FieldController')->only(['store','update','destroy']);
Route::resource('subscribers', 'SubscriberController')->only(['store','update','destroy']);

// Route::resources([
    // 'subscribers' => 'SubscriberController',
    // 'fields' => 'FieldController'
// ]);

// Then add the API resource controllers
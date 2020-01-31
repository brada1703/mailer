<?php

Route::get('/', 'DashboardController');
Route::resource('fieldvalues', 'FieldValueController')->only(['index']); //MOVE TO API CONTROLLER
Route::resource('fields', 'FieldController')->only(['index', 'store']); // AND DELETE BOTH

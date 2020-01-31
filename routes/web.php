<?php

Route::get('/', 'DashboardController');
Route::resource('fieldvalues', 'FieldValueController')->only(['index']); //MOVE TO API CONTROLLER

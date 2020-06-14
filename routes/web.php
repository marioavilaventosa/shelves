<?php

Route::get('/', 'HomeController@config');
Route::post('/configurar', 'HomeController@configurar');
Route::post('/configurarbbdd', 'HomeController@configurarbbdd');
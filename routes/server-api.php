<?php

Route::post('/vpns/authenticate', 'VpnController@authenticate');
Route::get('/vpns', 'VpnController@index');
Route::get('/vpns/{id}', 'VpnController@show')->where('id', '[0-9]+');

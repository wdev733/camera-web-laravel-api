<?php

Route::post('/register', 'IfuController@register')->middleware('rnlOfficeIpAddressFilter');
Route::put('/vpn-ip', 'IfuController@updateVpnIp');
Route::get('/configuration', 'IfuController@configuration');

<?php

use Illuminate\Http\Request;



//Auth
Route::middleware('api')->post('/login', 'LoginController@login');
Route::middleware('api')->post('/register', 'LoginController@register'); 

//
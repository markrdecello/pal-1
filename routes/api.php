<?php

use Illuminate\Http\Request;



//Auth
Route::middleware('api')->post('/login', 'LoginController@login');
Route::middleware('api')->post('/register', 'LoginController@register');
Route::middleware('api')->post('/profile/update/{id}', 'LoginController@updateProfile');
Route::middleware('api')->get('/profile/{id}', 'LoginController@getProfile');
Route::middleware('api')->get('/profile/counselor/{id}', 'LoginController@getUsersByCounselorID');
Route::middleware('api')->post('/register/form', 'FormController@register');
Route::middleware('api')->post('/register/question/{id}', 'QuestionController@register');
Route::middleware('api')->get('/register/submission/{user_id}/{form_id}', 'SubmitController@register');
Route::middleware('api')->post('/submit/question/{question_id}/{submitted_id}', 'AnswerController@register');
Route::middleware('api')->get('/submit/{id}', 'SubmitController@submit');
Route::middleware('api')->get('/status/{id}', 'SubmitController@status');
Route::middleware('api')->get('/get/form/available/{id}', 'SubmitController@availableForms');
Route::middleware('api')->get('/get/form/counselor/{id}', 'SubmitController@counselorForms');
Route::middleware('api')->get('/get/form/submit/{id}', 'SubmitController@getForm');
Route::middleware('api')->get('/get/form/index/{id}', 'FormController@getForm');
Route::middleware('api')->get('/approve/{id}', 'SubmitController@approve');
Route::middleware('api')->get('/resend/{id}', 'SubmitController@resend');

Route::middleware('api')->post('/chat/send', 'ChatController@sendMessage');
Route::middleware('api')->get('/chat/recall/{sender}/{receiver}', 'ChatController@loadChat');


//
<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::post('register','ApiController@register');
Route::post('authenticate','ApiController@authenticate');
Route::group(['middleware' => 'jwt.auth'], function () {
	Route::get('get-user','ApiController@getUser');
	Route::post('create-photo','ApiController@createPhoto');
	Route::get('list-photo','ApiController@listPhoto');

});

// Route::group(['middleware' => 'role:0'], function()    
// {
    
// }
// Route::group(['middleware' => 'role:1'], function()    
// {
    
// }
// Route::group(['middleware' => 'role:2'], function()    
// {
    
// }
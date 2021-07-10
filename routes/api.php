<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login', 'UserController@login');
Route::post('/register', 'UserController@register');

Route::middleware('auth:api')->group(function () {
    Route::post('/users/{id}', 'UserController@update');

    Route::get('/addresses', 'AddressController@list');
    Route::post('/addresses', 'AddressController@create');
    Route::get('/addresses/{id}', 'AddressController@get');
    Route::put('/addresses/{id}', 'AddressController@update');
    Route::delete('/addresses/{id}', 'AddressController@delete');

    Route::get('/treks', 'TrekController@list');
    Route::post('/treks', 'TrekController@create');
    Route::get('/treks/{id}', 'TrekController@get');
    Route::post('/treks/{id}', 'TrekController@join');
    Route::put('/treks/{id}', 'TrekController@update');
    Route::delete('/treks/{id}', 'TrekController@delete');

    Route::get('/messages', 'MessageController@list');
    // Route::post('/messages', 'MessageController@create');
    Route::get('/messages/{id}', 'MessageController@get');
    Route::post('/messages/{id}', 'MessageController@create');
    // Route::put('/messages/{id}', 'MessageController@update');
    Route::delete('/messages/{id}', 'MessageController@delete');
});

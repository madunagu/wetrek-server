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

Route::middleware('auth:api')->group(function () {

    Route::get('/addresses', 'AddressController@list');
    Route::post('/addresses', 'AddressController@create');
    Route::get('/addresses/{id}', 'AddressController@get');
    Route::put('/addresses/{id}', 'AddressController@update');
    Route::delete('/addresses/{id}', 'AddressController@delete');


    Route::get('/events', 'EventController@list');
    Route::post('/events', 'EventController@create');
    Route::get('/events/{id}', 'EventController@get');
    Route::put('/events/{id}', 'EventController@update');
    Route::delete('/events/{id}', 'EventController@delete');

    
    Route::get('/treks', 'TrekController@list');
    Route::post('/treks', 'TrekController@create');
    Route::get('/treks/{id}', 'TrekController@get');
    Route::post('/treks/{id}', 'TrekController@join');
    Route::put('/treks/{id}', 'TrekController@update');
    Route::delete('/treks/{id}', 'TrekController@delete');


    Route::get('/profile-media', 'ProfileMediaController@list');
    Route::post('/profile-media', 'ProfileMediaController@create');
    Route::get('/profile-media/{id}', 'ProfileMediaController@get');
    Route::put('/profile-media/{id}', 'ProfileMediaController@update');
    Route::delete('/profile-media/{id}', 'ProfileMediaController@delete');

});
<?php

use Illuminate\Http\Request;

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

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');
//Route::get('open', 'DataController@open');
Route::get('drinks', 'DrinkController@getAllDrinks');
Route::post('add_drink', 'DrinkController@add');

/**
 * 
 * Routes that only get served when JWT token is present and correct
 * 
 */
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::post('consumed', 'ConsumedController@add');
    Route::get('get_user_consumed', 'ConsumedController@getConsumedForUser');
//    Route::get('closed', 'DataController@closed');
});

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

Route::group(array('prefix' => 'api/v1'), function()
{

    // Additional User Routes
    Route::post('users/{user}/toggleTesterStatus', 'SubscriptionController@toggleTesterStatus', ['middleware' => 'admin']);

    // Default User Resource Routes
    Route::resource('users', 'UserController');

});
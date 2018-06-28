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

Route::middleware('auth:api')->group(function () {
    Route::get('current-user', 'API\CurrentUserController@show')->name('api.current-user.show');
    Route::match(['PUT', 'PATCH'], 'current-user', 'API\CurrentUserController@update')->name('api.current-user.update');
    Route::delete('current-user', 'API\CurrentUserController@destroy')->name('api.current-user.destroy');
});

Route::middleware('scope:list-guilds')->get('guilds', 'API\GuildController@index')->name('api.guilds.index');
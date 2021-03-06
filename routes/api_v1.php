<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Api routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your Api!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('articles/autocomplete', 'ArticlesController@autocomplete');
Route::get('articles', 'ArticlesController@index');
Route::post('articles', 'ArticlesController@store');

Route::post('files', 'FilesController@store');

Route::any('images/resize', 'FilesController@resize');

Route::post('register', 'AuthController@register');

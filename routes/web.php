<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return Redirect::to('/horizon');
    }

    return Redirect::to('/auth/google');
});

Route::get('auth/google', 'AuthController@redirectToProvider');
Route::get('auth/google/callback', 'AuthController@handleProviderCallback');
Route::get('logout', 'AuthController@logout');

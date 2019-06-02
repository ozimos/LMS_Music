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

Route::prefix('v1/auth')->name('auth.')->group(function () {

    Route::post('register', 'AuthController@register')->name('register');
    Route::post('login', 'AuthController@login')->name('login');
    Route::get('refresh', 'AuthController@refresh')->name('refresh');
    Route::middleware(['auth:api', 'addUserId'])->group(function(){
        Route::get('user', 'AuthController@user')->name('user');
        Route::get('logout', 'AuthController@logout')->name('logout');
    });

});
Route::prefix('v1')->middleware('auth:api')->group(function(){

    Route::apiResource('users', 'UserController')->except('store');
    Route::apiResource('songs', 'SongsController')->only(['index', 'show']);

    Route::middleware('addUserId')->group(function () {
        Route::name('albums.songs.')->prefix('albums/{album}/songs')->group(function () {
            Route::post('', 'AlbumsController@createSong')->name('create');
            Route::put('{song}', 'AlbumsController@updateSong')->name('update');
            Route::delete('{song}', 'AlbumsController@deleteSong')->name('delete');
        });
        Route::apiResources([
            'comments' => 'CommentsController',
            'profiles' => 'ProfilesController',
            'albums'   => 'AlbumsController',
        ]);
    });

});

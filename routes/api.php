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
    // Users
    Route::get('users', 'UserController@index')->middleware('isAdmin')->name('users.index');
    Route::delete('users/{user}', 'UserController@index')->middleware('isAdmin')->name('users.destroy');
    Route::apiResource('users', 'UserController')->middleware('isAdminOrSelf')
    ->except(['index', 'store', 'destroy']);
});
Route::prefix('v1')
    ->middleware('auth:api')
    ->group(function () {
        Route::middleware('addUserId')
            ->group(function () {
                Route::apiResources([
                    'comments' => 'CommentsController',
                ]);
            });
    });

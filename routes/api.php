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
Route::prefix('api/v1')
    ->group(function () {
        Route::get('artistes/search', 'ArtistesController@search');
        Route::get('comments/search', 'CommentsController@search');
        Route::get('profiles/search', 'ProfilesController@search');
        Route::apiResources([
            'artistes' => 'ArtistesController',
            'comments' => 'CommentsController',
            'profiles' => 'ProfilesController',
        ]);
    });

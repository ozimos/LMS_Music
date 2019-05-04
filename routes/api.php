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

Route::middleware(['auth:api', 'addUserId'])->get('/user', function (Request $request) {
    return $request->user();
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

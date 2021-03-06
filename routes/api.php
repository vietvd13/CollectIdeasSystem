<?php
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
Route::namespace('Api')->group(function() {
    Route::post('/auth/login','AuthController@login');
    Route::get('dasboard/export/category', 'DasboardController@exportCategory');
    Route::get('idea/download', 'DasboardController@downloadAttatchFiles');
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/auth/user','AuthController@user');
        Route::apiResource('/users','UserController');
        Route::get('roles','UserController@roles');
        Route::apiResource('category', 'CategoryController');
        Route::apiResource('department', 'DepartmentController');
        Route::apiResource('idea', 'IdeaController');
        Route::post('idea/comment', 'IdeaController@comment');
        Route::get('idea/comments/load', 'IdeaController@comments');
        Route::post('idea/like', 'IdeaController@like');
        Route::get('dasboard/category', 'DasboardController@categoriesByOwner');
        Route::get('dasboard/chart-donut', 'DasboardController@chartDonut');
        Route::get('dasboard/total', 'DasboardController@total');

        // Route::get('dasboard/export/category', 'DasboardController@total');
    });
});

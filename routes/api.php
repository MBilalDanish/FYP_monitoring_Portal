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
Route::apiResources(['user' => 'API\UserController']);
Route::get('studentprofile','API\UserController@studentprofile');
Route::put('studentprofile','API\UserController@updatestudentProfile');
Route::get('teacherprofile','API\UserController@teacherprofile');
Route::put('teacherprofile','API\UserController@updateteacherProfile');
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
Route::apiResources(['document' => 'API\DocumentController']);
Route::get('supervisor','API\UserController@supervisors');
Route::get('teacher','API\UserController@teachers');
Route::get('student','API\UserController@students');
Route::get('getdocumentsforteacher','API\DocumentController@getdocumentsforteacher');
Route::get('getAllDocuments','API\DocumentController@getAllDocuments');
Route::get('singleDocument/{doc_id}','API\DocumentController@singleDocument');
Route::post('assignMarks','API\DocumentController@assignMarks');
Route::apiResources(['docCom' => 'API\DocumentCompair']);
Route::get('getStats','API\UserController@getStats');
Route::get('sendEmailLink','API\EmailNewLinkController@verifyEmail');
Route::apiResources(['message' => 'API\MessageController']);
Route::get('getMessages/{chatUser_id}','API\MessageController@getMessages');


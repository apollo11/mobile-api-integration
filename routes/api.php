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

Route::prefix('v1/register/')->group(function () {
    Route::post('employee','EmployeeController@store');
    Route::post('employer', 'EmployerController@store');
    Route::post('password/email','Auth\EmailResetController@sendResetLinkEmailControl');
});

Route::prefix('v1/social')->group(function () {
    Route::post('fb/register', 'Social\FaceBookController@store');
    Route::post('google/register', 'Social\GoogleController@store');
});

Route::prefix('v1/')->group(function () {
    Route::get('school', 'School\SchoolController@index');
});


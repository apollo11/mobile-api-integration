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


Route::prefix('v1/')->group(function () {

    Route::post('login','Auth\LoginController@oauthLogin');
    Route::post('social/fb/login', 'Auth\LoginController@socialFBLogin');
    Route::post('social/google/login', 'Auth\LoginController@socialGoogleLogin');

});

Route::prefix('v1')->group(function () {

    Route::post('mobile/login', 'Mobile\MobileFireBaseController@checkIfValidToken');
    Route::post('mobile/validate', 'Mobile\MobileFireBaseController@fireBaseValidation');

});

Route::prefix('v1/register/')->group(function () {

    Route::post('employee','EmployeeController@store');
    Route::post('employer', 'EmployerController@store');
    Route::post('validate/user', 'EmployeeController@validateUser');
    Route::post('password/email','Auth\EmailResetController@sendResetLinkEmailControl');
    Route::post('social', 'Social\SocialController@store');

});

Route::prefix('v1/social')->group(function () {
//    Route::post('login', '')
    Route::post('validate/user', 'Social\SocialController@socialUserValidate');

});

Route::prefix('v1/details')->group(function () {

    Route::get('{email}', 'Social\SocialController@show');

});


Route::prefix('v1/')->group(function () {

    Route::get('school', 'School\SchoolController@index');

});


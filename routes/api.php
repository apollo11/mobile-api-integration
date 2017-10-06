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

    Route::post('login', 'Auth\LoginController@oauthLogin');
    Route::post('social/fb/login', 'Auth\LoginController@socialFBLogin');
    Route::post('social/google/login', 'Auth\LoginController@socialGoogleLogin');

});

Route::prefix('v1')->group(function () {

    Route::post('mobile/validate', 'Mobile\MobileFireBaseController@validateMobile');
    Route::post('mobile/login', 'Mobile\MobileFireBaseController@fireBaseValidation');

});

Route::prefix('v1/register/')->group(function () {

    Route::post('employee', 'Employee\EmployeeController@store');
    Route::post('validate/user', 'Employee\EmployeeController@validateUser');

    Route::post('employer', 'EmployerController@store');

    Route::post('password/email', 'Auth\EmailResetController@sendResetLinkEmailControl');
    Route::post('social', 'Social\SocialController@store');

    Route::post('fb', 'Social\FaceBookController@store');
    Route::post('google', 'Social\GoogleController@store');

});

Route::prefix('v1/social')->group(function () {

    Route::post('validate/user', 'Social\SocialController@socialUserValidate');

});

Route::prefix('v1/details')->group(function () {

    Route::get('{email}', 'Social\SocialController@show');

});


Route::prefix('v1/')->group(function () {

    Route::get('school', 'School\SchoolController@index');
    Route::get('industry', 'Industry\IndustryController@lists');
    Route::get('location', 'Location\LocationController@lists');

});

Route::group(['middleware' => ['auth:api']], function () {

    Route::prefix('v1/history/')->group(function () {

        Route::get('completed', 'History\HistoryController@CompletedCancelledList');
        Route::get('earned', 'History\EarnedController@earnedJobList');

    });

    Route::prefix('v1/job/')->group(function () {

        Route::get('lists', 'Job\JobController@jobApiLists');
        Route::get('details', 'Job\JobController@show');

        Route::post('apply', 'JobSchedule\JobScheduleController@store');

    });

    Route::prefix('v1/user/')->group(function () {

        Route::get('details', 'EmployeeProfile\EmployeeProfileController@show');

        Route::post('edit/info', 'EmployeeProfile\AdditionalInfoController@store');
        Route::post('edit/basic/info', 'EmployeeProfile\BasicInfoController@update');

    });

    Route::prefix('v1/job/schedule/')->group(function () {

        Route::get('lists', 'JobSchedule\JobScheduleController@jobScheduleLists');

        Route::post('cancel', 'CancelJob\CancelJobController@index');

    });

    Route::prefix('v1/job/check-in/')->group(function () {

        Route::get('details', 'Checkin\CheckinController@index');
        Route::post('apply', 'Checkin\CheckinController@update');

    });

    Route::prefix('v1/job/checkout/')->group(function () {

        Route::post('apply', 'Checkout\CheckoutController@update');

    });

});

Route::group(['middleware' => ['auth_client']], function () {

    Route::prefix('v1/job/')->group(function () {

        Route::get('lists', 'Job\JobController@jobApiLists');
        Route::get('lists/{id}', 'Job\JobController@show');

        Route::post('apply', 'JobSchedule\JobScheduleController@store');

    });

    Route::prefix('v1/user/')->group(function () {

        Route::get('details', 'EmployeeProfile\EmployeeProfileController@show');

        Route::post('edit/info', 'EmployeeProfile\AdditionalInfoController@store');

    });

    Route::prefix('v1/job/schedule/')->group(function () {

        Route::get('lists', 'JobSchedule\JobScheduleController@jobScheduleLists');

        Route::post('cancel', 'CancelJob\CancelJobController@index');

    });

    Route::prefix('v1/job/check-in/')->group(function () {

        Route::get('details', 'Checkin\CheckinController@index');
        Route::post('apply', 'Checkin\CheckinController@update');

    });

    Route::prefix('v1/job/checkout')->group(function () {

        Route::post('apply', 'Checkout\CheckoutController@update');

    });


});

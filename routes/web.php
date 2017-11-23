<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::group(['middleware' => ['auth']], function () {

    Route::prefix('employee')->group(function () {
        Route::get('/lists', 'Employee\EmployeeController@index')->name('employee.lists');
        Route::get('/create', 'Employee\EmployeeController@create')->name('employee.create');
        Route::get('details/{id}','Employee\EmployeeController@details')->name('employee.details');
        Route::get('edit/{id}','Employee\EmployeeController@edit')->name('employee.edit');
        Route::post('/signup', 'Employee\EmployeeController@signup')->name('employee.signup');

        Route::post('/pending/{id}', 'Employee\EmployeeController@pendingStatus')->name('employee.pending');
        Route::post('/approve/{id}', 'Employee\EmployeeController@approveStatus')->name('employee.approve');
        Route::post('/reject/{id}', 'Employee\EmployeeController@rejectUser')->name('employee.reject');
        Route::post('/upload/{id}', 'Employee\EmployeeController@uploadInfoUser')->name('employee.upload');
        Route::post('delete','Employee\EmployeeController@destroy')->name('employee.destroy-all');
        Route::post('delete/{id}','Employee\EmployeeController@destroyOne')->name('employee.destroy-one');
        Route::post('update/{id?}', 'Employee\EmployeeController@update')->name('employee.update');

        Route::post('update/profile/img/{id?}', 'Employee\EmployeeController@updateProfileImg')->name('employee.edit.img');
        Route::post('update/profile/frontic/{id?}', 'Employee\EmployeeController@updateFrontIc')->name('employee.edit.frontic');
        Route::post('update/profile/backic/{id?}', 'Employee\EmployeeController@updateBacktIc')->name('employee.edit.backic');
        Route::post('update/profile/bank/{id?}', 'Employee\EmployeeController@updateBankStmnt')->name('employee.edit.bank');

    });

    Route::prefix('employer')->group(function () {
        Route::get('/lists', 'Employer\EmployerController@index')->name('employer.lists');
        Route::get('new/list', 'Employer\EmployerController@newlyRegisteredEmployer')->name('employer.new.list');
        Route::get('/create', 'Employer\EmployerController@create')->name('employer.create');
        Route::get('/edit/{id}', 'Employer\EmployerController@edit')->name('employer.edit');
        Route::post('/add', 'Employer\EmployerController@store')->name('employer.add');
        Route::post('/update/{id?}', 'Employer\EmployerController@update')->name('employer.update');
        Route::post('multiple/{id?}/{param?}','Employer\EmployerController@destroy')->name('employer.multiple');
        Route::get('details/{id}','Employer\EmployerController@show')->name('employer.details');
    });

    Route::prefix('industry')->group(function () {
        Route::get('/lists', 'Industry\IndustryController@index')->name('industry.lists');
        Route::get('/create', 'Industry\IndustryController@create')->name('industry.create');
        Route::post('/add', 'Industry\IndustryController@store')->name('industry.add');
        Route::get('edit/{id}', 'Industry\IndustryController@edit')->name('industry.edit');
        Route::POST('update/{id}', 'Industry\IndustryController@update')->name('industry.update');
    });

    Route::prefix('location')->group(function () {
        Route::get('/create', 'Location\LocationController@create')->name('location.create');
        Route::get('/lists', 'Location\LocationController@index')->name('location.lists');
        Route::post('/add', 'Location\LocationController@store')->name('location.add');
    });

    Route::prefix('job')->group(function() {
       Route::get('/create','Job\JobController@create')->name('job.create');
       Route::get('/edit/{id?}','Job\JobController@edit')->name('job.edit');
       Route::post('/update/{id}','Job\JobController@update')->name('job.update');
       Route::get('/lists','Job\JobController@index')->name('job.lists');
       Route::post('/add','Job\JobController@store')->name('job.add');
       Route::post('multiple/{id?}/{param?}','Job\JobController@destroy')->name('job.multiple');
       Route::get('details/{id}','Job\JobController@details')->name('job.details');
       Route::post('/assign', 'AssignJob\AssignJobsController@store')->name('assign.job');

       Route::get('/getJobsSeekers/{id?}','Job\JobController@getJobsSeekers')->name('job.getJobsSeekers');


       Route::POST('/notification/{id?}','Job\JobController@sendNotification')->name('job.sendNotification');
       Route::get('/lists/{notification_status?}','Job\JobController@index')->name('job.lists');

    });

    Route::prefix('assign')->group(function() {
        Route::get('/lists','AssignJob\AssignJobsController@index')->name('assign.lists');
    });

    Route::prefix('cancel/job')->group(function() {
        Route::get('details/{userId}/{jobId}', 'CancelJob\CancelJobController@details')->name('cancel.details');
    });

    Route::prefix('payout')->group(function() {
       Route::get('lists', 'Payout\PayoutController@index')->name('payout.lists');
       Route::get('edit/{id}', 'Payout\PayoutController@edit')->name('payout.edit');
       Route::post('update/{id}', 'Payout\PayoutController@update')->name('payout.update');
       Route::post('approved/{id}/{userId}', 'Payout\PayoutController@approvedJob')->name('payout.approved');
       Route::post('processed/{id}/{userId}', 'Payout\PayoutController@processedJob')->name('payout.processed');
       Route::post('rejected/{id}/{userId}', 'Payout\PayoutController@rejectJob')->name('payout.rejected');
       Route::post('accepted/{id}/{userId}', 'Payout\PayoutController@acceptedJob')->name('payout.accepted');
       Route::post('multiprocessed', 'Payout\PayoutController@multiProcessed')->name('payout.multiple');
    });

    Route::prefix('pushnotification')->group(function() {
        Route::get('lists', 'PushNotification\PushNotificationController@all')->name('pushnotification.lists');
        Route::get('create', 'PushNotification\PushNotificationController@create')->name('pushnotification.create');
        Route::post('add', 'PushNotification\PushNotificationController@add')->name('pushnotification.add');
        Route::get('edit/{id}', 'PushNotification\PushNotificationController@edit')->name('pushnotification.edit');
        Route::POST('update', 'PushNotification\PushNotificationController@update')->name('pushnotification.update');
        Route::get('delete/{id}', 'PushNotification\PushNotificationController@delete')->name('pushnotification.delete');
    });

    Route::prefix('recipient')->group(function() {
        Route::get('create', 'RecipientGroup\RecipientGroupController@create')->name('recipient.create');
        Route::get('lists', 'RecipientGroup\RecipientGroupController@index')->name('recipient.lists');
        Route::post('search', 'RecipientGroup\RecipientGroupController@advanceSearch')->name('recipient.search');
        Route::post('add', 'RecipientGroup\RecipientGroupController@store')->name('recipient.store');
    });

    Route::prefix('settings')->group(function() {
       Route::get('/', 'Settings\SettingsController@index')->name('settings');
       Route::post('update', 'Settings\SettingsController@store')->name('settings.update');
    });

    Route::prefix('myprofile')->group(function() {
       Route::get('/', 'MyProfile\ProfileController@index')->name('myprofile');
       Route::post('update', 'MyProfile\ProfileController@update')->name('myprofile.update');
    });

    Route::prefix('reports')->group(function() {
       Route::get('/related_jobs', 'Reports\ReportsController@related_jobs')->name('reports.related_jobs');
    });
});

Route::get('/home', 'HomeController@index')->name('home');
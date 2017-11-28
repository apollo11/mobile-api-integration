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
        Route::get('/lists', 'Employee\EmployeeController@index')->name('employee.lists')->middleware('can:employee-view');
        Route::get('/create', 'Employee\EmployeeController@create')->name('employee.create')->middleware('can:employee-view');
        Route::get('details/{id}','Employee\EmployeeController@details')->name('employee.details')->middleware('can:employee-view');
        Route::get('edit/{id}','Employee\EmployeeController@edit')->name('employee.edit')->middleware('can:employee-view');
        Route::post('/signup', 'Employee\EmployeeController@signup')->name('employee.signup')->middleware('can:employee-view');

        Route::post('/pending/{id}', 'Employee\EmployeeController@pendingStatus')->name('employee.pending')->middleware('can:employee-view');
        Route::post('/approve/{id}', 'Employee\EmployeeController@approveStatus')->name('employee.approve')->middleware('can:employee-view');
        Route::post('/reject/{id}', 'Employee\EmployeeController@rejectUser')->name('employee.reject')->middleware('can:employee-view');
        Route::post('/upload/{id}', 'Employee\EmployeeController@uploadInfoUser')->name('employee.upload')->middleware('can:employee-view');

        Route::post('delete','Employee\EmployeeController@destroy')->name('employee.destroy-all')->middleware('can:employee-view');
        Route::post('delete/{id}','Employee\EmployeeController@destroyOne')->name('employee.destroy-one')->middleware('can:employee-view');
        Route::post('update/{id?}', 'Employee\EmployeeController@update')->name('employee.update');


        Route::post('update/profile/img/{id?}', 'Employee\EmployeeController@updateProfileImg')->name('employee.edit.img');
        Route::post('update/profile/frontic/{id?}', 'Employee\EmployeeController@updateFrontIc')->name('employee.edit.frontic');
        Route::post('update/profile/backic/{id?}', 'Employee\EmployeeController@updateBacktIc')->name('employee.edit.backic');
        Route::post('update/profile/bank/{id?}', 'Employee\EmployeeController@updateBankStmnt')->name('employee.edit.bank');


        Route::get('/job/detail/{user_id}/{id}', 'Employee\EmployeeController@jobdetail')->name('employee.job.detail');
        Route::post('/job/rate_job/{user_id}/{id}', 'Employee\EmployeeController@rate_job')->name('employee.job.rate_job');
    });

    Route::prefix('employer')->group(function () {
        Route::get('/lists', 'Employer\EmployerController@index')->name('employer.lists')->middleware('can:employer-view');
        Route::get('new/list', 'Employer\EmployerController@newlyRegisteredEmployer')->name('employer.new.list')->middleware('can:employer-view');
        Route::get('/create', 'Employer\EmployerController@create')->name('employer.create')->middleware('can:employer-view');
        Route::get('/edit/{id}', 'Employer\EmployerController@edit')->name('employer.edit')->middleware('can:employer-view');
        Route::post('/add', 'Employer\EmployerController@store')->name('employer.add');
        Route::post('/update/{id?}', 'Employer\EmployerController@update')->name('employer.update');
        Route::post('multiple/{id?}/{param?}','Employer\EmployerController@destroy')->name('employer.multiple');
        Route::get('details/{id}','Employer\EmployerController@show')->name('employer.details')->middleware('can:employer-view');
    });

    Route::prefix('industry')->group(function () {
        Route::get('/create', 'Industry\IndustryController@create')->name('industry.create')->middleware('can:admin-view');
        Route::get('/lists', 'Industry\IndustryController@index')->name('industry.lists')->middleware('can:admin-view');
        Route::post('/add', 'Industry\IndustryController@store')->name('industry.add');
        Route::get('edit/{id}', 'Industry\IndustryController@edit')->name('industry.edit');
        Route::POST('update/{id}', 'Industry\IndustryController@update')->name('industry.update');
    });

    Route::prefix('location')->group(function () {
        Route::get('/create', 'Location\LocationController@create')->name('location.create')->middleware('can:admin-view');
        Route::get('/lists', 'Location\LocationController@index')->name('location.lists')->middleware('can:admin-view');
        Route::post('/add', 'Location\LocationController@store')->name('location.add');
        Route::get('edit/{id}', 'Location\LocationController@edit')->name('location.edit');
        Route::POST('update/{id}', 'Location\LocationController@update')->name('location.update');
    });

    Route::prefix('job')->group(function() {
       Route::get('/create','Job\JobController@create')->name('job.create')->middleware('can:job-view');
       Route::get('/edit/{id?}','Job\JobController@edit')->name('job.edit')->middleware('can:job-view');
       Route::post('/update/{id}','Job\JobController@update')->name('job.update');
       Route::get('/lists','Job\JobController@index')->name('job.lists')->middleware('can:job-view');
       Route::post('/add','Job\JobController@store')->name('job.add');
       Route::post('multiple/{id?}/{param?}','Job\JobController@destroy')->name('job.multiple');
       Route::get('details/{id}','Job\JobController@details')->name('job.details')->middleware('can:job-view');
       Route::post('/assign', 'AssignJob\AssignJobsController@store')->name('assign.job');

       Route::get('/getJobsSeekers/{id?}','Job\JobController@getJobsSeekers')->name('job.getJobsSeekers');

       Route::POST('/notification/{id?}','Job\JobController@sendNotification')->name('job.sendNotification');
       Route::get('/lists/{notification_status?}','Job\JobController@index')->name('job.lists');

       Route::get('location_tracking/{id}','Job\JobController@location_tracking')->name('job.location_tracking')->middleware('can:job-view');
    });

    Route::prefix('assign')->group(function() {
        Route::get('/lists','AssignJob\AssignJobsController@index')->name('assign.lists');
    });

    Route::prefix('cancel/job')->group(function() {
        Route::get('details/{userId}/{jobId}', 'CancelJob\CancelJobController@details')->name('cancel.details');
    });

    Route::prefix('payout')->group(function() {
       Route::get('lists', 'Payout\PayoutController@index')->name('payout.lists')->middleware('can:payout-view');
       Route::get('edit/{id}', 'Payout\PayoutController@edit')->name('payout.edit')->middleware('can:payout-view');
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

        Route::get('scheduledNotification', 'PushNotification\PushNotificationController@notifyByPublishDateTime')->name('pushnotification.notifyByPublishDateTime');
    });

    Route::prefix('recipient')->group(function() {
        Route::get('create', 'RecipientGroup\RecipientGroupController@create')->name('recipient.create')->middleware('can:recipient-view');
        Route::get('edit/{id}', 'RecipientGroup\RecipientGroupController@edit')->name('recipient.edit')->middleware('can:recipient-view');
        Route::get('lists', 'RecipientGroup\RecipientGroupController@index')->name('recipient.lists')->middleware('can:recipient-view');
        Route::get('details/{id}', 'RecipientGroup\RecipientGroupController@show')->name('recipient.details')->middleware('can:recipient-view');
        Route::get('search', 'RecipientGroup\RecipientGroupController@advanceSearch')->name('recipient.search');
        Route::post('delete/{id}','RecipientGroup\RecipientGroupController@destroy')->name('recipient.delete');
        Route::post('multiple/delete','RecipientGroup\RecipientGroupController@multiDestroy')->name('recipient.multiple');
        Route::post('add', 'RecipientGroup\RecipientGroupController@store')->name('recipient.store');
    });

    Route::prefix('settings')->group(function() {
       Route::get('/', 'Settings\SettingsController@index')->name('settings')->middleware('can:settings-view');
       Route::post('update', 'Settings\SettingsController@store')->name('settings.update');
    });

    Route::prefix('myprofile')->group(function() {
       Route::get('/', 'MyProfile\ProfileController@index')->name('myprofile');
       Route::post('update', 'MyProfile\ProfileController@update')->name('myprofile.update');
    });

    Route::prefix('reports')->group(function() {
       Route::get('/weekly_report', 'Reports\ReportsController@weekly_report')->name('reports.weekly_report');
       Route::post('weekly_report_filter', 'Reports\ReportsController@weekly_report_filter')->name('reports.weekly_report_filter');
    });

    Route::prefix('user/mgt')->group(function() {
        Route::get('create', 'UserMgt\UserMgtController@create')->name('mgt.create')->middleware('can:admin-view');
        Route::get('edit/{id}', 'UserMgt\UserMgtController@edit')->name('mgt.edit')->middleware('can:admin-view');
        Route::get('list', 'UserMgt\UserMgtController@index')->name('mgt.list')->middleware('can:admin-view');
        Route::get('details/{id}', 'UserMgt\UserMgtController@show')->name('mgt.details')->middleware('can:admin-view');
        Route::post('update/{id}', 'UserMgt\UserMgtController@update')->name('mgt.update');
        Route::post('store', 'UserMgt\UserMgtController@store')->name('mgt.store');
        Route::post('delete/{id}', 'UserMgt\UserMgtController@destroy')->name('mgt.delete');
        Route::post('multi/delete', 'UserMgt\UserMgtController@multiDestroy')->name('mgt.multi.delete');
    });

    Route::prefix('notification')->group(function() {
        Route::get('24hour', 'Notification\NotificationController@jobReminderForDay')->name('notification.24hour');
        Route::get('birthdaynotification', 'Notification\NotificationController@birthdayNotification')->name('notification.birthdayNotification');
    });

});

Route::get('/home', 'HomeController@index')->name('home')->middleware('can:dashboard-view');

/*content page for mobile app*/
Route::get('/terms-conditions', 'WebContentController@index')->name('content');
Route::get('/privacy-policy', 'WebContentController@index')->name('content');
Route::get('/faq', 'WebContentController@index')->name('content');
Route::get('/interview-instruction', 'WebContentController@index')->name('content');

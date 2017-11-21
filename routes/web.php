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
        Route::get('/create', 'Employee\EmployeeController@create')->name('employee.create')->middleware('can:employee-add');
        Route::get('details/{id}','Employee\EmployeeController@details')->name('employee.details')->middleware('can:employee-view');
        Route::get('edit/{id}','Employee\EmployeeController@edit')->name('employee.edit')->middleware('can:employee-edit');
        Route::post('/signup', 'Employee\EmployeeController@signup')->name('employee.signup');

        Route::post('/pending/{id}', 'Employee\EmployeeController@pendingStatus')->name('employee.pending')->middleware('can:employee-edit');
        Route::post('/approve/{id}', 'Employee\EmployeeController@approveStatus')->name('employee.approve')->middleware('can:employee-edit');
        Route::post('/reject/{id}', 'Employee\EmployeeController@rejectUser')->name('employee.reject')->middleware('can:employee-edit');
        Route::post('/upload/{id}', 'Employee\EmployeeController@uploadInfoUser')->name('employee.upload')->middleware('can:employee-edit');
        Route::post('delete','Employee\EmployeeController@destroy')->name('employee.destroy-all')->middleware('can:employee-delete');
        Route::post('delete/{id}','Employee\EmployeeController@destroyOne')->name('employee.destroy-one')->middleware('can:employee-delete');
        Route::post('update/{id?}', 'Employee\EmployeeController@update')->name('employee.update')->middleware('can:employee-edit');

        Route::post('update/profile/img/{id?}', 'Employee\EmployeeController@updateProfileImg')->name('employee.edit.img')->middleware('can:employee-edit');
        Route::post('update/profile/frontic/{id?}', 'Employee\EmployeeController@updateFrontIc')->name('employee.edit.frontic')->middleware('can:employee-edit');
        Route::post('update/profile/backic/{id?}', 'Employee\EmployeeController@updateBacktIc')->name('employee.edit.backic')->middleware('can:employee-edit');
        Route::post('update/profile/bank/{id?}', 'Employee\EmployeeController@updateBankStmnt')->name('employee.edit.bank')->middleware('can:employee-edit');


        Route::get('/job/detail/{user_id}/{id}', 'Employee\EmployeeController@jobdetail')->name('employee.job.detail');
        Route::get('/job/rate_job/{user_id}/{id}', 'Employee\EmployeeController@rate_job')->name('employee.job.rate_job');
    });

    Route::prefix('employer')->group(function () {
        Route::get('/lists', 'Employer\EmployerController@index')->name('employer.lists');
        Route::get('new/list', 'Employer\EmployerController@newlyRegisteredEmployer')->name('employer.new.list');
        Route::get('/create', 'Employer\EmployerController@create')->name('employer.create')->middleware('can:employer-add');
        Route::get('/edit/{id}', 'Employer\EmployerController@edit')->name('employer.edit')->middleware('can:employer-edit');
        Route::post('/add', 'Employer\EmployerController@store')->name('employer.add');
        Route::post('/update/{id?}', 'Employer\EmployerController@update')->name('employer.update');
        Route::post('multiple/{id?}/{param?}','Employer\EmployerController@destroy')->name('employer.multiple')->middleware('can:employer-delete');
        Route::get('details/{id}','Employer\EmployerController@show')->name('employer.details')->middleware('can:employer-view');
    });

    Route::prefix('industry')->group(function () {
        Route::get('/create', 'Industry\IndustryController@create')->name('industry.create');
        Route::get('/lists', 'Industry\IndustryController@index')->name('industry.lists');
        Route::post('/add', 'Industry\IndustryController@store')->name('industry.add');
    });

    Route::prefix('location')->group(function () {
        Route::get('/create', 'Location\LocationController@create')->name('location.create');
        Route::get('/lists', 'Location\LocationController@index')->name('location.lists');
        Route::post('/add', 'Location\LocationController@store')->name('location.add');
    });

    Route::prefix('job')->group(function() {
       Route::get('/create','Job\JobController@create')->name('job.create')->middleware('can:job-add');
       Route::get('/edit/{id?}','Job\JobController@edit')->name('job.edit')->middleware('can:job-edit');
       Route::post('/update/{id}','Job\JobController@update')->name('job.update');
       Route::get('/lists','Job\JobController@index')->name('job.lists');
       Route::post('/add','Job\JobController@store')->name('job.add');
       Route::post('multiple/{id?}/{param?}','Job\JobController@destroy')->name('job.multiple')->middleware('can:job-delete');
       Route::get('details/{id}','Job\JobController@details')->name('job.details')->middleware('can:job-view');
       Route::post('/assign', 'AssignJob\AssignJobsController@store')->name('assign.job');

    });

    Route::prefix('assign')->group(function() {
        Route::get('/lists','AssignJob\AssignJobsController@index')->name('assign.lists');
    });

    Route::prefix('cancel/job')->group(function() {
        Route::get('details/{userId}/{jobId}', 'CancelJob\CancelJobController@details')->name('cancel.details');
    });

    Route::prefix('payout')->group(function() {
       Route::get('lists', 'Payout\PayoutController@index')->name('payout.lists')->middleware('can:payout-view');
       Route::get('edit/{id}', 'Payout\PayoutController@edit')->name('payout.edit')->middleware('can:payout-edit');
       Route::post('update/{id}', 'Payout\PayoutController@update')->name('payout.update');
       Route::post('approved/{id}/{userId}', 'Payout\PayoutController@approvedJob')->name('payout.approved')->middleware('can:payout-edit');
       Route::post('processed/{id}/{userId}', 'Payout\PayoutController@processedJob')->name('payout.processed')->middleware('can:payout-edit');
       Route::post('rejected/{id}/{userId}', 'Payout\PayoutController@rejectJob')->name('payout.rejected')->middleware('can:payout-edit');
       Route::post('accepted/{id}/{userId}', 'Payout\PayoutController@acceptedJob')->name('payout.accepted')->middleware('can:payout-edit');
       Route::post('multiprocessed', 'Payout\PayoutController@multiProcessed')->name('payout.multiple')->middleware('can:payout-edit');
    });

    Route::prefix('recipient')->group(function() {
        Route::get('create', 'RecipientGroup\RecipientGroupController@create')->name('recipient.create')->middleware('can:recipient-add');
        Route::get('edit/{id}', 'RecipientGroup\RecipientGroupController@edit')->name('recipient.edit')->middleware('can:recipient-edit');
        Route::post('multiple/{id?}/{param?}','RecipientGroup\RecipientGroupController@edit@destroy')->name('recipient.multiple')->middleware('can:employer-delete');
        Route::get('lists', 'RecipientGroup\RecipientGroupController@index')->name('recipient.lists');
        Route::get('details/{id}', 'RecipientGroup\RecipientGroupController@show')->name('recipient.details')->middleware('can:recipient-view');
        Route::post('search', 'RecipientGroup\RecipientGroupController@advanceSearch')->name('recipient.search');
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
    });

    Route::prefix('user/mgt')->group(function() {
        Route::get('create', 'UserMgt\UserMgtController@create')->name('mgt.create');
        Route::get('edit/{id}', 'UserMgt\UserMgtController@edit')->name('mgt.edit');
        Route::get('list', 'UserMgt\UserMgtController@index')->name('mgt.list');
        Route::get('details/{id}', 'UserMgt\UserMgtController@show')->name('mgt.details');
        Route::post('update/{id}', 'UserMgt\UserMgtController@update')->name('mgt.update');
        Route::post('store', 'UserMgt\UserMgtController@store')->name('mgt.store');
        Route::post('delete/{id}', 'UserMgt\UserMgtController@destroy')->name('mgt.delete');
        Route::post('multi/delete', 'UserMgt\UserMgtController@multiDestroy')->name('mgt.multi.delete');
    });

});

Route::get('/home', 'HomeController@index')->name('home')->middleware('can:dashboard-view');

/*content page for mobile app*/
Route::get('/terms-conditions', 'WebContentController@index')->name('content');
Route::get('/privacy-policy', 'WebContentController@index')->name('content');
Route::get('/faq', 'WebContentController@index')->name('content');
Route::get('/interview-instruction', 'WebContentController@index')->name('content');

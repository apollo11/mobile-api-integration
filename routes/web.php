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
        Route::post('/pending/{id}', 'Employee\EmployeeController@pendingStatus')->name('employee.pending');
        Route::post('/approve/{id}', 'Employee\EmployeeController@approveStatus')->name('employee.approve');
        Route::post('/reject/{id}', 'Employee\EmployeeController@rejectUser')->name('employee.reject');
        Route::post('/upload/{id}', 'Employee\EmployeeController@uploadInfoUser')->name('employee.upload');

    });

    Route::prefix('employer')->group(function () {
        Route::get('/lists', 'Employer\EmployerController@index')->name('employer.lists');
        Route::get('/create', 'Employer\EmployerController@create')->name('employer.create');
        Route::post('/add', 'Employer\EmployerController@store')->name('employer.add');
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
       Route::get('/create','Job\JobController@create')->name('job.create');
       Route::get('/lists','Job\JobController@index')->name('job.lists');
       Route::post('/add','Job\JobController@store')->name('job.add');
    });

});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', 'HomeController@countCancelledJobs')->name('test');


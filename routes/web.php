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
Route::group(['middleware' => ['auth']],function () {

    Route::prefix('dashboard')->group(function() {
        Route::get('/employee', 'EmployeeController@index');

    });

    Route::prefix('employer')->group(function () {
        Route::get('/lists', 'Employer\EmployerController@index')->name('employer.lists');
        Route::get('/create', 'Employer\EmployerController@create')->name('employer.create');
        Route::post('/add', 'Employer\EmployerController@store')->name('employer.add');
    });

});

Route::get('/home', 'HomeController@index')->name('home');

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

//Route::get('/', function () {
//    return view('home');
//});
Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/show', 'HomeController@show')->name('show');
Route::get('/show', 'InjuryReportController@index')->name('index');
Route::get('/detail/{id}', 'InjuryReportController@detail')->name('index');
Route::post('/detail/{id}/toggle', 'InjuryReportController@toggleMode')->name('toggle');
Route::post('/edit/{id}', 'InjuryReportController@edit')->name('edit');
Route::get('/injuryreport', 'InjuryReportController@index')->name('injuryreport');
Route::post('/register', 'InjuryReportController@register')->name('register');
Route::post('/save', 'InjuryReportController@save')->name('save');

Route::get('/report/{mode}', 'InjuryReportController@report')->name('report');
Route::get('/delete/{id}', 'InjuryReportController@delete')->name('delete');
Route::post('/logout', 'HomeController@logout')->name('logout');

Route::get('/profile', 'UserProfileController@index')->name('profile');

Route::get('/search', 'InjuryReportController@search')->name('search');
Route::post('/download', 'ExcelController@filterdownload')->name('download');

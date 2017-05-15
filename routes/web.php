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

Route::get('/', 'HomeController@getIndex');

Route::get('/company/{company}', 'CompanyController@getCompany');
Route::get('/user/{user}', 'UserController@getUser');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::post('/company/{company}/buy', 'ShareController@buyShares');
    Route::post('/company/{company}/sell', 'ShareController@sellShares');
});

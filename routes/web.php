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

Route::bind('user', function ($value) {
    return \App\User::whereName($value)->firstOrFail();
});
Route::bind('company', function ($value) {
    return \App\Company::whereIdentifier($value)->firstOrFail();
});

Route::get('/', 'HomeController@getIndex');

Route::get('/company/{company}', 'CompanyController@getCompany');
Route::get('/user/{user}', 'UserController@getUser');

Route::get('/leaderboards/user', 'HomeController@getUserLeaderboardByCredit');
Route::get('/leaderboards/user/credit', 'HomeController@getUserLeaderboardByCredit');
Route::get('/leaderboards/user/shares', 'HomeController@getUserLeaderboardByShares');
Route::get('/leaderboards/company', 'HomeController@getCompanyLeaderboardByValue');
Route::get('/leaderboards/company/value', 'HomeController@getCompanyLeaderboardByValue');
Route::get('/leaderboards/company/shares', 'HomeController@getCompanyLeaderboardByShares');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::post('/company/{company}/buy', 'ShareController@buyShares');
    Route::post('/company/{company}/sell', 'ShareController@sellShares');

    Route::get('/dash', 'HomeController@getDashboard');

    Route::get('/logout', function() {
        Auth::logout();
        return redirect('/');
    });
});

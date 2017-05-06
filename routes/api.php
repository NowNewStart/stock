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
Route::bind('user', function ($value) {
    return App\User::findOrFail($value);
});
Route::bind('company', function ($value) {
    return App\Company::findOrFail($value);
});
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace' => 'App\Http\Controllers','middleware' => 'api.auth', 'providers' => 'jwt'], function ($api) {
    $api->get('/user', 'ApiController@getUser');

    $api->get('/bank', 'BankController@getIndex');

    $api->get('/company', 'CompanyController@getIndex');
    $api->get('/company/{company}', 'CompanyController@getCompany');
    $api->post('/company/{company}/buy', 'ShareController@buyShares');
    $api->post('/company/{company}/sell', 'ShareController@sellShares');
});
$api->version('v1', [], function ($api) {
    $api->get('/', function () {
        return response([], 400);
    });
    $api->post('/auth', 'App\Http\Controllers\UserController@auth');
});

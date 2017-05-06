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
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace' => 'App\Http\Controllers','middleware' => 'api.auth', 'providers' => 'jwt'], function ($api) {
    $api->get('/user', 'UserController@getUser');
});
$api->version('v1', [], function ($api) {
    $api->get('/', function () {
        return response([], 400);
    });
    $api->post('/auth', 'App\Http\Controllers\UserController@auth');
});

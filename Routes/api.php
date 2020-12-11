<?php

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

Route::group(['middleware' => 'auth:admin_api'], function () {

    // ADMIN ROUTES
    Route::get('admin-users', 'Api\AdminUserController@index');
    Route::get('admin-users/{id}', 'Api\AdminUserController@show');
    Route::post('admin-users', 'Api\AdminUserController@store');
    Route::put('admin-users/{id}', 'Api\AdminUserController@update');
    Route::delete('admin-users', 'Api\AdminUserController@destroy');

    // USER ENDPOINTS
    Route::get('auth/current', 'Api\AdminUserController@currentUser');

});

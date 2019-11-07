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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:admin-api')->get('/admin', function (Request $request) {
    return $request->auth()->guard('admin')->user();
});


Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'Api\AuthController@login');
    Route::post('signup', 'Api\AuthController@signup');
    Route::get('signup/activate/{token}', 'Api\AuthController@signupActivate');
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'Api\AuthController@logout');
        Route::get('user', 'Api\AuthController@user');
    });
});

Route::group([
    'prefix' => 'auth/admin'
], function () {
    Route::post('login', 'Api\AdminAuthController@login');
    Route::get('signup/activate/{token}', 'Api\AdminAuthController@signupActivate');
    Route::post('signup', 'Api\AdminAuthController@signup');
  
    Route::group([
      'middleware' => 'auth:admin-api'
    ], function() {
        Route::get('logout', 'Api\AdminAuthController@logout');
        Route::get('/', 'Api\AdminAuthController@admin');
    });
});

Route::group([    
    'middleware' => 'api',    
    'prefix' => 'password'
], function () {    
    Route::post('create', 'Api\PasswordResetController@create');
    Route::get('find/{token}', 'Api\PasswordResetController@find');
    Route::post('reset', 'Api\PasswordResetController@reset');
});

Route::group([    
    'middleware' => 'auth:admin-api',
    'prefix' => 'password'
], function () {    
   	Route::post('admin/create', 'Api\AdminPasswordResetController@create');
    Route::get('admin/find/{token}', 'Api\AdminPasswordResetController@find');
    Route::post('admin/reset', 'Api\AdminPasswordResetController@reset');
});
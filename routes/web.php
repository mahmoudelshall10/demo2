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
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();


// Authentication admin Routes...

Route::get('admin/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('admin/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('admin/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('password.reset');
Route::post('admin/password/reset', 'Auth\AdminResetPasswordController@reset')->name('password.update');

Route::get('admin/email/verify', 'Auth\AdminVerificationController@show')->name('verification.notice');
Route::get('admin/email/verify/{id}', 'Auth\AdminVerificationController@verify')->name('verification.verify');
Route::get('admin/email/resend', 'Auth\AdminVerificationController@resend')->name('verification.resend');

Route::group(['middleware' => 'guest:admin'], function () {
    Route::get('admin/login', 'Admin\Admins@login')->name('admin.login');
    Route::post('admin/login', 'Admin\Admins@login_post');

});

Route::get('laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
Route::post('laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');

Route::get('/admin', 'Admin\Admins@index')->name('admin.home');

Route::group(['prefix' => 'admin'],function(){
    Route::post('logout','Admin\Admins@logout');
    Route::get('news','NewsController@index');
    Route::get('news/create','NewsController@create');
    Route::post('news','NewsController@store');
    Route::delete('news/delete/{id?}','NewsController@delete');


    // Route::delete('news/delete/{id}','NewsController@destroy')->name('admin.news.destroy');
});



   

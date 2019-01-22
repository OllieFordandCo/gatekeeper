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

Route::group(['middleware' => ['web']], function () {
    Route::post('login', 'OllieFordandCo\GateKeeper\Http\Controllers\Auth\LoginController@login');
    Route::get('login', 'OllieFordandCo\GateKeeper\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
    Route::get('login/{provider?}', 'OllieFordandCo\GateKeeper\Http\Controllers\Auth\LoginController@redirectToProvider')->name('loginWith');
    Route::post('logout', 'OllieFordandCo\GateKeeper\Http\Controllers\Auth\LoginController@logou    t')->name('logout');
    Route::get('authorise/{provider}', 'OllieFordandCo\GateKeeper\Http\Controllers\Auth\LoginController@handleProviderCallback')->name('authorise');


    Route::get('password/reset', 'OllieFordandCo\GateKeeper\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'OllieFordandCo\GateKeeper\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'OllieFordandCo\GateKeeper\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'OllieFordandCo\GateKeeper\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');
    
});

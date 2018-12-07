<?php
/**
 * Created by PhpStorm.
 * User: rubenmadila
 * Date: 02/12/2018
 * Time: 10:12
 */

// Authentication Routes...
Route::group(['middleware' => ['web']], function () {
    Route::get('login', 'OllieFordandCo\GateKeeper\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'OllieFordandCo\GateKeeper\Http\Controllers\Auth\LoginController@login');
    Route::post('logout', 'OllieFordandCo\GateKeeper\Http\Controllers\Auth\LoginController@logout')->name('logout');

    // Registration Routes...
    //if (config ?? true) {
        Route::get('register', 'OllieFordandCo\GateKeeper\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'OllieFordandCo\GateKeeper\Http\Controllers\Auth\RegisterController@register');
    //}
});
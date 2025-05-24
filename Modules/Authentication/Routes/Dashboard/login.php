<?php
Route::group(['prefix' => 'login'], function () {

    if (env('LOGIN', true)):

        // Show Login Form
        Route::get('/', 'Dashboard\LoginController@showLogin')
        ->name('view.dashboard.login')
        ->middleware('guest');

        // Submit Login
        Route::post('/', 'Dashboard\LoginController@postLogin')
        ->name('dashboard.login');

    endif;

});

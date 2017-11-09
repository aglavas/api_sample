<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Password reset form
Route::get('password/reset/{token}', 'Auth\ForgotPasswordController@getPasswordResetToken');
// Verification error view
Route::get('auth/email-verification/error', 'Auth\ActivationController@getVerificationError')->name('email-verification.error');
// Verifies user
Route::get('auth/email-verification/check/{token}', 'Auth\ActivationController@getVerification')->name('email-verification.check');
// Verification success
Route::get('auth/email-verification/success', 'Auth\ActivationController@getVerificationSuccess')->name('email-verification.success');

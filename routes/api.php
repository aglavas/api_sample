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

/**
 * Auth routes
 */
Route::group(['prefix' => 'auth'], function () {

    // Create login token
    Route::post('login', 'Auth\AuthController@postAuthLogin');

    // Destroy credentials
    Route::get('logout', 'Auth\AuthController@getAuthLogout');

    // Renew credentials
    Route::post('token/refresh', 'Auth\AuthController@postAuthTokenRefresh');

    // Register
    Route::post('user', 'Auth\AuthController@postAuthUser');

    Route::group(['middleware' => 'api_auth'], function () {

        //Upload user image
        Route::post('user/image', 'Auth\AuthController@postAuthUserImage');

        //Get user image url
        Route::get('user/image', 'Auth\AuthController@getAuthUserImage');

        // Resend activation mail
        Route::get('user/activate', 'Auth\ActivationController@getAuthUserActivate');

        // Update
        Route::patch('user', 'Auth\AuthController@patchAuthUser');

        // Delete
        Route::delete('user', 'Auth\AuthController@deleteAuthUser');

        // Show
        Route::get('user', 'Auth\AuthController@getAuthUser');

        //Change password
        Route::patch('password', 'Auth\AuthController@patchAuthPassword');
    });
});

/**
 * Password reset routes
 */

Route::group(['prefix' => 'password'], function () {
    // Require reset link
    Route::post('reset', 'Auth\ForgotPasswordController@postPasswordReset');
    // Reset password
    Route::post('reset/{token}', 'Auth\ResetPasswordController@postPasswordResetToken')->name('reset.password');
});


/**
 * Meals routes
 */
Route::group(['middleware' => 'api_auth'], function () {

    // Create new meal
    Route::post('meals', 'Meal\MealController@postMeals');
    // Edit meal
    Route::patch('meals/{id}', 'Meal\MealController@patchMeals')->where('id', '[0-9]+');
    // Delete meal
    Route::delete('meals/{id}', 'Meal\MealController@deleteMeals')->where('id', '[0-9]+');
    // Get meal by id
    Route::get('meals/{id}', 'Meal\MealController@getMealsById')->where('id', '[0-9]+');
    // Search meals
    Route::get('meals/search', 'Meal\MealController@getMealsSearch');
});

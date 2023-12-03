<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Entities\Models\User;

//
//Route::group(['middleware' => 'guest'], function () {
//    Route::get('/cp/auth', 'Web\AuthController@showLoginForm')->name('login');
//    Route::post('/cp/auth', 'Web\AuthController@login')->name('auth.login');
//
//    /*enter email*/
//    Route::get('/reset-password/email', 'Web\ForgotPasswordController@showResetForm')
//        ->name('password.email');
//    Route::post('/reset-password/email', 'Web\ForgotPasswordController@sendResetLinkEmail')
//        ->name('password.email.send');
//
//    /* send success */
//    Route::get('/reset-password/confirm', 'Web\ForgotPasswordController@showConfirmForm')
//        ->name('password.email.sent');
//
//    /*form reset */
//    Route::get('/reset-password/reset', 'Web\ResetPasswordController@showResetForm')
//        ->name('password.reset.form');
//    Route::post('/reset-password/reset', 'Web\ResetPasswordController@reset')
//        ->name('password.reset');
//
//    if (config('auth.social.google')) {
//        Route::get('/app/auth/google', 'Web\SocialiteController@authGoogleUrl')
//            ->name('auth.google');
//        Route::get('/app/auth/google/callback', 'Web\SocialiteController@authGoogle')
//            ->name('auth.google.callback');
//    }
//});
//Route::get('/cp/logout', 'Web\AuthController@logout')->middleware('auth')->name('logout');
//
//Route::group(['middleware' => 'auth'], function () {
//    Route::get('/cp/users/back-to', 'Web\UserController@backToMainUser')
//        ->name('cp.users.backTo');
//
//    Route::get('/cp/users/loginAs/{user}', 'Web\UserController@loginAsUser')
//        ->name('cp.users.loginAs')->middleware('can:loginAs,user');
//
//    Route::get('/cp/profile', 'Web\ProfileController@profile')
//        ->name('cp.profile');
//
//    Route::match(['PUT', 'PATCH', 'POST'], '/cp/profile', 'Web\ProfileController@update')
//        ->name('cp.profile.update');
//
//    /*Search*/
//    Route::get('/cp/users/search', 'Web\UserController@search')
//        ->name('cp.users.search')->middleware('can:read,' . User::class);
//
//    Route::get('/cp/users/ajax/search', 'Web\UserController@ajaxSearch')
//        ->name('cp.users.ajax')->middleware('can:read,' . User::class);
//
//    /*List*/
//    Route::get('/cp/users', 'Web\UserController@index')
//        ->name('cp.users.index')->middleware('can:read,' . User::class);
//
//    /*Create*/
//    Route::get('/cp/users/create', 'Web\UserController@create')
//        ->name('cp.users.create')->middleware('can:create,' . User::class);
//
//    Route::post('/cp/users', 'Web\UserController@store')
//        ->name('cp.users.store')->middleware('can:create,' . User::class);
//
//    /*Detail*/
//    Route::get('/cp/users/{user}', 'Web\UserController@show')
//        ->name('cp.users.show')->middleware('can:read,' . User::class);
//
//    /*Edit*/
//    Route::get('/cp/users/{user}/edit', 'Web\UserController@edit')
//        ->name('cp.users.edit')->middleware('can:update,user');
//
//    Route::match(['PUT', 'PATCH'], '/cp/users/{user}', 'Web\UserController@update')
//        ->name('cp.users.update')->middleware('can:update,user');
//
//    /*Delete*/
//    Route::delete('/cp/users/{user}', 'Web\UserController@destroy')
//        ->name('cp.users.destroy')->middleware('can:delete,user');
//
//    Route::post('/cp/users/{user}/update-status', 'Web\UserController@updateStatus')
//        ->name('cp.users.update-status')->middleware('can:update,user');
//});

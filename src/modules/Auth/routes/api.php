<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Entities\Models\Role;
use Modules\User\Http\Controllers\Api\UserController;

Route::group(['middleware' => 'guest'], function () {
    Route::post('/login', 'Api\AuthController@login')->name('login');
    Route::post('/register', 'Api\AuthController@register')->name('register');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/logout', 'Api\AuthController@logout')->name('api.logout');
    Route::post('/refresh', 'Api\AuthController@refresh')->name('api.refresh');
    Route::get('/user', 'Api\AuthController@user')->name('api.user');
});

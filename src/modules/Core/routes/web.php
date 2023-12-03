<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;

if (config('core.enable_view_log') === true) {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
}

Route::group(['middleware' => []], function () {
    Route::get('/', function () {
        return response()->json([
            'message' => 'Still work',
        ]);
    })->name('home');
});

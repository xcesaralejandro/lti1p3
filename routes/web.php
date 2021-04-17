<?php

use Illuminate\Support\Facades\Route;
use xcesaralejandro\lti1p3\Http\Controllers\{
    AuthController,
    Lti1p3Controller,
    PlatformsController
};

Route::get('/login', function(){
    return redirect()->route('lti1p3.auth');
})->name('login');

Route::group(['prefix' => 'lti'], function () {
    Route::post('/connect', [Lti1p3Controller::class, 'launchConnection'])->name('lti1p3.connect');
});

Route::group(['prefix' => 'admin', 'middleware' => ['web']], function () {
    Route::get('/login', [AuthController::class, 'index'])->name('lti1p3.auth');
    Route::post('/login', [AuthController::class, 'attemp'])->name('lti1p3.auth.attemp');
    Route::get('/logout', [AuthController::class, 'logout'])->name('lti1p3.auth.logout');
});

Route::group(['prefix' => 'admin', 'middleware' => ['web','auth']], function () {
    Route::resource('/platforms', PlatformsController::class, ['as' => 'lti1p3']);
});

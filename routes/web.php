<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LtiController;
use xcesaralejandro\lti1p3\Http\Controllers\{
    AuthController,
    DeploymentsController,
    ExamplesController,
    PlatformsController
};

Route::group(['prefix' => 'lti1p3'], function () {
    Route::post('/connect', [LtiController::class, 'launchConnection'])->name('lti1p3.connect');
});

Route::group(['prefix' => 'lti1p3', 'middleware' => ['web']], function () {
    Route::get('/login', [AuthController::class, 'index'])->name('lti1p3.auth');
    Route::post('/login', [AuthController::class, 'attemp'])->name('lti1p3.auth.attemp');
    Route::get('/logout', [AuthController::class, 'logout'])->name('lti1p3.auth.logout');
});

Route::group(['prefix' => 'lti1p3/admin', 'middleware' => ['web', 'lti1p3_session']], function () {
    Route::resource('/platforms', PlatformsController::class, ['as' => 'lti1p3']);
    Route::resource('platforms/{platform_id}/deployments', DeploymentsController::class, ['as' => 'lti1p3']);
});

Route::group(['prefix' => 'example', 'middleware' => 'inject_lti_instance'], function () {
    Route::post('/deeplinking', [ExamplesController::class, 'SendDeepLinkingMessage'])->name('deep_linking.example');
    Route::get('/deeplinking/view', [ExamplesController::class, 'launchDeepLinkingUrl'])->name('deep_linking.example.view');
});

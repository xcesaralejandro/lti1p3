<?php
use Illuminate\Support\Facades\Route;
use xcesaralejandro\lti1p3\Http\Controllers\Lti1p3Controller;

Route::get('api/lti1p3/jwks', [Lti1p3Controller::class, 'jwks'])->middleware('api');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\FacebookSocialiteController;

Route::get('/', [MainController::class, 'index']);
Route::get('/home', [MainController::class, 'home']);

Route::get('auth/facebook', [FacebookSocialiteController::class, 'redirectToFB']);
Route::get('callback/facebook', [FacebookSocialiteController::class, 'handleCallback']);

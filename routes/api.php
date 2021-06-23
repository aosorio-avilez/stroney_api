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

use Illuminate\Support\Facades\Route;

Route::prefix('users')
    ->group(__DIR__ . '/api/users.php');

Route::prefix('/categories')
    ->middleware('auth:sanctum')
    ->group(__DIR__ . '/api/categories.php');

Route::prefix('/currencies')
    ->middleware('auth:sanctum')
    ->group(__DIR__ . '/api/currencies.php');

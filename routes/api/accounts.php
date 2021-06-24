<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::post('', [AccountController::class, 'create']);

Route::get('/{accountId}', [AccountController::class, 'get']);

Route::put('/{accountId}', [AccountController::class, 'update']);

Route::patch('/{accountId}/balance', [AccountController::class, 'adjustBalance']);

Route::delete('/{accountId}', [AccountController::class, 'remove']);

Route::prefix('/{accountId}/movements')
    ->group(__DIR__ . '/account_movements.php');

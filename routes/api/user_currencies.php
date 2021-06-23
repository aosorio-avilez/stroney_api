<?php

use App\Http\Controllers\UserCurrencyController;
use Illuminate\Support\Facades\Route;

Route::post('', [UserCurrencyController::class, 'create']);

Route::put('/{userCurrencyId}', [UserCurrencyController::class, 'update']);

Route::delete('/{userCurrencyId}', [UserCurrencyController::class, 'remove']);

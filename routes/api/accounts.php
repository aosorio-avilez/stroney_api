<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::post('', [AccountController::class, 'create']);

Route::put('/{accountId}', [AccountController::class, 'update']);

Route::delete('/{accountId}', [AccountController::class, 'remove']);

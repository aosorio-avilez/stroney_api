<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth', [UserController::class, 'authenticate']);

Route::post('', [UserController::class, 'create']);

Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/revoke-access', [UserController::class, 'revokeAccess']);
});

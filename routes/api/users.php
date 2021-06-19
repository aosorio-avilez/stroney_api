<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth', [UserController::class, 'authenticate']);

Route::post('', [UserController::class, 'create']);

Route::patch('/email/{email}/temporal-password', [UserController::class, 'sendTemporalPassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/revoke-access', [UserController::class, 'revokeAccess']);
    
    Route::put('/{userId}', [UserController::class, 'update']);
    
    Route::patch('/{userId}/password', [UserController::class, 'updatePassword']);

    Route::prefix('/{userId}/categories')
        ->group(__DIR__ . '/categories.php');
});

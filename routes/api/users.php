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
    
    Route::get('/{userId}/categories', [UserController::class, 'categories']);
    
    Route::get('/{userId}/accounts', [UserController::class, 'accounts']);
    
    Route::prefix('/{userId}/currencies')
        ->group(__DIR__ . '/user_currencies.php');
});

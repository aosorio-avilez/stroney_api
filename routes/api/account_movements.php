<?php

use App\Http\Controllers\AccountMovementController;
use Illuminate\Support\Facades\Route;

Route::post('', [AccountMovementController::class, 'create']);

Route::get('', [AccountMovementController::class, 'all']);
